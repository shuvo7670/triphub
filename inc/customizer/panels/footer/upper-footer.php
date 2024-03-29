<?php
/**
 * Upper Footer Settings
 *
 * @package TripHub
*/

function triphub_customize_register_upper_footer( $wp_customize ){
    $colorDefaults = triphub_get_color_defaults();

    /** Footer */
    $wp_customize->add_section( 
        'upper_footer_settings',
         array(
            'priority' => 10,
            'title'    => __( 'Upper Footer', 'triphub' ),
            'panel'    => 'footer_panel'
        ) 
    );

    $wp_customize->add_setting(
        'upper_footer_bg_color',
        array(
            'default'           => $colorDefaults['upper_footer_bg_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'triphub_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new triphub_Alpha_Color_Customize_Control(
            $wp_customize,
            'upper_footer_bg_color',
            array(
                'label'   => __( 'Background Color', 'triphub' ),
                'section' => 'upper_footer_settings',
            )
        )
    );
    
    $wp_customize->add_setting(
        'upper_footer_text_color',
        array(
            'default'           => $colorDefaults['upper_footer_text_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'triphub_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new triphub_Alpha_Color_Customize_Control(
            $wp_customize,
            'upper_footer_text_color',
            array(
                'label'   => __( 'Text Color', 'triphub' ),
                'section' => 'upper_footer_settings',
            )
        )
    );

    $wp_customize->add_setting(
        'upper_footer_link_hover_color',
        array(
            'default'           => $colorDefaults['upper_footer_link_hover_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'triphub_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new triphub_Alpha_Color_Customize_Control(
            $wp_customize,
            'upper_footer_link_hover_color',
            array(
                'label'   => __( 'Link Hover Color', 'triphub' ),
                'section' => 'upper_footer_settings',
            )
        )
    );

    
    $wp_customize->add_setting(
        'upper_footer_widget_heading_color',
        array(
            'default'           => $colorDefaults['upper_footer_widget_heading_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'triphub_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new triphub_Alpha_Color_Customize_Control(
            $wp_customize,
            'upper_footer_widget_heading_color',
            array(
                'label'   => __( 'Widget Heading Color', 'triphub' ),
                'section' => 'upper_footer_settings',
            )
        )
    );

}
add_action( 'customize_register', 'triphub_customize_register_upper_footer' );