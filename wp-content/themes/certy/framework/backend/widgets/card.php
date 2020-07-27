<?php
/**
 * The template for displaying the card widget
 *
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'certy_card_widget_register' );

/**
 * Register our widget.
 */
function certy_card_widget_register() {
    register_widget( 'Certy_Card_Widget' );
}

/**
 * recent_Posts Widget class.
 */
class Certy_Card_Widget extends WP_Widget {

    /**
     * Widget setup.
     */
    function __construct() {
        /* Widget settings. */
        $widget_ops = array( 'classname' => 'certy_widget_card', 'description' => __('Card Widget','certy' ) );

        /* Widget control settings. */
        $control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'crt-card' );

        /* Create the widget. */
        parent::__construct( 'crt-card', __('Certy: Card Widget','certy' ), $widget_ops, $control_ops );
    }

    /**
     * How to display the widget on the screen.
     */
    function widget( $args, $instance ) {
        extract( $args );

        /* Our variables from the widget settings. */
        if(! empty($instance['image'])){
            $image = $instance['image'];
        }else{
            $image = '';
        }
        if(! empty($instance['hover_image'])){
            $hover_image = $instance['hover_image'];
        }else{
            $hover_image = '';
        }
        if(! empty($instance['title'])){
            $title = apply_filters('widget_title', $instance['title'] );
        }else{
            $title = '';
        }
        if(! empty($instance['secondary_title'])){
            $secondary_title = $instance['secondary_title'];
        }else{
            $secondary_title = '';
        }
        if(! empty($instance['secondary_title'])){
            $secondary_title = $instance['secondary_title'];
        }else{
            $secondary_title = '';
        }
        $show_social = isset($instance['show_social']) ? 'true' : 'false';


        /* Before widget (defined by themes). */
        echo $before_widget;
        ?>
            <div class="crt-card bg-primary text-center">
                <?php if(!empty($image)):
                    $image_type = substr($image, strrpos($image, '.') + 1);
                    $src_url = substr($image, 0, -4).'-195x195.'.$image_type;
                    ?>
                    <div class="crt-card-avatar">
                        <span class="crt-avatar-state">
                            <span class="crt-avatar-state1">
                                <img class="avatar avatar-195" alt="" src="<?php echo esc_url($src_url);?>" srcset="<?php echo esc_url($image);?> 2x">
                            </span>
                            <?php if(!empty($hover_image)):
                                $image_type_hover = substr($hover_image, strrpos($hover_image, '.') + 1);
                                $src_url = substr($hover_image, 0, -4).'-195x195.'.$image_type_hover;
                                ?>
                                <span class="crt-avatar-state2">
                                    <img class="avatar avatar-195" alt="" src="<?php echo esc_url($src_url);?>" srcset="<?php echo esc_url($hover_image);?> 2x" >
                                </span>
                            <?php endif;?>
                        </span>
                    </div>
                <?php endif;?>
                <div class="crt-card-info clear-mrg">
                    <?php if(!empty($title)):?>
                        <h2 class="text-upper"><?php echo esc_html($title); ?></h2>
                    <?php endif;?>
                    <?php if(!empty($secondary_title)):?>
                        <p class="text-muted"><?php echo esc_html($secondary_title); ?></p>
                    <?php endif;?>
                    <?php
                    if($show_social == 'true'):
                        get_template_part('template-parts/social');
                    endif;
                    ?>
                </div>
            </div>
        <?php
        /* After widget (defined by themes). */
        echo $after_widget;
    }

    /**
     * Update the widget settings.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['image'] = strip_tags( $new_instance['image'] );
        $instance['hover_image'] = strip_tags( $new_instance['hover_image'] );
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['secondary_title'] = strip_tags( $new_instance['secondary_title'] );
        $instance['show_social'] = $new_instance['show_social'];
        return $instance;
    }

    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form( $instance ) {

        /* Set up some default widget settings. */
        $defaults = array( 'title' => '', 'image' => '','hover_image' => '', 'secondary_title'=>'', 'show_social' => 'on', );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'image' )); ?>"><?php esc_html_e( 'Image Url:','certy' ); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id( 'image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'image' )); ?>" value="<?php echo esc_attr($instance['image']); ?>" style="width:100%;" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'hover_image' )); ?>"><?php esc_html_e( 'Hover Image Url:','certy' ); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id( 'hover_image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hover_image' )); ?>" value="<?php echo esc_attr($instance['hover_image']); ?>" style="width:100%;" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','certy' ); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
        </p>


        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'secondary_title' )); ?>"><?php esc_html_e( 'Secondary Title:','certy' ); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id( 'secondary_title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'secondary_title' )); ?>" value="<?php echo esc_attr($instance['secondary_title']); ?>" style="width:100%;" />
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_social'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_social')); ?>" name="<?php echo esc_attr($this->get_field_name('show_social')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_social')); ?>"><?php _e( 'Show Social Icons', 'certy' )?></label>
        </p>

        <?php
    }
}

?>
