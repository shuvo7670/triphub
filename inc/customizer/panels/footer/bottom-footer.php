<?php
/**
 * Bottom Footer Settings
 *
 * @package Travel Monster
*/

function triphub_customize_register_bottom_footer( $wp_customize ){
    $colorDefaults = triphub_get_color_defaults();
    $defaults      = triphub_get_general_defaults();

    /** Footer */
    $wp_customize->add_section( 
        'bottom_footer_settings',
         array(
            'priority' => 10,
            'title'    => __( 'Bottom Footer', 'triphub' ),
            'panel'    => 'footer_panel'
        ) 
    );

    $wp_customize->add_setting(
        'bottom_footer_copyright_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new triphub_Group_Control( 
            $wp_customize,
            'bottom_footer_copyright_group',
            array(
                'id'          => 'bottom_footer_copyright_group',
                'label'       => __( 'Copyright Settings', 'triphub' ),
                'section'     => 'bottom_footer_settings',
                'type'        => 'group',
                'style'       => 'collapsible',
            )
        )
    );
    
    /** Footer Copyright */
    $wp_customize->add_setting(
        'footer_copyright',
        array(
            'default'           => $defaults['footer_copyright'],
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        new triphub_Text_Control( 
            $wp_customize,
            'footer_copyright',
            array(
                'label'       => __( 'Footer Copyright Text', 'triphub' ),
                'section'     => 'bottom_footer_settings',
                'type'        => 'textarea',
                'group'       => 'bottom_footer_copyright_group'
            )
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'footer_copyright', array(
        'selector' => '.site-info .copyright',
        'render_callback' => 'triphub_get_footer_copyright',
    ) );

    /** Payment Label */
    $wp_customize->add_setting(
        'payment_label',
        array(
            'default'           => $defaults['payment_label'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        new triphub_Text_Control( 
            $wp_customize,
            'payment_label',
            array(
                'label'   => __( 'Payment Label', 'triphub' ),
                'section' => 'bottom_footer_settings',
                'type'    => 'text',
            )
        )
    );

    $wp_customize->selective_refresh->add_partial( 'payment_label', array(
        'selector'        => '.payments-showcase span',
        'render_callback' => 'triphub_payment_label',
    ) );

    /** Payment Image */
    $wp_customize->add_setting(
        'payment_image',
        array(
            'default'           => $defaults['payment_image'],
            'sanitize_callback' => 'triphub_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'payment_image',
            array(
                'label'   => __( 'Payment Image', 'triphub' ),
                'section' => 'bottom_footer_settings',
            )
        )
    );

    $wp_customize->add_setting(
        'bottom_footer_color_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new triphub_Group_Control( 
            $wp_customize,
            'bottom_footer_color_group',
            array(
                'id'          => 'bottom_footer_color_group',
                'label'       => __( 'Color Settings', 'triphub' ),
                'section'     => 'bottom_footer_settings',
                'type'        => 'group',
                'style'       => 'collapsible',
            )
        )
    );

    $wp_customize->add_setting(
        'bottom_footer_bg_color',
        array(
            'default'           => $colorDefaults['bottom_footer_bg_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'triphub_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new triphub_Alpha_Color_Customize_Control(
            $wp_customize,
            'bottom_footer_bg_color',
            array(
                'label'   => __( 'Background Color', 'triphub' ),
                'section' => 'bottom_footer_settings',
                'group'   => 'bottom_footer_color_group'
            )
        )
    );
    
    $wp_customize->add_setting(
        'bottom_footer_text_color',
        array(
            'default'           => $colorDefaults['bottom_footer_text_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'triphub_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new triphub_Alpha_Color_Customize_Control(
            $wp_customize,
            'bottom_footer_text_color',
            array(
                'label'   => __( 'Text Color', 'triphub' ),
                'section' => 'bottom_footer_settings',
                'group'   => 'bottom_footer_color_group'
            )
        )
    );

    $wp_customize->add_setting(
        'bottom_footer_link_initial_color',
        array(
            'default'           => $colorDefaults['bottom_footer_link_initial_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'triphub_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new triphub_Alpha_Color_Customize_Control(
            $wp_customize,
            'bottom_footer_link_initial_color',
            array(
                'label'   => __( 'Link Initial Color', 'triphub' ),
                'section' => 'bottom_footer_settings',
                'group'   => 'bottom_footer_color_group'
            )
        )
    );

    $wp_customize->add_setting(
        'bottom_footer_link_hover_color',
        array(
            'default'           => $colorDefaults['bottom_footer_link_hover_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'triphub_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new triphub_Alpha_Color_Customize_Control(
            $wp_customize,
            'bottom_footer_link_hover_color',
            array(
                'label'   => __( 'Link Hover Color', 'triphub' ),
                'section' => 'bottom_footer_settings',
                'group'   => 'bottom_footer_color_group'
            )
        )
    );

}
add_action( 'customize_register', 'triphub_customize_register_bottom_footer' );