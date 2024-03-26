<?php
/**
 * Pagination Settings
 *
 * @package Travel Monster
*/

function triphub_customize_register_general_pagination( $wp_customize ){
    
    $defaults = triphub_get_general_defaults();

    /** Pagination Settings */
    $wp_customize->add_section(
        'general_pagination_section',
        array(
            'title'    => __( 'Pagination', 'triphub' ),
            'priority' => 60,
            'panel'    => 'general_panel',
        )
    );

    /** Pagination Type */
    $wp_customize->add_setting( 
        'post_navigation', 
        array(
            'default'           => $defaults['post_navigation'],
            'sanitize_callback' => 'triphub_sanitize_select_radio'
        ) 
    );

    $wp_customize->add_control(
        'post_navigation',
        array(
            'type'    => 'radio',
            'section' => 'general_pagination_section',
            'label'   => __( 'Pagination Type', 'triphub' ),
            'description' => __( 'Select pagination type.', 'triphub' ),
            'choices' => array(
                'default'         => __( 'Default (Next / Previous)', 'triphub' ),
                'numbered'        => __( 'Numbered (1 2 3 4...)', 'triphub' ),
                'load_more'       => __( 'AJAX (Load More Button)', 'triphub' ),
                'infinite_scroll' => __( 'AJAX (Auto Infinite Scroll)', 'triphub' ),
            )
        )
    );

     
    /** Load More Label */
    $wp_customize->add_setting(
        'load_more_label',
        array(
            'default'           => $defaults['load_more_label'],
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
	   'load_more_label',
		array(
			'section'         => 'general_pagination_section',
			'label'	          => __( 'Load More Label', 'triphub' ),
			'type'            => 'text',
            'active_callback' => 'triphub_loading_ac' 
		)		
	);
    
    /** Loading Label */
    $wp_customize->add_setting(
        'loading_label',
        array(
            'default'           => $defaults['loading_label'],
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
	   'loading_label',
		array(
			'section'         => 'general_pagination_section',
			'label'	          => __( 'Loading Label', 'triphub' ),
			'type'            => 'text',
            'active_callback' => 'triphub_loading_ac' 
		)		
	);
    
    /** No more Label */
    $wp_customize->add_setting(
        'no_more_label',
        array(
            'default'           => $defaults['no_more_label'],
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
	   'no_more_label',
		array(
			'section'         => 'general_pagination_section',
			'label'	          => __( 'No More Label', 'triphub' ),
			'type'            => 'text',
            'active_callback' => 'triphub_loading_ac' 
		)		
	);
}
add_action( 'customize_register', 'triphub_customize_register_general_pagination' );