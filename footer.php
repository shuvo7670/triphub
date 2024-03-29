<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package TripHub
*/

	/**
     * After Content
     * 
     * @hooked triphub_content_end - 20
    */
    do_action( 'triphub_before_footer' );
    
    /**
     * Footer
     * 
     * @hooked triphub_footer_start  - 20
     * @hooked triphub_footer_top    - 30
     * @hooked triphub_footer_bottom - 40
     * @hooked triphub_footer_end    - 50
    */
    do_action( 'triphub_footer' );
    
    /**
     * After Footer
     * 
     * @hooked triphub_scrolltotop - 20
     * @hooked triphub_page_end    - 30
    */
    do_action( 'triphub_after_footer' );

	wp_footer(); ?>

</body>
</html>