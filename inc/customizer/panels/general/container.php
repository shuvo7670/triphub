<?php
/**
 * Container Settings
 *
 * @package Travel Monster
*/

function triphub_customize_register_general_container( $wp_customize ){
    
    $defaults = triphub_get_general_defaults();

    /** Container */
    $wp_customize->add_section( 
        'general_container_section',
         array(
            'priority' => 10,
            'title'    => __( 'Container', 'triphub' ),
            'panel'    => 'general_panel'
        ) 
    );

    /** Container Width */
    $wp_customize->add_setting(
        'container_width',
        array(
            'default'           => $defaults['container_width'],
            'sanitize_callback' => 'triphub_sanitize_empty_absint',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_setting(
        'tablet_container_width',
        array(
            'default'           => $defaults['tablet_container_width'],
            'sanitize_callback' => 'triphub_sanitize_empty_absint',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_setting(
        'mobile_container_width',
        array(
            'default'           => $defaults['mobile_container_width'],
            'sanitize_callback' => 'triphub_sanitize_empty_absint',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new triphub_Range_Slider_Control(
            $wp_customize,
            'container_width',
            array(
                'label'    => __( 'Container Width', 'triphub' ),
                'section'  => 'general_container_section',
                'settings' => array(
                    'desktop' => 'container_width',
                    'tablet'  => 'tablet_container_width',
                    'mobile'  => 'mobile_container_width'
                ),
                'choices' => array(
                    'desktop' => array(
                        'min'  => 700,
                        'max'  => 1920,
                        'step' => 5,
                        'edit' => true,
                        'unit' => 'px',
                    ),
                    'tablet' => array(
                        'min'  => 300,
                        'max'  => 1024,
                        'step' => 5,
                        'edit' => true,
                        'unit' => 'px',
                    ),
                    'mobile' => array(
                        'min'  => 150,
                        'max'  => 767,
                        'step' => 5,
                        'edit' => true,
                        'unit' => 'px',
                    ),
                )
            )
        )
    );  

    /** Container Width */
    $wp_customize->add_setting(
        'fullwidth_centered',
        array(
            'default'           => $defaults['fullwidth_centered'],
            'sanitize_callback' => 'triphub_sanitize_empty_absint',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_setting(
        'tablet_fullwidth_centered',
        array(
            'default'           => $defaults['tablet_fullwidth_centered'],
            'sanitize_callback' => 'triphub_sanitize_empty_absint',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_setting(
        'mobile_fullwidth_centered',
        array(
            'default'           => $defaults['mobile_fullwidth_centered'],
            'sanitize_callback' => 'triphub_sanitize_empty_absint',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new triphub_Range_Slider_Control(
            $wp_customize,
            'fullwidth_centered',
            array(
                'label'    => __( 'Fullwidth Centered Max-width', 'triphub' ),
                'section'  => 'general_container_section',
                'settings' => array(
                    'desktop' => 'fullwidth_centered',
                    'tablet'  => 'tablet_fullwidth_centered',
                    'mobile'  => 'mobile_fullwidth_centered'
                ),
                'choices' => array(
                    'desktop' => array(
                        'min'  => 700,
                        'max'  => 2000,
                        'step' => 5,
                        'edit' => true,
                        'unit' => 'px',
                    ),
                    'tablet' => array(
                        'min'  => 300,
                        'max'  => 1500,
                        'step' => 5,
                        'edit' => true,
                        'unit' => 'px',
                    ),
                    'mobile' => array(
                        'min'  => 150,
                        'max'  => 1000,
                        'step' => 5,
                        'edit' => true,
                        'unit' => 'px',
                    ),
                ),
            )
        )
    );

}
add_action( 'customize_register', 'triphub_customize_register_general_container' );