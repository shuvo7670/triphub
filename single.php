<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package TripHub
 */

get_header(); ?>	
	<main id="primary" class="site-main">
		<div class="travel-monster-container-wrap">
			<?php 
				/**
				 * TripHub After Container Wrap
				*/
				do_action( 'triphub_after_container_wrap' );
			
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'single' );

				endwhile; // End of the loop.

				/**
				* After post loop
				* @hooked triphub_related_posts  - 5 //Comment location "Below Content"
				* @hooked triphub_comment  - 10 //Comment location "Below Content"
				* @hooked ravel_monster_pro_author  - 20
				*/
				do_action( 'triphub_after_post_loop' );
			?>
		</div>
	</main><!-- #main -->	
<?php
get_sidebar();
/**
 * @hooked triphub_related_posts  - 5 //Comment location "At End"
 * @hooked triphub_comment  - 10 //Comment location "At End"
 */
do_action( 'triphub_before_footer_post_loop' );

get_footer();