<?php
/**
 * Load BASIC Function.
 *
 * @package RT_Portfolio
 */

if ( ! function_exists( 'rt_portfolio_fonts_url' ) ) {
	/**
	 * Register Google fonts.
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function rt_portfolio_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Barlow, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Josefin Sans: on or off', 'rt-portfolio' ) ) {
			$fonts[] = 'Josefin Sans:300,400,600,700';
		}
		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), '//fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
}

/**
 * Header Image
 */

function rt_portfolio_header_image() {

    $header_image = get_header_image(); 
    $header_image = ! empty( $header_image ) ? get_header_image() : get_template_directory_uri() . '/assets/img/about-us-bg.jpg';
    if ( is_singular() ) :
        $header_image = ( has_post_thumbnail() ) ? get_the_post_thumbnail_url( get_the_id(), 'full' ) : $header_image;
    endif;

    return $header_image;
    
}

if( ! function_exists( 'rt_portfolio_primary_navigation_fallback' ) ) :

    /**
     * Fallback for primary navigation.
     */
    function rt_portfolio_primary_navigation_fallback() {
        echo '<ul>';
        echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'rt-portfolio' ). '</a></li>';
        wp_list_pages( array(
            'title_li' => '',
            'depth'    => 1,
            'number'   => 7,
        ) );
        echo '</ul>';

    }

endif;

if ( ! function_exists( 'rt_portfolio_navigation' ) ) :
	/**
	 * Posts navigation.
	 *
	 * @since 1.0.0
	 */
	function rt_portfolio_navigation() {
		$pagination_option = rt_portfolio_get_option('pagination_option');

		if ( 'default' == $pagination_option) {
			the_posts_navigation();	
		} else{
			the_posts_pagination( array(
				'mid_size' => 5,
				'prev_text' => __( 'PREV', 'rt-portfolio' ),
				'next_text' => __( 'NEXT', 'rt-portfolio' ),
				) );
		}
	}

endif;
add_action( 'rt_portfolio_action_navigation', 'rt_portfolio_navigation' );

if ( ! function_exists( 'rt_portfolio_post_content' ) ) :
	/**
	 * Posts navigation.
	 *
	 * @since 1.0.0
	 */
	function rt_portfolio_post_content() {
		$blog_content_option = rt_portfolio_get_option('blog_content_option');

		if ( 'excpert' == $blog_content_option) { ?>
				<div class="entry-content">
					<?php the_excerpt();?>
				</div>	
				<a href="<?php the_permalink();?>"><?php echo esc_html__( 'Read More', 'rt-portfolio' );?></a>
		 <?php } else{
			the_content();
		}
	}

endif;
add_action( 'rt_portfolio_action_post_content', 'rt_portfolio_post_content' );

