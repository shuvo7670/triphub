<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package TripHub
 */

$sidebar = triphub_sidebar();

if ( ! $sidebar ) {
	return;
}
?>

<aside id="secondary" class="widget-area" <?php triphub_microdata( 'sidebar' ); ?>>
	<div class="sidebar-wrap-main">
		<?php dynamic_sidebar( $sidebar ); ?>
	</div>
</aside><!-- #secondary -->