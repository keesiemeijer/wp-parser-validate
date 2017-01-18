<?php
namespace WP_Parser_Validate;

class Validate {

	/**
	 * Logger object.
	 *
	 * @var object
	 */
	public $logger;

	/**
	 * DocBlock validation object.
	 *
	 * @var object
	 */
	public $doc;

	/**
	 * Types to validate.
	 *
	 * @var array
	 */
	public $types;

	public function __construct() {

		$this->logger   = new Validate_Logger();
		$this->docblock = new Validate_DocBlcock( $this->logger );

		$this->types = array(
			'classes'    => 'class',
			'properties' => 'property',
			'methods'    => 'method',
			'functions'  => 'function',
			'hooks'      => 'hook',
		);
	}

	/**
	 * Validates File.
	 * Validates Classes, Functions and Hooks.
	 *
	 * Todo: Validate file DocBlocks, includes, class constants and more.
	 *
	 * @param array   $file Parsed file data.
	 */
	public function validate_file( $file ) {

		if ( ! is_array( $file ) ) {
			return;
		}

		$validate = $this->types;

		// These are validated when a class gets validated.
		unset( $validate['methods'], $validate['properties'] );

		foreach ( array_keys( $validate ) as $type ) {
			$this->validate_type( $file, $type );
		}
	}

	/**
	 * Validate class, function or hook type nodes.
	 *
	 * @param array   $node        Parsed data.
	 * @param string  $type        Type of node to validate.
	 * @param string  $parent_type Type of parent node. (Used for hooks)
	 * @param string  $parent_name Name of parent node. (Used for hooks)
	 */
	function validate_type( $node, $type, $parent_type = '',  $parent_name = '' ) {
		$single = $this->get_type_single( $type );

		if ( ! $single || ! $this->node_exists( $node, $type ) ) {
			return;
		}

		foreach ( $node[ $type ] as $node_type ) {
			if ( 'hook' === $single ) {
				// Hooks can have a parent node.
				$parameters = array( $node_type, $parent_type,  $parent_name );
				call_user_func_array( array( $this, 'validate_hook' ) , $parameters );
			} else {
				call_user_func( array( $this, 'validate_' . $single ), $node_type );
			}
		}
	}

	/**
	 * Validate class.
	 *
	 * @param array   $node Parsed class data.
	 */
	function validate_class( $node ) {
		// Todo: Validate constants
		$this->validate_class_member( $node, 'properties' );
		$this->validate_class_member( $node, 'methods' );
	}

	/**
	 * Validate methods and properties of a class.
	 *
	 * @param array   $class_node Parsed class data.
	 * @param string  $type       Type of node. ('properties', 'methods')
	 */
	public function validate_class_member( $class_node, $type ) {

		$single = $this->get_type_single( $type );

		if ( ! $single || ! $this->node_exists( $class_node, $type ) ) {
			return;
		}

		$classname = get_name( $class_node );

		foreach ( $class_node[ $type ] as $node ) {

			if ( $this->docblock->has_docblock( $node, $single, 'class', $classname ) ) {
				// Validate DocBlock.
				$this->docblock->validate_docblock( $node, $single, 'class', $classname );
			}

			if ( 'methods' === $type ) {
				$name = get_name( $node );
				// Validate hooks.
				$this->validate_type( $node, 'hooks', $single, $name );
			}
		}
	}

	/**
	 * Validate function.
	 *
	 * @param array   $node Parsed function data.
	 */
	function validate_function( $node ) {
		if ( ! $node ) {
			return;
		}

		$name = get_name( $node );

		if ( $this->docblock->has_docblock(  $node, 'function' ) ) {
			// Validate DocBlock.
			$this->docblock->validate_docblock( $node, 'function' );
		}

		// Validate hooks.
		$this->validate_type( $node, 'hooks', 'function',  $name );
	}

	/**
	 * Validate hook.
	 *
	 * @param array   $node        Parsed Hook data.
	 * @param string  $parent_type Type of parent node.
	 * @param string  $parent_name Name of parent node.
	 */
	function validate_hook( $node, $parent_type = '', $parent_name = '' ) {

		if ( !$node ) {
			return;
		}

		$name     = get_name( $node );
		$name_raw = get_name_raw( $node );
		$type     = get_type( $node );
		$line     = get_line( $node );
		$desc     = get_doc_description( $node );

		$msg = validate_hook_name( $node );
		if ( $msg ) {
			$msg .= $this->logger->log_type_message( $name_raw, $type, $parent_type, $parent_name, $line );
			if( 0 === strpos($msg, 'Hook name could be more succinct') ) {
				$this->logger->log_notice( $name, $type, $msg );
			} else {
				$this->logger->log( $name, $type, $msg );
			}
		}

		if ( $this->docblock->has_docblock( $node, $type, $parent_type, $parent_name ) ) {
			if ( 0 === strpos( $desc, 'This action is documented in' ) ) {
				return;
			}

			if ( 0 === strpos( $desc, 'This filter is documented in' ) ) {
				return;
			}

			// Validate DocBlock.
			$this->docblock->validate_docblock( $node, $type, $parent_type, $parent_name );
		}
	}

	/**
	 * Check if node type exists.
	 *
	 * @param array   $node Parsed data.
	 * @param string  $type Type.
	 * @return Bool   Returns true if node type exists in data.
	 */
	function node_exists( $node, $type ) {
		return isset( $node[ $type ] ) && $node[ $type ];
	}

	/**
	 * Returns single node type name.
	 *
	 * @param string  $plural Plural node type name
	 * @return string Single node type name or empty string.
	 */
	function get_type_single( $plural ) {
		return isset( $this->types[ $plural ] ) ? $this->types[ $plural ] : '';
	}

	/**
	 * Get the current log
	 *
	 * @return array Array with log messages
	 */
	public function get_log() {
		return $this->logger->get_log();
	}

	/**
	 * Flush the logs.
	 */
	public function flush_log() {
		$this->logger->flush_log();
	}
}
