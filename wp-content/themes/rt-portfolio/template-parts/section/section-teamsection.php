<?php
/**
 * Template for Team Section
 *
 * @package RT_Portfolio
 */
$enable_team = rt_portfolio_get_option( 'enable_team' );

if ( false == $enable_team ){
    return;
}
$team_section_title  = rt_portfolio_get_option( 'team_section_title' );
$team_category     = rt_portfolio_get_option( 'team_category' );
$team_number     = rt_portfolio_get_option( 'team_number' );
?>

<div class="section team-section" id="teamsection">
    <div class="container">
        <div class="row">
            <?php if ( $team_section_title ): ?>
                <div class="custom-col-4">
                    <header class="entry-header heading">
                        <h2 class="entry-title"><?php echo esc_html( $team_section_title );?></h2>
                    </header>
                </div>
            <?php endif; ?>
            <div class="custom-col-8">
                <div class="team-item-wrapper">
                    <?php $team_args = array(
                        'post_type'   => 'post',
                        'posts_per_page' => absint( $team_number ),
                        'post_status' => 'publish',
                        'paged' => 1,
                    );
                    if ( absint( $team_category ) > 0 ) {
                        $team_args['cat'] = absint( $team_category );
                    }   
                    // Fetch posts.
                    $the_query = new WP_Query( $team_args );
                    if ( $the_query->have_posts() ) : $count= 0; ?>
                        <div class="owl-carousel owl-theme team-slider">
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post();
                            ?>
                            <?php $image = '';
                            if ( !has_post_thumbnail() ){
                                $image = 'no-image';
                            } 
                            ?>
                                <div class="team-item <?php echo esc_attr( $image);?>">
                                    <?php if ( has_post_thumbnail() ) :?>
                                        <figure class="team-image">
                                            <?php the_post_thumbnail( 'rt-portfolio-portfolio' );?>
                                        </figure>
                                    <?php endif;?>
                                    <div class="team-discription">
                                        <h3 class="author-name"><?php the_title();?></h3>
                                    </div>                                  
                                </div>
                            <?php endwhile;
                            wp_reset_postdata(); ?>
                        </div>
                    <?php endif; ?>                                
                </div>
            </div>
        </div>
    </div>
</div>