<?php
/**
 * Template for Home Section
 *
 * @package RT_Portfolio
 */

$enable_banner = rt_portfolio_get_option( 'enable_home' );

if ( false == $enable_banner ){
    return;
}

$banner_section_title = rt_portfolio_get_option( 'home_section_title' );
$home_sub_title = rt_portfolio_get_option( 'home_sub_title' );
$banner_page = rt_portfolio_get_option( 'banner_page' );
$banner_slider_category = rt_portfolio_get_option( 'banner_slider_category' );
$slider_number = rt_portfolio_get_option( 'slider_number' );
$slider_button_title = rt_portfolio_get_option( 'slider_button_title' );

?>

<div class="section banner-section" id="homesection">
    <div class="container">
        <div class="banner-content-wrapper">
            <div class="banner-image-section">
                <?php if( $banner_section_title ): ?>
                    <header class="entry-header heading">
                        <h2 class="entry-title"><?php echo esc_html( $banner_section_title );?></h2>
                    </header>
                <?php endif; ?>                
                <figure class="featured-image arrow-bg">
                    <img src="<?php echo esc_url(get_template_directory_uri() )?>/assets/img/arrow-bg.png" alt="">
                </figure>                
            </div>

            <div class="banner-text-section">
                <?php if( absint( $banner_page ) > 0 ): ?>
                    <?php $args = array (                                   
                        'p'           => absint($banner_page ),
                        'post_status'       => 'publish',
                        'post_type'         => 'page',
                    );
                    $loop = new WP_Query($args); 

                    if ( $loop->have_posts() ) : 
                        while ($loop->have_posts()) : $loop->the_post(); ?> 

                            <?php if ( has_post_thumbnail() ): ?>                 
                                <figure class="featured-image">
                                    <?php the_post_thumbnail( 'rt-portfolio-home' ); ?>
                                </figure>
                            <?php endif; ?>

                            <div class="personal-description">
                                <h3 class="author-name"><?php the_title();?></h3>
                                <h4 class="author-designation">
                                    <span><?php echo esc_html( $home_sub_title );?></span>
                                </h4>
                                <div class="entry-content">
                                    <p>
                                        <?php
                                        $more = '<a href="'.esc_url( get_permalink() ).'">'.esc_html__( '...Read More', 'rt-portfolio').'</a>';
                                            echo wp_kses_post( wp_trim_words( get_the_content(), 40, $more ) );
                                        ?>
                                    </p>
                                    
                                </div>


                            </div>
                        <?php endwhile;
                        wp_reset_postdata();
                    endif; ?>

                <?php endif; ?>
                <div class="personal-skills">
                    <?php $progress_secton = rt_portfolio_get_option('progress_secton'); 
                    $progress_secton = json_decode( $progress_secton );
                    if ($progress_secton ): 
                        foreach ($progress_secton as  $progess) {
                        $progess_number = $progess->progress_number;
                        $progess_title  = $progess->progress_title;
                        $progess_icon  = $progess->progress_icon;
                        if ( !empty( $progess_number ) && !empty( $progess_title ) && !empty( $progess_icon ) ){
                        ?>
                            <div class="individual-skills">
                                <h3 class="skills-title"><?php echo esc_html( $progess_title)?></h3>
                                <div class="skills-value"><?php echo absint( $progess_number );?><?php echo esc_attr( $progess_icon );?></div>
                                <div class="skills-wrapper">
                                    <div class="skills-progress-bar" style="width:<?php echo absint( $progess_number );?>%;">
                                    </div>
                                </div>
                            </div>
                        <?php }
                        } 
                    endif;?>

                </div>
            </div>

        </div>
    </div>
</div>
