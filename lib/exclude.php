<?php
namespace WP_Parser_Validate;

/**
 * Exclude third party libraries and wp-content folder.
 *
 * @param array   $file Array with file data.
 * @return bool        True if file has to be excluded.
 */
function exclude_file( $file ) {

	if ( !( isset( $file['path'] ) && $file['path'] ) ) {
		return true;
	}

	// Files to exclude.
	$exclude_files = array(
		'wp-admin/includes/class-pclzip.php',
		'wp-admin/includes/class-ftp-pure.php',
		'wp-admin/includes/class-ftp-sockets.php',
		'wp-admin/includes/class-ftp.php',
		'wp-includes/class-snoopy.php',
		'wp-includes/class-simplepie.php',
		'wp-includes/class-IXR.php',
		'wp-includes/class-phpass.php',
		'wp-includes/class-phpmailer.php',
		'wp-includes/class-pop3.php',
		'wp-includes/class-json.php',
		'wp-includes/class-smtp.php',
	);

	// Directories to exclude.
	$exclude_dirs = array(
		'wp-includes/ID3/',
		'wp-includes/Text/',
		'wp-includes/SimplePie/',
	);


	if ( in_array( $file['path'], $exclude_files ) ) {
		return true;
	}

	foreach ( $exclude_dirs as $dir ) {
		if ( 0 === strpos( $file['path'], $dir ) ) {
			return true;
		}
	}

	// Check if path starts with wp-content.
	if ( 0 === strpos( $file['path'], 'wp-content/' ) ) {
		return true;
	}

	return false;
}

/**
 * Exclude log messages.
 *
 * @param string  $msg  Log Message
 * @param string  $type Type of node.
 * @return string       Log message or empty string to exclude the message.
 */
function exclude_message( $msg, $type ) {

	if ( false !== strpos( strtolower( $msg ), "missing @access tag 'public'" ) ) {
		$msg = '';
	}

	return $msg;
}
