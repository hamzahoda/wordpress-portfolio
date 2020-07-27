<?php
/**
 * Template for displaying search forms in Certy
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$unique_id = esc_attr( uniqid( 'search-form-' ) );
?>

<form role="search" method="get" class="search-again" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="form-item-wrap">
		<input type="search" id="<?php echo $unique_id; ?>" class="form-item" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'certy' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</div>
	<div class="form-submit form-item-wrap">
		<input type="submit" id="submit" class="btn btn-primary" value="<?php echo esc_attr_x( 'Try Again', 'value', 'certy' ); ?>">
	</div>
</form>
