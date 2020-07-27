<?php
/**
 * Certy frontend functions
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

/**
 * @param $post_id
 * @param $image_id
 * @param string $size
 * @param string $class
 * @return 2x size if -2x image size is added
 */
function certy_post_thumbnail( $post_id, $image_id, $size = 'image', $class = '' )
{
	if(!empty($post_id)){
		$thumb_id = get_post_thumbnail_id( $post_id );
	}elseif(!empty($image_id)){
		$thumb_id = $image_id;
	}else{
		$thumb_id = '';
	}

	$thumbnail_arr = wp_get_attachment_image_src( $thumb_id, $size );
	$thumbnail = $thumbnail_arr[0];
	$thumbnail_2x_arr = wp_get_attachment_image_src( $thumb_id, $size . '-2x' );
	$thumbnail_2x = $thumbnail_2x_arr[0];
	$image  = '<img alt="" src="' . $thumbnail . '"';
	$image .= ( $thumbnail_2x ?  ' srcset="' : '' ); // open srcset
	$image .= ( $thumbnail_2x ? $thumbnail_2x . ' 2x' : '' );
	$image .= ( $thumbnail_2x ?  '"' : '' ); // close srcset
	$image .= ( $class ? ' class="' . esc_attr($class) . '"' : '' );
	$image .= ' >';

	return $image;
}

/**
 * Gets the posted on block
 */
function certy_posted_on() {

    // Get the author name; wrap it in a link.
    $byline = sprintf(
    /* translators: %s: post author */
        __( 'by %s', 'certy' ),
        '<span class="post-author vcard"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . get_the_author() . '</a></span>'
    );

    // Finally, let's write all of this to the page.
    echo '<span class="posted-on">' . certy_time_link() . '</span> ' . $byline;
}


/**
 * Gets a nicely formatted string for the published date.
 */
function certy_time_link() {
    $time_string = '<time class="post-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="post-date published" datetime="%1$s">%2$s</time><time class="post-date updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf( $time_string,
        get_the_date( DATE_W3C ),
        get_the_date(),
        get_the_modified_date( DATE_W3C ),
        get_the_modified_date()
    );

    // Wrap the time string in a link, and preface it with 'Posted on'.
    return sprintf(
    /* translators: %s: post date */
        '<span class="screen-reader-text">'. __( 'Posted on', 'certy' ) .'</span> %s',
        '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );
}

/**
 * @param $comment
 * @param $args
 * @param $depth
 * coment callback for change comment listing styles
 */
function certy_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?>>
        <article class="comment-body" id="comment-<?php comment_ID(); ?>">
            <header class="comment-header">
                <div class="comment-author vcard">
                    <?php echo get_avatar( $comment, $size='58'); ?>
                    <strong class="fn"><?php comment_author(); ?></strong>
                </div>
                <div class="comment-date">
                    <?php _e( 'at', 'certy'  );?>
                    <a href="#">
                            <time datetime="<?php echo get_the_date( 'c' ); ?>">
                            <?php comment_time('F j, Y H:i a'); ?>
                            </time>
                    </a>
                </div>
            </header>
            <div class="comment-content clear-mrg">
                <?php
                comment_text();
                $args_child = array(
                    'parent' => $comment->comment_ID,
                );
                $child_comments = get_comments( $args_child );
                ?>
            </div>
            <footer class="comment-footer">
                <?php if(!empty($child_comments) && $comment->comment_parent=='0'):?>
                    <div class="comment-replys-count">
                        <a rel="nofollow" class="comment-replys-link" href="#"><?php _e( 'show replies', 'certy' );?></a>
                    </div>
                <?php endif;?>

                <div class="comment-links">
                    <?php comment_reply_link( array_merge( $args, array( 'class' => 'comment-reply-link', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    <?php edit_comment_link(__( 'Edit', 'certy' )); ?>
                </div>
            </footer>
        </article>
    <?php
}

/**
 * @param $button
 * @return string
 * change comment submit button
 */
function certy_comment_form_submit_button($button) {
    $button =
        '
        <div class="form-submit form-item-wrap">
			<input name="submit" type="submit" id="submit" class="btn btn-primary btn-lg" value="'.__( 'Post Comment', 'certy' ).'">
        </div>
		';
    return $button;
}
add_filter('comment_form_submit_button', 'certy_comment_form_submit_button');

/**
 * @param $str
 * @return bool
 * check if content is empty
 */
function certy_empty_content($str) {
    return trim(str_replace('&nbsp;','',strip_tags($str))) == '';
}

/**
 * @return bool|string
 * check sidebar
 */
function check_sidebar(){
    if(is_singular('post') && is_active_sidebar('right-sidebar-single')){
        $sidebar = 'right-sidebar-single';
    }elseif(!is_front_page() && !is_page() && !is_singular('post') && is_active_sidebar('right-sidebar-archives')){
        $sidebar = 'right-sidebar-archives';
    }elseif(!is_front_page() && is_page() && is_active_sidebar('right-sidebar-pages')){
        $sidebar = 'right-sidebar-pages';
    }elseif(is_active_sidebar('right-sidebar')){
        $sidebar = 'right-sidebar';
    }else{
        $sidebar = false;
    }
    
    return $sidebar;
}

/**
 * @return bool|string
 * check sidebar
 */
function check_left_sidebar(){
    $show_left_sidebar_only_for_home = Kirki::get_option('certy_kirki_config', 'show_left_sidebar_only_for_home');
    $sidebar = false;
    if(is_front_page()){
        if(is_active_sidebar('left-sidebar-1')){
            $sidebar[] = 'left-sidebar-1';
        }
        if(is_active_sidebar('left-sidebar-2')){
            $sidebar[] = 'left-sidebar-2';
        }
    }elseif($show_left_sidebar_only_for_home == '0' && (is_active_sidebar('other-left-sidebar-1') || is_active_sidebar('other-left-sidebar-2'))) {
        if (is_active_sidebar('other-left-sidebar-1')) {
            $sidebar[] = 'other-left-sidebar-1';
        }
        if(is_active_sidebar('other-left-sidebar-2')) {
            $sidebar[] = 'other-left-sidebar-2';
        }
    }elseif($show_left_sidebar_only_for_home == '0' && (is_active_sidebar('left-sidebar-1') || is_active_sidebar('left-sidebar-2'))){
        if(is_active_sidebar('left-sidebar-1')){
            $sidebar[] = 'left-sidebar-1';
        }
        if(is_active_sidebar('left-sidebar-2')){
            $sidebar[] = 'left-sidebar-2';
        }
    }
    return $sidebar;
}


/**
 * @param $url
 * @return array|mixed|null|object
 * get instagram photos
 */
function certy_instagram($url){
    $ch = new WP_Http;
    $result = $ch->request( $url );
    return json_decode($result['body']);
}
