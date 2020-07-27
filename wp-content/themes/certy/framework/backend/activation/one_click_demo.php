<?php
/**
 * Register the predefined demo options.
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}


function certy_after_import_setup($selected_import) {

    //set demos
    $demos = array();
    $demos['Designer'] = [
        'homepage' => 'homedesigner',
        'menu' => '',
        'vertical_menu' => 'Designer - Vertical Menu',
    ];
    $demos['Florist'] = [
        'homepage' => 'homeflorist',
        'menu' => 'Florist - Main Menu',
        'vertical_menu' => 'Florist - Vertical Menu',
    ];
    $demos['Developer'] = [
        'homepage' => 'homedeveloper',
        'menu' => 'Developer - Main Menu',
        'vertical_menu' => 'Developer - Vertical Menu',
    ];
	 $demos['Dj'] = [
        'homepage' => 'homedj',
        'menu' => 'Dj - Main Menu',
        'vertical_menu' => 'Dj - Vertical Menu',
    ];
	 $demos['Teacher'] = [
        'homepage' => 'hometeacher',
        'menu' => 'Teacher - Main Menu',
        'vertical_menu' => 'Teacher - Vertical Menu',
    ];
	 $demos['Doctor'] = [
        'homepage' => 'homedoctor',
        'menu' => 'Doctor - Main Menu',
        'vertical_menu' => 'Doctor - Vertical Menu',
    ];
	 $demos['Architect'] = [
        'homepage' => 'homearchitect',
        'menu' => 'Architect - Main Menu',
        'vertical_menu' => '',
    ];
    $demos['Attorney'] = [
        'homepage' => 'homeattorney',
        'menu' => 'Attorney - Main Menu',
        'vertical_menu' => 'Attorney - Vertical Menu',
    ];
	
    foreach($demos as $key => $demo) {
        if ($key === $selected_import['import_file_name']) {
            //Set Menu
            $main_menu = get_term_by('name', $demo['menu'], 'nav_menu');
            $vertical_menu = get_term_by('name', $demo['vertical_menu'], 'nav_menu');

            set_theme_mod('nav_menu_locations', array(
                    'primary' => $main_menu->term_id,
                    'vertical' => $vertical_menu ? $vertical_menu->term_id : 0
                )
            );

            //Set Front page
            $page = get_page_by_path($demo['homepage']);
            if (isset($page->ID)) {
                update_option('page_on_front', $page->ID);
                update_option('show_on_front', 'page');
            }
            update_option('certy_has_demo_data', 1);
        }
    }
}

/**
 * @return array
 */
function certy_import_files() {

    $certy_demo_url = 'http://certy.px-lab.com/demos';
    $warning_html = '';

    if( get_option( 'certy_has_demo_data', false ) ) {
        $wp_reset_plugin = sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://srd.wordpress.org/plugins/wp-reset/', esc_html__( 'WP Reset', 'certy' ) );
        $wordpress_reset_plugin = sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://srd.wordpress.org/plugins/wordpress-reset/', esc_html__( 'WordPress Reset', 'certy' ) );
        $wordpress_database_reset_plugin = sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://hy.wordpress.org/plugins/wordpress-database-reset/', esc_html__( 'WordPress Database Reset', 'certy' ) );

        $warning_text = sprintf(
            '<p>%1$s</p><p>%2$s</p><p>%3$s</p>',
            esc_html__( 'If you want your demo to looked exactly like selected demo and to prevent conflicts with current content, we highly recommend importing demo data on a clean installation.', 'certy' ),
            esc_html__( 'We highly recommend to create backup of your site before database reset if you are working on your database. Please note that database reset means cleaning all content that you have in your WordPress and restore to WordPress defaults.', 'certy' ),
            sprintf( esc_html__( 'Please feel free to use %1$s, %2$s or %3$s plugins to reset your WordPress site.', 'certy' ), $wp_reset_plugin, $wordpress_reset_plugin, $wordpress_database_reset_plugin )
        );

        $warning_html = sprintf( '<p>%s</p>', $warning_text );
    }

    return array(
        array(
            'import_file_name'           => 'Designer',
            'import_preview_image_url'   => $certy_demo_url.'/designer/screenshot.png',
            'import_file_url'            => $certy_demo_url.'/designer/certy-wordpress.xml',
            'import_widget_file_url'     => $certy_demo_url.'/designer/certy-widgets.wie',
            'import_customizer_file_url' => $certy_demo_url.'/designer/certy-customizer.dat',
            'import_notice'              => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Designer', 'certy' ), $warning_html ),
        ),
        array(
            'import_file_name'           => 'Florist',
            'import_preview_image_url'   => $certy_demo_url.'/florist/screenshot.png',
            'import_file_url'            => $certy_demo_url.'/florist/certy-wordpress.xml',
            'import_widget_file_url'     => $certy_demo_url.'/florist/certy-widgets.wie',
            'import_customizer_file_url' => $certy_demo_url.'/florist/certy-customizer.dat',
            'import_notice'              => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Florist', 'certy' ), $warning_html ),
        ),
		array(
            'import_file_name'           => 'Developer',
            'import_preview_image_url'   => $certy_demo_url.'/developer/screenshot.jpg',
            'import_file_url'            => $certy_demo_url.'/developer/certy-wordpress.xml',
            'import_widget_file_url'     => $certy_demo_url.'/developer/certy-widgets.wie',
            'import_customizer_file_url' => $certy_demo_url.'/developer/certy-customizer.dat',
            'import_notice'              => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Developer', 'certy' ), $warning_html ),
        ),
		array(
            'import_file_name'           => 'Dj',
            'import_preview_image_url'   => $certy_demo_url.'/dj/screenshot.jpg',
            'import_file_url'            => $certy_demo_url.'/dj/certy-wordpress.xml',
            'import_widget_file_url'     => $certy_demo_url.'/dj/certy-widgets.wie',
            'import_customizer_file_url' => $certy_demo_url.'/dj/certy-customizer.dat',
            'import_notice'              => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Dj', 'certy' ), $warning_html ),
        ),
		array(
            'import_file_name'           => 'Teacher',
            'import_preview_image_url'   => $certy_demo_url.'/teacher/screenshot.jpg',
            'import_file_url'            => $certy_demo_url.'/teacher/certy-wordpress.xml',
            'import_widget_file_url'     => $certy_demo_url.'/teacher/certy-widgets.wie',
            'import_customizer_file_url' => $certy_demo_url.'/teacher/certy-customizer.dat',
            'import_notice'              => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Teacher', 'certy' ), $warning_html ),
        ),
		array(
            'import_file_name'           => 'Doctor',
            'import_preview_image_url'   => $certy_demo_url.'/doctor/screenshot.jpg',
            'import_file_url'            => $certy_demo_url.'/doctor/certy-wordpress.xml',
            'import_widget_file_url'     => $certy_demo_url.'/doctor/certy-widgets.wie',
            'import_customizer_file_url' => $certy_demo_url.'/doctor/certy-customizer.dat',
            'import_notice'              => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Doctor', 'certy' ), $warning_html ),
        ),
		array(
            'import_file_name'           => 'Architect',
            'import_preview_image_url'   => $certy_demo_url.'/architect/screenshot.png',
            'import_file_url'            => $certy_demo_url.'/architect/certy-wordpress.xml',
            'import_widget_file_url'     => $certy_demo_url.'/architect/certy-widgets.wie',
            'import_customizer_file_url' => $certy_demo_url.'/architect/certy-customizer.dat',
            'import_notice'              => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Architect', 'certy' ), $warning_html ),
        ),
        array(
            'import_file_name'           => 'Attorney',
            'import_preview_image_url'   => $certy_demo_url.'/attorney/screenshot.png',
            'import_file_url'            => $certy_demo_url.'/attorney/certy-wordpress.xml',
            'import_widget_file_url'     => $certy_demo_url.'/attorney/certy-widgets.wie',
            'import_customizer_file_url' => $certy_demo_url.'/attorney/certy-customizer.dat',
            'import_notice'              => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Attorney', 'certy' ), $warning_html ),
        ),
    );
}

add_filter( 'pt-ocdi/import_files', 'certy_import_files' );
add_action( 'pt-ocdi/after_import', 'certy_after_import_setup' );