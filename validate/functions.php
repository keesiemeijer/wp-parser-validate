<?php
namespace keesiemeijer\WP_Parser_Validate;

/**
 * Whether the phpdoc-parser is installed as a dependency.
 *
 * @return bool True if installed.
 */
function is_wp_parser_loaded() {
	$classes = array(
		'File_Reflector',
		'Function_Call_Reflector',
		'Method_Call_Reflector',
		'Static_Method_Call_Reflector',
		'WP_CLI_Logger'
	);

	foreach ( $classes as $class ) {
		if ( ! class_exists( "\WP_Parser\\" . $class ) ) {
			return false;
		}
	}

	if ( ! function_exists( '\WP_Parser\parse_files' ) ) {
		return false;
	}

	return true;
}

/**
 * Checks if it's a valid WordPress version number.
 *
 * @param string $version Version number.
 * @return bool            Returns true if version number is valid.
 */
function is_valid_wp_version( $version ) {

	$version = trim( (string) $version );

	// Remove development version
	// Remove strange versions like 1.2-mingus, etc.
	if ( false !== strpos( $version, '-' ) ) {
		$version = explode( '-', $current_version, 2 );
		$version = (string) $version[0];
	}

	$valid_versions = array( '1.5', '1.2', '1.0', '0.71' );
	if ( in_array( $version, $valid_versions, true ) ) {
		return true;
	}

	// muuuuu!
	if ( 0 === strpos( strtolower( $version ), 'mu' ) ) {
		return true;
	}

	// Unknown
	if ( 0 === strpos( strtolower( $version ), 'unknown' ) ) {
		return true;
	}

	// Match first 3 digits to be valid.
	// 1.5.1.3 is a valid WP version, should be allowed in DocBlock.
	return preg_match( '/\d+\.\d+\.\d+/', trim( $version ) );
}

/**
 * Removes passed by reference (&) from an argument.
 *
 * @param string $argument Argument.
 * @return string           Argument with passed by reference removed.
 */
function remove_reference( $argument ) {
	return trim( ltrim( $argument, '&' ) );
}

/**
 * Get array values from a string.
 *
 * This function tries to get array values from a string by
 * matching a string starting with 'array(' and ending with ')'.
 * The parser returns all ref array hook parameters in a string.
 *
 * @param string $args Hook reference argument.
 * @return array        Hook reference arguments.
 */
function get_array_values_from_string( $args ) {

	if ( ! is_string( $args ) ) {
		return false;
	}

	$args = trim( $args );

	// Match a string starting with 'array(' and ending with ')'.
	if ( ! ( ( 0 === strpos( $args, 'array(' ) ) && ( ')' === substr( $args, -1 ) ) ) ) {
		return false;
	}

	$args = substr( $args, 6 );
	$args = substr( $args, 0, -1 );
	$args = explode( ',', $args );
	$args = array_map( 'trim', $args );
	$args = array_map( __NAMESPACE__ . '\\remove_reference', $args );

	return $args;
}

/**
 * Checks if a type is a hook type.
 *
 * @param string $type Type.
 * @return bool          Returns true if it's a hook type.
 */
function is_hook( $type ) {
	return in_array( $type, array( 'filter', 'action', 'filter_reference',  'action_reference' ) );
}

/**
 * Whether a hook name is concatenated.
 *
 * Checks hooks names for array keys ("hook_{$arr['val']}")
 * or object properties "hook_{$obj->prop}"
 *
 * @param array $node Parsed hook data.
 * @return boolean    True when name is concatenated
 */
function is_hookname_concatenated( $node ) {
	return isset( $node['concat'] ) && $node['concat'];
}

/**
 * Whether a hook name is succinct.
 *
 *
 * @param array $node Parsed hook data.
 * @return boolean       [description]
 */
function is_hookname_succinct( $node ) {
	$name_raw = get_name_raw( $node );
	$invalid_chars = array_filter( array( '[', '->', ), function( $chars ) use ( $name_raw ) {
			return false !== strpos( $name_raw, $chars );
		} );

	if ( ! empty( $invalid_chars ) ) {
		return false;
	}

	return true;
}


/**
 * Filters a list of objects, based on a set of key => value arguments.
 * See: wp_list_filter();
 *
 * @param array  $list     An array of objects to filter.
 * @param array  $args     Optional. An array of key => value arguments to match
 *                         against each object. Default empty array.
 * @param string $operator Optional. The logical operation to perform. 'AND' means
 *                         all elements from the array must match. 'OR' means only
 *                         one element needs to match. 'NOT' means no elements may
 *                         match. Default 'AND'.
 * @return array Array of found values.
 */
function filter( $list, $args = array(), $operator = 'AND' ) {

	if ( ! is_array( $list ) || empty( $args ) ) {
		return array();
	}

	$operator = strtoupper( $operator );

	if ( ! in_array( $operator, array( 'AND', 'OR', 'NOT' ), true ) ) {
		return array();
	}

	$count = count( $args );
	$filtered = array();

	foreach ( $list as $key => $obj ) {
		$to_match = (array) $obj;

		$matched = 0;
		foreach ( $args as $m_key => $m_value ) {
			if ( array_key_exists( $m_key, $to_match ) && $m_value == $to_match[ $m_key ] ) {
				$matched++;
			}
		}

		if (
			( 'AND' == $operator && $matched == $count ) ||
			( 'OR' == $operator && $matched > 0 ) ||
			( 'NOT' == $operator && 0 == $matched )
		) {
			$filtered[ $key ] = $obj;
		}
	}

	$list = $filtered;

	return $list;
}
