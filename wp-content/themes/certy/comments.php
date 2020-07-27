<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Certy_Theme
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area padd-box">
    <h2 class="title text-upper"><?php _e( 'Comments', 'certy' )?></h2>
    <div class="padd-box-sm">
        <?php if ( have_comments() ) : ?>
            <?php paginate_comments_links(); ?>
                <ol class="comment-list clear-list">
                    <?php
                    wp_list_comments( array(
                        'style'       => 'ol',
                        'callback' => 'certy_comment'
                    ) );
                    ?>
                </ol>
        <?php endif;?>
    </div>
</div>
<div class="padd-box">
    <?php
        $req = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $comment_args = array(
            'fields' => apply_filters( 'comment_form_default_fields', array(
                'author'  => '
                            <div class="form-group">
                                <label class="form-label" for="author">'. __( 'Name', 'certy' ) .' <span class="required">*</span></label>
                                <div class="form-item-wrap">
                                    <input type="text" class="form-item" id="author" name="author" ' . $aria_req . ' />
                                </div>
                            </div>',
                'email'  => '
                            <div class="form-group">
                                <label class="form-label" for="email">'. __( 'Email', 'certy' ) .' <span class="required">*</span></label>
                                <div class="form-item-wrap">
                                    <input type="email" class="form-item" id="email" name="email" ' . $aria_req . ' />
                                </div>
                            </div>',
                'website' => '
                            <div class="form-group">
                                    <label class="form-label" for="url">'. __( 'Website', 'certy' ) .'</label>
                                    <div class="form-item-wrap">
                                        <input type="text" class="form-item" id="url" name="url"  />
                                    </div>
                            </div>',
                ) ),

            'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . __( 'Your email address will not be published.<br>', 'certy' ) . '</span>' . __( 'Required fields are marked', 'certy' ) . ' <span class="required">*</span></p>',
            'title_reply' => __( 'Leave a comment', 'certy'  ),
            'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title title text-upper">',
            'title_reply_after' => '</h2>',
            'class_form' => 'comment-form padd-box-sm',
            'comment_field' => '
                                    <div class="form-group">
                                        <label class="form-label" for="comment2">'. __( 'Your Comment', 'certy' ) .'</label>
                                        <div class="form-item-wrap">
                                            <textarea id="comment"  name="comment" class="form-item" ' . $aria_req . '></textarea>
                                        </div>
                                    </div>',

        );
        comment_form($comment_args);
    ?>
</div>
