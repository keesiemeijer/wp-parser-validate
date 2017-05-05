<?php
namespace keesiemeijer\WP_Parser_Validate;

/**
 * Parses content.
 *
 * @param string $content Content.
 * @return array Array with parsed data.
 */
function parse_content( $content ) {

	if ( ! ( is_string( $content ) && ! empty( $content ) ) ) {
		return;
	}

	$file       = WP_PARSER_VALIDATE_TEMP_FILE;
	$data       = array();
	$save_error = update_temp_file( $content, 'parse' );

	if ( ! $save_error ) {
		$data = parse_files( array( $file ), '' );
	} else {
		echo $save_error;
	}

	return $data;
}

/**
 * Updates the temp file used for parsing.
 *
 * @param string $content The content to write to the temp file.
 * @param string $context Should error be wrapped in paragraph tags. Default true.
 * @return string Empty string or error message if an error occurred.
 */
function update_temp_file( $content = '', $context = '' ) {
	$file    = WP_PARSER_VALIDATE_TEMP_FILE;
	$error   = "Error - Could not write to file: {$file}";
	$message = '';

	if ( is_writable( $file ) ) {
		$write_to_file = file_put_contents( $file, $content );
		if ( false === $write_to_file ) {
			$message = $error;
		}
	} else {
		$message = $error;
	}

	return ( $context === 'parse' ) ? $message : '<p>' . $message . '</p>';
}

/**
 * Updates the temp file after parsing and returns validation messages.
 *
 * @param string $message Message to return after parsing.
 * @return string Message to return after parsing.
 */
function finish_parsing( $message = '' ) {
	$save_error = update_temp_file( "<?php\n// Temp file for parsing" );
	if ( $save_error ) {
		$message .= $save_error;
	}

	return $message;
}

/**
 * Validates code and returns validation message html.
 *
 * @param string $code Code to validate.
 */
function get_validation_html( $code = '' ) {
	$html = '';
	$code = trim( (string) $code );

	if ( empty( $code ) ) {
		return "<h3>Please enter some code to validate</h3>";
	}

	if ( ! is_wp_parser_loaded() ) {
		return "<h3>Could not parse content. Missing dependencies</h3>";
	}

	// Check for parsing errors.
	ob_start();
	parse_content( $code );
	$error = ob_get_contents();
	ob_end_clean();

	if ( $error ) {
		$html .= "<h3>The code contains errors</h3>";
		$html .= "<p>{$error}</p>";
		return finish_parsing( $html );
	}

	$data = parse_content( $code );
	if ( ! ( isset( $data[0] ) && $data[0] ) ) {
		return finish_parsing( '' );
	}

	$data = $data[0];

	// Check if file contains functions classes or hooks
	$types_found = array_filter(  array( 'functions', 'classes', 'hooks' ),
		function( $type ) use ( $data ) {
			return isset( $data[ $type ] );
		} );

	if ( ! $types_found ) {
		$html .= "<h3>The parser could not find any functions, classes, methods or hooks to validate</h3>";
		$html .= "<p>Please include a function, class, method or hook and make sure the code is valid (i.e. doesn't produce any PHP parsing errors).</p>";
		return finish_parsing( $html );
	}

	$validate = new Validate;
	$validate->logger->set_format( 'html' );
	$validate->validate_file( $data );

	// Get log messages with notices excluded.
	$errors   = $validate->logger->get_log_messages( true );
	if ( ! empty( $errors ) ) {
		$html .= "<h3>Documentation did not pass validation</h3>";
	} else {
		$html .= "<h3 class='valid'>Documentation Passed Validation!</h3>";
	}

	// Get all log messages
	$messages = $validate->logger->get_log_messages();

	if ( $messages ) {
		$html .= '<ol>';
		foreach ( $messages as $msg ) {
			$html .= '<li>' . $msg . '</li>';
		}
		$html .= '</ol>';
	}

	return finish_parsing( $html );
}
