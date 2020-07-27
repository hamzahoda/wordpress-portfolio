<?php
/**
 * certy-extensions extension
 *
 * @package certy-shortcodes
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

/**
 * Manages nested shortcodes' relationships
 *
 * Class Certy_Shortcode_Manager
 */
final class Certy_Shortcode_Manager {
    private function  __construct(){}
    private function  __clone(){}

    /**
     * @var Certy_Shortcode_Manager
     */
    private static $instance = null;

    /**
     * @return Certy_Shortcode_Manager
     */
    public static function get_instance(){
        if( self::$instance === null ){
            self::$instance = new self();
        }
        return self::$instance;
    }


    /**
     * @var bool
     */
    private $is_new_tab_group;

    /**
     * @param bool $is_new_tab_group
     * @return void
     */
    public function set_new_tab_group( $is_new_tab_group = true ) {
        $this->is_new_tab_group = $is_new_tab_group;
    }

    /**
     * @return bool
     */
    public function is_new_tab_group(){
        return $this->is_new_tab_group;
    }

    /**
     * @var bool
     */
    private $is_new_accordion_group;

    /**
     * @param bool $is_new_tab_group
     * @return void
     */
    public function set_new_accordion_group( $is_new_accordion_group = true ) {
        $this->is_new_accordion_group = $is_new_accordion_group;
    }

    /**
     * @return bool
     */
    public function is_new_accordion_group(){
        return $this->is_new_accordion_group;
    }

}

// toggle-link
add_shortcode('certy_toggle_link', 'certy_toggle_link');
function certy_toggle_link( $atts, $cont = null ) {
    extract( shortcode_atts( array(
        'toggle_text' => __('Show More',CERTY_EXTENSIONS_TEXT_DOMAIN),
    ), $atts ) );

        $out = '';

        if(empty($toggle_text)):
            $toggle_text = __('Show More',CERTY_EXTENSIONS_TEXT_DOMAIN);
        endif;
            $out .= '<a class="toggle-link" href="#toggle_content'.uniqid().'"><small>'.$toggle_text.'</small></a>';
            $out .= '<div id="toggle_content'.uniqid().'" class="toggle-cont" style="display: none;">'.do_shortcode($cont).'</div>';

    return $out;
}

// alert
add_shortcode('certy_alert', 'certy_alert');
function certy_alert( $atts, $cont = null ) {
    extract( shortcode_atts( array(
        'type' => '',
    ), $atts ) );

    $out = '';

    if(empty($type)):
        $type = 'success';
    endif;
    $out .= '<div class="alert alert-'.$type.'" role="alert">
                '.do_shortcode($cont).'
                <button type="button" class="close"><span class="crt-icon crt-icon-close"></span></button>
            </div>';

    return $out;
}

//circle bars
add_shortcode('circle_bar', 'circle_bar');
function circle_bar($atts, $cont = null) {
    extract( shortcode_atts( array(
        'visible_value' => '',
        'bar_value' => '',
    ), $atts ) );

    $out = '
                <div class="progress-chart crt-animate" role="progressbar" aria-valuenow="'.$bar_value.'%" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar" data-text="'.$visible_value.'" data-value="'.($bar_value/100).'"></div>
                    <strong class="progress-title">'.do_shortcode($cont).'</strong>
                </div>
            ';

    return $out;
}

//dote bars
add_shortcode('dote_bar', 'dote_bar');
function dote_bar($atts, $cont = null)
{
    extract(shortcode_atts(array(
        'visible_value' => '',
        'bar_value' => '',
    ), $atts));

    $out = '   <div class="progress-bullets crt-animate" role="progressbar" aria-valuenow="'.$bar_value.'" aria-valuemin="0" aria-valuemax="10">
                    <strong class="progress-title">'.do_shortcode($cont).'</strong>
                    <span class="progress-bar">';
                        for($bullet_count=0;$bullet_count<10;$bullet_count++):
                            $out .= '<span class="bullet';
                                if($bullet_count<=intval($bar_value-1)):
                                    $out .= ' fill';
                                endif;
                            $out .= '"></span>';
                        endfor;
    $out .= '       </span>
                    <span class="progress-text text-muted">'.$visible_value.'</span>
                </div>
            ';

    return $out;
}

//line bars
add_shortcode('line_bar', 'line_bar');
function line_bar($atts, $cont = null)
{
    extract(shortcode_atts(array(
        'visible_value' => '',
        'bar_value' => '',
    ), $atts));

    $out = '<div class="progress-line crt-animate" role="progressbar" aria-valuenow="'.$bar_value.'" aria-valuemin="0" aria-valuemax="100">
                <strong class="progress-title">'.$visible_value.'</strong>
                <div class="progress-bar" data-text="'.$bar_value.'%" data-value="'.($bar_value/100).'"></div>
            </div>
            ';

    return $out;
}

// One/half
add_shortcode('wrapper', 'one_half_wrapper');
function one_half_wrapper($atts, $cont = null) {

    $str = "<div class='row'>";
    $str .= do_shortcode($cont);
    $str .= '</div>';
    return $str;
}
add_shortcode('one_half', 'one_half');
function one_half($atts, $cont = null) {
    $str = '';
    $str .= "<div class='col-sm-6'>";
    $str .= do_shortcode($cont);
    $str .= "</div>";
    return $str;
}
add_shortcode('one_third', 'one_third');
function one_third($atts, $cont = null) {

    $str = '';
    $str .= "<div class='col-sm-4'>";
    $str .= do_shortcode($cont);
    $str .= "</div>";
    return $str;
}
add_shortcode('one_fourth', 'one_fourth');
function one_fourth($atts, $cont = null) {
    $str = '';
    $str .= "<div class='col-sm-3'>";
    $str .= do_shortcode($cont);
    $str .= "</div>";
    return $str;
}

//Button Group
add_shortcode('certy_button_group', 'certy_button_group');
function certy_button_group($atts, $cont = null) {
    $str = '';
    $str .= "<p class=\"btn-group\">";
    $str .= do_shortcode($cont);
    $str .= "</p>";
    return $str;
}

// Button
add_shortcode('certy_button', 'certy_button');
function certy_button( $atts ) {
    extract( shortcode_atts( array(
        'button_text' => '',
        'button_link'   => '#',
        'target'   => '_blank',
        'color'   => 'default',
        'style'   => 'default',
        'font_style'   => 'default',
        'size'   => 'large',
        'icon'   => '',
        'full_width'   => '0',
    ), $atts ) );

		
		switch ($size){
			case 'medium':
			$btn_size = '';
			break;
			case 'small':
			$btn_size = 'btn-sm';
			break;
			default:
			$btn_size = 'btn-lg';
		}

        $font_style_class='';
        $style_class='';
        if(empty($color) || ( $color !='primary' && $color !='secondary' && $color !='bordered' ) ){
            $color = 'default';
        }
    
        if(!empty($full_width) && $full_width=='1'){
            $full_width_class = ' btn-block';
        }else{
            $full_width_class = '';
        }

        if(empty($font_style) || $font_style !='default'){
            $font_style = 'thin';
        }
        if($font_style=='thin'){
            $font_style_class = ' btn-thin';
        }

        if($style=='circle'){
            $style_class = ' btn-icon';
        }
        if($icon == 'icon class'){
            $icon = '';
        }

        if(!empty($icon) && $style != 'circle'){
            $icon = '<span class="crt-icon '.$icon.'"></span>';
        }elseif($style == 'circle'){
            $icon = '<span class="crt-icon crt-icon-side-bar-icon"></span>';
            $button_text = '';
        }
	
	if($button_text || $button_link):
		$out = '<a class="btn '.$btn_size.$full_width_class.' btn-'.$color.$style_class.$font_style_class.'" target="'.$target.'" href="'.$button_link.'">'.$icon.$button_text.'</a>';
	endif;

    return $out;
}

// Slider
add_shortcode('certy_slider', 'certy_slider');
function certy_slider($atts, $cont = null) {
	extract( shortcode_atts( array(
        'dotes' => 'false',
        'slides_count' => '1',
    ), $atts ) );

    if($slides_count>1){
        $class='carousel';
    }else{
        $class='slider';
    }

    if(empty($slides_count)){
        $slides_count = 1;
    }

    if(empty($dotes)){
        $dotes = 'false';
    }

    $str = '<div class="cr-'.$class.'" data-slick=\'{"slidesToShow": '.$slides_count.', "slidesToScroll": '.$slides_count.', "dots": '.$dotes.'}\'>';
    $str .= do_shortcode($cont);
    $str .= '</div>';
    return $str;
}
add_shortcode('slide', 'slide');
function slide($atts) {
	extract( shortcode_atts( array(
        'image_link' => '',
    ), $atts ) );
	
    $str = '';
    $str .= "<div>";
    $str .= '<img src="'.$image_link.'" alt="slide" />';
    $str .= "</div>";
    return $str;
}

add_action('media_buttons','add_sc_select',11);

//tabs
//wrapper
add_shortcode('certy_tabs_wrapper', 'certy_tabs_wrapper');
function certy_tabs_wrapper($atts, $cont = null) {
    extract( shortcode_atts( array(
        'type' => '',
    ), $atts ) );

    if($type == 'vertical'){
        $class="vertical";
    }else{
        $class = 'horizontal';
    }

    $out = '<div class="tabs tabs-'.$class.'">';
    $out .= do_shortcode($cont);
    $out .= '</div>';

    return $out;
}

//tabs
//title wrapper
add_shortcode('certy_tab_title_wrapper', 'certy_tab_title_wrapper');
function certy_tab_title_wrapper($atts, $cont = null) {

    Certy_Shortcode_Manager::get_instance()->set_new_tab_group();

    $out = '<ul class="tabs-menu">';
    $out .= do_shortcode($cont);
    $out .= '</ul>';

    return $out;
}

//tabs
//title
add_shortcode('certy_tab_title', 'certy_tab_title');
function certy_tab_title($atts, $cont = null) {
    extract( shortcode_atts( array(
        'for' => '',
    ), $atts ) );

    STATIC $i = 0; $i++;

    if( Certy_Shortcode_Manager::get_instance()->is_new_tab_group() ){
        Certy_Shortcode_Manager::get_instance()->set_new_tab_group( false );
        $active = ' class="active"';
    }else{
        $active = '';
    }

    $out = '<li'.$active.'><a href="#'.$i.$for.'">';
    $out .= do_shortcode($cont);
    $out .= '</a></li>';

    return $out;
}

//tabs
//content wrapper
add_shortcode('certy_tab_content_wrapper', 'certy_tab_content_wrapper');
function certy_tab_content_wrapper($atts,$cont = null) {

    $out = '<div class="tabs-content">';
    $out .= do_shortcode($cont);
    $out .= '</div>';

    return $out;
}

//tabs
//content
add_shortcode('certy_tab_content', 'certy_tab_content');
function certy_tab_content($atts, $cont = null) {
    extract( shortcode_atts( array(
        'id' => '',
    ), $atts ) );

    STATIC $i = 0; $i++;

    $out = '<div id="'.$i.$id.'" class="tab-content">';
    $out .= do_shortcode($cont);
    $out .= '</div>';

    return $out;
}

//toggle
//wrapper
add_shortcode('certy_toggle_wrapper', 'certy_toggle_wrapper');
function certy_toggle_wrapper($atts, $cont = null) {

    $out = '<ul class="togglebox">';
    $out .= do_shortcode($cont);
    $out .= '</ul>';

    return $out;
}

//toggle
add_shortcode('certy_toggle', 'certy_toggle');
function certy_toggle($atts, $cont = null) {
    extract( shortcode_atts( array(
        'title' => '',
    ), $atts ) );

    $out = '<li><h3 class="togglebox-header">'.$title.'</h3><div class="togglebox-content">';
    $out .= do_shortcode($cont);
    $out .= '</div></li>';

    return $out;
}

//Accordion
//wrapper
add_shortcode('certy_accordion_wrapper', 'certy_accordion_wrapper');
function certy_accordion_wrapper($atts, $cont = null) {

    Certy_Shortcode_Manager::get_instance()->set_new_accordion_group();

    $out = '<ul class="accordion">';
    $out .= do_shortcode($cont);
    $out .= '</ul>';

    return $out;
}

//accordion
add_shortcode('certy_accordion', 'certy_accordion');
function certy_accordion($atts, $cont = null) {
    extract( shortcode_atts( array(
        'title' => '',
    ), $atts ) );

    if(Certy_Shortcode_Manager::get_instance()->is_new_accordion_group()){
        Certy_Shortcode_Manager::get_instance()->set_new_accordion_group( false );
        $active = ' class="active"';
    }else{
        $active = '';
    }

    $out = '<li'.$active.'><h3 class="accordion-header">'.$title.'</h3><div class="accordion-content">';
    $out .= do_shortcode($cont);
    $out .= '</div></li>';

    return $out;
}

//tooltip
add_shortcode('certy_tooltip', 'certy_tooltip');
function certy_tooltip($atts, $cont = null) {
    extract( shortcode_atts( array(
        'title' => '',
    ), $atts ) );

    $out = '<span class="tooltip" data-tooltip="'.$title.'">';
    $out .= do_shortcode($cont);
    $out .= '</span>';

    return $out;
}

//dropcup
add_shortcode('certy_dropcup', 'certy_dropcup');
function certy_dropcup($atts, $cont = null) {
    extract( shortcode_atts( array(
        'color' => '',
        'background_color' => '',
    ), $atts ) );

    $out ='';
    if($color == 'primary'){
        $class = ' text-primary';
    }else{
        $class = '';
    }

    if(!empty($background_color) && $background_color == 'primary'){
        $class_bg = '-sq bg-primary';
    }elseif(!empty($background_color)){
        $class_bg = '-sq';
    }else{
        $class_bg = '';
    }

    $out = '<span class="text-dropcup'.$class_bg.$class.'">';
    $out .= do_shortcode($cont);
    $out .= '</span>';

    return $out;
}

//map
add_shortcode('certy_map', 'certy_map');
function certy_map($atts, $cont = null) {
    extract( shortcode_atts( array(
        'latitude' => '',
        'longitude' => '',
    ), $atts ) );

    $out ='';

    if(!empty($latitude) && !empty($longitude)) {
        $out = '<div class="map" data-latitude="'.$latitude.'" data-longitude="'.$longitude.'"></div>';
    }

    return $out;
}

//socials
add_shortcode('certy_socials', 'certy_socials');
function certy_socials($atts) {
    extract( shortcode_atts( array(
        'align' => 'left',
    ), $atts ) );

    $out = '';
    $socials = Kirki::get_option('certy_kirki_config', 'social_options');
    if(!empty($socials)):
        $out .= '<ul class="crt-social clear-list text-'.$align.'">';
                    foreach($socials as $social):
                        if(!empty($social['link_text']) && !empty($social['link_url'])):
                            $out .= '<li><a target="_blank" href="'.$social['link_url'].'"><span class="crt-icon crt-icon-'.$social['link_text'].'"></span></a></li>';
                        endif;
                    endforeach;
        $out .= '</ul>';
    endif;

    return $out;
}

//highlight
add_shortcode('certy_highlight', 'certy_highlight');
function certy_highlight($atts,$cont = null) {
    $out ='';

    $out .= '<mark>'.do_shortcode($cont).'</mark>';

    return $out;
}

//share
add_shortcode('certy_share', 'certy_share');
function certy_share($atts) {
    extract( shortcode_atts( array(
        'align' => 'left',
    ), $atts ) );

    $out ='';
    $inline_share = Kirki::get_option('certy_kirki_config', 'share_div');

    if(!empty($inline_share)) {
        $out .= '<div class="share-box text-'.$align.' clearfix">
                    <button class="share-btn btn btn-bordered btn-upper">
                        <span class="crt-icon crt-icon-share"></span>'.__('Share','certy').'
                    </button>'.$inline_share.'</div>';
    }

    return $out;
}

//icon text
add_shortcode('certy_icon_text', 'certy_icon_text');
function certy_icon_text($atts, $cont = null) {
    extract( shortcode_atts( array(
        'class' => '',
    ), $atts ) );


    $str = "<span class='crt-icon-item'><span class='crt-icon crt-icon-{$class}'></span>";
    $str .= do_shortcode($cont).'</span>';
    return $str;
}


function add_sc_select(){
    global $shortcode_tags;
	$shortcodes_list = '';
    echo '&nbsp;<select class="sc_select"><option value="">Select Shortcode</option>';
    $shortcodes_list .= '<option value="'."[wrapper][one_half]
<h3>ONE HALF</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_half][one_half]
<h3>ONE HALF</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_half][/wrapper]".'">One Half</option>';
    $shortcodes_list .= '<option value="'."[wrapper][one_third]
<h3>ONE THIRD</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_third][one_third]
<h3>ONE THIRD</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_third][one_third]
<h3>ONE THIRD</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_third][/wrapper]".'">One Third</option>';
    $shortcodes_list .= '<option value="'."[wrapper][one_fourth]
<h3>ONE FOURTH</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_fourth][one_fourth]
<h3>ONE FOURTH</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_fourth][one_fourth]
<h3>ONE FOURTH</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_fourth][one_fourth]
<h3>ONE FOURTH</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_fourth][/wrapper]".'">One Fourth</option>';
    $shortcodes_list .= '<option value="'."[certy_button_group]
                                                [certy_button button_text='Download' button_link='#' target='_blank' style='circle|default' font_style='thin|default'  color='primary|secondary|default|bordered' size='small|medium|large' icon='icon class' full_width='1|0']
                                                [certy_button button_text='Download' button_link='#' target='_blank' style='circle|default' font_style='thin|default'  color='primary|secondary|default|bordered' size='small|medium|large' icon='icon class' full_width='1|0']
                                                [certy_button button_text='Download' button_link='#' target='_blank' style='circle|default' font_style='thin|default'  color='primary|secondary|default|bordered' size='small|medium|large' icon='icon class' full_width='1|0']
                                            [/certy_button_group]".'">Button Group</option>';
	$shortcodes_list .= '<option value="'."[certy_button button_text='Download' button_link='#' target='_blank' style='circle|default' font_style='thin|default'  color='primary|secondary|default|bordered' size='small|medium|large' icon='icon class' full_width='1|0']".'">Button</option>';
	$shortcodes_list .= '<option value="'."[certy_slider dotes='false' slides_count='1'][slide image_link=''][slide image_link=''][slide image_link=''][/certy_slider]".'">Slider</option>';
	$shortcodes_list .= '<option value="'."[certy_tabs_wrapper type='horizontal|vertical']
											[certy_tab_title_wrapper]
												[certy_tab_title for='1']Tab 1[/certy_tab_title]
												[certy_tab_title for='2']Tab 2[/certy_tab_title]
												[certy_tab_title for='3']Tab 3[/certy_tab_title]
												[certy_tab_title for='4']Tab 4[/certy_tab_title]
											[/certy_tab_title_wrapper]
											[certy_tab_content_wrapper]
												[certy_tab_content id='1']
													Tab 1 content<br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
													Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
													fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor.
												[/certy_tab_content]
												[certy_tab_content id='2']
													Tab 2 content<br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
													Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
													fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor.
												[/certy_tab_content]
												[certy_tab_content id='3']
													Tab 3 content<br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
													Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
													fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor.
												[/certy_tab_content]
												[certy_tab_content id='4']
													Tab 4 content<br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
													Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
													fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor.
												[/certy_tab_content]
											[/certy_tab_content_wrapper]
										[/certy_tabs_wrapper]".'">Tabs</option>';
	$shortcodes_list .= '<option value="'."[certy_toggle_wrapper] [certy_toggle title='Toggle Box Title 1'] Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna. Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna. Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. [/certy_toggle] [certy_toggle title='Toggle Box Title 2'] Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna. Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna. Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. [/certy_toggle] [certy_toggle title='Toggle Box Title 3'] Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna. Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna. Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. [/certy_toggle] [/certy_toggle_wrapper]".'">Toggle</option>';
	   
		$shortcodes_list .= '<option value="'."[certy_accordion_wrapper] [certy_accordion title='Accordion Box Title 1'] Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna. Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna. Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. [/certy_accordion] [certy_accordion title='Accordion Box Title 2'] Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna. Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna. Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. [/certy_accordion] [certy_accordion title='Accordion Box Title 3'] Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna. Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna. Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. [/certy_accordion] [/certy_accordion_wrapper]".'">Accordion</option>';
		$shortcodes_list .= '<option value="'."[certy_alert type='success|info|warning|danger']Your Message[/certy_alert]".'">Alert Message</option>';
		$shortcodes_list .= '<option value="'."[certy_toggle_link toggle_text='Show More']Established fact that a reader will be distracted by the readable content of a page when lookingt its layout.[/certy_toggle_link]".'">Toggle Link</option>';
		$shortcodes_list .= '<option value="'."[circle_bar visible_value='Visible Value' bar_value='0-100']Visible Title[/circle_bar]".'">Circle Bar</option>';
		$shortcodes_list .= '<option value="'."[dote_bar visible_value='Visible Value' bar_value='0-10']Visible Title[/dote_bar]".'">Dote Bar</option>';
		$shortcodes_list .= '<option value="'."[line_bar visible_value='Visible Value' bar_value='0-100']".'">Line Bar</option>';
		$shortcodes_list .= '<option value="'."[certy_tooltip title='tooltip text']Lorem ipsum[/certy_tooltip]".'">Tooltip</option>';
		$shortcodes_list .= '<option value="'."[certy_dropcup color='default|primary' background_color='default|primary']L[/certy_dropcup]".'">Dropcup</option>';
		$shortcodes_list .= '<option value="'."[certy_socials align='left|center|right']".'">Socials</option>';
		$shortcodes_list .= '<option value="'."[certy_share align='left|center|right']".'">Share Button</option>';
		$shortcodes_list .= '<option value="'."[certy_highlight]highlighted text[/certy_highlight]".'">Highlight</option>';
        $shortcodes_list .= '<option value="'."[certy_icon_text class='music']&nbsp;&nbsp;Lorem ipsum dolor sit amet&nbsp;&nbsp;&nbsp;&nbsp;[/certy_icon_text]".'">Icon With Text</option>';
    echo $shortcodes_list;
	
    echo '</select>';
}

function certy_shortcode_enqueue_script() {
	wp_enqueue_script( 'rs-shortcode-button-js', plugin_dir_url( __FILE__ ).'shortcodes.js',array('jquery'),'', true );
} 
add_action( 'admin_enqueue_scripts', 'certy_shortcode_enqueue_script' );

