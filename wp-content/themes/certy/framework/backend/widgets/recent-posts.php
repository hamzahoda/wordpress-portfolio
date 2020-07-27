<?php
/**
 * The template for displaying the recent posts widget
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
add_action( 'widgets_init', 'certy_recent_posts_load_widgets' );

/**
 * Register our widget.
 */
function certy_recent_posts_load_widgets() {
	register_widget( 'Certy_Recent_Posts_Widget' );
}

/**
 * recent_Posts Widget class.
 */
class Certy_Recent_Posts_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_posts_entries', 'description' => __('Recent Posts','certy' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'latest-blog-posts-widget' );

		/* Create the widget. */
		parent::__construct( 'latest-blog-posts-widget', 'Certy: Recent Posts', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		if(! empty($instance['title'])){
			$title = apply_filters('widget_title', $instance['title'] );
		}else{
			$title = '';
		}
		if(! empty($instance['count'])){
			$count = $instance['count'];
		}else{
			$count = '';
		}
		if(! empty($instance['cat'])){
			$cat = $instance['cat'];
		}else{
			$cat = '';
		}


		/* Before widget (defined by themes). */			
		echo $before_widget;		

		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title ) echo $before_title . $title . $after_title;

        $args = array(
            'posts_per_page'   => $count,
            'category'         => $cat,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'suppress_filters' => true
        );
        $posts_array = get_posts( $args );
        if($posts_array):?>
            <ul>
            <?php
			global $post;
            foreach($posts_array as $post):setup_postdata($post);
				$comment_link = get_comments_link();
				$comment_number = get_comments_number();
            ?>
            <li>
                <?php if(has_post_thumbnail()):?>
                    <a class="post-image" href="<?php the_permalink();?>">
						<?php the_post_thumbnail( 'certy-thumbnail-widget');?>
                    </a>
                <?php endif;?>
                <div class="post-content">
                    <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                </div>
				<div class="post-category-comment">
					<?php
					$category = get_the_category();
					foreach($category as $cat):
						?>
						<a href="<?php echo esc_url(get_category_link($cat->term_id));?>" class="post-category"><?php echo esc_html($cat->name);?></a>
					<?php endforeach;?>
					<?php if (comments_open()) :?>
						<a href="<?php echo esc_url($comment_link);?>" class="post-comments"><?php echo intval($comment_number);?> <?php _e( 'comments', 'certy' )?></a>
					<?php endif;?>
				</div>
            </li>
	<?php 
		endforeach;wp_reset_postdata();?>
        </ul>
		<?php endif;

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = strip_tags( $new_instance['count'] );
		$instance['cat'] = strip_tags( $new_instance['cat'] );
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'count' => '4', 'cat'=>'');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','certy' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'count' )); ?>"><?php esc_html_e( 'Count:','certy' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'count' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'count' )); ?>" value="<?php echo esc_attr($instance['count']); ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'cat' )); ?>"><?php esc_html_e( 'Category ID (optional):','certy' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'cat' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'cat' )); ?>" value="<?php echo esc_attr($instance['cat']); ?>" style="width:100%;" />
		</p>
		
	<?php
	}
}

?>