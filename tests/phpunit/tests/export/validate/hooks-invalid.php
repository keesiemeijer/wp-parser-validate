<?php
/**
 * A test case for validating docblocks.
 */

namespace WP_Parser_Validate\Tests;

/**
 * Validate docblocks for hooks.
 */
class Validate_Hooks extends Export_UnitTestCase {

	private $logs = array();

	/**
	 * Get validation logs.
	 */
	public function setUp() {

		parent::setUp();

		$validate = new \WP_Parser_Validate\Validate();
		$validate->validate_file( $this->export_data );

		foreach ( $validate->get_log() as $logs ) {
			foreach ( $logs as $log ) {
				$this->logs[] = $log;
			}
		}
	}

	/**
	 * Test filter filter reference, action and action reference without DocBlocks.
	 */
	public function test_function_missing_docblocks() {
		$hooks = array( 'filter', 'action' );
		foreach ( $hooks as $hook ) {
			$this->assertContainsSubstring( "No DocBlock found for {$hook} 'no_docblock_{$hook}'", $this->logs );
			$this->assertContainsSubstring( "No DocBlock found for {$hook}_reference 'no_docblock_{$hook}_ref'", $this->logs );
		}
	}


	/**
	 * Test parser issue https://github.com/WordPress/phpdoc-parser/issues/185.
	 */
	public function test_good_filter_with_missing_docblock() {
		$this->assertContainsSubstring( "No DocBlock found for filter 'good_filter_with_missing_docblock'", $this->logs );
	}

	/**
	 * Test filter with concatenated name.
	 */
	public function test_filter_concatenated_name() {
		//Invalid concatenated hook name for filter ''invalid_concatenated_name' . $filter'
		$this->assertContainsSubstring( "Invalid concatenated hook name for filter ''invalid_concatenated_name' . " . '$filter' ."'", $this->logs );
	}

	/**
	 * Test filter with missing description.
	 */
	public function test_filter_missing_description() {
		$this->assertContainsSubstring( "No description found in DocBlock for filter 'missing_description_filter'", $this->logs );
	}

	/**
	 * Test filter with missing @since tag.
	 */
	public function test_filter_missing_since() {
		$this->assertContainsSubstring( "Missing @since tag in DocBlock for filter 'missing_since_filter'", $this->logs );
	}

	/**
	 * Test function with wrong version in @since tag.
	 */
	public function test_filter_wrong_version() {
		$this->assertContainsSubstring( "Invalid version in @since tag in DocBlock for filter 'wrong_version_filter'", $this->logs );
	}

	/**
	 * Test filter with missing parameters.
	 */
	public function test_filter_missing_parameters() {
		$this->assertContainsSubstring( "Missing parameters in DocBlock for filter 'missing_param_filter'", $this->logs );
	}

	/**
	 * Test filter reference with missing parameters.
	 */
	public function test_filter_ref_missing_parameters() {
		$this->assertContainsSubstring( "Missing parameters in DocBlock for filter_reference 'missing_param_filter_ref'", $this->logs );
	}

	/**
	 * Test filter with too many parameters.
	 */
	public function test_filter_too_many_parameters() {
		$this->assertContainsSubstring( "Too many parameters in DocBlock for filter 'too_many_params_filter'", $this->logs );
	}

	/**
	 * Test filter with missing @param description.
	 */
	public function test_filter_missing_param_description() {
		$this->assertContainsSubstring( "Missing description for @param '". '$value' . "' in DocBlock for filter 'missing_param_description_filter'", $this->logs );
	}

	/**
	 * Test filter with mismatched @params.
	 */
	public function test_filter_mismatched_param() {
		$this->assertContainsSubstring( "Mismatched @param tag name '". '$new_value' . "' in DocBlock for filter 'mismatched_params_filter'", $this->logs );
	}

	/**
	 * Test function with missing @param variable.
	 */
	public function test_filter_missing_param_variable() {
		$this->assertContainsSubstring( "Missing @param variable '". '$value' . "' in DocBlock for filter 'missing_variable_filter'", $this->logs );
	}

	/**
	 * Test warning for not succinct hook name.
	 */
	public function test_filter_not_succinct() {
		$this->assertContainsSubstring( "Hook name could be more succinct for filter '" . '"not_succinct_filter_name_{$this->filter[' . "'" . 'value' . "']}", $this->logs );
	}
}
