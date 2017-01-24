<?php
/**
 * A test case for exporting docblocks.
 */

namespace WP_Parser_Validate\Tests;

/**
 * Validate docblocks for hooks.
 */
class Validate_Valid_Hooks extends Export_UnitTestCase {

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
	 * Test that filters are found.
	 */
	public function test_hooks_are_found() {
		$this->assertTrue( ( isset( $this->export_data['hooks'] ) && !empty( $this->export_data['hooks'] ) ) );
	}

	/**
	 * Test that filters validate.
	 */
	public function test_hooks_validate() {
		$this->assertEmpty( $this->logs );
	}

}
