<?php
/**
 * The template part for displaying the footer.
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

?>
</div>
</div>

<?php get_sidebar(); ?>
<?php $footer_options = footer_options();?>
<footer id="crtFooter" class="crt-container-lg">
    <div class="crt-container">
        <?php if(!empty($footer_options['footer_content'])):?>
            <div class="crt-container-sm clear-mrg text-center">
                <p><?php echo wp_kses_post($footer_options['footer_content']);?></p>
            </div>
        <?php endif;?>
    </div>
</footer>
<?php if(empty($footer_options['hide_go_top'])):?>
    <button id="crtBtnUp" class="btn btn-icon btn-primary">
        <span class="crt-icon crt-icon-arrow-page-up"></span>
    </button>
<?php endif;?>

<?php if(empty($footer_options['disable_left_shape'])): ?>
    <svg id="crtBgShape1" class="hidden-sm hidden-xs" height="519" width="758">
        <polygon class="pol" points="0,455,693,352,173,0,92,0,0,71"/>
    </svg>
<?php endif;?>
<?php if(empty($footer_options['disable_right_shape'])): ?>
    <svg id="crtBgShape2" class="hidden-sm hidden-xs" height="536" width="633">
        <polygon points="0,0,633,0,633,536"/>
    </svg>
<?php endif; ?>
</div>
<?php wp_footer();?>
</body>
</html>
