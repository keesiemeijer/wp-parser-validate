<?php
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

$content = '';
$output  = '';

if ( isset( $_REQUEST['validate_code'] ) && isset( $_REQUEST['code_content'] ) ) {
	if ( function_exists( '\WP_Parser_Validate\get_validation_html' ) ) {

		$content = (string) $_REQUEST['code_content'];
		if ( get_magic_quotes_gpc() ) {
			$content = stripslashes( (string) $_REQUEST['code_content'] );
		}

		$output = \WP_Parser_Validate\get_validation_html( $content );
	}
}

include dirname( __FILE__ ) . "/lib/form.php";
?>
