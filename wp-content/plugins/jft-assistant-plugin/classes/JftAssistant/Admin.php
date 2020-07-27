<?php

/**
 * The Admin class
 */
class JftAssistant_Admin {

	/**
	 * The constructor that determines the class to load
	 */
	public function __construct() {
		$this->load();
	}

	/**
	 * Load the hooks
	 */
	private function load() {
		// @codingStandardsIgnoreStart
		@session_start();
		// @codingStandardsIgnoreEnd

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'upgrader_process_complete', array( $this, 'post_theme_install' ), 10, 2 );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'jft_assistant_load_themes', array( $this, 'load_themes' ), 10, 1 );
		add_action( 'wp_ajax_' . JFT_ASSISTANT_SLUG__, array( $this, 'ajax' ) );
		add_action( 'admin_notices', array( $this, 'optimole_notice' ) );

		add_filter( 'themes_api', array( $this, 'themes_api' ), 10, 3 );
		add_filter( 'themes_api_result', array( $this, 'themes_api_result' ), 10, 3 );
		add_filter( 'install_themes_tabs', array( $this, 'install_themes_tabs' ) );
	}

	/**
	 * Optimole notice conditions
	 * @return bool
	 */
	public function should_show_optimole_notice() {
		$current_screen = get_current_screen();
		if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ||
		     is_network_admin() ||
		     ! current_user_can( 'manage_options' ) ||
		     empty( $current_screen )
		) {
			return false;
		}

		if ( isset( $_GET['jft_nonce'] ) && isset( $_GET['optml_notice_hide_upsell'] ) && $_GET['optml_notice_hide_upsell'] === 'yes' && wp_verify_nonce( $_GET['jft_nonce'], 'optml_notice_hide_upsell' ) ) {
			update_option( 'optml_notice_hide_upsell', 'yes' );

			return false;
		}
		if ( get_option( 'optml_notice_hide_upsell', 'no' ) === 'yes' ) {
			return false;
		}
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active( 'optimole-wp/optimole-wp.php' ) ) {
			return false;
		}
		if ( isset( $current_screen->base ) && in_array( $current_screen->base, array(
				'plugins',
				'plugin-install',
				'plugin-editor',
				'themes',
				'theme-install',
				'upload',
				'media'
			) ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Show optimole notice.
	 */
	public function optimole_notice() {
		if ( ! $this->should_show_optimole_notice() ) {
			return;
		}

		?>
        <div class="notice notice-success">
            <p> <?php echo( __( 'Improve your website loading speed by up to <strong>10</strong> seconds using <strong><a href="http://optimole.com" target="_blank">Optimole - Image Optimization Service</a></strong>. <br/>Optimole compress and delivers in average <strong>70%</strong> smaller
				images and is fully integrated with your <strong>theme</strong>.', 'jft-assistant' ) ); ?></p>
            <p>
                <a href="<?php echo add_query_arg(
					array( 's' => 'optimole', 'type' => 'author', 'tab' => 'search' ),
					network_admin_url( 'plugin-install.php' )
				); ?>" target="_blank" class="button   button-primary">
                    <i class="dashicons dashicons-download"
                       style="line-height: 1.5;"></i><?php _e( 'Check out Optimole', 'jft-assistant' ); ?>
                </a>
                <a class="button"
                   href="<?php echo wp_nonce_url( add_query_arg( array( 'optml_notice_hide_upsell' => 'yes' ) ), 'optml_notice_hide_upsell', 'jft_nonce' ); ?>"><?php _e( 'I\'m not interested', 'jft-assistant' ); ?></a>
            </p>
        </div>
		<?php
	}

	/**
	 * Redirect the plugin on first-time activation to the themes page.
	 */
	function admin_init() {
		global $pagenow;
		if ( isset( $_GET['activate'] ) && 'plugins.php' === $pagenow ) {
			$time = get_option( JFT_ASSISTANT_SLUG__ . 'activation', false );
			if ( false === $time ) {

				$args = array(
					'browse' => 'jft',
					'pg'     => 'jft',
				);

				update_option( JFT_ASSISTANT_SLUG__ . 'activation', time() );
				wp_safe_redirect( add_query_arg( $args, admin_url( '/theme-install.php' ) ) );
				exit;
			}
		}
	}

	/**
	 * Load themes for a specific page.
	 *
	 * @param int $page Page number.
	 */
	function load_themes( $page = 1 ) {
		$args = array( 'page' => $page );
		$this->get_themes( (object) $args );
	}

	/**
	 * Get the themes from the endpoint.
	 *
	 * @param object $args Arguments used to query for installer pages from the Themes API.
	 * @param bool $return_object Whether to return an object or an array.
	 */
	function get_themes( $args, $return_object = true ) {
		if ( isset( $args->all ) && $args->all ) {
			return $this->get_all_themes();
		}

		$page = isset( $args->page ) ? $args->page : 1;
		$key  = sprintf( '%s_response_%d_%d_%d', JFT_ASSISTANT_SLUG__, str_replace( '.', '', JFT_ASSISTANT_VERSION__ ), $page, JFT_ASSISTANT_THEMES_PERPAGE__ );
		if ( isset( $args->search ) && ! empty( $args->search ) ) {
			$key .= $args->search;
		}
		if ( isset( $args->sticky ) && ! empty( $args->sticky ) ) {
			$key .= 'sticky';
		}
		$response = get_transient( $key );
		$endpoint = str_replace( '#', $page, JFT_ASSISTANT_THEMES_ENDPOINT__ );
		if ( isset( $args->search ) && ! empty( $args->search ) ) {
			$endpoint = add_query_arg( 'search', $args->search, $endpoint );
		}
		if ( isset( $args->sticky ) && ! empty( $args->sticky ) ) {
			$endpoint = add_query_arg( 'sticky', $args->sticky, $endpoint );
		}

		if ( false === $response ) {
			$response = $this->call_api( $endpoint );

			if ( ! $response || is_wp_error( $response ) || $response['response']['code'] != 200 ) {
				return null;
			}

			if ( ! JFT_ASSISTANT_THEMES_DISABLE_CACHE__ ) {
				set_transient( $key, $response, JFT_ASSISTANT_THEMES_CACHE_DAYS__ * DAY_IN_SECONDS );
			}
		}

		return $this->parse_response( $response, $args, $return_object );
	}

	/**
	 * Get all the themes from db, irrespective of pagination.
	 */
	private function get_all_themes() {
		$themes = array();
		$args   = (object) array();
		for ( $page = 1; $page < 100; $page ++ ) {
			$response = get_transient( sprintf( '%s_response_%d_%d_%d', JFT_ASSISTANT_SLUG__, str_replace( '.', '', JFT_ASSISTANT_VERSION__ ), $page, JFT_ASSISTANT_THEMES_PERPAGE__ ) );
			if ( false === $response ) {
				// thats it, we are done. No more pages.
				break;
			}
			$response = $this->parse_response( $response, $args, false );
			if ( is_array( $response ) && array_key_exists( 'themes', $response ) ) {
				$themes = array_merge( $themes, $response['themes'] );
			}
		}

		return array( 'themes' => $themes );
	}

	/**
	 * Parse the response from the API or the transient.
	 */
	private function parse_response( $response, $args, $return_object ) {
		$json = json_decode( wp_remote_retrieve_body( $response ), true );
		$res  = array();
		if ( $json ) {
			$themes = array();
			foreach ( $json as $theme ) {
				$date       = DateTime::createFromFormat( 'Y-m-d\TH:i:s', $theme['modified_gmt'] );
				$link       = $theme['download_url'];
				$array      = explode( '/', $link );
				$zip_file   = end( $array );
				$theme_data = array(
					'theme_id'       => $theme['theme_id'],
					'slug'           => $theme['slug'],
					'name'           => $theme['title_attribute'],
					'version'        => $theme['version'],
					'rating'         => $theme['score'],
					'num_ratings'    => $theme['comments'],
					'author'         => $theme['author_name'],
					'preview_url'    => $theme['demo_url'],
					'screenshot_url' => is_array( $theme['listing_image'] ) && count( $theme['listing_image'] ) > 0 ? $theme['listing_image'][0] : '',
					'last_update'    => $date->format( 'Y-m-d' ),
					'homepage'       => isset( $theme['link'] ) ? $theme['link'] : '',
					'description'    => $theme['description'],
					'download_link'  => $theme['download_url'],
					'zip_name'       => $theme['zip_name'],
				);
				if ( $return_object ) {
					$themes[] = (object) $theme_data;
				} else {
					$themes[ $theme['slug'] ] = $theme_data;
				}
			}

			$headers = wp_remote_retrieve_headers( $response );

			$res = array(
				'info'   => array(
					'page'    => isset( $args->page ) ? $args->page : 1,
					'results' => $headers['X-WP-Total'],
					'pages'   => $headers['X-WP-TotalPages'],
				),
				'themes' => $themes,
			);
		}

		if ( $return_object ) {
			return (object) $res;
		}

		return $res;
	}

	/**
	 * Call the specified endpoint.
	 *
	 * @param string $endpoint The endpoint to call.
	 */
	private function call_api( $endpoint ) {
		return wp_remote_get(
			$endpoint,
			array(
				'headers' => array(
					'X-JFT-Source' => 'JFT Assistant v' . JFT_ASSISTANT_VERSION__,
				),
				'timeout' => 180,
			)
		);
	}

	/**
	 * Create the menu item for the standalone page.
	 */
	function admin_menu() {
		add_submenu_page(
			'themes.php', __( 'JustFreeThemes', 'jft-assistant' ), __( 'JustFreeThemes', 'jft-assistant' ), 'manage_options', add_query_arg(
				array(
					'browse' => 'jft',
					'pg'     => 'jft',
				), '/theme-install.php'
			)
		);
	}

	/**
	 * Remove the upload button on the standalone page.
	 */
	function install_themes_tabs( $array ) {
		if ( isset( $_GET['pg'] ) && 'jft' === $_GET['pg'] ) {
			return null;
		}

		return $array;
	}

	/**
	 * Fires when the upgrader process is complete.
	 *
	 * See also {@see 'upgrader_package_options'}.
	 *
	 * @param WP_Upgrader $upgrader WP_Upgrader instance. In other contexts, $this, might be a
	 *                                  Theme_Upgrader, Plugin_Upgrader, Core_Upgrade, or Language_Pack_Upgrader
	 *                                  instance.
	 * @param array $hook_extra {
	 *                                  Array of bulk item update data.
	 *
	 * @type string $action Type of action. Default 'update'.
	 * @type string $type Type of update process. Accepts 'plugin', 'theme', 'translation', or 'core'.
	 * @type bool $bulk Whether the update process is a bulk update. Default true.
	 * @type array $plugins Array of the basename paths of the plugins' main files.
	 * @type array $themes The theme slugs.
	 * @type array $translations {
	 *         Array of translations update data.
	 *
	 * @type string $language The locale the translation is for.
	 * @type string $type Type of translation. Accepts 'plugin', 'theme', or 'core'.
	 * @type string $slug Text domain the translation is for. The slug of a theme/plugin or
	 *                                'default' for core translations.
	 * @type string $version The version of a theme, plugin, or core.
	 *     }
	 * }
	 */
	function post_theme_install( WP_Upgrader $upgrader, $hook_extra ) {
		$zip_file = $upgrader->result['destination_name'] . '.zip';
		// reverse look up to find out the name of the theme that was installed. Cumbersome, but the 'install_theme_complete_actions' filter that should be called,
		// is not being called so we have to do this.
		$theme_id = null;
		$themes   = $this->get_themes( (object) array( 'all' => true ), false );
		foreach ( $themes['themes'] as $slug => $theme ) {
			if ( $zip_file === $theme['zip_name'] ) {
				$theme_id = $theme['theme_id'];
				break;
			}
		}

		if ( ! is_null( $theme_id ) ) {
			wp_remote_get(
				str_replace( '#id#', $theme_id, JFT_THEO_TRACK_ENDPOINT__ ),
				array(
					'headers' => array(
						'X-Theo-User'        => md5( site_url() ),
						'X-Theo-Source-Type' => 'wpadmin',
					),
				)
			);
		}
	}

	/**
	 * Filters the returned WordPress.org Themes API response.
	 *
	 * @param array|object|WP_Error $res WordPress.org Themes API response.
	 * @param string $action Requested action. Likely values are 'theme_information',
	 *                                      'feature_list', or 'query_themes'.
	 * @param object $args Arguments used to query for installer pages from the WordPress.org Themes
	 *                                      API.
	 */
	function themes_api_result( $res, $action, $args ) {
		if ( 'query_themes' === $action && ( $this->is_tab_jft( $args ) || $this->is_search_jft() ) ) {
			$responses = array();

			// let's get the sticky themes first if this is the first page of the JFT page.
			if ( $this->is_tab_jft( $args ) ) {
				$page = isset( $args->page ) ? $args->page : 1;
				if ( 1 === $page ) {
					$responses[] = $this->get_themes( (object) array( 'sticky' => true ), true );
				}
			}

			$responses[] = $this->get_themes( $args, true );

			// get the next page preemptively.
			$args->page  = isset( $args->page ) ? $args->page + 1 : 2;
			$responses[] = $this->get_themes( $args, true );

			// send the consolidated response.
			return $this->append_response( $responses );
		}

		if ( 'theme_information' === $action ) {

			$response = $this->get_themes( $args, false );
			if ( isset( $args->slug ) && array_key_exists( $args->slug, $response['themes'] ) ) {
				return (object) $response['themes'][ $args->slug ];
			}
		}

		return $res;
	}

	/**
	 * Checks whether the tab requesting theme information is the JFT tab or not.
	 *
	 * @param object $args Arguments used to query for installer pages from the Themes API.
	 */
	private function is_tab_jft( $args ) {
		$type = isset( $args->browse ) ? ( strpos( $args->browse, '&' ) !== false ? strstr( $args->browse, '&', true ) : $args->browse ) : '';
		if ( isset( $args->browse ) && 'jft' === $type ) {
			return true;
		}

		return false;
	}

	/**
	 * Checks whether this page is a JFT page and a search is being attempted.
	 */
	private function is_search_jft() {
		return isset( $_SESSION[ JFT_ASSISTANT_SLUG__ ] ) && JFT_ASSISTANT_SLUG__ === $_SESSION[ JFT_ASSISTANT_SLUG__ ];
	}

	/**
	 * Add the responses into one response suitable for consumption by WordPress.
	 */
	private function append_response( $array ) {
		if ( ! $array ) {
			return null;
		}

		$final = array();
		foreach ( $array as $response ) {
			// discard non-object responses as we expect only objects.
			if ( ! is_object( $response ) ) {
				continue;
			}
			$response = (array) $response;
			$prev     = intval( isset( $final['info']['page'] ) ? $final['info']['page'] : 0 );
			if ( intval( $response['info']['page'] ) > $prev ) {
				$final['info']['page'] = $response['info']['page'];
			}

			// these will remain constant through the request.
			$final['info']['results'] = $response['info']['results'];
			$final['info']['pages']   = $response['info']['pages'];

			// append themes.
			$themes = (array) $response['themes'];
			if ( isset( $final['themes'] ) ) {
				$final['themes'] = array_merge( $final['themes'], $themes );
			} else {
				$final['themes'] = $themes;
			}
		}

		$themes = array();
		if ( isset( $final['themes'] ) ) {
			foreach ( $final['themes'] as $theme ) {
				$themes[] = (object) $theme;
			}
		}
		$final['themes'] = $themes;

		return (object) $final;
	}

	/**
	 * Filters whether to override the WordPress.org Themes API.
	 *
	 * Passing a non-false value will effectively short-circuit the WordPress.org API request.
	 *
	 * If `$action` is 'query_themes', 'theme_information', or 'feature_list', an object MUST
	 * be passed. If `$action` is 'hot_tags', an array should be passed.
	 *
	 * @param false|object|array $default Whether to override the WordPress.org Themes API. Default false.
	 * @param string $action Requested action. Likely values are 'theme_information',
	 *                                    'feature_list', or 'query_themes'.
	 * @param object $args Arguments used to query for installer pages from the Themes API.
	 */
	function themes_api( $default, $action, $args ) {
		if ( $this->is_tab_jft( $args ) && 'query_themes' === $action ) {
			return true;
		}

		if ( 'theme_information' === $action ) {

			$response = $this->get_themes( $args, false );
			if ( isset( $args->slug ) && array_key_exists( $args->slug, $response['themes'] ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Load the scripts and styles
	 */
	function admin_enqueue_scripts() {
		$current_screen = get_current_screen();

		if ( ! isset( $current_screen->id ) ) {
			return array();
		}
		if ( ! in_array( $current_screen->id, array( 'theme-install' ) ) ) {
			return array();
		}

		$jft_page = isset( $_GET['pg'] ) && 'jft' === $_GET['pg'];

		$theme['link_check'] = JFT_THEME_COOKIE_ENDPOINT__;

		wp_enqueue_script( 'jft-assistant', JFT_ASSISTANT_RESOURCES__ . 'admin/js/jft-assistant.js', array( 'jquery' ), JFT_ASSISTANT_VERSION__ );
		wp_localize_script(
			'jft-assistant', 'jft', array(
				'screen'    => $current_screen->id,
				'tab_name'  => __( 'JustFreeThemes', 'jft-assistant' ),
				'jft_page'  => $jft_page,
				'ajax'      => array(
					'nonce'  => wp_create_nonce( JFT_ASSISTANT_SLUG__ ),
					'action' => JFT_ASSISTANT_SLUG__,
				),
				'theme'     => $theme,
				'orbit_fox' => $this->get_orbit_fox_params(),
			)
		);

		if ( $jft_page ) {
			wp_register_style( 'jft-assistant', JFT_ASSISTANT_RESOURCES__ . 'admin/css/jft-assistant.css' );
			wp_enqueue_style( 'jft-assistant' );
		}
	}

	/**
	 * Returns the orbit fox related parameters.
	 */
	private function get_orbit_fox_params() {
		$prompt = false;
		$file   = 'themeisle-companion/themeisle-companion.php';
		if ( ! is_plugin_active( $file ) ) {
			$prompt = true;
			// maybe its installed but not active?
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			WP_Filesystem();
			global $wp_filesystem;
			$plugin_path = str_replace( ABSPATH, $wp_filesystem->abspath(), trailingslashit( dirname( JFT_ASSISTANT_DIR__ ) ) );
			$plugin_file = trailingslashit( $plugin_path ) . $file;
			if ( $wp_filesystem->is_readable( $plugin_file ) ) {
				$prompt = false;
			}
		}

		if ( $prompt && false === ( $value = get_transient( JFT_ASSISTANT_SLUG__ . 'orbit_fox' ) ) ) {
			return array(
				'prompt'   => __( 'Do you want to install the OrbitFox plugin as well for free uptime monitoring, sharing icons and google analytics integration?', 'jft-assistant' ),
				'install'  => admin_url( sprintf( 'update.php?action=install-plugin&plugin=themeisle-companion&_wpnonce=%s', wp_create_nonce( 'install-plugin_' . 'themeisle-companion' ) ) ),
				'activate' => admin_url( sprintf( 'plugins.php?action=activate&plugin=%s&_wpnonce=%s', urlencode( $file ), wp_create_nonce( 'activate-plugin_' . $file ) ) ),
			);
		}

		return null;
	}

	/**
	 * Single entry point for the ajax methods.
	 */
	function ajax() {
		check_ajax_referer( JFT_ASSISTANT_SLUG__, 'nonce' );
		if ( ! current_user_can( 'install_themes' ) ) {
			return;
		}
		switch ( $_POST['_action'] ) {
			case 'in_page':
				// set a variable in the session that identifies this page as the JFT page (not tab) so that any search on this page
				// can be identified as originating from here and then the correct API can be called. This is because any text typed in the search box
				// causes backbone to append search=whatever as the query param and remove all others. So, we cannot identify the JFT page only on the basis
				// of the query string and thus have to depend on the session.
				$_SESSION[ JFT_ASSISTANT_SLUG__ ] = JFT_ASSISTANT_SLUG__;
				break;
			case 'out_page':
				// unset the session variable so that it does not confuse search in other pages. This is called on window.unload.
				if ( isset( $_SESSION[ JFT_ASSISTANT_SLUG__ ] ) ) {
					unset( $_SESSION[ JFT_ASSISTANT_SLUG__ ] );
				}
				break;
			case 'get_theme_links':
				if ( ! isset( $_POST['theme_details'] ) ) {
					break;
				}
				if ( ! isset( $_POST['theme_details']['theme'] ) ) {
					break;
				}
				$theme_info = $this->get_single_theme_information( $_POST['theme_details']['theme']['id'] );
				if ( empty( $theme_info ) ) {
					break;
				}
				if ( ! isset( $theme_info->slug ) ) {
					break;
				}
				$theme            = array();
				$theme['link']    = add_query_arg(
					array(
						'action'   => 'install-theme',
						'theme'    => $theme_info->slug,
						'_wpnonce' => wp_create_nonce( 'install-theme_' . $theme_info->slug ),
					), admin_url( '/update.php' )
				);
				$theme['message'] = sprintf( __( 'Do you want to install %s?', 'jft-assistant' ), esc_attr( $theme_info->name ) );
				wp_send_json( $theme );
				break;
			case 'orbit_fox_prompt':
				// don't prompt again for 1 week.
				set_transient( JFT_ASSISTANT_SLUG__ . 'orbit_fox', 1, WEEK_IN_SECONDS );
				break;
			case 'orbit_fox_install':
				// don't prompt again for 1 week.
				set_transient( JFT_ASSISTANT_SLUG__ . 'orbit_fox', 1, WEEK_IN_SECONDS );
				break;
		}

		wp_die();
	}

	/**
	 * Get the information of a single theme (from the API not from the database as we don't know on which page this theme might be available).
	 */
	private function get_single_theme_information( $id ) {
		$endpoint = str_replace( '#', 1, JFT_ASSISTANT_THEMES_ENDPOINT__ );
		$endpoint = add_query_arg( 'include', $id, $endpoint );
		$response = $this->call_api( $endpoint );
		$theme    = $this->parse_response( $response, (object) array(), true );

		return $theme->themes[0];
	}
}
