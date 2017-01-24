<?php
/**
 * A test case for exporting docblocks.
 */

namespace WP_Parser_Validate\Tests;

/**
 * Validate docblocks forfunctions.
 */
class Validate_Valid_Functions extends Export_UnitTestCase {

	private $logs;

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
	 * Test that functions are found.
	 */
	public function test_functions_are_found() {
		$this->assertTrue( ( isset( $this->export_data['functions'] ) && !empty( $this->export_data['functions'] ) ) );
	}

	/**
	 * Test that function validates.
	 */
	public function test_function_validates() {
		$this->assertEmpty( $this->logs );
	}
}
