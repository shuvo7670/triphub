<?php
/**
 * General
 *
 * @package TripHub
 */

function triphub_customize_register_general_settings( $wp_customize ) {
    
    /** General */
    $wp_customize->add_panel( 
        'general_panel',
         array(
            'priority'    => 20,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'General', 'triphub' ),
        ) 
    );
}
add_action( 'customize_register', 'triphub_customize_register_general_settings' );