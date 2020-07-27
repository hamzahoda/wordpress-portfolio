<?php
/**
 * The template for displaying the page
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

get_header();
if(have_posts()): the_post();
    $sections = get_field('sections');
    $disable_paper_animation = kirki::get_option('certy_kirki_config','disable_paper_animation');
?>
    <div class="crt-paper-layers<?php if(empty($disable_paper_animation)):?> crt-animate<?php endif;?>">
        <div class="crt-paper clear-mrg clearfix">
            <div class="crt-paper-cont paper-padd clear-mrg">
                <?php if (!certy_empty_content($post->post_content)):?>
                    <div class="padd-box">
                        <h2 class="title-lg text-upper"><?php the_title();?></h2>
                        <?php the_content(); ?>
                    </div>
                <?php endif;?>
                <?php
                if($sections):
                    foreach($sections as $section):
                        $layout = $section["acf_fc_layout"];
                        if(!empty($layout)):
                            $component_name = str_replace('_section','',$layout);

                            if( $layout == 'end_of_paper_divider' ):
                    ?>
            </div>
        </div>
    </div>

    <div class="crt-paper-layers<?php if(empty($disable_paper_animation)):?> crt-animate<?php endif;?>">
        <div class="crt-paper clear-mrg clearfix">
            <div class="crt-paper-cont paper-padd clear-mrg">
                <?php   endif;
                        set_query_var( 'section', $section );
                        get_template_part('template-parts/page-components/'.$component_name);
                        endif;
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>
<?php endif;?>
<?php get_footer();?>
