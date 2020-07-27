<?php
/**
 * The template for displaying the right sidebar
 *
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}
?>

<div id="crtSidebar">
    <button id="crtSidebarClose" class="btn btn-icon btn-light btn-shade">
        <span class="crt-icon crt-icon-close"></span>
    </button>

    <div id="crtSidebarInner">
        <?php if ( has_nav_menu( 'primary' ) ) : set_query_var('location',''); ?>
            <nav id="crtMainNavSm" class="hidden-lg hidden-md text-center">
                <?php get_template_part('template-parts/navigation') ?>
            </nav>
        <?php endif; ?>
        <?php $sidebar = check_sidebar();?>
        <?php if($sidebar):?>
            <aside class="widget-area clear-mrg">
                <?php dynamic_sidebar($sidebar);?>
            </aside>
        <?php endif;?>
    </div>
</div>
