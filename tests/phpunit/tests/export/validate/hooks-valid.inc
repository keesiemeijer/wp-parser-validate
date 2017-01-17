<?php

/**
 * This is a well documented filter.
 *
 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
 *
 * @since 3.9.0
 *
 * @param array   $value     Lorem ipsum dolor sit amet, consectetur adipisicing elit.
 * @param string  $old_value Lorem ipsum dolor sit amet.
 */
$value = apply_filters( 'well_documented_filter', $value, $old_value );

// Duplicate Filter

/** This filter is documented in wp-content/plugins/wp-parser-validate/tests/phpunit/tests/export/validate/hooks-valid.inc */
$value = apply_filters( 'well_documented_filter', $value, $old_value );

/**
 * This is a well documented function.
 *
 * Long description.
 *
 * @since 3.9.0
 *
 * @see Function/method/class relied on
 * @link URL
 * @global type $varname Short description.
 *
 * @param type    $thing Description.
 * @param type    $var   Optional. Description.
 * @return type Description.
 */
function function_with_filters( $thing, $var ) {

	/**
	 * This is a well documented action.
	 *
	 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
	 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
	 *
	 * @since 3.9.0
	 *
	 * @param array   $value     Lorem ipsum dolor sit amet, consectetur adipisicing elit.
	 * @param string  $old_value Lorem ipsum dolor sit amet.
	 */
	$value = do_action( 'well_documented_action_in_function', $value, $old_value );

	// Duplicate Action

	/** This action is documented in wp-content/plugins/wp-parser-validate/tests/phpunit/tests/export/validate/hooks-valid.inc */
	$value = apply_filters( 'well_documented_action_in_function', $value, $old_value );

	/**
	 * This is a well documented filter.
	 *
	 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
	 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
	 *
	 * @since 3.9.0
	 *
	 * @param array   $value     Lorem ipsum dolor sit amet, consectetur adipisicing elit.
	 * @param string  $old_value Lorem ipsum dolor sit amet.
	 */
	if ( $value = apply_filters( 'another_well_documented_filter', $value, $old_value ) ) {
		// do stuff.
	}

	// Duplicate Filter

	/** This filter is documented in wp-content/plugins/wp-parser-validate/tests/phpunit/tests/export/validate/hooks-valid.inc */
	$value = apply_filters( 'another_well_documented_filter', $value, $old_value );

	/**
	 * This is a well documented filter ref.
	 *
	 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
	 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
	 *
	 * @since 3.9.0
	 *
	 * @param array   $value     Lorem ipsum dolor sit amet, consectetur adipisicing elit.
	 * @param string  $old_value Lorem ipsum dolor sit amet.
	 */
	if ( $value = apply_filters_ref_array( 'well_documented_filter_ref', array( $value, $old_value ) ) ) {
		// do stuff.
	}

	// Duplicate Filter Reference

	/** This filter is documented in wp-content/plugins/wp-parser-validate/tests/phpunit/tests/export/validate/hooks-valid.inc */
	$value = apply_filters_ref_array( 'well_documented_filter_ref', array( $value, $old_value ) );

	/**
	 * This is a well documented filter ref.
	 *
	 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
	 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
	 *
	 * @since 3.9.0
	 *
	 * @param array   $value     Lorem ipsum dolor sit amet, consectetur adipisicing elit.
	 * @param string  $old_value Lorem ipsum dolor sit amet.
	 */
	if ( $value = do_action_ref_array( 'well_documented_action_ref_no_array', $pieces ) ) {
		// do stuff.
	}

	// Duplicate Action Reference

	/** This action is documented in wp-content/plugins/wp-parser-validate/tests/phpunit/tests/export/validate/hooks-valid.inc */
	$value = do_action_ref_array( 'well_documented_action_ref_no_array', $pieces );
}

/**
 * This is a properly documented class.
 *
 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
 *
 * @package WordPress
 * @since 2.1.0
 */
class Good_Doc_Class {

	/**
	 * This is a properly documented public method.
	 *
	 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
	 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @param string|int $code    Error code
	 * @param string  $message Error message
	 * @param mixed   $data    Optional. Error data.
	 * @return WP_Error
	 */
	public function method_with_filter_from_good_doc_class( $code = '', $message = '', $data = '' ) {
		/**
		 * This is a well documented filter.
		 *
		 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
		 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
		 *
		 * @since 3.9.0
		 *
		 * @param array   $value     Lorem ipsum dolor sit amet, consectetur adipisicing elit.
		 * @param string  $old_value Lorem ipsum dolor sit amet.
		 */
		if ( $value = apply_filters( 'well_documented_filter_in_method', $value, $old_value ) ) {
			// do stuff.
		}

		// Duplicate Action Reference

		/** This action is documented in wp-content/plugins/wp-parser-validate/tests/phpunit/tests/export/validate/hooks-valid.inc */
		$value = apply_filters( 'well_documented_filter_in_method', $value, $old_value );
	}
}
