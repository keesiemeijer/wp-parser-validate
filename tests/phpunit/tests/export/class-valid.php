<?php
/**
 * A test case for validating classes.
 */

namespace keesiemeijer\WP_Parser_Validate\Tests;

/**
 * Validate docblocks for methods and properties.
 */
class Validate_Valid_Class extends Export_UnitTestCase {

	private $logs;

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
	 * Test that class, methods and properties are found.
	 */
	public function test_classes_are_found() {
		$class = isset( $this->export_data['classes'] ) && !empty( $this->export_data['classes'] );
		$this->assertTrue( $class );
		$methods = isset( $this->export_data['classes'][0]['methods'] ) && !empty( $this->export_data['classes'][0]['methods'] );
		$this->assertTrue( $methods );
		$properties = isset( $this->export_data['classes'][0]['properties'] ) && !empty( $this->export_data['classes'][0]['properties'] );
		$this->assertTrue( $properties );
	}

	/**
	 * Test that class validates.
	 */
	public function test_class_validates() {
		$this->assertEmpty( $this->logs );
	}
}
