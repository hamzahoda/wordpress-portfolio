<?php
/**
 * Register the required plugins for Certy theme.
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

add_action( 'tgmpa_register', 'certy_register_required_plugins' );
function certy_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'               => __( 'Certy Theme Extensions', 'certy' ),       // The plugin name.
			'slug'               => 'certy-extensions',       // The plugin slug (typically the folder name).
			'source'             => CERTY_BACKEND_PATH . 'activation/plugins/certy-extensions.zip',   // The plugin source.
			'required'           => true,   // If false, the plugin is only 'recommended' instead of required.
			'version'            => '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '' // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'               => __( 'Advanced Custom Fields PRO', 'certy' ),       // The plugin name.
			'slug'               => 'advanced-custom-fields-pro',       // The plugin slug (typically the folder name).
			'source'             => CERTY_BACKEND_PATH . 'activation/plugins/advanced-custom-fields-pro.zip',   // The plugin source.
			'required'           => true,   // If false, the plugin is only 'recommended' instead of required.
			'version'            => '5.7.9', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '' // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'     				=> __( 'One Click Demo Importer', 'certy' ), // The plugin name
			'slug'     				=> 'one-click-demo-import', // The plugin slug (typically the folder name)
			'source'   				=> 'https://wordpress.org/plugins/one-click-demo-import/', // The plugin source
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'          => '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => __( 'Contact Form 7', 'certy' ),       // The plugin name.
			'slug'               => 'contact-form-7',       // The plugin slug (typically the folder name).
			'source'             => 'https://wordpress.org/plugins/contact-form-7/',   // The plugin source.
			'required'           => false,   // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '' // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'     				=> __( 'Appointment Calendar', 'certy' ), // The plugin name
			'slug'     				=> 'appointment-calendar', // The plugin slug (typically the folder name)
			'source'   				=> CERTY_BACKEND_PATH . 'activation/plugins/appointment-calendar.zip', // The plugin source
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific
			'external_url'          => '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> __( 'Share Buttons by AddThis', 'certy' ), // The plugin name
			'slug'     				=> 'addthis', // The plugin slug (typically the folder name)
			'source'   				=> 'https://wordpress.org/plugins/addthis/', // The plugin source
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific
			'external_url'          => '', // If set, overrides default API URL and points to an external URL
		),
	);

	/*
	 * Array of configuration settings.
	 */
	$config = array(
		'id'           => 'certy',                    // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                           // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins',      // Menu slug.
		'has_notices'  => true,                         // Show admin notices or not.
		'dismissable'  => true,                         // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                           // If 'dismissible' is false, this message will be output at top of nag.
		'is_automatic' => false,                        // Automatically activate plugins after installation or not.
		'message'      => '',                           // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
