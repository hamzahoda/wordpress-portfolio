<?php
/**
 * The template for pagination
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

if ( $wp_query->max_num_pages > 1 ) {
    ?>
    <div class="pagination">
        <?php
        $total = $wp_query->found_posts;
        $page = isset( $_GET['page'] ) ? abs( (int) $_GET['page'] ) : 1;
        $format = 'page/%#%/';
        $current_page = max(1, $paged);
        $big = 999999999;
        echo paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?page=%#%',
            'end_size'           => 1,
            'mid_size'           => 2,
            'prev_next'          => True,
            'prev_text'          => '<i class="crt-icon crt-icon-chevron-left"></i>',
            'next_text'          => '<i class="crt-icon crt-icon-chevron-right"></i>',
            'type'               => 'plain',
            'add_args'           => False,
            'add_fragment'       => '',
            'before_page_number' => '',
            'after_page_number'  => '',
            'total' => ceil($total / $posts_per_page),
            'current' => $current_page,
        ));
        ?>
    </div>
<?php }