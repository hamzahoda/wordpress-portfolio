<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "mainContainer" div.
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="crt">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php endif; ?>
    <?php wp_head();?>
</head>
<?php
$header_options = certy_header_options();
$vertical_nav_options = certy_vertical_nav_options();
$sidebar = check_sidebar();
?>
<body <?php body_class();?> data-color="<?php echo esc_attr($header_options['primary_color']);?>">

<div class="crt-wrapper">
    <header id="crtHeader" class="crt-logo-<?php echo esc_attr($header_options['logo_position']);?>">
        <div class="crt-head-inner crt-container">
            <div class="crt-container-sm">
                <div class="crt-head-row">
                    <?php if($header_options['hide_logo_area'] != '1'):?>
                        <div id="crtHeadCol1" class="crt-head-col text-left">
                            <a id="crtLogo" class="crt-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <?php if(!empty($header_options['custom_logo']) || !empty($header_options['logo_text'])):?>
                                    <?php if(!empty($header_options['custom_logo'])):?>
                                        <img src="<?php echo esc_url($header_options['custom_logo']);?>" alt="<?php esc_html(bloginfo('name'));?>">
                                    <?php endif;?>
                                    <?php if(!empty($header_options['logo_text'])):?>
                                        <span><?php echo esc_html($header_options['logo_text']);?></span>
                                    <?php endif;?>
                                <?php else:?>
                                    <h1 class="site-title"><?php esc_html(bloginfo('name'));?></h1>
                                    <p class="site-description"><?php esc_html(bloginfo('description'));?></p>
                                <?php endif;?>
                            </a>
                        </div>
                    <?php endif;?>

                    <?php if ( has_nav_menu( 'primary' ) ) : ?>
                        <div id="crtHeadCol2" class="crt-head-col text-<?php echo esc_attr($header_options['menu_position']); ?>">
                            <div class="crt-nav-container crt-container hidden-sm hidden-xs">
                                <nav id="crtMainNav">
                                    <?php get_template_part('template-parts/navigation') ?>
                                </nav>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($sidebar || (!$sidebar && has_nav_menu( 'primary' ))):?>
                        <div id="crtHeadCol3" class="crt-head-col text-right<?php if(!$sidebar && has_nav_menu( 'primary' )):?> hidden-lg hidden-md<?php endif;?>">
                            <button id="crtSidebarBtn" class="btn btn-icon btn-shade">
                                <span class="crt-icon crt-icon-side-bar-icon"></span>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if ( has_nav_menu( 'vertical' ) ) : set_query_var('location','vertical');
                if(empty($vertical_nav_options['show_vertical_navigation_home']) || (!empty($vertical_nav_options['show_vertical_navigation_home']) && is_front_page())):
            ?>
                    <nav id="crtNavSm" class="crt-nav hidden-lg hidden-md">
                        <?php if(!empty($vertical_nav_options['personal_image'])): ?>
                            <?php if(!empty($vertical_nav_options['link_for_personal_image'])):?>
                                <div class="crt-avatar">
                                    <a href="<?php echo esc_url($vertical_nav_options['link_for_personal_image']);?>"<?php if(!empty($vertical_nav_options['tooltip_for_personal_image'])):?> data-tooltip="<?php echo esc_html($vertical_nav_options['tooltip_for_personal_image']);?>"<?php endif;?>>
                            <?php endif;?>
                            <?php echo certy_post_thumbnail('',attachment_url_to_postid($vertical_nav_options['personal_image']), 'certy-thumbnail-vertical',"avatar avatar-42" );?>
                            <?php if(!empty($vertical_nav_options['link_for_personal_image'])):?>
                                    </a>
                                </div>
                            <?php endif;?>
                        <?php endif;?>
                        <?php get_template_part('template-parts/navigation') ?>
                    </nav>
                <?php endif; ?>
        <?php endif; ?>
    </header>
    <div id="crtContainer" class="crt-container">
        <?php get_sidebar('left');?>

        <?php if ( has_nav_menu( 'vertical' ) ) :
                set_query_var('location','vertical');
                if(empty($vertical_nav_options['show_vertical_navigation_home']) || (!empty($vertical_nav_options['show_vertical_navigation_home']) && is_front_page())):
            ?>
                    <div id="crtNavWrap" class="hidden-sm hidden-xs">
                        <div id="crtNavInner"<?php if(!empty($vertical_nav_options['enable_sticky'])):?> class="crt-sticky"<?php endif;?>>
                            <div class="crt-nav-cont">
                                <div id="crtNavScroll">
                                    <nav id="crtNav" class="crt-nav">
                                        <?php if(!empty($vertical_nav_options['personal_image'])): ?>
                                            <div class="crt-nav-img">
                                            <?php if(!empty($vertical_nav_options['link_for_personal_image'])):?>
                                                <a href="<?php echo esc_url($vertical_nav_options['link_for_personal_image']);?>"<?php if(!empty($vertical_nav_options['tooltip_for_personal_image'])):?> data-tooltip="<?php echo esc_html($vertical_nav_options['tooltip_for_personal_image']);?>"<?php endif;?>>
                                            <?php endif;?>
                                                    <?php echo certy_post_thumbnail('',attachment_url_to_postid($vertical_nav_options['personal_image']), 'certy-thumbnail-vertical',"avatar avatar-42" );?>
                                            <?php if(!empty($vertical_nav_options['link_for_personal_image'])):?>
                                                </a>
                                            <?php endif;?>
                                            </div>
                                        <?php endif;?>
                                        <?php get_template_part('template-parts/navigation') ?>
                                    </nav>
                                </div>

                                <div id="crtNavTools" class="hidden">
                                    <span class="crt-icon crt-icon-dots-three-horizontal"></span>

                                    <button id="crtNavArrow" class="clear-btn">
                                        <span class="crt-icon crt-icon-chevron-thin-down"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="crt-nav-btm"></div>
                        </div>
                    </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="crt-container-sm">