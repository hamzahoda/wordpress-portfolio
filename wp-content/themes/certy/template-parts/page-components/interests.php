<?php
/**
 * The template for displaying the interests component
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}
$section = get_query_var( 'section');
$title = $section['title'];
$subtitle = $section['subtitle'];
$menu_id = $section['menu_id'];
$enable_bottom_line = $section['enable_bottom_line'];
$interests = $section['interests'];
$brd_class = '';
if(!empty($enable_bottom_line)){
    $brd_class=' brd-btm ';
}
?>
<section<?php if(!empty($menu_id)):?> id="<?php echo esc_attr($menu_id);?>"<?php endif;?> class="section<?php echo esc_attr($brd_class);?> padd-box">
    <div class="row">
        <div class="col-sm-12 clear-mrg">
            <?php if(!empty($title)):?>
                <h2 class="title-lg text-upper"><?php echo esc_html($title);?></h2>
            <?php endif;?>
            <?php if(!empty($subtitle)):?>
                <h3 class="title-thin text-muted"><?php echo esc_html($subtitle);?></h3>
            <?php endif;?>
            <?php if(!empty($interests)):?>
                <ul class="crt-icon-list crt-icon-list-col3 clearfix">
                    <?php foreach($interests as $interest):?>
                        <li>
                            <?php if(!empty($interest['interest_class'])):?>
                                <span class="crt-icon <?php echo esc_attr($interest['interest_class']);?>"></span>
                            <?php endif;?>
                            <?php if(!empty($interest['interest_name'])): echo esc_html($interest['interest_name']);endif;?>
                        </li>
                    <?php endforeach;?>
                </ul>
            <?php endif;?>
        </div>
    </div>
</section>
