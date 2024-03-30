<?php
/**
 * Social Network Settings
 *
 * @package TripHub
*/

function triphub_customize_register_footer_social_network( $wp_customize ){

    $defaults = triphub_get_general_defaults();

    /** Social Network */
    $wp_customize->add_section( 
        'social_network_settings',
         array(
            'priority' => 31,
            'title'    => __( 'Social Networks', 'triphub' ),
        ) 
    );

    $wp_customize->add_setting(
        'social_network_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Triphub_Note_Control( 
            $wp_customize,
            'social_network_text',
            array(
                'section'     => 'social_network_settings',
                'label'       => 'Social Network Accounts',
                'description' => __( 'Add the links to your social media accounts and display them across your site.', 'triphub' ),
            )
        )
    );

    /** Facebook */
    $wp_customize->add_setting(
        'triphub_facebook',
        array(
            'default'           => $defaults['triphub_facebook'],
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
		new Triphub_Text_Control( 
			$wp_customize,
			'triphub_facebook',
			array(
				'section'         => 'social_network_settings',
				'label'           => __( 'Facebook', 'triphub' ),
			)
		)
	);

    /** Twitter */
    $wp_customize->add_setting(
        'triphub_twitter',
        array(
            'default'           => $defaults['triphub_twitter'],
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
		new Triphub_Text_Control( 
			$wp_customize,
			'triphub_twitter',
			array(
				'section'         => 'social_network_settings',
				'label'           => __( 'Twitter', 'triphub' ),
			)
		)
	);

     /** Instagram */
     $wp_customize->add_setting(
        'triphub_instagram',
        array(
            'default'           => $defaults['triphub_instagram'],
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
		new Triphub_Text_Control( 
			$wp_customize,
			'triphub_instagram',
			array(
				'section'         => 'social_network_settings',
				'label'           => __( 'Instagram', 'triphub' ),
			)
		)
	);

    /** Pinterest */
    $wp_customize->add_setting(
        'triphub_pinterest',
        array(
            'default'           => $defaults['triphub_pinterest'],
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
		new Triphub_Text_Control( 
			$wp_customize,
			'triphub_pinterest',
			array(
				'section'         => 'social_network_settings',
				'label'           => __( 'Pinterest', 'triphub' ),
			)
		)
	);

    /** YouTube  */
    $wp_customize->add_setting(
        'triphub_youtube',
        array(
            'default'           => $defaults['triphub_youtube'],
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new Triphub_Text_Control( 
			$wp_customize,
			'triphub_youtube',
			array(
				'section'         => 'social_network_settings',
				'label'           => __( 'YouTube', 'triphub' ),
			)
		)
	);

    /** TikTok  */
    $wp_customize->add_setting(
        'triphub_tiktok',
        array(
            'default'           => $defaults['triphub_tiktok'],
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new Triphub_Text_Control( 
			$wp_customize,
			'triphub_tiktok',
			array(
				'section'         => 'social_network_settings',
				'label'           => __( 'TikTok', 'triphub' ),
			)
		)
	);

    /** Linkedin */
    $wp_customize->add_setting(
        'triphub_linkedin',
        array(
            'default'           => $defaults['triphub_linkedin'],
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new Triphub_Text_Control( 
			$wp_customize,
			'triphub_linkedin',
			array(
				'section'         => 'social_network_settings',
				'label'           => __( 'Linkedin', 'triphub' ),
			)
		)
	);

    /** Whatsapp */
    $wp_customize->add_setting(
        'triphub_whatsapp',
        array(
            'default'           => $defaults['triphub_whatsapp'],
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new Triphub_Text_Control( 
			$wp_customize,
			'triphub_whatsapp',
			array(
				'section'         => 'social_network_settings',
				'label'           => __( 'Whatsapp', 'triphub' ),
			)
		)
	);

    /** Viber */
    $wp_customize->add_setting(
        'triphub_viber',
        array(
            'default'           => $defaults['triphub_viber'],
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new Triphub_Text_Control( 
			$wp_customize,
			'triphub_viber',
			array(
				'section'         => 'social_network_settings',
				'label'           => __( 'Viber', 'triphub' ),
			)
		)
	);

    /** Telegram */
    $wp_customize->add_setting(
        'triphub_telegram',
        array(
            'default'           => $defaults['triphub_telegram'],
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new Triphub_Text_Control( 
			$wp_customize,
			'triphub_telegram',
			array(
				'section'         => 'social_network_settings',
				'label'           => __( 'Telegram', 'triphub' ),
			)
		)
	);

    /** Trip Advisor */
    $wp_customize->add_setting(
        'triphub_tripadvisor',
        array(
            'default'           => $defaults['triphub_tripadvisor'],
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new Triphub_Text_Control( 
			$wp_customize,
			'triphub_tripadvisor',
			array(
				'section'         => 'social_network_settings',
				'label'           => __( 'Trip Advisor', 'triphub' ),
			)
		)
	);

}
add_action( 'customize_register', 'triphub_customize_register_footer_social_network' );