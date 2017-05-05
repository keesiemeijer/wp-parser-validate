<?php

apply_filters( 'no_docblock_filter', $value, $old_value );
apply_filters_ref_array( 'no_docblock_filter_ref', array( $value, $old_value ) );
do_action( 'no_docblock_action', $value, $old_value );
do_action_ref_array( 'no_docblock_action_ref', array( $value, $old_value ) );

/**
 * This is a well documented dynamic filter.
 *
 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
 *
 * @since 2.6.0
 *
 * @param mixed   $value     The new, unserialized option value.
 * @param mixed   $old_value The old option value.
 */
$value = apply_filters( 'invalid_concatenated_name' . $filter, $value, $old_value );

/**
 * This is a well documented dynamic filter.
 *
 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
 *
 * @since 2.6.0
 *
 * @param mixed   $value     The new, unserialized option value.
 * @param mixed   $old_value The old option value.
 */
$value = apply_filters( "not_succinct_filter_name_{$this->filter}", $value, $old_value );

/**
 *
 *
 * @since 2.6.0
 *
 * @param mixed   $value     The new, unserialized option value.
 * @param mixed   $old_value The old option value.
 */
$value = apply_filters( 'missing_description_filter', $value, $old_value );

/**
 * This is a well documented dynamic filter.
 *
 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
 *
 * @param mixed   $value     The new, unserialized option value.
 * @param mixed   $old_value The old option value.
 */
$value = apply_filters( 'missing_since_filter', $value, $old_value );

/**
 * This is a well documented dynamic filter.
 *
 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
 *
 * @since 2
 *
 * @param mixed   $value     The new, unserialized option value.
 * @param mixed   $old_value The old option value.
 */
$value = apply_filters( 'wrong_version_filter', $value, $old_value );

/**
 * This is a well documented dynamic filter.
 *
 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
 *
 * @since 2.6.0
 *
 * @param mixed   $value The new, unserialized option value.
 */
$value = apply_filters( 'missing_param_filter', $value, $old_value );

/**
 * This is a well documented dynamic filter.
 *
 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
 *
 * @since 2.6.0
 *
 * @param mixed   $value The new, unserialized option value.
 */
$value = apply_filters_ref_array( 'missing_param_filter_ref', array( $value, $old_value ) );

/**
 * This is a well documented dynamic filter.
 *
 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
 *
 * @since 2.6.0
 *
 * @param mixed   $value       The new, unserialized option value.
 * @param mixed   $old_value   The old option value.
 * @param mixed   $older_value The old option value.
 */
$value = apply_filters( 'too_many_params_filter', $value, $old_value );

/**
 * This is a well documented dynamic filter.
 *
 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
 *
 * @since 2.6.0
 *
 * @param mixed   $value
 * @param mixed   $old_value The old option value.
 */
$value = apply_filters( 'missing_param_description_filter', $value, $old_value );

/**
 * This is a well documented dynamic filter.
 *
 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
 *
 * @since 2.6.0
 *
 * @param mixed   $new_value The new, unserialized option value.
 * @param mixed   $old_value The old option value.
 */
$value = apply_filters( 'mismatched_params_filter', $value, $old_value );

/**
 * This is a well documented dynamic filter.
 *
 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
 *
 * @since 2.6.0
 *
 * @param mixed   value The new, unserialized option value.
 * @param mixed   $old_value The old option value.
 */
$value = apply_filters( 'missing_variable_filter', $value, $old_value );

/**
 * https://github.com/WordPress/phpdoc-parser/issues/185.
 *
 * @since 2.6.0
 *
 * @param mixed   $value     The new, unserialized option value.
 * @param mixed   $old_value The old option value.
 */
if ( apply_filters( 'good_filter_with_missing_docblock', $value, $old_value ) ) {
	/**
	 * This is a well documented dynamic filter.
	 *
	 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
	 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
	 *
	 * @since 2.6.0
	 *
	 * @param mixed   $value     The new, unserialized option value.
	 * @param mixed   $old_value The old option value.
	 */
	$value = apply_filters( 'another_good_filter', $value, $old_value );
}

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
function invalid_hooks_function( $thing, $var ) {
	/**
	 * This is a well documented dynamic filter.
	 *
	 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
	 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
	 *
	 * @since 2.6.0
	 *
	 * @param mixed   $value     The new, unserialized option value.
	 * @param mixed   $old_value The old option value.
	 */
	$value = apply_filters( "not_succinct_filter_name_{$this->filter}", $value, $old_value );

	/**
	 * This is a well documented dynamic filter.
	 *
	 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
	 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
	 *
	 * @since 2.6.0
	 *
	 * @param mixed   $value     The new, unserialized option value.
	 * @param mixed   $old_value The old option value.
	 */
	$value = apply_filters( 'invalid_concatenated_name' . $filter, $value, $old_value );
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
    public function invalid_hooks_method( $code = '', $message = '', $data = '' ) {

		/**
		 * This is a well documented dynamic filter.
		 *
		 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
		 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
		 *
		 * @since 2.6.0
		 *
		 * @param mixed   $value     The new, unserialized option value.
		 * @param mixed   $old_value The old option value.
		 */
		$value = apply_filters( "not_succinct_filter_name_{$this->filter}", $value, $old_value );

		/**
		 * This is a well documented dynamic filter.
		 *
		 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
		 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
		 *
		 * @since 2.6.0
		 *
		 * @param mixed   $value     The new, unserialized option value.
		 * @param mixed   $old_value The old option value.
		 */
		$value = apply_filters( 'invalid_concatenated_name' . $filter, $value, $old_value );
    }
}
