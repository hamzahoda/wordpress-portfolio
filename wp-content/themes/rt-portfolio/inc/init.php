<?php
/**
 * My Portfolio Load Files
 *
 * @package RT_Portfolio
 */

/**
 * Include default theme options.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/customizer/default.php';

/**
 * Load Hooks.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/hook/structure.php';
require_once trailingslashit( get_template_directory() ) . 'inc/hook/custom.php';
require_once trailingslashit( get_template_directory() ) . 'inc/hook/basic.php';

/**
 * Repeater Controller options.
 */
require trailingslashit( get_template_directory() ) . '/inc/customizer/repeater-controller/customizer.php';

/**
 * Customizer Controller options.
 */
require trailingslashit( get_template_directory() ) . 'inc/customizer/control.php';

/**
 * Implement the Custom Header feature.
 */
require trailingslashit( get_template_directory() ) . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require trailingslashit( get_template_directory() ) . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require trailingslashit( get_template_directory() ) . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require trailingslashit( get_template_directory() ) . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require trailingslashit( get_template_directory() ) . '/inc/jetpack.php';
}

/**
 * Plugin Activation Section.
 */
require trailingslashit( get_template_directory() ) . '/inc/class-tgm-plugin-activation.php';

/**
 * Demo Import.
 */
require trailingslashit( get_template_directory() ) . '/inc/demo-import/demo.php';

