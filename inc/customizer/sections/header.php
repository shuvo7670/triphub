<?php
/**
 * Header Setting
 *
 * @package Travel Monster
 */

function triphub_customize_register_layout_header( $wp_customize ) {
    
    $defaults      = triphub_get_general_defaults();
    $colorDefaults = triphub_get_color_defaults();

    $wp_customize->add_section(
        'layout_header',
        array(
            'title'      => __( 'Main Header', 'triphub' ),
            'priority'   => 30,
            'capability' => 'edit_theme_options',
        )
    );

    /** General Settings */
    $wp_customize->add_setting(
        'main_header_general_settings_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new triphub_Group_Control( 
            $wp_customize,
            'main_header_general_settings_group',
            array(
                'id'          => 'main_header_general_settings_group',
                'label'       => __( 'General Settings', 'triphub' ),
                'section'     => 'layout_header',
                'type'        => 'group',
                'style'       => 'collapsible',
            )
        )
    );

    /*Header layouts*/
    $wp_customize->add_setting( 
        'header_width_layout', 
        array(
            'default'           => $defaults['header_width_layout'],
            'sanitize_callback' => 'triphub_sanitize_select_radio',
            'transport'         => 'postMessage'
        ) 
    );
    
    $wp_customize->add_control(
		new triphub_Radio_Buttonset_Control(
			$wp_customize,
			'header_width_layout',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Header Width', 'triphub' ),
				'choices' => array(
					'boxed'     => __( 'Boxed', 'triphub' ),
					'fullwidth' => __( 'Fullwidth', 'triphub' ),
                ),
                'group' => 'main_header_general_settings_group',
			)
		)
	);

    /** Sticky Header Menu */
    $wp_customize->add_setting(
        'ed_sticky_header',
        array(
            'default'           => $defaults['ed_sticky_header'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new triphub_Toggle_Control( 
			$wp_customize,
			'ed_sticky_header',
			array(
				'section'  => 'layout_header',
				'label'    => __( 'Sticky Header', 'triphub' ),
				'group'    => 'main_header_general_settings_group',
				'priority' => 10
			)
		)
	);

      /** Header Search Menu */
      $wp_customize->add_setting(
        'ed_header_search',
        array(
            'default'           => $defaults['ed_header_search'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new triphub_Toggle_Control( 
			$wp_customize,
			'ed_header_search',
			array(
				'section'  => 'layout_header',
				'label'    => __( 'Header Search', 'triphub' ),
				'group'    => 'main_header_general_settings_group',
				'priority' => 15
			)
		)
    );

    /** Top Header Background Color */
    $wp_customize->add_setting(
        'top_header_bg_color',
        array(
            'default'           => $colorDefaults['top_header_bg_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'triphub_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new triphub_Alpha_Color_Customize_Control(
            $wp_customize,
            'top_header_bg_color',
            array(
                'label'    => __( 'Top Header Color', 'triphub' ),
                'section'  => 'layout_header',
                'group'    => 'main_header_general_settings_group',
                'priority' => 25
            )
        )
    );

    /** Top Header Text Color */
    $wp_customize->add_setting(
        'top_header_text_color',
        array(
            'default'           => $colorDefaults['top_header_text_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'triphub_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new triphub_Alpha_Color_Customize_Control(
            $wp_customize,
            'top_header_text_color',
            array(
                'label'   => __( 'Text Color', 'triphub' ),
                'section' => 'layout_header',
                'group'   => 'main_header_general_settings_group',
                'priority' => 30
            )
        )
    );

    /** Navigation Menu Settings */
    $wp_customize->add_setting(
        'main_header_navigation_menu_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new triphub_Group_Control( 
            $wp_customize,
            'main_header_navigation_menu_group',
            array(
                'id'          => 'main_header_navigation_menu_group',
                'label'       => __( 'Navigation Menu', 'triphub' ),
                'section'     => 'layout_header',
                'type'        => 'group',
                'style'       => 'collapsible',
            )
        )
    );

    /** Items Spacing */
    $wp_customize->add_setting(
        'header_items_spacing',
        array(
            'default'           => $defaults['header_items_spacing'],
            'sanitize_callback' => 'triphub_sanitize_empty_absint',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new triphub_Range_Slider_Control(
            $wp_customize,
            'header_items_spacing',
            array(
                'label'    => __( 'Items Spacing', 'triphub' ),
                'section'  => 'layout_header',
                'settings' => array(
                    'desktop' => 'header_items_spacing',
                ),
                'choices' => array(
                    'desktop' => array(
                        'min'  => 0,
                        'max'  => 50,
                        'step' => 1,
                        'edit' => true,
                        'unit' => 'px',
                    ),
                ),
                'group' => 'main_header_navigation_menu_group', 
            )
        )
    );

    /** Header Strech Menu */
    $wp_customize->add_setting(
        'header_strech_menu',
        array(
            'default'           => $defaults['header_strech_menu'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
            'transport' => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new triphub_Toggle_Control( 
			$wp_customize,
			'header_strech_menu',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Stretch Menu', 'triphub' ),
				'group'   => 'main_header_navigation_menu_group',
			)
		)
	);

    /** Dropdown Width */
    $wp_customize->add_setting(
        'header_dropdown_width',
        array(
            'default'           => $defaults['header_dropdown_width'],
            'sanitize_callback' => 'triphub_sanitize_empty_absint',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new triphub_Range_Slider_Control(
            $wp_customize,
            'header_dropdown_width',
            array(
                'label'    => __( 'Dropdown Width', 'triphub' ),
                'section'  => 'layout_header',
                'settings' => array(
                    'desktop' => 'header_dropdown_width',
                ),
                'choices' => array(
                    'desktop' => array(
                        'min'  => 0,
                        'max'  => 350,
                        'step' => 1,
                        'edit' => true,
                        'unit' => 'px',
                    ),
                ),
                'group' => 'main_header_navigation_menu_group', 
            )
        )
    );

    /** Contact Information */
    $wp_customize->add_setting(
        'main_header_contact_information_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new triphub_Group_Control( 
            $wp_customize,
            'main_header_contact_information_group',
            array(
                'id'          => 'main_header_contact_information_group',
                'label'       => __( 'Contact Information', 'triphub' ),
                'section'     => 'layout_header',
                'type'        => 'group',
                'style'       => 'collapsible',
            )
        )
    );

     /** Phone */
     $wp_customize->add_setting(
        'triphub_phone',
        array(
            'default'           => $defaults['triphub_phone'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new triphub_Text_Control( 
			$wp_customize,
			'triphub_phone',
			array(
				'section'  => 'layout_header',
				'priority' => 8,
				'label'    => __( 'Phone', 'triphub' ),
				'group'    => 'main_header_contact_information_group',
			)
		)
	);

    $wp_customize->selective_refresh->add_partial( 'triphub_phone', array(
        'selector'        => '.header-m .contact-phone-wrap',
        'render_callback' => 'triphub_header_phone',
    ) );

    /** Email */
    $wp_customize->add_setting(
        'triphub_email',
        array(
            'default'           => $defaults['triphub_email'],
            'sanitize_callback' => 'sanitize_email',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new triphub_Text_Control( 
			$wp_customize,
			'triphub_email',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Email', 'triphub' ),
				'group'   => 'main_header_contact_information_group',
			)
		)
	);

    $wp_customize->selective_refresh->add_partial( 'triphub_email', array(
        'selector'        => '.header-m .contact-email-wrap',
        'render_callback' => 'triphub_header_email',
    ) );

    /** Header Button */
    $wp_customize->add_setting(
        'main_header_header_button_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new triphub_Group_Control( 
            $wp_customize,
            'main_header_header_button_group',
            array(
                'id'          => 'main_header_header_button_group',
                'label'       => __( 'Header Button', 'triphub' ),
                'section'     => 'layout_header',
                'type'        => 'group',
                'style'       => 'collapsible',
            )
        )
    );

     /** Phone */
     $wp_customize->add_setting(
        'header_button_label',
        array(
            'default'           => $defaults['header_button_label'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new triphub_Text_Control( 
			$wp_customize,
			'header_button_label',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Button Label', 'triphub' ),
				'group'   => 'main_header_header_button_group',
			)
		)
	);

    $wp_customize->selective_refresh->add_partial( 'header_button_label', array(
        'selector'        => '.site-header .btn-book .btn-primary',
        'render_callback' => 'triphub_get_header_button',
    ) );

    /** Phone */
    $wp_customize->add_setting(
        'header_button_link',
        array(
            'default'           => $defaults['header_button_link'],
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
		new triphub_Text_Control( 
			$wp_customize,
			'header_button_link',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Button URL', 'triphub' ),
				'group'   => 'main_header_header_button_group',
			)
		)
	);
    
    $wp_customize->add_setting(
        'ed_header_button_newtab',
        array(
            'default'           => $defaults['ed_header_button_newtab'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new triphub_Toggle_Control( 
			$wp_customize,
			'ed_header_button_newtab',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Open link in new Tab', 'triphub' ),
				'group'   => 'main_header_header_button_group',
			)
		)
	);

    $wp_customize->add_setting(
        'ed_header_button_sticky',
        array(
            'default'           => $defaults['ed_header_button_sticky'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new triphub_Toggle_Control( 
			$wp_customize,
			'ed_header_button_sticky',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Show in Sticky Header', 'triphub' ),
				'group'   => 'main_header_header_button_group',
			)
		)
	);

    /** Background Color */
    $wp_customize->add_setting(
        'header_btn_bg_color',
        array(
            'default'           => $colorDefaults['header_btn_bg_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'triphub_sanitize_rgba',
        )
    );
    $wp_customize->add_control(
        new triphub_Alpha_Color_Customize_Control(
            $wp_customize,
            'header_btn_bg_color',
            array(
                'label'   => __( 'Background Color', 'triphub' ),
                'section' => 'layout_header',
				'group'   => 'main_header_header_button_group',
            )
        )
    );

    /** Background Hover Color */
    $wp_customize->add_setting(
        'header_btn_bg_hover_color',
        array(
            'default'           =>  $colorDefaults['header_btn_bg_hover_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'triphub_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new triphub_Alpha_Color_Customize_Control(
            $wp_customize,
            'header_btn_bg_hover_color',
            array(
                'label'   => __( 'Background Hover Color', 'triphub' ),
                'section' => 'layout_header',
				'group'   => 'main_header_header_button_group',
            )
        )
    );
    
    /** Text Color */
    $wp_customize->add_setting(
        'header_btn_text_color',
        array(
            'default'           => $colorDefaults['header_btn_text_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'triphub_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new triphub_Alpha_Color_Customize_Control(
            $wp_customize,
            'header_btn_text_color',
            array(
                'label'   => __( 'Text Color', 'triphub' ),
                'section' => 'layout_header',
                'group'   => 'main_header_header_button_group',
            )
        )
    );

    /** Text Hover Color */
    $wp_customize->add_setting(
        'header_btn_text_hover_color',
        array(
            'default'           => $colorDefaults['header_btn_text_hover_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'triphub_sanitize_rgba',
        )
    );
    $wp_customize->add_control(
        new triphub_Alpha_Color_Customize_Control(
            $wp_customize,
            'header_btn_text_hover_color',
            array(
                'label'   => __( 'Text Hover Color', 'triphub' ),
                'section' => 'layout_header',
                'group'   => 'main_header_header_button_group',
            )
        )
    );

    /** Currency Converter Settings */
    $wp_customize->add_setting(
        'main_header_currency_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new triphub_Group_Control( 
            $wp_customize,
            'main_header_currency_group',
            array(
                'id'              => 'main_header_currency_group',
                'label'           => __( 'Currency Converter', 'triphub' ),
                'section'         => 'layout_header',
                'type'            => 'group',
                'style'           => 'collapsible',
                'active_callback' => 'triphub_is_currency_converter_activated'
            )
        )
    );

    /** Currency Code */
    $wp_customize->add_setting(
        'ed_currency_code',
        array(
            'default'           => $defaults['ed_currency_code'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new triphub_Toggle_Control( 
			$wp_customize,
			'ed_currency_code',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Currency Code', 'triphub' ),
				'group'   => 'main_header_currency_group',
			)
		)
	);

    /** Currency Symbol */
    $wp_customize->add_setting(
        'ed_currency_symbol',
        array(
            'default'           => $defaults['ed_currency_symbol'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new triphub_Toggle_Control( 
			$wp_customize,
			'ed_currency_symbol',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Currency Symbol', 'triphub' ),
				'group'   => 'main_header_currency_group',
			)
		)
	);
    
    /** Currency Name */
      $wp_customize->add_setting(
        'ed_currency_name',
        array(
            'default'           => $defaults['ed_currency_name'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new triphub_Toggle_Control( 
			$wp_customize,
			'ed_currency_name',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Currency Name', 'triphub' ),
				'group'   => 'main_header_currency_group',
			)
		)
	);

    /** Social Media Settings */
    $wp_customize->add_setting(
        'main_header_social_media_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new triphub_Group_Control( 
            $wp_customize,
            'main_header_social_media_group',
            array(
                'id'          => 'main_header_social_media_group',
                'label'       => __( 'Social Media Settings', 'triphub' ),
                'section'     => 'layout_header',
                'type'        => 'group',
                'style'       => 'collapsible',
            )
        )
    );

    /** Social Media */
    $wp_customize->add_setting(
        'ed_social_media',
        array(
            'default'           => $defaults['ed_social_media'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new triphub_Toggle_Control( 
			$wp_customize,
			'ed_social_media',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Social Media', 'triphub' ),
				'group'   => 'main_header_social_media_group',
			)
		)
	);

    /* Open in new tab */

    $wp_customize->add_setting(
        'ed_social_media_newtab',
        array(
            'default'           => $defaults['ed_social_media_newtab'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new triphub_Toggle_Control( 
			$wp_customize,
			'ed_social_media_newtab',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Open in new tab', 'triphub' ),
				'group'   => 'main_header_social_media_group',
			)
		)
	);

    $wp_customize->add_setting(
		'social_media_order', 
		array(
			'default'           => $defaults['social_media_order'], 
			'sanitize_callback' => 'triphub_sanitize_sortable',
		)
	);

	$wp_customize->add_control(
		new triphub_Sortable_Control(
			$wp_customize,
			'social_media_order',
			array(
				'section'     => 'layout_header',
				'label'       => __( 'Social Media', 'triphub' ),
				'choices'     => array(
            		'triphub_facebook'    => __( 'Facebook', 'triphub'),
            		'triphub_twitter'     => __( 'Twitter', 'triphub'),
            		'triphub_instagram'   => __( 'Instagram', 'triphub'),
            		'triphub_pinterest'   => __( 'Pinterest', 'triphub'),
            		'triphub_youtube'     => __( 'Youtube', 'triphub'),
            		'triphub_tiktok'      => __( 'TikTok', 'triphub'),
            		'triphub_linkedin'    => __( 'LinkedIn', 'triphub'),
            		'triphub_whatsapp'    => __( 'WhatsApp', 'triphub'),
            		'triphub_viber'       => __( 'Viber', 'triphub'),
            		'triphub_telegram'    => __( 'Telegram', 'triphub'),
            		'triphub_tripadvisor' => __( 'Trip Advisor', 'triphub')
            	),
                'group'           => 'main_header_social_media_group',
			)
		)
    );

    $wp_customize->add_setting(
        'header_social_media_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new triphub_Note_Control( 
            $wp_customize,
            'header_social_media_text',
            array(
                'section'         => 'layout_header',
                'description'     => sprintf(__( 'You can add links to your social media profiles %1$s here. %2$s', 'triphub' ), '<span class="text-inner-link header_social_media_text">', '</span>'),
                'group'           => 'main_header_social_media_group',
            )
        )
    );

     /** Mobile Header Settings */
     $wp_customize->add_setting(
        'mobile_header_settings_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new triphub_Group_Control( 
            $wp_customize,
            'mobile_header_settings_group',
            array(
                'id'          => 'mobile_header_settings_group',
                'label'       => __( 'Mobile Header Settings', 'triphub' ),
                'section'     => 'layout_header',
                'type'        => 'group',
                'style'       => 'collapsible',
            )
        )
    );

    /** Phone Label */
    $wp_customize->add_setting(
        'mobile_menu_label',
        array(
            'default'           => $defaults['mobile_menu_label'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new triphub_Text_Control( 
			$wp_customize,
			'mobile_menu_label',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Menu Label', 'triphub' ),
				'group'   => 'mobile_header_settings_group',
			)
		)
	);

    $wp_customize->selective_refresh->add_partial( 'mobile_menu_label', array(
        'selector'        => '.mobile-header .mob-menu-op-txt',
        'render_callback' => 'triphub_header_mobile_menu_label',
    ) );

    /** Mobile Menu Search */
    $wp_customize->add_setting(
        'ed_mobile_search',
        array(
            'default'           => $defaults['ed_mobile_search'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new triphub_Toggle_Control( 
			$wp_customize,
			'ed_mobile_search',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Show Search', 'triphub' ),
				'group'   => 'mobile_header_settings_group',
			)
		)
	);

    /** Mobile Menu Phone */
    $wp_customize->add_setting(
        'ed_mobile_phone',
        array(
            'default'           => $defaults['ed_mobile_phone'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new triphub_Toggle_Control( 
			$wp_customize,
			'ed_mobile_phone',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Show Phone Number', 'triphub' ),
				'group'   => 'mobile_header_settings_group',
			)
		)
	);

    /** Mobile Menu Email*/
    $wp_customize->add_setting(
        'ed_mobile_email',
        array(
            'default'           => $defaults['ed_mobile_email'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new triphub_Toggle_Control( 
			$wp_customize,
			'ed_mobile_email',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Show Email Address', 'triphub' ),
				'group'   => 'mobile_header_settings_group',
			)
		)
	);

    /** Mobile Menu Social Media */
    $wp_customize->add_setting(
        'ed_mobile_social_media',
        array(
            'default'           => $defaults['ed_mobile_social_media'],
            'sanitize_callback' => 'triphub_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new triphub_Toggle_Control( 
			$wp_customize,
			'ed_mobile_social_media',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Show Social Media', 'triphub' ),
				'group'   => 'mobile_header_settings_group',
			)
		)
	);
}
add_action( 'customize_register', 'triphub_customize_register_layout_header' );