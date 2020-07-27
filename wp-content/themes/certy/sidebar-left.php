<?php
/**
 * The template for displaying the left sidebar
 *
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}
?>


<?php $sidebar = check_left_sidebar();
if($sidebar):
?>
    <div id="crtSideBoxWrap">
        <div id="crtSideBox" class="clear-mrg">
            <?php foreach($sidebar as $side):
                if($side == 'left-sidebar-1' || $side == 'other-left-sidebar-1'):
                    $class='1';
                else:
                    $class='2';
                endif;
                ?>
                <div class="crt-side-box-<?php echo esc_attr($class);?> clear-mrg">
                    <?php dynamic_sidebar($side); ?>
                </div>
            <?php endforeach;?>
        </div>
    </div>
<?php endif;?>