<?php

/**
 * The autoloader
 */
class JftAssistant_Autoloader {

	/**
	 * Determines the class to load
	 *
	 * @param string $class the class name.
	 */
	public static function autoload( $class ) {
		if ( 0 !== strpos( $class, 'JftAssistant' ) ) {
			return;
		}

		if ( is_file(
			$file = dirname( __FILE__ ) . '/../' . str_replace(
				array( '_', "\0" ), array(
					'/',
					'',
				), $class
			) . '.php'
		) ) {
			require $file;

		}
	}

	/**
	 * Register our autoloader
	 *
	 * @param string|bool $prepend which name to prepend the class with.
	 */
	public static function register( $prepend = false ) {
		if ( version_compare( phpversion(), '5.3.0', '>=' ) ) {
			spl_autoload_register( array( new self(), 'autoload' ), true, $prepend );
		} else {
			spl_autoload_register( array( new self(), 'autoload' ) );
		}
	}

}
