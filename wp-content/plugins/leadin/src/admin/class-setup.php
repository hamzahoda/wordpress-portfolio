<?php

namespace Leadin\admin;

use Leadin\utils\Validator;

/**
 * Class responsible for setting up the plugin.
 */
class Setup {
	/**
	 * Class constructor, adds the necessary hooks.
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'init' ) );
		register_deactivation_hook( LEADIN_BASE_PATH, array( $this, 'cleanup' ) );
	}

	/**
	 * `admin_init` hook
	 */
	private function init() {
		$this->validate();
		$this->hydrate_affiliate_code();
		$this->hydrate_acquisition_attribution();
	}

	/**
	 * Return affiliate code from either file or option.
	 */
	private function hydrate_affiliate_code() {
		if ( Options::get_affiliate_code() ) {
			return;
		}

		if ( FileSystem::file_exists( $file_name ) ) {
			$affiliate_code = trim( FileSystem::get_content( $file_name ) );
			add_option( 'hubspot_affiliate_code', $affiliate_code );
		}
	}

	/**
	 * Return attribution string from wither file or option.
	 */
	private function hydrate_acquisition_attribution() {
		if ( Options::get_acquisition_attribution() ) {
			return;
		}

		$file_name = 'hs_attribution.txt';

		if ( FileSystem::file_exists( $file_name ) ) {
			$acquisition_attribution = trim( FileSystem::get_content( $file_name ) );
			add_option( 'hubspot_acquisition_attribution', $acquisition_attribution );
		}
	}

	/**
	 * Validate existing options.
	 */
	private function validate() {
		$portal_id       = get_option( 'leadin_portalId' );
		$valid_portal_id = intval( $portal_id ) || ctype_digit( $portal_id );

		if ( ! $valid_portal_id ) {
			delete_option( 'leadin_portalId' );
			delete_option( 'leadin_portal_domain' );
		}

		if ( $valid_portal_id ) {
			$domain = get_option( 'leadin_portal_domain' );
			if ( ! Validator::is_valid_domain( $domain ) ) {
				delete_option( 'leadin_portal_domain' );
			}
		}
	}

	/**
	 * Plugin deactivation hook. It cleans up all the options.
	 */
	public function cleanup() {
		foreach ( array(
			'leadin_portal_domain',
			'leadin_portalId',
			'leadin_pluginVersion',
			'hubspot_affiliate_code',
			'hubspot_acquisition_attribution',
		) as $option_name
		) {
			if ( get_option( $option_name ) ) {
				delete_option( $option_name );
			}
		}
	}
}
