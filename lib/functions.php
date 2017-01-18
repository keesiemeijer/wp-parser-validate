<?php
namespace WP_Parser_Validate;

/**
 * Parses content.
 *
 * @param string  $content Content.
 * @return array Array with parsed data.
 */
function parse_content( $content ) {

	if ( ! ( is_string( $content ) && !empty( $content ) ) ) {
		return;
	}

	$data = array();

	// Fake the parser with this file.
	$file = dirname( __FILE__ );

	if ( is_readable(  $file ) ) {
		// Set content when parsing files
		$data = parse_files( array( $file ), '', $content );
	}

	return $data;
}

/**
 * Displays validation errors for code.
 *
 * @param string  $code Code to validate.
 */
function get_validation_html( $code = '' ) {
	$out  ='';
	$code = trim( (string) $code );

	if ( empty( $code ) ) {
		return "<h3>Please enter some code to validate</h3>";
	}

	// Parsing serrors.
	ob_start();
	parse_content( $code );
	$error = ob_get_contents();
	ob_end_clean();

	if ( $error ) {
		$out .= "<h3>The code contains errors</h3>";
		$out .= "<p>{$error}</p>";
		return $out;
	}

	$data = parse_content( $code );
	if ( ! ( isset( $data[0] ) && $data[0] ) ) {
		return;
	}

	$data = $data[0];
	$found = false;
	foreach ( array( 'functions', 'classes', 'hooks' ) as $type ) {
		if ( isset( $data[ $type ] ) ) {
			$found = true;
		}
	}

	if ( !$found ) {
		$out .= "<h3>The parser could not find any functions, classes, methods or hooks to validate</h3>";
		$out .= "<p>Please include a function, class, method or hook and make sure the code is valid (i.e. doesn't produce any PHP parsing errors).</p>";
		return $out;
	}

	$validate = new Validate;
	$validate->logger->set_format( 'html' );
	$validate->validate_file( $data );
	$log = $validate->logger->get_log();

	if ( !empty( $log ) ) {
		$out .= "<h3>Code did not pass validation</h3>";
		ob_start();
		$validate->logger->display_logs();
		$out .= ob_get_clean();

	} else {
		$out .= "<h3 class='valid'>Passed Validation!</h3>";
	}

	return $out;
}

/**
 * Checks if it's a valid WordPress version number.
 *
 * @param string  $version Version number.
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
 * @param string  $argument Argument.
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
 *
 * @param string  $args Hook reference argument.
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
 * @param string  $type Type.
 * @return bool          Returns true if it's a hook type.
 */
function is_hook( $type ) {
	return in_array( $type, array( 'filter', 'action', 'filter_reference',  'action_reference' ) );
}

/**
 * Validate a hook name.
 *
 * Todo: Get proper raw value of the hook name when parsing.
 * The parser returns "hook_name_$var" as "hook_name_{$var}"
 *
 * @param array   $node Parsed hook data.
 */
function validate_hook_name( $node ) {

	$name_raw = get_name_raw( $node );
	$type     = get_type( $node );

	if ( isset( $node['concat'] ) && $node['concat'] ) {
		return 'Invalid concatenated hook name';
	}

	// Hook names with array keys ("hook_{$arr['val']}") or object properties "hook_{$obj->prop}"
	$invalid_chars = array_filter( array( '[', '->', ), function( $chars ) use ( $name_raw ) {
			return false !== strpos( $name_raw, $chars );
		} );

	if ( !empty( $invalid_chars ) ) {
		return 'Hook name could be more succinct';
	}

	return '';
}


/**
 * Filters a list of objects, based on a set of key => value arguments.
 * See: wp_list_filter();
 *
 * @param array   $list     An array of objects to filter.
 * @param array   $args     Optional. An array of key => value arguments to match
 *                         against each object. Default empty array.
 * @param string  $operator Optional. The logical operation to perform. 'AND' means
 *                         all elements from the array must match. 'OR' means only
 *                         one element needs to match. 'NOT' means no elements may
 *                         match. Default 'AND'.
 * @return array Array of found values.
 */
function filter( $list, $args = array(), $operator = 'AND' ) {

	if ( !is_array( $list ) || empty( $args ) ) {
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
			$filtered[$key] = $obj;
		}
	}

	$list = $filtered;

	return $list;
}
