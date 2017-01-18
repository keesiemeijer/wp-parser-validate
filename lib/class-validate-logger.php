<?php
namespace WP_Parser_Validate;

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
	 * Log Messages.
	 *
	 * @access private
	 *
	 * @var array
	 */
	public $format = '';

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
	 * @param string  $format Type of log. Accepts 'html' or 'wp-cli'.
	 */
	public function set_format( $format ) {
		$this->format = $format;
	}

	/**
	 * Add log message to the log.
	 * Groups messages by type and name of node.
	 *
	 * @param string  $name Name of node.
	 * @param string  $type Type of node.
	 * @param string  $msg  Message.
	 */
	public function log( $name, $type, $msg, $prefix = '' ) {

		$prefix = $prefix ? $prefix : 'Invalid: ';
		if ( 'wp-cli' === $this->format ) {
			$prefix = '';
		}
		$msg  = ('html' === $this->format) ? lcfirst( $msg ) : $msg;
		$type = is_hook( $type ) ? 'hook' : $type;
		$name = strtolower( $name );
		$name = trim( preg_replace( '/[^a-z0-9_\-]/', '', $name ) );
		$this->log["{$type}::{$name}"][] = $prefix . $msg;
	}

	/**
	 * Add a warning to the log.
	 *
	 * @param string  $name Name of node.
	 * @param string  $type Type of node.
	 * @param string  $msg  Message.
	 */
	public function log_warning( $name, $type, $msg ) {
		$this->log( $name, $type, $msg, 'Warning: ' );
	}

	/**
	 * Add a warning to the log.
	 *
	 * @param string  $name Name of node.
	 * @param string  $type Type of node.
	 * @param string  $msg  Message.
	 */
	public function log_notice( $name, $type, $msg ) {
		$this->log( $name, $type, $msg, 'Notice: ' );
	}

	/**
	 * Display log messages.
	 */
	public function display_logs() {
		$out = '';

		$logs = $this->log;
		if ( empty( $logs ) ) {
			return;
		}

		foreach ( $logs as $key => $log ) {
			$type = explode( '::', $key, 2 );
			$type = ( isset( $type[0] ) && $type[0] ) ? $type[0] : '';

			foreach ( $log as $msg ) {
				$msg = exclude_message( $msg, $type );
				$msg = trim( $msg );

				if ( $msg ) {
					$out .= '<li>' . $msg . '</li>';
				}
			}
		}

		if ( $out ) {
			echo '<ul>' . $out . '</ul>';
		}
	}

	/**
	 * Returns a log message for the type of node, with parent node and line number.
	 *
	 * @param string  $name        Name of node.
	 * @param string  $type        Type of node. ('function', 'hook', 'class', 'method', 'property')
	 * @param string  $parent_type Type of parent node.
	 * @param string  $parent_name Name of parent node.
	 * @param integer $line        Line number of node in file.
	 * @return string              Log message.
	 */
	function log_type_message( $name, $type, $parent_type = '', $parent_name = '', $line = 0 ) {
		$msg = '';
		$str = "for %s '%s'";
		if ( 'html' === $this->format ) {
			$str = "for %s <span>%s</span>";
		}
		if ( $parent_type && $parent_name ) {
			$str .= ( 'html' === $this->format ) ? " in %s <span>%s</span>" : " in %s '%s'";
			$msg .= ' ' . sprintf( $str, $type, $name, $parent_type, $parent_name );
		} else {
			$msg .= ' ' . sprintf( $str, $type, $name );
		}

		if ( $line ) {
			$msg .= ' ' . sprintf( "(line %d)", $line );
		}

		return $msg;
	}

}
