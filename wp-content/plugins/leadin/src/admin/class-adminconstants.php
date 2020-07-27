<?php
namespace Leadin\admin;

use Leadin\admin\Links;
use Leadin\admin\utils\DeviceId;
use Leadin\utils\Versions;
use Leadin\LeadinOptions;
/**
 * Class containing all the constants used for admin script localization.
 */
class AdminConstants {
	/**
	 * Returns leadinConfig, containing all the data needed by the leadin javascript.
	 */
	public static function get_leadin_config() {
		$wp_user    = wp_get_current_user();
		$wp_user_id = $wp_user->ID;
		return array(
			'adminUrl'            => admin_url(),
			'ajaxUrl'             => Links::get_ajax_url(),
			'deviceId'            => DeviceId::get(),
			'didDisconnect'       => true,
			'env'                 => constant( 'LEADIN_ENV' ),
			'formsScript'         => constant( 'LEADIN_FORMS_SCRIPT_URL' ),
			'formsScriptPayload'  => constant( 'LEADIN_FORMS_PAYLOAD' ),
			'hubspotBaseUrl'      => constant( 'LEADIN_BASE_URL' ),
			'leadinPluginVersion' => constant( 'LEADIN_PLUGIN_VERSION' ),
			'locale'              => get_locale(),
			'nonce'               => wp_create_nonce( 'hubspot-ajax' ),
			'phpVersion'          => Versions::get_wp_version(),
			'pluginPath'          => constant( 'LEADIN_PATH' ),
			'plugins'             => get_plugins(),
			'portalId'            => get_option( 'leadin_portalId' ),
			'accountName'         => get_option( 'leadin_account_name' ),
			'portalDomain'        => get_option( 'leadin_portal_domain' ),
			'portalEmail'         => get_user_meta( $wp_user_id, 'leadin_email', true ),
			'iframeUrl'           => Links::get_iframe_src(),
			'loginUrl'            => Links::get_login_url(),
			'routes'              => Links::get_routes_mapping(),
			'signupUrl'           => Links::get_signup_url(),
			'theme'               => get_option( 'stylesheet' ),
			'wpVersion'           => Versions::get_wp_version(),
			'dismissedReview'     => metadata_exists( 'user', $wp_user_id, 'leadin_hide_feedback_notice' ),
		);
	}
	/**
	 * Returns leadinI18n, containing all the translations needed on the frontend.
	 */
	public static function get_leadin_i18n() {
		return array(
			'chatflows'            => __( 'Live Chat', 'leadin' ),
			'email'                => __( 'Email', 'leadin' ),
			'pricing'              => __( 'Advanced Features', 'leadin' ),
			'signIn'               => __( 'Sign In', 'leadin' ),
			'selectExistingForm'   => __( 'Select an existing form', 'leadin' ),
			'selectForm'           => __( 'Select a form', 'leadin' ),
			'formBlockTitle'       => __( 'HubSpot Form', 'leadin' ),
			'formBlockDescription' => __( 'Select and embed a HubSpot form', 'leadin' ),
		);
	}
}
