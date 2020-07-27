<?php
/**
 * The template for social
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}
$socials = Kirki::get_option('certy_kirki_config', 'social_options');
if(!empty($socials)):
?>
    <ul class="crt-social clear-list">
        <?php foreach($socials as $social):
            if(!empty($social['link_text']) && !empty($social['link_url'])):
            ?>
                <li><a target="_blank" href="<?php echo esc_url($social['link_url']);?>"><span class="crt-icon crt-icon-<?php echo esc_attr($social['link_text'])?>"></span></a></li>
            <?php endif;?>
        <?php endforeach;?>
    </ul>
<?php endif;?>