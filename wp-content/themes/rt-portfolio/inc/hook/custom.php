<?php
/**
 * Custom theme functions.
 *
 * This file contains hook functions attached to theme hooks.
 *
 * @package RT_Portfolio
 */

if ( ! function_exists( 'rt_portfolio_side_header' ) ) :
	/**
	 * Top Heading
 	 *
	 * @since 1.0.0
	 */
function rt_portfolio_side_header() {
	?>
	<div id="menu">
		<div class="menu-icon">
		  <span></span>
		  <span></span>
		  <span></span>
		</div>
		<div class="menu-logo-section">
        	<?php $site_identity  = rt_portfolio_get_option( 'site_identity' );
        	if ( in_array( $site_identity, array( 'logo-only', 'logo-text' ) )  ) { ?>
        		<div class="site-logo">
        			<?php the_custom_logo(); ?> 
        		</div>
    		<?php } ?>

			<?php if ( in_array( $site_identity, array( 'title-text', 'title-only', 'logo-text' ) ) ) : ?>
				<?php
				if( in_array( $site_identity, array( 'title-text', 'title-only' ) )  ) {
					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
					endif;
				} 
				if ( in_array( $site_identity, array( 'title-text', 'logo-text' ) ) ) {
					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
					<?php
					endif; 
				}?>
			<?php endif; ?>
		</div>	
			
		<?php $enable_single_menu  = rt_portfolio_get_option( 'enable_single_menu' ); 
		if ( true == $enable_single_menu ) { ?>
			<div class="menu-wrapper main-menu">		          			
				<ul>
					<?php $enabled_sections 	= rt_portfolio_get_sections();
	       			foreach( $enabled_sections as $section ){
	       				if( $section['menu_text'] ){
	        			?>
							<li data-menuanchor="<?php echo esc_attr( $section['id'] );?>">
								<a href="<?php echo esc_url( home_url( '/' ).'#' . esc_attr( $section['id'] ) ); ?>" data-scroll="#<?php echo esc_attr( $section['id'] );?>section"><?php echo esc_html( $section['menu_text'] );?></a>
							</li>					
						<?php } 
					}?>
				</ul>			
			</div>
		<?php } else {
			wp_nav_menu( array( 'theme_location' => 'menu-1', 'container_class' => 'menu-wrapper main-menu', 'menu_id' => 'primary-menu','fallback_cb' => 'rt_portfolio_primary_navigation_fallback' ) ); 
		} ?>

		<?php $enable_social_menu  = rt_portfolio_get_option( 'enable_social_menu' );
		if ( true == $enable_social_menu && has_nav_menu( 'social-menu' ) ){ ?>
			<div class="top-social-bar">
				<?php do_action( 'rt_portfolio_action_social_menu' );?>
			</div>
		<?php } ?>		

	</div>
	<?php 
}

endif;
add_action( 'rt_portfolio_side_action_header', 'rt_portfolio_side_header', 10);

if ( ! function_exists( 'rt_portfolio_social_menu' ) ) :
	/**
	 * Top Heading
 	 *
	 * @since 1.0.0
	 */
function rt_portfolio_social_menu() {
	?>
	<div class="inline-social-icons social-links">
		<?php wp_nav_menu( array(
			'theme_location'  => 'social-menu',
			'container'       => false,						
			'depth'           => 1,
			'fallback_cb'     => false,
			) ); 
		?>
	</div>
	
	<?php 
}

endif;
add_action( 'rt_portfolio_action_social_menu', 'rt_portfolio_social_menu', 10);

if ( ! function_exists( 'rt_portfolio_site_branding' ) ) :
	/**
	 * Site branding 
 	 *
	 * @since 1.0.0
	 */
function rt_portfolio_site_branding() {
	?>
    <div class="hgroup-wrap">
        <div class="container">
            <section class="site-branding">
            	<?php $site_identity  = rt_portfolio_get_option( 'site_identity' );
            	if ( in_array( $site_identity, array( 'logo-only', 'logo-text' ) )  ) { ?>
            		<div class="site-logo">
            			<?php the_custom_logo(); ?> 
            		</div>
        		<?php } ?>

				<?php if ( in_array( $site_identity, array( 'title-text', 'title-only', 'logo-text' ) ) ) : ?>
					<?php
					if( in_array( $site_identity, array( 'title-text', 'title-only' ) )  ) {
						if ( is_front_page() && is_home() ) : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php else : ?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php
						endif;
					} 
					if ( in_array( $site_identity, array( 'title-text', 'logo-text' ) ) ) {
						$description = get_bloginfo( 'description', 'display' );
						if ( $description || is_customize_preview() ) : ?>
							<p class="site-description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
						<?php
						endif; 
					}?>
				<?php endif; ?>
            
            </section>
            <?php $enable_search  = rt_portfolio_get_option( 'enable_search' ); 
			if( false == $enable_search){
				return;
			} ?>
            <div id="left-search" class="search-container">
                <div class="search-toggle">
                </div>
                <div class="search-section">
                    <?php get_search_form();?>
                    <span class="search-arrow"></span>
                </div>
            </div>
        </div>
    </div>	
	<?php 
}
endif;
add_action( 'rt_portfolio_action_header', 'rt_portfolio_site_branding', 10 );


if ( ! function_exists( 'rt_portfolio_footer_copyright' ) ) :
	/**
	 * Footer Copyright 	 *
	 * @since 1.0.0
	 */
function rt_portfolio_footer_copyright() {
	?>
	<div class="site-generator">
		<div class="container">
			<?php 
				$powered_by_text = sprintf( esc_html__( 'Theme of %s', 'rt-portfolio' ), '<a target="_blank" rel="designer" href="https://rigorousthemes.com/">Rigorous Themes</a>' ); 
			?>	
            <span class="copyright"><?php echo wp_kses_post($powered_by_text); 
            if ( function_exists( 'the_privacy_policy_link' ) ) {
					the_privacy_policy_link( ' | ' );
			}?></span>
		</div>
	</div>    
	<?php 
}
endif;
add_action( 'rt_portfolio_action_footer', 'rt_portfolio_footer_copyright', 10 );


if ( ! function_exists( 'rt_portfolio_footer_social_media' ) ) :
	/**
	 * Footer Social Menu 	 *
	 * @since 1.0.0
	 */
function rt_portfolio_footer_social_media() {
	?>
	<?php $enable_footer_social_menu  = rt_portfolio_get_option( 'enable_footer_social_menu' );
	$social_menu_title  = rt_portfolio_get_option( 'social_menu_title' );
	if ( true == $enable_footer_social_menu && has_nav_menu( 'social-menu' ) ){ ?>	
		<div class="follow-section">
			<h4><?php echo esc_html( $social_menu_title );?></h4>
			<?php do_action( 'rt_portfolio_action_social_menu' );?>
		</div>
	<?php } ?>
	<div class="back-to-top" style="display: block;">
		<a href="#masthead" title="Go to Top" class="fa-angle-up"></a>
	</div>	
	<?php 
}
endif;
add_action( 'rt_portfolio_action_footer_content', 'rt_portfolio_footer_social_media', 10 );
