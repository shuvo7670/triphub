<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Travel Monster
*/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); triphub_microdata( 'article' ); ?>>
	<?php
		/**
		 * @hooked triphub_post_thumbnail - 15
		 * @hooked triphub_entry_header   - 20 
		*/
		do_action( 'triphub_before_post_entry_content' );

		/**
		 * @hooked triphub_entry_content - 15
		 * @hooked triphub_entry_footer  - 20
		*/
		do_action( 'triphub_post_entry_content' );
	?>
</article><!-- #post-## -->