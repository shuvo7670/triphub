<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Travel Monster
*/
$defaults       = triphub_get_general_defaults();
$page_alignment = get_theme_mod( 'page_alignment', $defaults[ 'page_alignment' ] );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); triphub_microdata( 'article' ); ?> data-alignment="title-<?php echo esc_attr( $page_alignment ); ?>">
	<?php
		/**
		 * @hooked triphub_post_thumbnail - 15
		 * @hooked triphub_entry_header   - 20 
		*/
		do_action( 'triphub_before_page_entry_content' );

		/**
		 * @hooked triphub_entry_content - 15
		 * @hooked triphub_entry_footer  - 20
		*/
		do_action( 'triphub_page_entry_content' );
	?>
</article><!-- #post-## -->