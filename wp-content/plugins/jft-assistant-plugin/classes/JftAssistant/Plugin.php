<?php

/**
 * The initializer of the plugin
 */
class JftAssistant_Plugin {

	/**
	 * The instance of the plugin.
	 *
	 * @var JftAssistant_Plugin
	 */
	private static $_instance;

	/**
	 * Load and return the singleton instance
	 */
	public static function get_instance() {
		if ( ! self::$_instance ) {
			self::$_instance  = new JftAssistant_Plugin();
		}
		return self::$_instance;
	}

	/**
	 * Load the classes relevant to the plugin
	 */
	public function load() {
		// @codingStandardsIgnoreStart
		@mkdir( JFT_ASSISTANT_DIR__ . 'tmp' );
		// @codingStandardsIgnoreEnd

		new JftAssistant_Admin();
	}

	/**
	 * Called when the plugin is activated
	 */
	public function activate() {
		JftAssistant_Log_Debug::init();
		new JftAssistant_Admin();
		// load the first page into the cache.
		do_action( 'jft_assistant_load_themes', 1 );
	}

	/**
	 * Called whtn the plugin is deactivate
	 */
	public function deactivate() {
		// empty.
	}
}
