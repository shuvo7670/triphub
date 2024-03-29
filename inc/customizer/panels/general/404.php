<?php
/**
 * 404 Page Settings
 *
 * @package TripHub
*/

function triphub_customize_register_general_404_page( $wp_customize ){
    
    $defaults = triphub_get_general_defaults();

    $wp_customize->add_section(
        'general_404_section',
        array(
            'title'    => __( '404 Page', 'triphub' ),
            'priority' => 70,
            'panel'    => 'general_panel',
        )
    );

    $wp_customize->add_setting(
        '404_image',
        array(
            'default'           => $defaults['404_image'],
            'sanitize_callback' => 'absint',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Cropped_Image_Control(
            $wp_customize,
            '404_image',
            array(
                'label'       => __( 'Upload 404 Image', 'triphub' ),
                'section'     => 'general_404_section',
                'flex_width'  => true,
                'flex_height' => true,
                'width'       => 1920,
                'height'      => 600,
            )
        )
    );

    $wp_customize->add_setting(
        'ed_latest_post',
        array(
            'default'           => $defaults['ed_latest_post'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        new triphub_Toggle_Control( 
            $wp_customize,
            'ed_latest_post',
            array(
				'section' => 'general_404_section',
				'label'   => __( 'Show Latest Posts', 'triphub' ),
			)
        )
    );

    /** Number of Posts */
    $wp_customize->add_setting(
        'no_of_posts_404',
        array(
            'default'           => $defaults['no_of_posts_404'],
            'sanitize_callback' => 'triphub_sanitize_empty_absint',
        )
    );

    $wp_customize->add_control(
        new triphub_Range_Slider_Control(
            $wp_customize,
            'no_of_posts_404',
            array(
                'label'           => __( 'Number of Posts', 'triphub' ),
                'section'         => 'general_404_section',
                'active_callback' => 'triphub_404_ac',
                'settings'        => array(  'desktop' => 'no_of_posts_404' ),
                'choices'         => array(
                    'desktop' => array(
                        'min'  => 1,
                        'max'  => 12,
                        'step' => 1,
                        'edit' => true,
                        'unit' => '',
                    ),
                ),
            )
        )
    );

     /** Posts Per Row */
     $wp_customize->add_setting(
        'posts_per_row_404',
        array(
            'default'           => $defaults['posts_per_row_404'],
            'sanitize_callback' => 'triphub_sanitize_empty_absint',
        )
    );

    $wp_customize->add_control(
        new triphub_Range_Slider_Control(
            $wp_customize,
            'posts_per_row_404',
            array(
                'label'           => __( 'Posts per row', 'triphub' ),
                'section'         => 'general_404_section',
                'active_callback' => 'triphub_404_ac',
                'settings'        => array( 'desktop' => 'posts_per_row_404' ),
                'choices'         => array(
                    'desktop' => array(
                        'min'  => 2,
                        'max'  => 4,
                        'step' => 1,
                        'edit' => true,
                        'unit' => '',
                    ),
                ),
            )
        )
    );
}
add_action( 'customize_register', 'triphub_customize_register_general_404_page' );