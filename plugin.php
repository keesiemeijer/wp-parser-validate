<?php
/**
 * Plugin Name: WP Parser Validate
 * Description: Validate DocBlocks.
 * Author: keesiemeijer
 * Author URI: https://github.com/keesiemeijer/wp-parser-validate/graphs/contributors
 * Plugin URI: https://github.com/keesiemeijer/wp-parser-validate
 */

/*
 * This plugin is based on the phpdoc-parser.
 * https://github.com/WordPress/phpdoc-parser/
 * 
 * Authors: https://github.com/WordPress/phpdoc-parser/graphs/contributors
 */

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';

	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		\WP_CLI::add_command( 'parser', 'WP_Parser_Validate\\Command' );
	}
}