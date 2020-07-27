<?php

/**
 * The logging and debug functionality
 */
class JftAssistant_Log_Debug {

	/**
	 * The functions that writes the logs
	 *
	 * @param string $msg the message to log.
	 * @param bool   $force whether to force logging of the message.
	 */
	public static function log( $msg, $force = false ) {
		if ( ! ( $force || JFT_ASSISTANT_DEBUG__ ) ) {
			return;
		}

		error_log( date( 'F j, Y H:i:s', current_time( 'timestamp' ) ) . ' - ' . $msg );
		file_put_contents( JFT_ASSISTANT_DIR__ . 'tmp/log.log', date( 'F j, Y H:i:s', current_time( 'timestamp' ) ) . ' - ' . $msg . "\n", FILE_APPEND );
	}

	/**
	 * Intializes the logging
	 */
	public static function init() {
		// @codingStandardsIgnoreStart
		@unlink( JFT_ASSISTANT_DIR__ . 'tmp/log.log' );
		// @codingStandardsIgnoreEnd
	}
}
