<?php
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

$content     = '';
$validation  = '';

define( 'WP_PARSER_VALIDATE_TEMP_FILE', dirname( __FILE__ ) . '/content/temp.php' );

if ( isset( $_REQUEST['validate_code'] ) && isset( $_REQUEST['code_content'] ) ) {
	if ( function_exists( '\keesiemeijer\WP_Parser_Validate\get_validation_html' ) ) {

		$content = (string) $_REQUEST['code_content'];
		if ( get_magic_quotes_gpc() ) {
			$content = stripslashes( $content );
		}


		$validation  = \keesiemeijer\WP_Parser_Validate\get_validation_html( $content );
		$content     = htmlspecialchars( $content, ENT_QUOTES, 'UTF-8' );
	}
}

include dirname( __FILE__ ) . "/view/index.php";
