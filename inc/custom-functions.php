<?php
/**
 * TripHub Custom functions and definitions
 *
 * @package TripHub
*/

if ( ! function_exists( 'triphub_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function triphub_setup() {
		$build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on TripHub, use a find and replace
		 * to change 'triphub' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'triphub', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		$menus = array(
			'primary'   => esc_html__( 'Primary', 'triphub' ),
			'secondary' => esc_html__( 'Secondary', 'triphub' ),
			'footer'    => esc_html__( 'Footer', 'triphub' ),
		);
	
		if( triphub_is_polylang_active() ){
			$menus['language'] = esc_html__( 'Language', 'triphub' ); 
		}
	
		register_nav_menus( $menus );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'triphub_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		add_image_size( 'triphub-fullwidth', 1290, 670, true ); 
		add_image_size( 'triphub-withsidebar', 860, 510, true );
		add_image_size( 'triphub-blog-grid', 415, 260, true );
		add_image_size( 'triphub-latest-post', 970, 655, true );
		add_image_size( 'triphub-blog-list', 300, 440, true );
		add_image_size( 'triphub-header-bg-img', 1920, 350, true );
		add_image_size( 'triphub-single-layout-two', 1920, 600, true );

		/** Starter Content */
		$starter_content = array(
			// Specify the core-defined pages to create and add custom thumbnails to some of them.
			'posts' => array( 
				'home', 
				'blog',
			),
			
			// Default to a static front page and assign the front and posts pages.
			'options' => array(
				'show_on_front' => 'page',
				'page_on_front' => '{{home}}',
				'page_for_posts' => '{{blog}}',
			),
			
			// Set up nav menus for each of the two areas registered in the theme.
			'nav_menus' => array(
				// Assign a menu to the "top" location.
				'primary' => array(
					'name' => __( 'Primary', 'triphub' ),
					'items' => array(
						'page_home',
						'page_blog',
					)
				)
			),
		);
		
		$starter_content = apply_filters( 'triphub_starter_content', $starter_content );
		
		add_theme_support( 'starter-content', $starter_content );

		// Add theme support for Responsive Videos.
		add_theme_support( 'jetpack-responsive-videos' );

		// Add excerpt support for pages
		add_post_type_support( 'page', 'excerpt' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );
	
		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		// Add support for block editor styles.
		add_theme_support( 'wp-block-styles' );

	}
endif;
add_action( 'after_setup_theme', 'triphub_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function triphub_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'triphub_content_width', 780 );
}
add_action( 'after_setup_theme', 'triphub_content_width', 0 );

if( ! function_exists( 'triphub_template_redirect_content_width' ) ) :
/**
* Adjust content_width value according to template.
*
* @return void
*/
function triphub_template_redirect_content_width(){
	$sidebar = triphub_sidebar();
	if( $sidebar ){	   
		$GLOBALS['content_width'] = 780;       
	}else{
	
		if( is_singular() ){
			if( triphub_sidebar( true ) === 'full-width centered' ){
				$GLOBALS['content_width'] = 780;
			}else{
				$GLOBALS['content_width'] = 1170;                
			}                
		}else{
			$GLOBALS['content_width'] = 1170;
		}
	}
}
endif;
add_action( 'template_redirect', 'triphub_template_redirect_content_width' );

if( ! function_exists( 'triphub_scripts') ) :
/**
 * Enqueue scripts and styles.
 * 
 * @return void
 */
function triphub_scripts() {

	$defaults     = triphub_get_general_defaults();
	$build        = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
	$suffix       = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	// Add parameters for the JS
    global $wp_query;
    $max = $wp_query->max_num_pages;
	$paged = ( get_query_var( 'paged' ) > 1 ) ? get_query_var( 'paged' ) : 1;

	/** Ajax Pagination */
    $pagination       = get_theme_mod( 'post_navigation', $defaults['post_navigation'] );
    $loadmore         = get_theme_mod( 'load_more_label', $defaults['load_more_label'] );
    $loading          = get_theme_mod( 'loading_label', $defaults['loading_label']);
    $nomore           = get_theme_mod( 'no_more_label', $defaults['no_more_label'] );

	$ed_localgoogle_fonts   = get_theme_mod( 'ed_localgoogle_fonts', $defaults['ed_localgoogle_fonts'] );
	$ed_preload_local_fonts = get_theme_mod( 'ed_preload_local_fonts', $defaults['ed_preload_local_fonts'] );

    wp_enqueue_style( 'triphub-google-fonts', triphub_google_fonts_url(), array(), null );
	wp_enqueue_style( 'triphub-style', get_template_directory_uri() . '/css/build/default.css', array(), TRIPHUB_THEME_VERSION );

	wp_style_add_data( 'triphub-style', 'rtl', 'replace' );
	if( $suffix ){
		wp_style_add_data( 'triphub-style', 'suffix', $suffix );
	}

	if( triphub_is_elementor_activated() ){
        wp_enqueue_style( 'triphub-elementor', get_template_directory_uri(). '/css' . $build . '/elementor' . $suffix . '.css', array(), TRIPHUB_THEME_VERSION );
    }

	if( $pagination === 'load_more' || $pagination === 'infinite_scroll' ){
		wp_enqueue_script( 'triphub-ajax', get_template_directory_uri() . '/js' . $build . '/ajax' . $suffix . '.js', array('jquery'), TRIPHUB_THEME_VERSION, true );
		wp_localize_script( 
			'triphub-ajax',
			'triphub_ajax',
			array( 
				'url'       => admin_url( 'admin-ajax.php' ),
				'startPage' => $paged,
				'maxPages'  => $max,
				'nextLink'  => next_posts( $max, false ),
				'autoLoad'  => $pagination,
				'loadmore'  => $loadmore,
				'loading'   => $loading,
				'nomore'    => $nomore,
			) 
		);	
	}
	wp_enqueue_script( 'triphub-custom', get_template_directory_uri() . '/js' . $build . '/custom' . $suffix . '.js', array( 'jquery' ), TRIPHUB_THEME_VERSION, true );
	
	wp_localize_script( 
		'triphub-custom',
		'triphub_custom',
		array( 
			'url'              => admin_url( 'admin-ajax.php' ),
			'rtl'              => is_rtl(),
			'sticky_widget'    => get_theme_mod( 'ed_last_widget_sticky', $defaults['ed_last_widget_sticky'] ),
			'ed_sticky_header' => get_theme_mod( 'ed_sticky_header', $defaults['ed_sticky_header'] ),
			'ed_sticky_form'   => get_theme_mod( 'ed_sticky_booking_form', $defaults['ed_sticky_booking_form'] )
		) 
	);	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if (  $ed_localgoogle_fonts && 
		! is_customize_preview() && 
		! is_admin() && 
		$ed_preload_local_fonts ) {
			triphub_preload_local_fonts( triphub_google_fonts_url() );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'triphub_scripts' );

if( ! function_exists( 'triphub_admin_scripts' ) ) :
/**
 * Enqueue admin scripts and styles.
 * 
 * @return void
*/
function triphub_admin_scripts( $hook ){   

	if( $hook == 'post-new.php' || $hook == 'post.php' || $hook == 'user-new.php' || $hook == 'user-edit.php' || $hook == 'profile.php' || $hook == 'widgets.php' ){
		wp_enqueue_style( 'triphub-admin', get_template_directory_uri() . '/inc/css/admin.css', '', TRIPHUB_THEME_VERSION );
		wp_enqueue_script( 'triphub-admin', get_template_directory_uri() . '/inc/js/admin.js', array( 'jquery', 'jquery-ui-sortable' ), TRIPHUB_THEME_VERSION, false );
	}
}
endif; 
add_action( 'admin_enqueue_scripts', 'triphub_admin_scripts' );

if( ! function_exists( 'triphub_block_editor_styles' ) ) :
/**
 * Enqueue editor styles for Gutenberg
 * 
 * @return void
 */
function triphub_block_editor_styles() {
	// Use minified libraries if SCRIPT_DEBUG is false
	$build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	
	// Block styles.
    wp_enqueue_style( 'triphub-block-editor-style', get_template_directory_uri() . '/css' . $build . '/editor-block' . $suffix . '.css' );

    wp_add_inline_style( 'triphub-block-editor-style', triphub_gutenberg_inline_style() );

    // Add custom fonts.
    wp_enqueue_style( 'triphub-google-fonts', triphub_google_fonts_url(), array(), null );

}
endif;
add_action( 'enqueue_block_editor_assets', 'triphub_block_editor_styles' );

if( ! function_exists( 'triphub_body_classes' ) ) :
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function triphub_body_classes( $classes ) {
	$defaults              = triphub_get_general_defaults();
	$container_layout      = get_theme_mod( 'layout', $defaults['layout'] );
	$blog_page_layout      = get_theme_mod( 'blog_page_layout', $defaults['blog_page_layout'] );
	$archive_layout        = get_theme_mod( 'archive_page_layout', $defaults['archive_page_layout'] );
	$editor_options        = get_option( 'classic-editor-replace' );
	$allow_users_options   = get_option( 'classic-editor-allow-users' );
	$ed_last_widget_sticky = get_theme_mod( 'ed_last_widget_sticky',$defaults['ed_last_widget_sticky'] );
	$ed_sticky_booking     = get_theme_mod( 'ed_sticky_booking_form',$defaults['ed_sticky_booking_form'] );
	$stickyheader          = get_theme_mod( 'ed_sticky_header', $defaults['ed_sticky_header'] );

	//Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	
	if( is_page() ){
		$page_layout      = get_theme_mod( 'page_layout', $defaults['page_layout'] );
		$container_layout = ( $page_layout === 'default' ) ? $container_layout : $page_layout;
	}
	
	if( is_archive() || is_search() ){
		$classes[] = 'archive-layout-'.$archive_layout;
	}
	if( is_single() ){
		$single_post_layout = get_theme_mod( 'single_post_layout', $defaults['single_post_layout'] );
		$classes[] = 'post-layout-'.$single_post_layout;
	}

	if( is_home() || is_archive() || is_search() ){
		$archive_layout   = get_theme_mod( 'archive_page_layout', $defaults['archive_page_layout'] );
		$container_layout = ( $archive_layout === 'default' ) ? $container_layout : $archive_layout;
	}	
	
	switch( $container_layout ){
		case 'boxed':
			$classes[] = 'box-layout';
		break;
		case 'content_boxed':
			$classes[] = 'content-box-layout';
		break;
		case 'full_width_contained':
			$classes[] = 'default-layout';
		break;
		case 'full_width_stretched':
			$classes[] = 'fluid-layout';
		break;
	}
	
	if( is_home() ){
		$classes[] = 'blog-layout-'.$blog_page_layout;
	}

	if( $ed_last_widget_sticky ){
        $classes[] = (is_singular('trip') && $ed_sticky_booking) ? '' : 'ed_last_widget_sticky';
    }

	if( ! triphub_is_classic_editor_activated() || ( triphub_is_classic_editor_activated() && $editor_options == 'block' ) || ( triphub_is_classic_editor_activated() && $allow_users_options == 'allow' && has_blocks() ) ){
        $classes[] = 'triphub-has-blocks';
	}
	
	$classes[] = triphub_sidebar( true );	
	
	if( $stickyheader ){
		$classes[] = 'sticky-header';
    }

	if( is_singular( 'trip' ) ){
        $classes[] = 'fix-tabbar-enabled';
    }

	return $classes;
}
endif;
add_filter( 'body_class', 'triphub_body_classes' );

if( ! function_exists( 'triphub_pingback_header' ) ) :
/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function triphub_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
endif;
add_action( 'wp_head', 'triphub_pingback_header' );

if( ! function_exists( 'triphub_post_classes' ) ) :
/**
 * Add custom classes to the array of post classes.
 * 
 * @return array
*/
function triphub_post_classes( $classes, $class, $post_id ){
	
	$classes[] = 'triphub-post';

	if( ! has_post_thumbnail( $post_id ) ){
		$classes[] = 'no-post-thumbnail';
	}

	if( is_single() ){
		$classes[] = 'triphub-single';
	}
	
	$classes[] = 'latest_post';
	
	return $classes;
}
endif;
add_filter( 'post_class', 'triphub_post_classes', 10, 3 );

if ( ! function_exists( 'triphub_excerpt_length' ) ) :
/**
 * Changes the default 55 character in excerpt 
 * 
 * @return void
*/
function triphub_excerpt_length( $length ) {
	$defaults = triphub_get_general_defaults();
	$excerpt_length = get_theme_mod( 'excerpt_length', $defaults['excerpt_length'] );
	return is_admin() ? $length : absint( $excerpt_length );    
}
endif;
add_filter( 'excerpt_length', 'triphub_excerpt_length', 999 );

if( ! function_exists( 'triphub_archive_heading' ) ) :
/**
 * Prefix for archive heading
 *
 * @param string $title
 * @return string
 */
function triphub_archive_heading( $title ){ 
	$defaults  = triphub_get_general_defaults();
	$ed_prefix = get_theme_mod( 'ed_archive_prefix', $defaults['ed_archive_prefix'] );
	$ed_title  = get_theme_mod( 'ed_archive_title', $defaults['ed_archive_title'] );
	
	if( is_category() ){
		$page_title =  $ed_title ? '<h1 class="page-title">'. esc_html( single_cat_title( '', false ) ) .'</h1>' : '';
		
		if( $ed_prefix ){
			$title = '<div class="archive-title-wrapper"><span class="sub-title">'. esc_html__( 'Category:', 'triphub' ) . '</span>' . $page_title . '</div>';
		}else{
			$title = $page_title;
		}			
	}elseif( is_tag() ){
		$page_title =  $ed_title ? '<h1 class="page-title">' . esc_html( single_tag_title( '', false ) ) . '</h1>' : '';

		if( $ed_prefix ) {
			$title = '<div class="archive-title-wrapper"><span class="sub-title">'. esc_html__( 'Tag', 'triphub' ) . '</span>'. $page_title .'</div>';
		}else{
			$title = $page_title;
		}
	}elseif( is_year() ){
		$page_title =  $ed_title ? '<h1 class="page-title">' . get_the_date( _x( 'Y', 'yearly archives date format', 'triphub' ) ) . '</h1>' : '';

		if( $ed_prefix ){
			$title = '<div class="archive-title-wrapper"><span class="sub-title">'. esc_html__( 'Year', 'triphub' ) . '</span>'. $page_title .'</div>';
		}else{
			$title = $page_title;                   
		}
	}elseif( is_month() ){
		$page_title =  $ed_title ? '<h1 class="page-title">' . get_the_date( _x( 'F Y', 'monthly archives date format', 'triphub' ) ) . '</h1>' : '';

		if( $ed_prefix ){
			$title = '<div class="archive-title-wrapper"><span class="sub-title">'. esc_html__( 'Month', 'triphub' ) . '</span>'. $page_title .'</div>';
		}else{
			$title = $page_title;                                   
		}
	}elseif( is_day() ){
		$page_title =  $ed_title ? '<h1 class="page-title">' . get_the_date( _x( 'F j, Y', 'daily archives date format', 'triphub' ) ) . '</h1>' : '';

		if( $ed_prefix ){
			$title = '<div class="archive-title-wrapper"><span class="sub-title">'. esc_html__( 'Day', 'triphub' ) . '</span>'. $page_title .'</div>';
		}else{
			$title = $page_title;                                   
		}
	}elseif( is_tax() ) {
		$tax        = get_taxonomy( get_queried_object()->taxonomy );
		$page_title = $ed_title ? '<h1 class="page-title">' . single_term_title( '', false ) . '</h1>' : '';

		if( $ed_prefix ){
			$title = '<div class="archive-title-wrapper"><span class="sub-title">' . $tax->labels->singular_name . '</span>'. $page_title .'</div>';
		}else{
			$title = $page_title;                                   
		}
	}elseif( is_post_type_archive( 'trip' ) ){
		$title = '<h1 class="page-title">' . post_type_archive_title( '', false ) . '</h1>';
	}

	return $title;
}
endif;
add_filter( 'get_the_archive_title', 'triphub_archive_heading' );

if ( ! function_exists( 'triphub_dynamic_mce_css' ) ) :
/**
 * Add Editor Style 
 * Add Link Color Option in Editor Style (MCE CSS)
 */
function triphub_dynamic_mce_css( $mce_css ){
	$mce_css .= ', ' . add_query_arg( array( 'action' => 'triphub_dynamic_mce_css', '_nonce' => wp_create_nonce( 'triphub_dynamic_mce_nonce', __FILE__ ) ), admin_url( 'admin-ajax.php' ) );
	return $mce_css;
}
endif;
add_filter( 'mce_css', 'triphub_dynamic_mce_css' );
	
if ( ! function_exists( 'triphub_dynamic_mce_css_ajax_callback' ) ) : 
/**
 * Ajax Callback
 * 
 * @return void
 */
function triphub_dynamic_mce_css_ajax_callback(){
	
	/* Check nonce for security */
	$nonce = isset( $_REQUEST['_nonce'] ) ? $_REQUEST['_nonce'] : '';
	if( ! wp_verify_nonce( $nonce, 'triphub_dynamic_mce_nonce' ) ){
		die(); // don't print anything
	}
	
	/* Get Link Color */
	$typo_defaults   = triphub_get_typography_defaults();
	$primary_font    = wp_parse_args( get_theme_mod( 'primary_font' ), $typo_defaults['primary_font'] );
	$primary_fonts   = triphub_get_font_family( $primary_font );
	
	/* Set File Type and Print the CSS Declaration */
	header( 'Content-type: text/css' );
	echo ':root .mce-content-body {
		--primary-font: ' . esc_html( $primary_fonts['font'] ) . ';
	}';
	die(); // end ajax process.
}
endif;
add_action( 'wp_ajax_triphub_dynamic_mce_css', 'triphub_dynamic_mce_css_ajax_callback' );
add_action( 'wp_ajax_no_priv_triphub_dynamic_mce_css', 'triphub_dynamic_mce_css_ajax_callback' );	