<?php

namespace Leadin\admin;

use Leadin\LeadinOptions;
use Leadin\AssetsManager;
use Leadin\admin\AdminFilters;
use Leadin\admin\MenuConstants;
use Leadin\admin\Gutenberg;
use Leadin\admin\NoticeManager;
use Leadin\admin\PluginActionsManager;
use Leadin\admin\DeactivationForm;
use Leadin\admin\api\RegistrationApi;
use Leadin\admin\api\SkipConnectApi;
use Leadin\admin\api\DisconnectApi;
use Leadin\admin\utils\Background;
use Leadin\utils\Versions;
use Leadin\includes\utils as utils;

/**
 * Class responsible for initializing the admin side of the plugin.
 */
class LeadinAdmin {
	const REDIRECT_TRANSIENT = 'leadin_redirect_after_activation';

	/**
	 * Class constructor, adds all the hooks and instantiate the APIs.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'load_languages' ), 14 );
		add_action( 'admin_init', array( $this, 'redirect_after_activation' ) );
		add_action( 'admin_menu', array( $this, 'build_menu' ) );
		add_action( 'admin_notices', array( $this, 'add_background_iframe' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		register_activation_hook( LEADIN_BASE_PATH, array( $this, 'activate' ) );

		$portal_id = LeadinOptions::get_portal_id();

		new RegistrationApi();
		new DisconnectApi();
		new SkipConnectApi();
		new PluginActionsManager();
		new DeactivationForm();
		new NoticeManager();
		new AdminFilters();

		if ( ! empty( $portal_id ) ) {
			new Gutenberg();
		}
	}

	/**
	 * Load the .mo language files.
	 */
	public function load_languages() {
		load_plugin_textdomain( 'leadin', false, '/leadin/languages' );
	}

	/**
	 * Set transient after activating the plugin.
	 */
	public function activate() {
		set_transient( self::REDIRECT_TRANSIENT, true, 60 );
	}

	/**
	 * Redirect to the dashboard after activation.
	 */
	public function redirect_after_activation() {
		$portal_id = LeadinOptions::get_portal_id();

		if ( get_transient( self::REDIRECT_TRANSIENT ) ) {
			delete_transient( self::REDIRECT_TRANSIENT );
			wp_safe_redirect( admin_url( 'admin.php?page=leadin' ) );
			exit;
		} elseif ( ! empty( $portal_id ) && isset( $_GET['page'] ) && 'leadin' === $_GET['page'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$landing_page = MenuConstants::DASHBOARD;
			wp_safe_redirect( admin_url( 'admin.php?page=' . $landing_page ) );
			exit;
		}
	}

	/**
	 * Adds scripts for the admin section.
	 */
	public function enqueue_scripts() {
		AssetsManager::enqueue_admin_assets();
		if ( get_current_screen()->id === 'plugins' ) {
			AssetsManager::enqueue_feedback_assets();
		}
	}

	/**
	 * Adds Leadin menu to admin sidebar
	 */
	public function build_menu() {
		$portal_id         = LeadinOptions::get_portal_id();
		$notification_icon = '';

		if ( ! $portal_id ) {
			$notification_icon = ' <span class="update-plugins count-1"><span class="plugin-count">!</span></span>';
		}

		if ( ! empty( $portal_id ) ) {
			add_menu_page( __( 'HubSpot', 'leadin' ), __( 'HubSpot', 'leadin' ) . $notification_icon, 'edit_posts', MenuConstants::ROOT, array( $this, 'build_app' ), 'dashicons-sprocket', '25.100713' );
			add_submenu_page( MenuConstants::ROOT, __( 'Dashboard', 'leadin' ), __( 'Dashboard', 'leadin' ), 'edit_posts', MenuConstants::DASHBOARD, array( $this, 'build_app' ) );
			add_submenu_page( MenuConstants::ROOT, __( 'Reporting', 'leadin' ), __( 'Reporting', 'leadin' ), 'edit_posts', MenuConstants::REPORTING, array( $this, 'build_app' ) );
			add_submenu_page( MenuConstants::ROOT, __( 'Contacts', 'leadin' ), __( 'Contacts', 'leadin' ), 'edit_posts', MenuConstants::CONTACTS, array( $this, 'build_app' ) );
			add_submenu_page( MenuConstants::ROOT, __( 'Lists', 'leadin' ), __( 'Lists', 'leadin' ), 'edit_posts', MenuConstants::LISTS, array( $this, 'build_app' ) );
			add_submenu_page( MenuConstants::ROOT, __( 'Forms', 'leadin' ), __( 'Forms', 'leadin' ), 'edit_posts', MenuConstants::FORMS, array( $this, 'build_app' ) );
			add_submenu_page( MenuConstants::ROOT, __( 'Settings', 'leadin' ), __( 'Settings', 'leadin' ), 'edit_posts', MenuConstants::SETTINGS, array( $this, 'build_app' ) );
			add_submenu_page( MenuConstants::ROOT, __( 'Advanced Features', 'leadin' ), __( 'Advanced Features', 'leadin' ), 'edit_posts', MenuConstants::PRICING, array( $this, 'build_app' ) );
			remove_submenu_page( MenuConstants::ROOT, MenuConstants::ROOT );
		} else {
			add_menu_page( __( 'HubSpot', 'leadin' ), __( 'HubSpot', 'leadin' ) . $notification_icon, 'manage_options', MenuConstants::ROOT, array( $this, 'build_app' ), 'dashicons-sprocket', '25.100713' );
		}
	}

	/**
	 * Renders the leadin admin page.
	 */
	public function build_app() {
		AssetsManager::enqueue_bridge_assets();

		$error_message = '';

		if ( Versions::is_php_version_supported() ) {
			$error_message = sprintf(
				__( 'HubSpot All-In-One Marketing %1$s requires PHP %2$s or higher. Please upgrade WordPress first.', 'leadin' ),
				LEADIN_PLUGIN_VERSION,
				LEADIN_REQUIRED_PHP_VERSION
			);
		} elseif ( Versions::is_wp_version_supported() ) {
			$error_message = sprintf(
				__( 'HubSpot All-In-One Marketing %1$s requires PHP %2$s or higher. Please upgrade WordPress first.', 'leadin' ),
				LEADIN_PLUGIN_VERSION,
				LEADIN_REQUIRED_WP_VERSION
			);
		}

		if ( $error_message ) {
			?>
				<div class='notice notice-warning'>
					<p>
						<?php echo esc_html( $error_message ); ?>
					</p>
				</div>
			<?php
		} else {
			?>
				<div id="leadin-iframe-container"></div>
			<?php
		}
	}

	/**
	 * Render the background iframe.
	 */
	public function add_background_iframe() {
		if ( Background::should_load_background_iframe() ) {
			?>
				<div id="leadin-iframe-container" style="display: none"></div>
			<?php
		}
	}
}
