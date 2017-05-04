<?php
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';

	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		\WP_CLI::add_command( 'parser', 'WP_Parser_Validate\\Command' );
	}
}