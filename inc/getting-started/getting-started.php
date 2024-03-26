<?php
/**
 * Getting Started Page.
 *
 * @package triphub
 */


 /**
 * Adds a menu item for the theme license under the appearance menu.
 *
 * since 1.0.0
 */
function triphub_license_menu() {

    add_theme_page(
        __( 'Getting Started','triphub' ),
        __( 'Getting Started','triphub' ),
        'manage_options',
        'travel-monster-license',
        'triphub_license_page'
    );
}
add_action( 'admin_menu', 'triphub_license_menu' );

function triphub_license_page(){
		?>
		
        <div class="wrap getting-started">
			<h2 class="notices"></h2>
			<div class="intro-wrap">
				<div class="intro">
					<h3><?php printf( __( 'Getting started with %1$s v%2$s', 'triphub' ), triphub_THEME_NAME, triphub_THEME_VERSION ); ?></h3>
                    <h4><?php printf( __( 'You will find everything you need to get started with %1$s below.', 'triphub' ), triphub_THEME_NAME ); ?></h4>
				</div>
			</div><!-- .intro-wrap -->
			<div class="panels">
				<ul class="inline-list">
					<li data-id="plugins" class="current">
                        <a id="plugins" href="javascript:void(0);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 18">
                                <defs><style>.a{fill:#354052;}</style></defs>
                                <path class="a" d="M16,9v4.66l-3.5,3.51V19h-1V17.17L8,13.65V9h8m0-6H14V7H10V3H8V7H7.99A1.987,1.987,0,0,0,6,8.98V14.5L9.5,18v3h5V18L18,14.49V9a2.006,2.006,0,0,0-2-2Z" transform="translate(-6 -3)"/>
                            </svg>
                            <?php esc_html_e( 'Recommended Plugins', 'triphub' ); ?>
                        </a>
                    </li>
					<li data-id="help">
                        <a id="help" href="javascript:void(0);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                                <defs><style>.a{fill:#354052;}</style></defs>
                                <path class="a" d="M12,23H11V16.43A5.966,5.966,0,0,1,7,18a6.083,6.083,0,0,1-6-6V11H7.57A5.966,5.966,0,0,1,6,7a6.083,6.083,0,0,1,6-6h1V7.57A5.966,5.966,0,0,1,17,6a6.083,6.083,0,0,1,6,6v1H16.43A5.966,5.966,0,0,1,18,17,6.083,6.083,0,0,1,12,23Zm1-9.87v7.74a4,4,0,0,0,0-7.74ZM3.13,13A4.07,4.07,0,0,0,7,16a4.07,4.07,0,0,0,3.87-3Zm10-2h7.74a4,4,0,0,0-7.74,0ZM11,3.13A4.08,4.08,0,0,0,8,7a4.08,4.08,0,0,0,3,3.87Z" transform="translate(-1 -1)"/>
                            </svg>
                            <?php esc_html_e( 'Getting Started', 'triphub' ); ?>
                        </a>
                    </li>
					<li data-id="demo">
                        <a id="demo" href="javascript:void(0);">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C12.5523 2 13 2.44772 13 3V13.5858L16.2929 10.2929C16.6834 9.90237 17.3166 9.90237 17.7071 10.2929C18.0976 10.6834 18.0976 11.3166 17.7071 11.7071L12.7071 16.7071C12.3166 17.0976 11.6834 17.0976 11.2929 16.7071L6.29289 11.7071C5.90237 11.3166 5.90237 10.6834 6.29289 10.2929C6.68342 9.90237 7.31658 9.90237 7.70711 10.2929L11 13.5858V3C11 2.44772 11.4477 2 12 2Z" fill="black"/>
                                <path d="M4 13C4 12.4477 3.55228 12 3 12C2.44772 12 2 12.4477 2 13V21C2 21.5523 2.44772 22 3 22H21C21.5523 22 22 21.5523 22 21V13C22 12.4477 21.5523 12 21 12C20.4477 12 20 12.4477 20 13V20H4V13Z" fill="black"/>
                            </svg>
                            <?php esc_html_e( 'Demo Import', 'triphub' ); ?>
                        </a>
                    </li>
					<li data-id="support">
                        <a id="support" href="javascript:void(0);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <defs><style>.a{fill:#354052;}</style></defs>
                                <path class="a" d="M11,18h2V16H11ZM12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.011,8.011,0,0,1,12,20ZM12,6a4,4,0,0,0-4,4h2a2,2,0,0,1,4,0c0,2-3,1.75-3,5h2c0-2.25,3-2.5,3-5A4,4,0,0,0,12,6Z" transform="translate(-2 -2)"/>
                            </svg>
                            <?php esc_html_e( 'FAQ\'s &amp; Support', 'triphub' ); ?>
                        </a>
                    </li>
					<li data-id="themes" class="ajax">
                        <a id="themeclub" href="javascript:void(0);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24.5" height="21.5" viewBox="0 0 24.5 21.5">
                                <g transform="translate(-409.75 -2401.75)">
                                    <g transform="translate(411 2403)">
                                        <path d="M1,0H21a1,1,0,0,1,1,1V6H0V1A1,1,0,0,1,1,0Z" fill="none"/>
                                        <path class="browser-1" d="M1-.5H21A1.5,1.5,0,0,1,22.5,1V6a.5.5,0,0,1-.5.5H0A.5.5,0,0,1-.5,6V1A1.5,1.5,0,0,1,1-.5Z" fill="none" stroke-width="1.5"/>
                                    </g>
                                    <g transform="translate(411 2410)">
                                        <path d="M0,0H22V11a1,1,0,0,1-1,1H1a1,1,0,0,1-1-1Z" fill="none"/>
                                        <path class="browser-2" d="M0-.5H22a.5.5,0,0,1,.5.5V11A1.5,1.5,0,0,1,21,12.5H1A1.5,1.5,0,0,1-.5,11V0A.5.5,0,0,1,0-.5Z" fill="none" stroke-width="1.5"/>
                                    </g>
                                    <circle class="browser-3" cx="1" cy="1" r="1" transform="translate(413 2405)"/>
                                    <circle class="browser-4" cx="1" cy="1" r="1" transform="translate(416 2405)"/>
                                    <circle class="browser-5" cx="1" cy="1" r="1" transform="translate(419 2405)"/>
                                    <rect class="browser-6" width="9" height="2" rx="1" transform="translate(423 2405)"/>
                                </g>
                            </svg>
                            <?php esc_html_e( 'Extensions', 'triphub' ); ?>
                        </a>
                    </li>
				</ul>
				<div id="panel" class="panel">
					<?php require get_template_directory() . '/inc/getting-started/tabs/plugins-panel.php'; ?>
					<?php require get_template_directory() . '/inc/getting-started/tabs/help-panel.php'; ?>
					<?php require get_template_directory() . '/inc/getting-started/tabs/demo-import-panel.php'; ?>
					<?php require get_template_directory() . '/inc/getting-started/tabs/support-panel.php'; ?>
					<?php require get_template_directory() . '/inc/getting-started/tabs/theme-club-panel.php'; ?>
					<?php require get_template_directory() . '/inc/getting-started/tabs/license-panel.php'; ?>					
				</div><!-- .panel -->
			</div><!-- .panels -->
		</div><!-- .getting-started -->			
		<?php
}


if( ! function_exists( 'triphub_getting_started_admin_scripts' ) ) :
/**
 * Load Getting Started styles in the admin
 */
function triphub_getting_started_admin_scripts( $hook ){
	// Load styles only on our page
    if( 'appearance_page_travel-monster-license' != $hook ) return;

    wp_enqueue_style( 'travel-monster-getting-started', get_template_directory_uri() . '/inc/getting-started/css/getting-started.css', false, triphub_THEME_VERSION );
	wp_enqueue_script( 'travel-monster-getting-started', get_template_directory_uri() . '/inc/getting-started/js/getting-started.js', array( 'jquery' ), triphub_THEME_VERSION, true );
	wp_localize_script( 'travel-monster-getting-started', 'triphub_getting_started', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    wp_enqueue_script( 'travel-monster-recommended-plugin-install', get_template_directory_uri() . '/inc/getting-started/js/recommended-plugin-install.js', array( 'jquery','plugin-install','wp-util','updates' ), triphub_THEME_VERSION, true );    
    $localize = array(
        'ajaxUrl'              => admin_url( 'admin-ajax.php' ),
        'ActivatingText'       => __( 'Activating', 'triphub' ),
        'DeactivatingText'     => __( 'Deactivating', 'triphub' ),
        'PluginActivateText'   => __( 'Activate', 'triphub' ),
        'PluginDeactivateText' => __( 'Deactivate', 'triphub' ),
        'SettingsText'         => __( 'Settings', 'triphub' ),
        'BrowseTemplates'      => __( 'Browse Starter Templates', 'triphub' )
    );  
    wp_localize_script( 'travel-monster-recommended-plugin-install', 'gs_page', $localize );
}
endif;
add_action( 'admin_enqueue_scripts', 'triphub_getting_started_admin_scripts' );

if( ! function_exists( 'triphub_call_plugin_api' ) ) :
/**
 * Plugin API
**/
function triphub_call_plugin_api( $plugin ) {
	include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	$call_api = plugins_api( 
        'plugin_information', 
            array(
    		'slug'   => $plugin,
    		'fields' => array(
    			'downloaded'        => false,
    			'rating'            => false,
    			'description'       => false,
    			'short_description' => true,
    			'donate_link'       => false,
    			'tags'              => false,
    			'sections'          => true,
    			'homepage'          => true,
    			'added'             => false,
    			'last_updated'      => false,
    			'compatibility'     => false,
    			'tested'            => false,
    			'requires'          => false,
    			'downloadlink'      => false,
    			'icons'             => true
    		)
    	) 
    );
	return $call_api;
}
endif;

/**
 * Required Plugin Activate
 *
 * @since 1.2.4
 */
function required_plugin_activate() {

    if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! $_POST['init'] ) {
        wp_send_json_error(
            array(
                'success' => false,
                'message' => __( 'No plugin specified', 'triphub' ),
            )
        );
    }

    $plugin_init = ( isset( $_POST['init'] ) ) ? esc_attr( $_POST['init'] ) : '';

    $activate = activate_plugin( $plugin_init, '', false, true );

    if ( is_wp_error( $activate ) ) {
        wp_send_json_error(
            array(
                'success' => false,
                'message' => $activate->get_error_message(),
            )
        );
    }

    wp_send_json_success(
        array(
            'success' => true,
            'message' => __( 'Plugin Successfully Activated', 'triphub' ),
        )
    );

}
add_action('wp_ajax_gs-sites-plugin-activate', 'required_plugin_activate');
add_action('wp_ajax_nopriv_gs-sites-plugin-activate', 'required_plugin_activate');

/**
 * Required Plugin Activate
 *
 * @since 1.2.4
 */
function required_plugin_deactivate() {

    if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! $_POST['init'] ) {
        wp_send_json_error(
            array(
                'success' => false,
                'message' => __( 'No plugin specified', 'triphub' ),
            )
        );
    }

    $plugin_init = ( isset( $_POST['init'] ) ) ? esc_attr( $_POST['init'] ) : '';

    $deactivate = deactivate_plugins( $plugin_init, '', false );

    if ( is_wp_error( $deactivate ) ) {
        wp_send_json_error(
            array(
                'success' => false,
                'message' => $deactivate->get_error_message(),
            )
        );
    }

    wp_send_json_success(
        array(
            'success' => true,
            'message' => __( 'Plugin Successfully Deactivated', 'triphub' ),
        )
    );

}
add_action('wp_ajax_gs-sites-plugin-deactivate', 'required_plugin_deactivate');
add_action('wp_ajax_nopriv_gs-sites-plugin-deactivate', 'required_plugin_deactivate');

if( ! function_exists( 'triphub_check_for_icon' ) ) :
/**
 * Check For Icon 
**/
function triphub_check_for_icon( $arr ) {
	if( ! empty( $arr['svg'] ) ){
		$plugin_icon_url = $arr['svg'];
	}elseif( ! empty( $arr['2x'] ) ){
		$plugin_icon_url = $arr['2x'];
	}elseif( ! empty( $arr['1x'] ) ){
		$plugin_icon_url = $arr['1x'];
	}else{
		$plugin_icon_url = $arr['default'];
	}                               
	return $plugin_icon_url;
}
endif;

if( ! function_exists( 'triphub_theme_club_list' ) ) :
/**
 * Ajax Callback for Theme Club List
 */
function triphub_theme_club_list(){
    
	//Getting theme list from the transient if there are any....
    $theme_array = get_transient( 'wptravelengine_feed_transient' );
    
    if( $theme_array ){
        ob_start();
        foreach( $theme_array as $theme_list ){
            $theme_title   = isset( $theme_list['info']['title'] ) ? $theme_list['info']['title'] : '';
            $theme_image   = isset( $theme_list['info']['thumbnail'] ) ? $theme_list['info']['thumbnail'] : '';
            $theme_content = isset( $theme_list['info']['excerpt'] ) ? $theme_list['info']['excerpt'] : '';
            $theme_link    = isset( $theme_list['info']['permalink'] ) ? $theme_list['info']['permalink'] : '';
             ?>
            <div class="wptravelengine">
                <div class="theme-image">
                    <a class="theme-link" href="<?php echo esc_url( $theme_link ); ?>" target="_blank" rel="nofollow">
                        <img data-layzr="<?php echo esc_url( $theme_image ); ?>" src="<?php echo esc_url( $theme_image ); ?>" alt="">
                    </a>
                </div>
                <h3><a href="<?php echo esc_url( 'https://wptravelengine.com' . $theme_link ); ?>"><?php echo esc_html( $theme_title ); ?></a></h3>
                <?php echo wpautop( wp_kses_post( $theme_content ) ); ?>
            </div>
            <?php
        }             
    }else{
        // Getting the Themelist from restapi from https://wptravelengine.com
        $themes_list = wp_safe_remote_get( 'https://wptravelengine.com/edd-api/v2/products/?category=add-ons&number=-1' );
        if ( ! is_wp_error( $themes_list ) && 200 === wp_remote_retrieve_response_code( $themes_list ) ){    
            $body        = wp_remote_retrieve_body( $themes_list ); //getting body 
            $theme_array = json_decode( $body, true ); // making object into array    
            $theme_array = $theme_array['products'] ? $theme_array['products'] : '';
            set_transient( 'wptravelengine_feed_transient', $theme_array, 336 * HOUR_IN_SECONDS );
            if( $theme_array ){
                foreach( $theme_array as $theme_list ){
                    $theme_title   = isset( $theme_list['info']['title'] ) ? $theme_list['info']['title'] : '';
                    $theme_image   = isset( $theme_list['info']['thumbnail'] ) ? $theme_list['info']['thumbnail'] : '';
                    $theme_content = isset( $theme_list['info']['excerpt'] ) ? $theme_list['info']['excerpt'] : '';
                    $theme_link    = isset( $theme_list['info']['permalink'] ) ? $theme_list['info']['permalink'] : '';
                     ?>
                    <div class="wptravelengine">
                        <div class="theme-image">
                            <a class="theme-link" href="<?php echo esc_url( $theme_link ); ?>" target="_blank" rel="nofollow">
                                <img data-layzr="<?php echo esc_url( $theme_image ); ?>" src="<?php echo esc_url( $theme_image ); ?>" alt="">
                            </a>
                        </div>
                        <h3><a href="<?php echo esc_url( 'https://wptravelengine.com' . $theme_link ); ?>"><?php echo esc_html( $theme_title ); ?></a></h3>
                        <?php echo wpautop( wp_kses_post( $theme_content ) ); ?>
                    </div>
                    <?php
                }
            }
        }else {
            $themes_link = 'https://wptravelengine.com/theme-club/';
            printf( __( '%1$sThis theme feed seems to be temporarily down. Please check back later, or visit our <a href="%2$s" target="_blank">Themes Club page on WP Travel Engine</a>.%3$s', 'triphub' ), '<p>', esc_url( $themes_link ), '</p>' );
        }       
    }

    echo ob_get_clean();

    wp_die();
}
endif;
add_action( 'wp_ajax_theme_club_from_rest', 'triphub_theme_club_list' );