<?php

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
function good_doc_function( $thing, $var ) {
}

/**
 * Short description. (use period)
 *
 * Long description.
 *
 * @since 3.9.0
 *
 * @link URL
 * @global type $varname Short description.
 *
 * @param type    $thing Description.
 * @param type    $var   Optional. Description.
 * @param type    $oops  Optional. Description.
 * @return type Description.
 */
function too_many_params_variadic_function( $thing, $var ) {
	$args = func_get_args();
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
 * @param type    &$var  Optional. Description.
 * @return type Description.
 */
function passed_by_reference_parameter_function( $thing, &$var ) {
}

/**
 * Short description. (use period)
 *
 * Long description.
 *
 * @since 3.9.0
 *
 * @link URL
 * @global type $varname Short description.
 *
 * @param string|array $thing {
 *     Optional. Array or string of arguments.
 *
 *     @type string       $show_option_all   Text to display for showing all categories. Default empty.
 *     @type string       $show_option_none  Text to display for showing no categories. Default empty.
 * }
 * @param type    $var   Optional. Description.
 * @return type Description.
 */
function array_parameter_function( $thing, $var ) {
}
