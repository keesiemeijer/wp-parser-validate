<?php
namespace WP_Parser_Validate;

use WP_CLI;
use WP_CLI_Command;

/**
 * Converts PHPDoc markup into a template ready for import to a WordPress blog.
 */
class Command extends WP_CLI_Command {

	/**
	 * Validate Parsed Data
	 *
	 * @subcommand validate
	 * @synopsis   <directory> [--exclude-notices] [--import-internal] [--user]
	 *
	 * @param array   $args
	 * @param array   $assoc_args
	 */
	public function validate( $args, $assoc_args ) {
		list( $directory ) = $args;
		$directory = realpath( $directory );

		if ( empty( $directory ) ) {
			WP_CLI::error( sprintf( "Can't read %1\$s. Does the file exist?", $directory ) );
			exit;
		}

		WP_CLI::line();

		$assoc_args['validate'] = true;

		// Import data
		$this->_do_import( $this->_get_phpdoc_data( $directory, 'array' ), $assoc_args );
	}

	/**
	 * Generate the data from the PHPDoc markup.
	 *
	 * @param string  $path   Directory or file to scan for PHPDoc
	 * @param string  $format What format the data is returned in: [json|array].
	 *
	 * @return string|array
	 */
	protected function _get_phpdoc_data( $path, $format = 'json' ) {
		WP_CLI::line( sprintf( 'Extracting PHPDoc from %1$s. This may take a few minutes...', $path ) );
		$is_file = is_file( $path );
		$files   = $is_file ? array( $path ) : get_wp_files( $path );
		$path    = $is_file ? dirname( $path ) : $path;

		if ( $files instanceof \WP_Error ) {
			WP_CLI::error( sprintf( 'Problem with %1$s: %2$s', $path, $files->get_error_message() ) );
			exit;
		}

		$output = parse_files( $files, $path );

		if ( 'json' == $format ) {
			return json_encode( $output, JSON_PRETTY_PRINT );
		}

		return $output;
	}

	/**
	 * Import the PHPDoc $data into WordPress posts and taxonomies
	 *
	 * @param array   $data
	 * @param array   $assoc_args Optional arguments.
	 * @param bool    $deprecated Not used.
	 */
	protected function _do_import( array $data, $assoc_args = array(), $deprecated = false ) {

		// Validate the data
		$validate = new Importer;
		$validate->setLogger( new WP_CLI_Logger() );
		$validate->validate( $data, $assoc_args );

		WP_CLI::line();
	}
}
