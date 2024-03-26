<?php
/**
 * Footer Settings
 *
 * @package Travel Monster
 */

function triphub_customize_register_footer_settings( $wp_customize ) {
    
    /** Footer */
    $wp_customize->add_panel( 
        'footer_panel',
         array(
            'priority'    => 31,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Footer Settings', 'triphub' ),
        ) 
    );
}
add_action( 'customize_register', 'triphub_customize_register_footer_settings' );