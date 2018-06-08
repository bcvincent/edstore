<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package storefront
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php do_action( 'custom_sidebar_cart' );

	 dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
