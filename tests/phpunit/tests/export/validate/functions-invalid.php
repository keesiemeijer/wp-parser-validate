<?php
/**
 * A test case for validating docblocks.
 */

namespace WP_Parser_Validate\Tests;

/**
 * Validate docblocks for functions.
 */
class Validate_Functions extends Export_UnitTestCase {

	private $logs = array();

	/**
	 * Get validation logs.
	 */
	public function setUp() {

		parent::setUp();

		$validate = new \WP_Parser_Validate\Validate();
		$validate->validate_file( $this->export_data );

		$this->logs = $validate->get_log_messages();
	}

	/**
	 * Test function with no DocBlock.
	 */
	public function test_function_missing_docblock() {
		$this->assertContainsSubstring( "No DocBlock found for function 'no_docblock_function'", $this->logs );
	}

	/**
	 * Test function with missing description.
	 */
	public function test_function_missing_description() {
		$this->assertContainsSubstring( "No description found in DocBlock for function 'missing_description_function'", $this->logs );
	}

	/**
	 * Test function with missing @since tag.
	 */
	public function test_function_missing_since() {
		$this->assertContainsSubstring( "Missing @since tag in DocBlock for function 'missing_since_function'", $this->logs );
	}

	/**
	 * Test function with wrong version in @since tag.
	 */
	public function test_function_wrong_version() {
		$this->assertContainsSubstring( "Invalid version in @since tag in DocBlock for function 'wrong_version_function'", $this->logs );
	}

	/**
	 * Test function with missing parameters.
	 */
	public function test_function_missing_parameters() {
		$this->assertContainsSubstring( "Missing parameters in DocBlock for function 'missing_param_function'", $this->logs );
	}

	/**
	 * Test function with too many parameters.
	 */
	public function test_function_too_many_parameters() {
		$this->assertContainsSubstring( "Too many parameters in DocBlock for function 'too_many_params_function'", $this->logs );
	}

	/**
	 * Test function with missing @param description.
	 */
	public function test_function_missing_param_description() {
		$this->assertContainsSubstring( "Missing description for @param '". '$thing' . "' in DocBlock for function 'missing_param_description_function'", $this->logs );
	}

	/**
	 * Test function with mismatched @params.
	 */
	public function test_function_mismatched_param() {
		$this->assertContainsSubstring( "Mismatched @param tag name '". '$wrong' . "' in DocBlock for function 'mismatched_params_function'", $this->logs );
	}

	/**
	 * Test function with missing @param variable.
	 */
	public function test_function_missing_param_variable() {
		//Missing @param variable '$var' in DocBlock for function 'missing_variable_function'
		$this->assertContainsSubstring( "Missing @param variable '". '$var' . "' in DocBlock for function 'missing_variable_function'", $this->logs );
	}

	/**
	 * Test function that returns void.
	 */
	public function test_function_return_void() {
		$this->assertContainsSubstring( "The @return tag with value 'void' can be omitted in DocBlock for function 'return_void_function'", $this->logs );
	}
}
