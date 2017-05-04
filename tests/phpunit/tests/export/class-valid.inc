<?php

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
     * This is a properly documented private property.
     *
     * @access private
     *
     * @since 2.1.0
     * @var array
     * @access private
     */
    private $good_doc_private_property_from_good_doc_class = array();

    /**
     * This is a properly documented protected property.
     *
     * @access protected
     *
     * @since 2.1.0
     * @var array
     * @access protected
     */
    protected $good_doc_protected_property_from_good_doc_class = array();

    /**
     * This is a properly documented public property.
     *
     * @access public
     *
     * @since 2.1.0
     * @var array
     * @access public
     */
    public $good_doc_public_property_from_good_doc_class = array();

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
    public function good_doc_public_method_from_good_doc_class( $code = '', $message = '', $data = '' ) {
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
    public function good_doc_public_method_from_good_doc_class_with_filter( $code = '', $message = '', $data = '' ) {
        /**
         * This is a well documented filter.
         *
         * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
         * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
         *
         * @since 3.9.0
         *
         * @param array   $mce_translation Key/value pairs of strings.
         * @param string  $mce_locale      Locale.
         */
        $mce_translation = apply_filters( 'good_static_filter', $mce_translation, $mce_locale );
    }

    /**
     * This is a properly documented protected method.
     *
     * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
     * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
     *
     * @since 2.1.0
     * @access protected
     *
     * @param string|int $code    Error code
     * @param string  $message Error message
     * @param mixed   $data    Optional. Error data.
     * @return WP_Error
     */
    protected function good_doc_protected_method_from_good_doc_class( $code = '', $message = '', $data = '' ) {
    }

    /**
     * This is a properly documented private method.
     *
     * Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
     * Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
     *
     * @since 2.1.0
     * @access private
     *
     * @param string|int $code    Error code
     * @param string  $message Error message
     * @param mixed   $data    Optional. Error data.
     * @return WP_Error
     */
    private function good_doc_private_method_from_good_doc_class( $code = '', $message = '', $data = '' ) {
    }
}
