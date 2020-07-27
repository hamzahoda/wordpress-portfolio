<?php
/**
 * The template for post navigation
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

$prevPost = get_previous_post();
if ($prevPost) {
    if(has_post_thumbnail($prevPost->ID)){
        $image_prev = wp_get_attachment_image(get_post_thumbnail_id($prevPost->ID), 'certy-post-nav');
    }else{
        $image_prev = '<img src='.get_template_directory_uri().'/assets/images/demo-image-default.jpg alt='. __( "Previous", "certy"  ).'>';
    };
}else{
    $image_prev = '';
}
$nextPost = get_next_post();
if ($nextPost) {
    if(has_post_thumbnail($nextPost->ID)){
        $image_next = wp_get_attachment_image(get_post_thumbnail_id($nextPost->ID), 'certy-post-nav', false);
    }else{
        $image_next = '<img src='.get_template_directory_uri().'/assets/images/demo-image-default.jpg alt='. __( "Next", "certy"  ).'>';
    };

}else{
    $image_next = '';
}
?>
<nav class="post-nav" role="navigation">
    <div class="padd-box-sm brd-btm">
        <h2 class="screen-reader-text"><?php _e( 'Post navigation', 'certy'  );?></h2>

        <div class="row">
            <div class="col-sm-5 col-xs-6">
                <div class="post-nav-prev">
                    <?php previous_post_link( "%link", '<span class="text-left text-muted">'.__( 'previous article', 'certy'  ).'</span><figure>'.$image_prev.'</figure><strong class="text-upper text-center">%title</strong>' ); ?>
                </div>
            </div>

            <div class="col-sm-5 col-sm-offset-2 col-xs-6">
                <div class="post-nav-next">
                    <?php next_post_link( "%link", '<span class="text-right text-muted">'.__( 'next article', 'certy'  ).'</span><figure>'.$image_next.'</figure><strong class="text-upper text-center">%title</strong>' ); ?>
                </div>
            </div>
        </div>
    </div>
</nav>
