<?php

/**
 * A parent test case class for the data export tests.
 */

namespace WP_Parser_Validate\Tests;

/**
 * Parent test case for data export tests.
 */
class Import_UnitTestCase extends Export_UnitTestCase {

	/**
	 * The importer instace used in the tests.
	 *
	 * @var \WP_Parser_Validate\Importer
	 */
	protected $importer;

	/**
	 * Set up before the tests.
	 */
	public function setUp() {

		parent::setUp();

		// Todo: create validation importer.

		// $this->importer = new \WP_Parser_Validate\Importer;
		// $this->importer->import( array( $this->export_data ) );
	}
}
