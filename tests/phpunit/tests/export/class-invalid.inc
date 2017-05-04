<?php

/**
 * This is a invalid documented class.
 *
 * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
 * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
 *
 * @package WordPress
 * @since 2.1.0
 */
class Invalid_Class {

    public $property_missing_docblock = array();

    /**
     *
     *
     * @since 2.1.0
     * @var array
     */
    private $property_missing_description = array();

    /**
     * Missing since.
     *
     * @var array
     */
    private $property_missing_since = array();

    /**
     * Wrong version.
     *
     * @since 1
     * @var array
     */
    private $property_wrong_version = array();

    /**
     * Missing access.
     *
     * @since 2.1.0
     * @var array
     */
    private $property_missing_access = array();

    /**
     * Wrong access.
     *
     * @access public
     *
     * @since 2.1.0
     * @var array
     * @access protected
     */
    private $property_wrong_access = array();

    /**
     * Missing var.
     *
     * @access public
     *
     * @since 2.1.0
     * @access protected
     */
    private $property_missing_var = array();

    public function method_missing_docblock( $code = '', $message = '', $data = '' ) {
    }

    /**
     *
     *
     * @since 2.1.0
     * @access public
     *
     * @param string|int $code    Error code
     * @param string  $message Error message
     * @param mixed   $data    Optional. Error data.
     * @return WP_Error
     */
    public function method_missing_description( $code = '', $message = '', $data = '' ) {
    }

    /**
     * This is a properly documented public method.
     *
     * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
     * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
     *
     * @access public
     *
     * @param string|int $code    Error code
     * @param string  $message Error message
     * @param mixed   $data    Optional. Error data.
     * @return WP_Error
     */
    public function method_missing_since( $code = '', $message = '', $data = '' ) {
    }

    /**
     * This is a properly documented public method.
     *
     * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
     * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
     *
     * @since 2
     * @access public
     *
     * @param string|int $code    Error code
     * @param string  $message Error message
     * @param mixed   $data    Optional. Error data.
     * @return WP_Error
     */
    public function method_wrong_version( $code = '', $message = '', $data = '' ) {
    }

    /**
     * This is a properly documented public method.
     *
     * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
     * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
     *
     * @since 2.1.0
     *
     * @param string|int $code    Error code
     * @param string  $message Error message
     * @param mixed   $data    Optional. Error data.
     * @return WP_Error
     */
    private function method_missing_access( $code = '', $message = '', $data = '' ) {
    }

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
    private function method_wrong_access( $code = '', $message = '', $data = '' ) {
    }

    /**
     * This is a properly documented public method.
     *
     * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
     * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
     *
     * @since 2.1.0
     * @access public
     *
     * @param string  $message Error message
     * @param mixed   $data    Optional. Error data.
     * @return WP_Error
     */
    public function method_missing_parameters( $code = '', $message = '', $data = '' ) {
    }

    /**
     * This is a properly documented public method.
     *
     * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
     * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
     *
     * @since 2.1.0
     * @access public
     *
     * @param string|int $oops    too much.
     * @param string|int $code    Error code
     * @param string  $message Error message
     * @param mixed   $data    Optional. Error data.
     * @return WP_Error
     */
    public function method_too_many_parameters( $code = '', $message = '', $data = '' ) {
    }

    /**
     * This is a properly documented public method.
     *
     * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
     * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
     *
     * @since 2.1.0
     * @access public
     *
     * @param string|int $code
     * @param string  $message Error message
     * @param mixed   $data    Optional. Error data.
     * @return WP_Error
     */
    public function method_missing_param_description( $code = '', $message = '', $data = '' ) {
    }


    /**
     * This is a properly documented public method.
     *
     * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
     * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
     *
     * @since 2.1.0
     * @access public
     *
     * @param string|int $wrong   Error code
     * @param string  $message Error message
     * @param mixed   $data    Optional. Error data.
     * @return WP_Error
     */
    public function method_mismatched_parameters( $code = '', $message = '', $data = '' ) {
    }

    /**
     * This is a properly documented public method.
     *
     * @since 2.1.0
     * @access public
     *
     * @param string|int code    Error code
     * @param string  $message Error message
     * @param mixed   $data    Optional. Error data.
     * @return WP_Error
     */
    public function method_missing_param_variable( $code = '', $message = '', $data = '' ) {
    }

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
     * @return void
     */
    public function method_returning_void( $code = '', $message = '', $data = '' ) {
    }

}
