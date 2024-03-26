<?php
/**
 * Single Trip Setting
 *
 * @param [type] $wp_customize
 * @return void
 */
function triphub_customize_register_single_trip( $wp_customize ){

    if( triphub_is_wpte_activated() ){

        $default = triphub_get_general_defaults();

        /** Single Trip */
        $wp_customize->add_section( 
            'single_trip_section',
            array(
                'priority' => 71,
                'title'    => __( 'Single Trip', 'triphub' ),
            ) 
        );

        
        $wp_customize->add_setting(
            'ed_sticky_booking_form',
            array(
                'default'           => $default['ed_sticky_booking_form'],
                'sanitize_callback' => 'triphub_sanitize_checkbox',
            )
        );
    
        $wp_customize->add_control(
            new triphub_Toggle_Control( 
                $wp_customize,
                'ed_sticky_booking_form',
                array(
                    'section' => 'single_trip_section',
                    'label'   => __( 'Enable sticky booking form', 'triphub' ),
                )
            )
        );
    }
}
add_action( 'customize_register', 'triphub_customize_register_single_trip' );