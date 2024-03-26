<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Travel Monster
*/
	/**
     * Doctype Hook
     * 
     * @hooked triphub_doctype
    */
    do_action( 'triphub_doctype' );
?>
<head <?php triphub_microdata( 'head' ); ?>>
<?php 
    /**
     * Before wp_head
     * 
     * @hooked triphub_head
    */
    do_action( 'triphub_before_wp_head' );

	wp_head(); ?>
</head>

<body <?php body_class(); triphub_microdata( 'body' ); ?>>
<?php 
	
	wp_body_open(); 

	/**
     * Before Header
     * 
     * @hooked triphub_page_start - 20 
    */
    do_action( 'triphub_before_header' );

	/**
     * Header
     * @hooked triphub_notification_topbar - 15
     * @hooked triphub_header - 20     
    */
    do_action( 'triphub_header' );
    
    /**
     * After Header
    */
    do_action( 'triphub_after_header' );
    
    /**
     * Content
     * 
     * @hooked triphub_content_start
    */
    do_action( 'triphub_content' );