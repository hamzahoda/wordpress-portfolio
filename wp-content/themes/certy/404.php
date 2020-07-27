<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

get_header();
$notfound_options = certy_404_options();
?>

<div class="crt-paper-layers">
    <div class="crt-paper clearfix">
        <div class="crt-paper-cont paper-padd clear-mrg">
            <div class="padd-box-sm clear-mrg">
                <div class="text-center">
                    <?php if(!empty($notfound_options['404_title'])):?>
                        <strong class="title-404 text-upper"><?php echo esc_html($notfound_options['404_title']);?></strong>
                    <?php endif;?>
                    <?php if(!empty($notfound_options['404_description'])):?>
                        <span class="info-404"><?php echo wp_kses_post($notfound_options['404_description']);?></span>
                    <?php endif;?>
                    <?php if(!empty($notfound_options['404_button_text'])):?>
                        <a class="btn btn-primary" href="javascript:history.back()"><?php echo esc_html($notfound_options['404_button_text']);?></a>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer();?>
