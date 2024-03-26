<?php
/**
 * Scroll to Top Settings
 *
 * @package Travel Monster
*/

function triphub_customize_register_general_scroll_to_top( $wp_customize ){
    
    $defaults = triphub_get_general_defaults();

    /** Scroll to Top */
    $wp_customize->add_section( 
        'general_scroll_top_section',
         array(
            'priority' => 50,
            'title'    => __( 'Scroll to Top', 'triphub' ),
            'panel'    => 'general_panel'
        ) 
    );

    $wp_customize->add_setting(
        'ed_scroll_top',
        array(
            'default'           => $defaults['ed_scroll_top'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        new triphub_Toggle_Control( 
            $wp_customize,
            'ed_scroll_top',
            array(
				'section' => 'general_scroll_top_section',
				'label'   => __( 'Show Scroll to Top', 'triphub' ),
			)
        )
    );

    /** Scroll to Top Icon size */
    $wp_customize->add_setting(
    'scroll_top_size',
    array(
        'default'           => $defaults['scroll_top_size'],
        'sanitize_callback' => 'triphub_sanitize_empty_absint',
        'transport'         => 'postMessage',
    )
    );

    $wp_customize->add_setting(
        'tablet_scroll_top_size',
        array(
            'default'           => $defaults['tablet_scroll_top_size'],
            'sanitize_callback' => 'triphub_sanitize_empty_absint',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_setting(
        'mobile_scroll_top_size',
        array(
            'default'           => $defaults['mobile_scroll_top_size'],
            'sanitize_callback' => 'triphub_sanitize_empty_absint',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new triphub_Range_Slider_Control(
            $wp_customize,
            'scroll_top_size',
            array(
                'label'    => __( 'Icon Size', 'triphub' ),
                'section'  => 'general_scroll_top_section',
                'settings' => array(
                    'desktop' => 'scroll_top_size',
                    'tablet'  => 'tablet_scroll_top_size',
                    'mobile'  => 'mobile_scroll_top_size'
                ),
                'choices' => array(
                    'desktop' => array(
                        'min'  => 1,
                        'max'  => 50,
                        'step' => 1,
                        'edit' => true,
                        'unit' => 'px',
                    ),
                    'tablet' => array(
                        'min'  => 1,
                        'max'  => 50,
                        'step' => 1,
                        'edit' => true,
                        'unit' => 'px',
                    ),
                    'mobile' => array(
                        'min'  => 1,
                        'max'  => 50,
                        'step' => 1,
                        'edit' => true,
                        'unit' => 'px',
                    ),
                ),
                'active_callback' => 'triphub_scroll_to_top_ac'
            )
        )
    );

}
add_action( 'customize_register', 'triphub_customize_register_general_scroll_to_top' );