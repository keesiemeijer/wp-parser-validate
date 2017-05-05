<?php
namespace keesiemeijer\WP_Parser_Validate;

class Validate_DocBlcock {

	/**
	 * Logger object.
	 *
	 * @var object
	 */
	public $logger;

	public function __construct( Validate_Logger $logger ) {
		$this->logger = $logger;
	}

	/**
	 * Validate a DocBlock.
	 *
	 * @param array  $node        Parsed data.
	 * @param string $type        Type of node. ('function', 'hook', 'class', 'method', 'property')
	 * @param string $parent_type Type of parent node.
	 * @param string $parent_name Name of parent node.
	 */
	public function validate_docblock( $node, $type, $parent_type = '', $parent_name = '' ) {

		if ( is_hook( $type ) || in_array( $type, array( 'function', 'method', 'hook' ) ) ) {
			$this->validate_doc_params( $node, $type, $parent_type, $parent_name );
		}

		if ( in_array( $type, array( 'function', 'method' ) ) ) {
			$this->validate_return( $node, $type, $parent_type, $parent_name );
		}

		if ( in_array( $type, array( 'property', 'method' ) ) ) {
			$this->validate_access( $node, $type, $parent_type, $parent_name );
		}

		if ( $type === 'property' ) {
			$this->validate_var( $node, $type, $parent_type, $parent_name );
		}

		$this->validate_since( $node, $type, $parent_type, $parent_name );
		$this->validate_description( $node, $type, $parent_type, $parent_name );
	}

	/**
	 * Checks if a DocBlock exists.
	 *
	 * @param array  $node        Parsed data.
	 * @param string $type        Type of node. ('function', 'hook', 'class', 'method', 'property')
	 * @param string $parent_type Type of parent node.
	 * @param string $parent_name Name of parent node.
	 * @return bool Returns true if a node has a DocBlock.
	 */
	public function has_docblock( $node, $type, $parent_type = '', $parent_name = '' ) {

		// Function get_docblock() returns associative array with empty values.
		// Todo: return false when exporting a missing DocBlock. (see export_docblock() in runner.php)

		$docblock = array_filter( get_docblock( $node ) );

		if ( empty( $docblock ) ) {
			$name = get_name( $node );
			$line = get_line( $node );
			$msg  = "No DocBlock found";
			$msg .= $this->logger->format_message( $name, $type, $parent_type, $parent_name, $line );
			$this->logger->log( $name, $type, $msg );
			return false;
		}

		return true;
	}

	/**
	 * Validate DocBlock @param tags against parameters.
	 *
	 * @param array  $node        Parsed data.
	 * @param array  $type        Type of node. ('function', 'method', 'hook')
	 * @param string $parent_type Type of parent node.
	 * @param string $parent_name Name of parent node.
	 */
	public function validate_doc_params( $node, $type, $parent_type = '', $parent_name = '' ) {

		if ( ! $this->has_docblock( $node, $type, $parent_type, $parent_name ) ) {
			return;
		}

		$name       = get_name( $node );
		$line       = get_line( $node );
		$parameters = get_parameter_names( $node );
		$doc_params = get_doc_params_key( $node, 'variable' );
		$doc_desc   = get_doc_params_key( $node, 'content' );
		$format     = $this->logger->get_format_string();
		$continue   = true;

		if ( is_hook( $type ) ) {
			if ( in_array( $type, array( 'action_reference', 'filter_reference' ) ) ) {
				// Reference parameters are stored in a single string by the parser.
				// Todo: get reference parameters when parsing.
				$ref_args  = isset( $parameters[0] ) ? $parameters[0] : false;
				$parameters = get_array_values_from_string( $ref_args );

				if ( ! $parameters ) {
					return;
				}
			}
		}

		if ( count( $doc_params ) < count( $parameters ) ) {
			$msg =  'Missing parameters in DocBlock';
			$msg .= $this->logger->format_message( $name, $type, $parent_type, $parent_name, $line );
			$this->logger->log( $name, $type, $msg );
			$continue = false;
		}

		if ( count( $doc_params ) > count( $parameters ) ) {
			$functions   = get_function_names( $node );
			$variadic    = array( 'func_get_args', 'func_num_args', 'func_get_arg' );
			$is_variadic = array_filter( $functions, function( $value ) use ( $variadic ) {
					return in_array( $value, $variadic );
				} );

			if ( ! empty( $is_variadic ) ) {
				// Bail. Variadic parameters function.
				return;
			}

			$msg = 'Too many parameters in DocBlock';
			$msg .= $this->logger->format_message( $name, $type, $parent_type, $parent_name, $line );
			$this->logger->log( $name, $type, $msg );
			$continue = false;
		}

		if ( ! $continue ) {
			return;
		}

		// Same amount of DocBlock @params as function parameters.

		// Check actual parameter variables against DocBlock @param variables.
		foreach ( $parameters as $key => $parameter ) {

			$arg_name = remove_reference( $parameter );
			$doc_arg  = isset( $doc_params[ $key ] ) && $doc_params[ $key ];

			// Check if variable has a description
			if ( ! $doc_desc[ $key ] ) {
				$msg    = sprintf( "Missing description for @param {$format} in DocBlock", $doc_params[ $key ] );
				$msg .= $this->logger->format_message( $name, $type, $parent_type, $parent_name, $line );
				$this->logger->log( $name, $type, $msg );
			}

			// Check if it's a variable.
			if ( 0 !== strpos( $arg_name, '$' ) ) {
				// Bail, not a variable.
				continue;
			}

			$restricted = array( '[', '->', '.' );

			foreach ( $restricted as $r ) {
				if ( false !== strpos( $arg_name, $r ) ) {
					// Bail, can't be validated.
					// Could be an array value, object property, concatenated, etc.
					continue 2;
				}
			}

			if ( ! $doc_arg ) {
				// Empty DocBlock $variable
				//
				// Check if it's the first word of the content.
				// Possible with variables passed by reference '&$var'.
				// See: https://github.com/WordPress/phpdoc-parser/issues/176
				// Todo: Fix the issue or log messages for '&$var'.
				if ( isset( $doc_desc[ $key ] ) ) {
					$content    = explode( ' ', $doc_desc[ $key ], 2 );
					$first      = ( isset( $content[0] ) && $content[0] ) ? true : false;
					$doc_arg    = $first ? remove_reference( html_entity_decode( $content[0] ) ) : false;
				}

				if ( ( false !== $doc_arg ) && ( $doc_arg === $arg_name ) ) {
					// Found parameter in content.
					continue;
				}

				// Variable parameter not found.
				// Todo: Better log message.
				$msg = sprintf( "Missing @param variable {$format} in DocBlock",  $arg_name );
				$msg .= $this->logger->format_message( $name, $type, $parent_type, $parent_name, $line );
				$this->logger->log( $name, $type, $msg );
				continue;
			}

			// Check if variable names are mismatched.
			if ( $arg_name !== $doc_params[ $key ] ) {
				$msg = sprintf( "Mismatched @param tag name {$format} in DocBlock",  $doc_params[ $key ] );
				$msg .= $this->logger->format_message( $name, $type, $parent_type, $parent_name, $line );
				$this->logger->log_notice( $name, $type, $msg );
			}
		}
	}

	/**
	 * Validate the @access tag against visibility.
	 *
	 * @param array  $node        Parsed data.
	 * @param array  $type        Type of node. ('method', 'property')
	 * @param string $parent_type Type of parent node.
	 * @param string $parent_name Name of parent node.
	 */
	public function validate_access( $node, $type, $parent_type = '', $parent_name = '' ) {
		$name       = get_name( $node );
		$line       = get_line( $node );
		$visibility = get_visibility( $node );
		$access     = get_doc_access( $node );
		$format     = $this->logger->get_format_string();

		if ( ( $visibility && $access ) && ( $access !== $visibility ) ) {
			$msg = sprintf( "Wrong @access tag {$format} in DocBlock", $access );
			$msg .= $this->logger->format_message( $name, $type, $parent_type, $parent_name, $line );
			$this->logger->log( $name, $type, $msg );
		}
		if ( ! $access ) {
			$msg = sprintf( "Missing @access tag {$format} in DocBlock", $visibility );
			$msg .= $this->logger->format_message( $name, $type, $parent_type, $parent_name, $line );
			$this->logger->log( $name, $type, $msg );
		}
	}

	/**
	 * Validate version in @since tags.
	 *
	 * @param array  $node        Parsed data.
	 * @param array  $type        Type of node. ('function', 'hook', 'class', 'method', 'property')
	 * @param string $parent_type Type of parent node.
	 * @param string $parent_name Name of parent node.
	 */
	public function validate_since( $node, $type, $parent_type = '', $parent_name = '' ) {
		$name  = get_name( $node );
		$line  = get_line( $node );
		$since = get_doc_since( $node );

		if ( empty( $since ) ) {
			$msg = "Missing @since tag in DocBlock";
			$msg .= $this->logger->format_message( $name, $type, $parent_type, $parent_name, $line );
			$this->logger->log( $name, $type, $msg );

			return;
		}

		foreach ( $since as $version ) {
			$version = isset( $version['content'] ) ? $version['content'] : false;

			if ( ! $version || ! is_valid_wp_version( $version ) ) {
				$msg = "Invalid version in @since tag in DocBlock";
				$msg .= $this->logger->format_message( $name, $type, $parent_type, $parent_name, $line );
				$this->logger->log( $name, $type, $msg );
			}
		}
	}

	/**
	 * Validate DocBlock description.
	 *
	 * @param array  $node        Parsed data.
	 * @param string $type        Type of node. ('function', 'method')
	 * @param string $parent_type Type of parent node.
	 * @param string $parent_name Name of parent node.
	 */
	public function validate_description(  $node, $type, $parent_type = '', $parent_name = ''  ) {
		$name = get_name( $node );
		$line = get_line( $node );
		$desc = get_doc_description( $node );

		if ( ! $desc ) {
			$msg = "No description found in DocBlock";
			$msg .= $this->logger->format_message( $name, $type, $parent_type, $parent_name, $line );
			$this->logger->log( $name, $type, $msg );
		}
	}

	/**
	 * Validate @return tag.
	 *
	 * Checks if 'void' is found in the return types.
	 *
	 * @param array  $node        Parsed data.
	 * @param string $type        Type of node. ('function', 'method')
	 * @param string $parent_type Type of parent node.
	 * @param string $parent_name Name of parent node.
	 */
	public function validate_return(  $node, $type, $parent_type = '', $parent_name = ''  ) {
		$name         = get_name( $node );
		$line         = get_line( $node );
		$return_types = get_doc_return_types( $node );
		$format       = $this->logger->get_format_string();

		if ( ! ( isset( $return_types[0] ) && ( 1 === count( $return_types ) ) ) ) {
			return;
		}

		if ( 'void' === strtolower( $return_types[0] ) ) {

			$msg = sprintf( "The @return tag with value {$format} can be omitted in DocBlock", 'void' );
			$msg .= $this->logger->format_message( $name, $type, $parent_type, $parent_name, $line );
			$this->logger->log_notice( $name, $type, $msg );
		}
	}

	/**
	 * Validate @var tag in a class property.
	 *
	 * Checks if 'void' is found in the return types.
	 *
	 * @param array  $node        Parsed data.
	 * @param string $type        Type of node. ('function', 'method')
	 * @param string $parent_type Type of parent node.
	 * @param string $parent_name Name of parent node.
	 */
	public function validate_var( $node, $type, $parent_type = '', $parent_name = ''  ) {
		$name = get_name( $node );
		$vars = get_doc_var( $node );
		$line = get_line( $node );

		if ( empty( $vars ) ) {
			$msg = "Missing @var tag in DocBlock";
			$msg .= $this->logger->format_message( $name, $type, $parent_type, $parent_name, $line );

			$this->logger->log( $name, $type, $msg );
		}
	}
}
