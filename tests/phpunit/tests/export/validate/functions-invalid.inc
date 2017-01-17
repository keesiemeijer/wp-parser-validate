<?php


function no_docblock_function( $thing, $var ) {
}

/**
 *
 *
 * @since 3.9.4
 *
 * @see Function/method/class relied on
 * @link URL
 * @global type $varname Short description.
 *
 * @param type    $thing Description.
 * @param type    $var   Optional. Description.
 * @return type Description.
 */
function missing_description_function( $thing, $var ) {
}

/**
 * Short description. (use period)
 *
 * Long description.
 *
 * @see Function/method/class relied on
 * @link URL
 * @global type $varname Short description.
 *
 * @param type    $thing Description.
 * @param type    $var   Optional. Description.
 * @return type Description.
 */
function missing_since_function( $thing, $var ) {
}

/**
 * Short description. (use period)
 *
 * Long description.
 *
 * @since 1
 *
 * @see Function/method/class relied on
 * @link URL
 * @global type $varname Short description.
 *
 * @param type    $thing Description.
 * @param type    $var   Optional. Description.
 * @return type Description.
 */
function wrong_version_function( $thing, $var ) {
}

/**
 * Short description. (use period)
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
 * @return type Description.
 */
function missing_param_function( $thing, $var ) {
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
function too_many_params_function( $thing, $var ) {
}


/**
 * Short description. (use period)
 *
 * Long description.
 *
 * @since 3.9.0
 *
 * @see Function/method/class relied on
 * @link URL
 * @global type $varname Short description.
 *
 * @param type    $thing
 * @param type    $var   Optional. Description.
 * @return type Description.
 */
function missing_param_description_function( $thing, $var ) {
}

/**
 * Short description. (use period)
 *
 * Long description.
 *
 * @since 3.9.0
 *
 * @see Function/method/class relied on
 * @link URL
 * @global type $varname Short description.
 *
 * @param type    $wrong Description.
 * @param type    $var   Optional. Description.
 * @return type Description.
 */
function mismatched_params_function( $thing, $var ) {
}

/**
 * Short description. (use period)
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
 * @param type    var Description.
 * @return type Description.
 */
function missing_variable_function( $thing, $var ) {
}


/**
 * Short description. (use period)
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
 * @return void
 */
function return_void_function( $thing, $var ) {
}
