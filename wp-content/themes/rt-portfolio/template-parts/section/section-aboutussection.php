<?php
/**
 * Template for About Section
 *
 * @package RT_Portfolio
 */

$enable_aboutussection = rt_portfolio_get_option( 'enable_aboutus' );

if ( false == $enable_aboutussection ){
    return;
}
$intro_section_title = rt_portfolio_get_option( 'intro_section_title' );

$intro_title_first= rt_portfolio_get_option( 'intro_title_first' );
$intro_title_second= rt_portfolio_get_option( 'intro_title_second' );

$page_ids = array();
$intro_page_first = rt_portfolio_get_option( 'intro_page_first' );
$intro_page_second = rt_portfolio_get_option( 'intro_page_second' );

?>



<div class="section about-us-section" id="aboutussection">
    <div class="container">
        <div class="row">
            <?php if ( $intro_section_title ): ?>
                <div class="custom-col-4">
                    <header class="entry-header heading">
                        <h2 class="entry-title"><?php echo esc_html( $intro_section_title );?></h2>
                    </header>
                </div>
            <?php endif; ?>
            <div class="custom-col-8">
                <div class="about-us-content">
                    <?php if( !empty( $intro_title_first)  || !empty( $intro_title_second ) ): ?>
                        <div class="about-history">
                            <div class="tabs about-tabs">
                                <ul class="tab-links">
                                    <?php if( !empty( $intro_title_first ) ): ?>
                                        <li class="active">
                                            <a href="#about-me"><?php echo esc_html( $intro_title_first );?></a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if( !empty( $intro_title_second ) ): ?>
                                        <li class="second-tab">
                                            <a href="#hostory"><?php echo esc_html( $intro_title_second );?></a>
                                        </li>
                                    <?php endif; ?>

                                </ul>

                                <div class="tab-content">
                                    <?php $args_intro = array (                         
                                        'p'                 => absint( $intro_page_first ),
                                        'post_status'       => 'publish',
                                        'post_type'         => 'page',
                                    );

                                    $loop = new WP_Query( $args_intro ); 

                                    if ( $loop->have_posts() ) : 
                                        while ($loop->have_posts()) : $loop->the_post(); ?>                                    
                                            <div id="about-me" class="tab active">
                                                <div class="entry-content">
                                                    <?php the_content();?>
                                                </div>
                                            </div>
                                        <?php endwhile;
                                        wp_reset_postdata();?>
                                    <?php endif; ?>

                                    <?php $args_intro = array (                         
                                        'p'                 => absint( $intro_page_second ),
                                        'post_status'       => 'publish',
                                        'post_type'         => 'page',
                                    );

                                    $loop = new WP_Query( $args_intro ); 

                                    if ( $loop->have_posts() ) : 
                                        while ($loop->have_posts()) : $loop->the_post(); ?>
                                            <div id="hostory" class="tab">
                                                <div class="entry-content">
                                                   <?php the_content(); ?>
                                                </div>
                                            </div>
                                        <?php endwhile;
                                        wp_reset_postdata();
                                    endif; ?>
                                </div><!-- .tab-content -->                            
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="counter-item-wrapper">
                        <?php $counter_secton = rt_portfolio_get_option('counter_secton');
                        $counter_secton = json_decode( $counter_secton );
                        if ( $counter_secton ): 
                            foreach ($counter_secton as  $counter) {
                                $counter_number = $counter->counter_number;
                                $counter_title = $counter->counter_title;
                                if ( !empty( $counter_number ) && !empty( $counter_title ) ){
                                ?>
                                    <div class="counter-item">
                                        <span class="count"><?php echo absint( $counter_number );?></span>
                                        <span class="counter-title"><?php echo esc_html( $counter_title)?></span>
                                    </div><!-- .counter-item -->
                                <?php } 
                            }
                        endif;?>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>