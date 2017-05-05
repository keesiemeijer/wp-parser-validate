<?php
namespace keesiemeijer\WP_Parser_Validate;

class Validate_Logger {

	/**
	 * Log Messages.
	 *
	 * @access private
	 *
	 * @var array
	 */
	private $log = array();

	/**
	 * Log Format.
	 *
	 * @access private
	 *
	 * @var string
	 */
	private $format = '';

	/**
	 * Get the current log
	 *
	 * @return array Array with log messages
	 */
	public function get_log() {
		return $this->log;
	}

	/**
	 * Flush the current log
	 */
	public function flush_log() {
		$this->log = array();
	}

	/**
	 * Set format of log
	 *
	 * @param string $format Type of log. Accepts 'html' or 'wp-cli'.
	 */
	public function set_format( $format ) {
		$this->format = $format;
	}

	/**
	 * Returns string used in sprintf depending on format.
	 */
	public function format_string() {
		$format = "'%s'";
		if ( 'html' === $this->format ) {
			$format = "<span>%s</span>";
		}
		return $format;
	}

	/**
	 * Log a warning.
	 *
	 * @param string $name Name of node.
	 * @param string $type Type of node.
	 * @param string $msg  Message.
	 */
	public function log_warning( $name, $type, $msg ) {
		$this->log( $name, $type, $msg, 'Warning' );
	}

	/**
	 * Log a notice.
	 *
	 * @param string $name Name of node.
	 * @param string $type Type of node.
	 * @param string $msg  Message.
	 */
	public function log_notice( $name, $type, $msg ) {
		$this->log( $name, $type, $msg, 'Notice' );
	}

	/**
	 * Add log message to the log.
	 * Groups messages by type and name of node.
	 *
	 * @param string $name   Name of node.
	 * @param string $type   Type of node.
	 * @param string $msg    Message.
	 * @param string $prefix Prefix for message.
	 */
	public function log( $name, $type, $msg, $prefix = '' ) {
		$html_str   = "<span class='%s'>%s</span><span>:</span> ";
		$prefix     = $prefix ? $prefix : 'Invalid';
		$key_prefix = trim( preg_replace( '/[^a-z0-9_\-]/', '', strtolower( $prefix ) ) );
		$key_prefix = $key_prefix ? $key_prefix : 'unknown';
		$key_name   = trim( preg_replace( '/[^a-z0-9_\-]/', '', strtolower( $name ) ) );
		$key_name   = $key_name ? $key_name : 'unknown';
		$prefix     = ( 'html' === $this->format ) ? sprintf( $html_str, $key_prefix, $prefix ) : '';
		$type       = is_hook( $type ) ? 'hook' : $type;

		$this->log["{$type}::{$key_name}"][ $key_prefix ][] = $prefix . $msg;
	}

	/**
	 * Display log messages.
	 *
	 * @param bool $exclude_notices Whether to exclude notices or not. Default false.
	 */
	public function display_logs( $exclude_notices = false ) {
		$out  = '';
		$logs = $this->get_log_messages( $exclude_notices );

		if ( empty( $logs ) ) {
			return;
		}

		echo '<ol>';
		foreach ( $logs as $msg ) {
			echo '<li>' . $msg . '</li>';
		}
		echo '</ol>';
	}

	/**
	 * Return log messages.
	 *
	 * @param boolean $exclude_notices Whether to exclude notices or not. Default false.
	 * @return array Array with log messages.
	 */
	function get_log_messages( $exclude_notices = false ) {
		$messages = array();
		$logs     = $this->log;

		if ( empty( $logs ) ) {
			return;
		}

		$defaults = array( 'invalid' => array(), 'notice' => array() );

		foreach ( $logs as $key => $log ) {
			$type = explode( '::', $key, 2 );
			$type = ( isset( $type[0] ) && $type[0] ) ? $type[0] : '';
			$log  = array_merge( $defaults, $log );

			if ( $exclude_notices ) {
				$log = $log['invalid'];
			} else {
				$log = array_merge( $log['invalid'], $log['notice'] );
			}

			foreach ( $log as $msg ) {
				$msg = trim( exclude_message( $msg, $type ) );
				if ( $msg ) {
					$_type = $type ? str_pad( $type . ': ', 10 ) : '';
					$msg   = ( 'wp-cli' === $this->format ) ? $_type . $msg : $msg;

					$messages[] = $msg;
				}
			}
		}

		return $messages;
	}

	/**
	 * Returns a formatted log message for the type of node, with parent node and line number.
	 *
	 * @param string  $name        Name of node.
	 * @param string  $type        Type of node. ('function', 'hook', 'class', 'method', 'property')
	 * @param string  $parent_type Type of parent node.
	 * @param string  $parent_name Name of parent node.
	 * @param integer $line        Line number of node in file.
	 * @return string              Log message.
	 */
	public function format_message( $name, $type, $parent_type = '', $parent_name = '', $line = 0 ) {
		$msg = '';
		$format = $this->format_string();
		$str = "for %s {$format}";

		if ( $parent_type && $parent_name ) {
			$msg .= ' ' . sprintf( $str . " in %s {$format}", $type, $name, $parent_type, $parent_name );
		} else {
			$msg .= ' ' . sprintf( $str, $type, $name );
		}

		if ( $line ) {
			$line_str = sprintf( "line %d", $line );
			if ( 'html' === $this->format ) {
				$line_str = sprintf( '<span class="line-number" data-line-number="%d">%s</span>', $line, $line_str );
			}
			$msg .= ' (' . $line_str . ')';

		}

		return $msg;
	}

}
