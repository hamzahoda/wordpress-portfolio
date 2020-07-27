<?php

namespace Leadin\admin\utils;

use Leadin\wp\Page;

/**
 * Class containing utility functions for the background iframe.
 */
class Background {
	/**
	 * Return true if the page should render a background iframe.
	 */
	public static function should_load_background_iframe() {
		return Page::is_dashboard() || Page::is_gutenberg_page();
	}
}
