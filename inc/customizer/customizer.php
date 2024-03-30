<?php
/**
 * TripHub Theme Customizer
 *
 * @package TripHub
 */

/**
 * Requiring customizer panels & sections
*/

$triphub_sections     = array( 'header', 'site','title','blog','archive','page','post', 'typography', 'seo', 'social-network', 'colors', 'singletrip' );
$triphub_panels       = array( 'general', 'footer' );
$triphub_sub_sections = array(
    'general'     => array( 'container', 'sidebar', 'button', 'scroll-to-top', 'pagination', '404', ),
	'footer'     => array( 'upper-footer', 'bottom-footer' )
);

foreach( $triphub_panels as $panel ){
   require get_template_directory() . '/inc/customizer/panels/' . $panel . '.php';
}

foreach( $triphub_sub_sections as $key => $sections ){
    foreach( $sections as $section ){        
        require get_template_directory() . '/inc/customizer/panels/' . $key . '/' . $section . '.php';
    }
}

foreach( $triphub_sections as $section ){
    require get_template_directory() . '/inc/customizer/sections/' . $section . '.php';
}

/**
 * Sanitization Functions
*/
require get_template_directory() . '/inc/customizer/sanitization-functions.php';

/**
 * Active Callbacks
*/
require get_template_directory() . '/inc/customizer/active-callback.php';

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function triphub_customize_preview_js() {
	$build        = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
	$suffix       = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'triphub-customizer', get_template_directory_uri() . '/js' . $build . '/customizer' . $suffix . '.js', array( 'customize-preview' ), triphub_THEME_VERSION, true );

	wp_localize_script(
		'triphub-customizer',
		'triphub_view_port',
		array(
			'mobile'               => triphub_get_media_query( 'mobile' ),
			'tablet'               => triphub_get_media_query( 'tablet' ),
			'desktop'              => triphub_get_media_query( 'desktop' ),
			'googlefonts'          => apply_filters( 'triphub_typography_customize_list', triphub_get_all_google_fonts() ),
			'systemfonts'          => apply_filters( 'triphub_typography_system_stack', '-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"' ),
			'breadcrumb_sep_one'   => triphub_breadcrumb_icons_list('one'),
			'breadcrumb_sep_two'   => triphub_breadcrumb_icons_list('two'),
			'breadcrumb_sep_three' => triphub_breadcrumb_icons_list('three'),
		)
	);

}
add_action( 'customize_preview_init', 'triphub_customize_preview_js' );

/**
 * Get the requested media query.
 *
 * @param string $name Name of the media query.
 */
function triphub_get_media_query( $name ) {

	// If the theme function doesn't exist, build our own queries.
	$desktop     = apply_filters( 'triphub_desktop_media_query', '(min-width:1024px)' );
	$tablet      = apply_filters( 'triphub_tablet_media_query', '(min-width: 720px) and (max-width: 1024px)' );
	$mobile      = apply_filters( 'triphub_mobile_media_query', '(max-width:719px)' );

	$queries = apply_filters(
		'triphub_media_queries',
		array(
			'desktop'     => $desktop,
			'tablet'      => $tablet,
			'mobile'      => $mobile,
		)
	);

	return $queries[ $name ];
}

/**
 * Add misc inline scripts to our controls.
 *
 * We don't want to add these to the controls themselves, as they will be repeated
 * each time the control is initialized.
 */
function triphub_control_inline_scripts() {

	wp_enqueue_style('triphub-customize', get_template_directory_uri() . '/inc/css/customize.css', array(), triphub_THEME_VERSION );
	wp_enqueue_script('triphub-customize', get_template_directory_uri() . '/inc/js/customize.js', array('jquery', 'customize-controls'), triphub_THEME_VERSION, true);
	
	wp_localize_script( 'triphub-customize', 'triphub_data',
		array(
			'primary'  => has_nav_menu( 'primary' ),
			'nonce'    => wp_create_nonce( 'triphub-local-fonts-flush' ),
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'flushit'  => __( 'Successfully Flushed!','triphub' ),
		)
	);

	wp_localize_script( 'triphub-typography-customizer', 'triphub_customize',
		array(
			'nonce' => wp_create_nonce( 'triphub_customize_nonce' )
		)
	);

	wp_localize_script(
		'triphub-typography-customizer',
		'travelMonsterTypography',
		array(
			'googleFonts' => apply_filters( 'triphub_typography_customize_list', triphub_get_all_google_fonts() )
		)
	);

	wp_localize_script( 'triphub-typography-customizer', 'typography_defaults', triphub_typography_default_fonts() );
}
add_action( 'customize_controls_enqueue_scripts', 'triphub_control_inline_scripts', 100 );

/*
 * Notifications in customizer
 */
require get_template_directory() . '/inc/customizer-plugin-recommend/customizer-notice/class-customizer-notice.php';

require get_template_directory() . '/inc/customizer-plugin-recommend/plugin-install/class-plugin-install-helper.php';

require get_template_directory() . '/inc/customizer-plugin-recommend/plugin-install/class-plugin-recommend.php';

$config_customizer = array(
	'recommended_plugins' => array(
		//change the slug for respective plugin recomendation
        'wp-travel-engine' => array(
			'recommended' => true,
			'description' => sprintf(
				/* translators: %s: plugin name */
				esc_html__( 'If you want to take full advantage of the features this theme has to offer, please install and activate %s plugin.', 'triphub' ), '<strong>WP Travel Engine</strong>'
			),
		),
	),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'triphub' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'triphub' ),
	'activate_button_label'     => esc_html__( 'Activate', 'triphub' ),
	'deactivate_button_label'   => esc_html__( 'Deactivate', 'triphub' ),
);
triphub_Customizer_Notice::init( apply_filters( 'triphub_customizer_notice_array', $config_customizer ) );
/**
 * Functions that removes default section in wp
 *
 * @param [type] $wp_customize
 * @return void
 */
function triphub_removing_default_sections( $wp_customize ){
	$wp_customize->remove_section('header_image');
	$wp_customize->remove_section('background_image');
}
add_action( 'customize_register','triphub_removing_default_sections' );