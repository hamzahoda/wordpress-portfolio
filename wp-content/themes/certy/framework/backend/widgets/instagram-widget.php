<?php
/**
 * The template for displaying instagram widget
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
add_action( 'widgets_init', 'certy_instagram_widget_load_widgets' );

/**
 * Register our widget.
 */
function certy_instagram_widget_load_widgets() {
	register_widget( 'Certy_Instagram_Widget' );
}

/**
 * recent_Posts Widget class.
 */
class Certy_Instagram_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'certy_widget_instagram', 'description' => __('Shows the instagram photos','certy' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'crt-instagram-widget' );

		/* Create the widget. */
		parent::__construct( 'crt-instagram-widget', __('Certy: Instagram Widget','certy' ), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$access_token = $instance['access_token'];
		$count = $instance['count'];


		/* Before widget (defined by themes). */			
		echo $before_widget;		

		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title ) echo $before_title . $title . $after_title;

        if(!empty($access_token)):
            $feed_data = certy_instagram("https://api.instagram.com/v1/users/self/media/recent/?access_token=".$access_token);
			if($feed_data):
                ?>
                <ul class="instagram-pics">
                    <?php 
					$i = 0;
                    foreach ($feed_data->data as $post):
						if($i == intval($count)):break;endif;
					?>
                        <li>
                            <a style="background-image: url('<?php echo esc_html($post->images->standard_resolution->url); ?>')" target="blank" href="<?php echo esc_url($post->link); ?>"></a>
                        </li>
                    <?php $i++; endforeach;?>
                </ul>
            <?php
            endif;
        endif;
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['access_token'] = strip_tags( $new_instance['access_token'] );
		$instance['count'] = strip_tags( $new_instance['count'] );
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'count' => '9', 'access_token' =>'');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','certy' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
		</p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'access_token' )); ?>"><?php esc_html_e( 'Access Token:','certy' ); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id( 'access_token' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'access_token' )); ?>" value="<?php echo esc_attr($instance['access_token']); ?>" style="width:100%;" />
        </p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'count' )); ?>"><?php esc_html_e( 'Count:','certy' ); ?></label>
			<input type='number' id="<?php echo esc_attr($this->get_field_id( 'count' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'count' )); ?>" value="<?php echo esc_attr($instance['count']); ?>" style="width:100%;" />
		</p>
		
		<p>
            <?php esc_html_e( 'Please ','certy' ); ?><a target="_blank" href="http://instagram.pixelunion.net/"><?php esc_html_e( 'Generate Access Token ','certy' ); ?></a> <?php esc_html_e( 'and put the token to "access_token" field above to make this widget work','certy' ); ?>
		</p>
		
	<?php
	}
}

?>