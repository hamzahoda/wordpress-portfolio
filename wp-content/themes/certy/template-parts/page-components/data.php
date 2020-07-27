<?php
/**
 * The template for displaying the data section component
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}
//global
$section = get_query_var( 'section');
$title = $section['title'];
$subtitle = $section['subtitle'];
$menu_id = $section['menu_id'];
//left box
$title_left_box = $section['title_left_box'];
$select_section_left_box = $section['select_section_left_box'];
$info_fields_left_box = $section['info_fields_left_box'];
$select_data_bars_style_left_box = $section['select_data_bars_style_left_box'];
$data_bar_left_box = $section['data_bar_left_box'];
$editor_left_box = $section['editor_left_box'];
//right box
$title_right_box = $section['title_right_box'];
$select_section_right_box = $section['select_section_right_box'];
$info_fields_right_box = $section['info_fields_right_box'];
$select_data_bars_style_right_box = $section['select_data_bars_style_right_box'];
$data_bar_right_box = $section['data_bar_right_box'];
$editor_right_box = $section['editor_right_box'];
$row_class = '6';
if(empty($select_section_left_box)||empty($select_section_right_box)){
    $row_class = '12';
}
$enable_bottom_line = $section['enable_bottom_line'];
$brd_class = '';
if(!empty($enable_bottom_line)){
    $brd_class=' brd-btm';
}
?>
<section<?php if(!empty($menu_id)):?> id="<?php echo esc_attr($menu_id);?>"<?php endif;?> class="section padd-box<?php echo esc_attr($brd_class);?>">
    <?php if(!empty($title)):?>
        <h2 class="title-lg text-upper"><?php echo esc_html($title);?></h2>
    <?php endif;?>
    <?php if(!empty($subtitle)):?>
        <h3 class="title-thin text-muted"><?php echo esc_html($subtitle);?></h3>
    <?php endif;?>
    <div class="row">
        <?php if(!empty($select_section_left_box)):?>
            <div class="col-sm-<?php echo esc_attr($row_class);?> clear-mrg">
                <?php if(!empty($title_left_box)):?>
                    <h3 class="title-thin text-muted"><?php echo esc_html($title_left_box);?></h3>
                <?php endif;?>
                <?php
                    if(!empty($select_section_left_box)):
                        if($select_section_left_box == 'info' && !empty($info_fields_left_box)):
                        ?>
                            <dl class="dl-horizontal clear-mrg">
                                <?php foreach($info_fields_left_box as $field):?>
                                    <?php if(!empty($field['name_field'])):?>
                                        <dt class="text-upper"><?php echo esc_html($field['name_field']);?></dt>
                                    <?php endif;?>
                                    <?php if(!empty($field['value_field'])):?>
                                        <dd><?php echo wp_kses_post($field['value_field']);?></dd>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </dl>
                        <?php
                        elseif($select_section_left_box == 'bar' && !empty($data_bar_left_box)): $i = 1;
                            foreach($data_bar_left_box as $bar):
                                $title = $bar['title'];
                                $visible_value = $bar['visible_value'];
                                $bar_value_in = $bar['bar_value_in'];
                                if(empty($bar_value_in)){
                                    $bar_value_in = 0;
                                }
                                if($select_data_bars_style_left_box == 'dotbar'):
                            ?>
                                    <div class="progress-bullets crt-animate" role="progressbar" aria-valuenow="<?php echo intval($bar_value_in);?>" aria-valuemin="0" aria-valuemax="10">
                                        <?php if($title):?>
                                            <strong class="progress-title"><?php echo esc_html($title);?></strong>
                                        <?php endif;?>
                                        <span class="progress-bar">
                                            <?php for($bullet_count=0;$bullet_count<10;$bullet_count++):?>
                                                <span class="bullet<?php if($bullet_count<=intval($bar_value_in)):?> fill<?php endif;?>"></span>
                                            <?php endfor;?>
                                        </span>
                                        <?php if(!empty($visible_value)):?>
                                            <span class="progress-text text-muted"><?php echo esc_html($visible_value);?></span>
                                        <?php endif;?>
                                    </div>
                                <?php elseif($select_data_bars_style_left_box == 'linebar'):?>
                                    <div class="progress-line crt-animate" role="progressbar" aria-valuenow="<?php echo intval($bar_value_in);?>" aria-valuemin="0" aria-valuemax="100">
                                        <?php if($title):?>
                                            <strong class="progress-title"><?php echo esc_html($title);?></strong>
                                        <?php endif;?>
                                        <div class="progress-bar"<?php if(!empty($visible_value)):?> data-text="<?php echo esc_html($visible_value);?>"<?php endif;?> data-value="<?php echo esc_attr($bar_value_in)/100;?>"></div>
                                    </div>
                                <?php elseif($select_data_bars_style_left_box == 'circlebar'):
                                    if($i==1 || (($i-1)%3) == 0):?>
                                    <div class="row">
                                    <?php endif;?>
                                        <div class="col-xs-4 text-center">
                                            <div class="progress-chart crt-animate" role="progressbar" aria-valuenow="<?php echo intval($bar_value_in);?>" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <div class="progress-bar" data-text="<?php echo esc_html($visible_value);?>" data-value="<?php echo esc_attr($bar_value_in/100);?>"></div>
                                                <?php if($title):?>
                                                    <strong class="progress-title"><?php echo esc_html($title);?></strong>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    <?php if($i == count($data_bar_left_box) || $i%3 == 0):?>
                                    </div>
                                    <?php endif;
                                    endif;
                                $i++; endforeach;
                            elseif($select_section_left_box == 'editor' && !empty($editor_left_box)):
                                echo wp_kses_post($editor_left_box);
                            endif;?>
                <?php endif;?>
            </div>
        <?php endif;?>
        <?php if(!empty($select_section_right_box)):?>
            <div class="col-sm-<?php echo esc_attr($row_class);?> clear-mrg">
                <?php if(!empty($title_right_box)):?>
                    <h3 class="title-thin text-muted"><?php echo esc_html($title_right_box);?></h3>
                <?php endif;?>
                <?php
                if(!empty($select_section_right_box)):
                    if($select_section_right_box == 'info' && !empty($info_fields_right_box)):
                        ?>
                        <dl class="dl-horizontal clear-mrg">
                            <?php foreach($info_fields_right_box as $field):?>
                                <?php if(!empty($field['name_field'])):?>
                                    <dt class="text-upper"><?php echo esc_html($field['name_field']);?></dt>
                                <?php endif;?>
                                <?php if(!empty($field['value_field'])):?>
                                    <dd><?php echo wp_kses_post($field['value_field']);?></dd>
                                <?php endif;?>
                            <?php endforeach;?>
                        </dl>
                        <?php
                    elseif($select_section_right_box == 'bar' && !empty($data_bar_right_box)): $i = 1;
                        foreach($data_bar_right_box as $bar):
                            $title = $bar['title'];
                            $visible_value = $bar['visible_value'];
                            $bar_value_in = $bar['bar_value_in'];
                            if(empty($bar_value_in)){
                                $bar_value_in = 0;
                            }
                            if($select_data_bars_style_right_box == 'dotbar'):
                                ?>
                                <div class="progress-bullets crt-animate" role="progressbar" aria-valuenow="<?php echo intval($bar_value_in);?>" aria-valuemin="0" aria-valuemax="10">
                                    <?php if($title):?>
                                        <strong class="progress-title"><?php echo esc_html($title);?></strong>
                                    <?php endif;?>
                                    <span class="progress-bar">
                                        <?php for($bullet_count=0;$bullet_count<10;$bullet_count++): ?>
                                            <span class="bullet<?php if($bullet_count<intval($bar_value_in/10)):?> fill<?php endif;?>"></span>
                                        <?php endfor;?>
                                    </span>
                                    <?php if(!empty($visible_value)):?>
                                        <span class="progress-text text-muted"><?php echo esc_html($visible_value);?></span>
                                    <?php endif;?>
                                </div>
                            <?php elseif($select_data_bars_style_right_box == 'linebar'):?>
                                <div class="progress-line crt-animate" role="progressbar" aria-valuenow="<?php echo intval($bar_value_in);?>" aria-valuemin="0" aria-valuemax="100">
                                    <?php if($title):?>
                                        <strong class="progress-title"><?php echo esc_html($title);?></strong>
                                    <?php endif;?>
                                    <div class="progress-bar"<?php if(!empty($visible_value)):?> data-text="<?php echo esc_html($visible_value);?>"<?php endif;?> data-value="<?php echo esc_attr($bar_value_in)/100;?>"></div>
                                </div>
                            <?php elseif($select_data_bars_style_right_box == 'circlebar'):
                                if($i==1 || (($i-1)%3) == 0):
                                ?>
                                <div class="row">
                                <?php endif;?>
                                    <div class="col-xs-4 text-center">
                                        <div class="progress-chart crt-animate" role="progressbar" aria-valuenow="<?php echo intval($bar_value_in);?>" aria-valuemin="0"
                                             aria-valuemax="100">
                                            <div class="progress-bar" data-text="<?php echo esc_html($visible_value);?>" data-value="<?php echo esc_attr($bar_value_in/100);?>"></div>
                                            <?php if($title):?>
                                                <strong class="progress-title"><?php echo esc_html($title);?></strong>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                <?php if($i == count($data_bar_right_box) || $i%3 == 0):?>
                                </div>
                            <?php endif;
                                endif;
                                $i++; endforeach;
                        elseif($select_section_right_box == 'editor' && !empty($editor_right_box)):
                            echo wp_kses_post($editor_right_box);
                        endif;?>
                <?php endif;?>
            </div>
        <?php endif;?>
    </div>
    <!-- .row -->
</section>