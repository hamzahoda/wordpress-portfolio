<?php
/**
 * Functions to provide support for the One Click Demo Import plugin (wordpress.org/plugins/one-click-demo-import)
 *
 * @package RT_Portfolio
 */

/**
* Remove branding
*/
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

/*Import demo data*/
if ( ! function_exists( 'rt_portfolio_demo_import_files' ) ) :
    function rt_portfolio_demo_import_files() {
        return array(
            array(
                'import_file_name'             => 'RT Portfolio',                
                'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo-import/rtportfolio.wordpress.xml',
                'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo-import/rt-portfolio-widgets.wie',
                'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo-import/rt-portfolio-export.dat',
                'import_notice'                => esc_html__( 'NOTE: One Click Demo import doesnot work properly in old setup. Please try reseting WordPress', 'rt-portfolio' ),
            ),
        ); 
    }

    add_filter( 'pt-ocdi/import_files', 'rt_portfolio_demo_import_files' );

endif;

/**
 * Action that happen after import
 */
if ( ! function_exists( 'rt_portfolio_after_demo_import' ) ) :
    function rt_portfolio_after_demo_import( $selected_import ) {
            //Set Menu
            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu'); 

            $social_menu = get_term_by('name', 'Social Menu', 'nav_menu'); 

            set_theme_mod( 'nav_menu_locations' , array( 
                'menu-1' => $primary_menu->term_id,
                'social-menu' => $social_menu->term_id, 
            ) 

            );
            //Set Front page
            $page = get_page_by_title( 'Home');
            if ( isset( $page->ID ) ) {
                update_option( 'page_on_front', $page->ID );
                update_option( 'show_on_front', 'page' );
            }          

        

    }

    add_action( 'pt-ocdi/after_import', 'rt_portfolio_after_demo_import' );

endif;