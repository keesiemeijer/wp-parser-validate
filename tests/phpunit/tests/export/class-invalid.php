<?php
/**
 * A test case for validating docblocks.
 */

namespace keesiemeijer\WP_Parser_Validate\Tests;

/**
 * Validate docblocks for methods and properties.
 */
class Validate_Class extends Export_UnitTestCase {

	private $logs = array();

	/**
	 * Get validation logs.
	 */
	public function setUp() {

		parent::setUp();

		$validate = new \keesiemeijer\WP_Parser_Validate\Validate();
		$validate->validate_file( $this->export_data );

		$this->logs = $validate->get_log_messages();
	}

	/**
	 * Test missing docblock.
	 */
	public function test_missing_docblock() {
		foreach ( array( 'method', 'property' ) as $type ) {
			$prefix = 'property' === $type ? '$' : '';
			$this->assertContainsSubstring( "No DocBlock found for $type '{$prefix}{$type}_missing_docblock' in class 'Invalid_Class'", $this->logs );
		}
	}

	/**
	 * Test missing description.
	 */
	public function test_missing_description() {
		foreach ( array( 'method', 'property' ) as $type ) {
			$prefix = 'property' === $type ? '$' : '';
			$this->assertContainsSubstring( "No description found in DocBlock for $type '{$prefix}{$type}_missing_description' in class 'Invalid_Class'", $this->logs );
		}
	}

	/**
	 * Test missing since.
	 */
	public function test_missing_since_tag() {
		foreach ( array( 'method', 'property' ) as $type ) {
			// Missing @since tag in DocBlock for property '$property_missing_since' in class 'Invalid_Class'
			$prefix = 'property' === $type ? '$' : '';
			$this->assertContainsSubstring( "Missing @since tag in DocBlock for $type '{$prefix}{$type}_missing_since' in class 'Invalid_Class'", $this->logs );
		}
	}

	/**
	 * Test invalid WP version.
	 */
	public function test_invalid_version() {
		foreach ( array( 'method', 'property' ) as $type ) {
			$prefix = 'property' === $type ? '$' : '';
			$this->assertContainsSubstring( "Invalid version in @since tag in DocBlock for $type '{$prefix}{$type}_wrong_version' in class 'Invalid_Class'", $this->logs );
		}
	}

	/**
	 * Test missing @access tag.
	 */
	public function test_missing_access_tag() {

		foreach ( array( 'method', 'property' ) as $type ) {
			$prefix = 'property' === $type ? '$' : '';
			$this->assertContainsSubstring( "Missing @access tag 'private' in DocBlock for $type '" . $prefix . $type . '_missing_access' . "' in class 'Invalid_Class'", $this->logs );
		}

	}

	/**
	 * Test wrong @access tag.
	 */
	public function test_wrong_access_tag() {
		foreach ( array( 'method', 'property' ) as $type ) {
			$prefix = 'property' === $type ? '$' : '';
			$this->assertContainsSubstring( "Wrong @access tag 'public' in DocBlock for $type '" . $prefix . $type . '_wrong_access' . "' in class 'Invalid_Class'", $this->logs );
		}
	}

	/**
	 * Test property without @var tag.
	 */
	public function test_property_missing_var() {
		$this->assertContainsSubstring( "Missing @var tag in DocBlock for property '" . '$property_missing_var' . "' in class 'Invalid_Class'", $this->logs );
	}

	/**
	 * Test method with missing parameters.
	 */
	public function test_method_missing_parameters() {
		$this->assertContainsSubstring( "Missing parameters in DocBlock for method 'method_missing_parameters' in class 'Invalid_Class'", $this->logs );
	}

	/**
	 * Test method with too many parameters.
	 */
	public function test_method_too_many_parameters() {
		$this->assertContainsSubstring( "Too many parameters in DocBlock for method 'method_too_many_parameters' in class 'Invalid_Class'", $this->logs );
	}

	/**
	 * Test method with missing @param description.
	 */
	public function test_method_missing_param_description() {
		$this->assertContainsSubstring( "Missing description for @param '". '$code' . "' in DocBlock for method 'method_missing_param_description' in class 'Invalid_Class'", $this->logs );
	}

	/**
	 * Test method with mismatched @params.
	 */
	public function test_method_mismatched_params() {
		$this->assertContainsSubstring( "Mismatched @param tag name '". '$wrong' . "' in DocBlock for method 'method_mismatched_parameters' in class 'Invalid_Class'", $this->logs );
	}

	/**
	 * Test method with missing @param variable.
	 */
	public function test_method_missing_param_variable() {
		$this->assertContainsSubstring( "Missing @param variable '". '$code' . "' in DocBlock for method 'method_missing_param_variable' in class 'Invalid_Class'", $this->logs );
	}

	/**
	 * Test method that returns void.
	 */
	public function test_method_return_void() {
		$this->assertContainsSubstring( "The @return tag with value 'void' can be omitted in DocBlock for method 'method_returning_void' in class 'Invalid_Class'", $this->logs );
	}
}
