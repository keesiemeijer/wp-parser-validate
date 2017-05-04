<?php
if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

\WP_CLI::add_command( 'parser', 'keesiemeijer\WP_Parser_Validate\\Command' );
