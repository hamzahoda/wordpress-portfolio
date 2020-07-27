<?php
namespace Leadin\admin;

use Leadin\LeadinOptions;

/**
 * Class containing all the filters used for the admin side of the plugin.
 */
class AdminFilters {
	/**
	 * Class constructor, adds the necessary filters.
	 */
	public function __construct() {
		if ( ! defined( 'LEADIN_AFFILIATE_CODE' ) ) {
			define( 'LEADIN_AFFILIATE_CODE', 'leadin_affiliate_code' );
		}

		\add_filter( LEADIN_AFFILIATE_CODE, array( $this, 'get_affiliate_code' ), 100 );
	}

	/**
	 * If no filter was defined, try to get the affiliate code from the options.
	 *
	 * @param String $affiliate Affiliate code returned by previous filter.
	 */
	public function get_affiliate_code( $affiliate ) {
		return empty( $affiliate ) ? LeadinOptions::get_affiliate_code() : $affiliate;
	}

	/**
	 * Apply leadin_affiliate_code filter.
	 */
	public static function apply_affiliate_code() {
		return \apply_filters( LEADIN_AFFILIATE_CODE, null );
	}
}
