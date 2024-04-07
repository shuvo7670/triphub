<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package TripHub
*/

if( ! function_exists( 'triphub_doctype' ) ) :
/**
 * Doctype Declaration
*/
function triphub_doctype(){ ?>
	<!DOCTYPE html>
	<html <?php language_attributes(); ?>>
	<?php
}
endif;
add_action( 'triphub_doctype', 'triphub_doctype' );

if( ! function_exists( 'triphub_head' ) ) :
/**
 * Before wp_head 
*/
function triphub_head(){ ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php
}
endif;
add_action( 'triphub_before_wp_head', 'triphub_head' );

if( ! function_exists( 'triphub_page_start' ) ) :
/**
 * Page Start
*/
function triphub_page_start(){ ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'triphub' ); ?></a>
	<?php
}
endif;
add_action( 'triphub_before_header', 'triphub_page_start', 20 );

if( ! function_exists( 'triphub_header' ) ) :
/**
 * Header Start
*/
function triphub_header(){ 
	$defaults     = triphub_get_general_defaults();
	$header_array = array( 'one' );
	if( triphub_pro_is_activated() && defined( 'triphub_PRO_PATH' ) ){
		$header_array = array( 'one', 'two', 'three', 'four', 'five', 'six' );
		$header       = get_theme_mod( 'header_layout', $defaults['header_layout'] );
		if( in_array( $header, $header_array ) ){       
		 	/**
			 * Typography Functions
			 */
			require triphub_PRO_PATH . 'headers/'.$header.'.php';
		}
	}else{
		get_template_part( 'headers/one' );
	}
	
}
endif;
add_action( 'triphub_header', 'triphub_header', 20 );

if( ! function_exists( 'triphub_polylang_language_switcher' ) ) :
/**
 * Template for Polylang Language Switcher
*/
function triphub_polylang_language_switcher(){
	if( triphub_is_polylang_active() || triphub_is_wpml_active() ){ ?>
		<div class="header-t-lang">
			<nav class="language-dropdown">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'language',
						'menu_class'     => 'languages',
						'fallback_cb'    => false,
					) );
				?>
			</nav><!-- .language-dropdown -->
		</div><!-- .header-t-lang -->
		<?php        
	}
}
endif;
add_action( 'triphub_language_switcher', 'triphub_polylang_language_switcher' );

if( ! function_exists( 'triphub_currency_converter' ) ) :
/**
 * Currency Converter
*/
function triphub_currency_converter(){
	if( triphub_is_currency_converter_activated() ){
		$helper_functions = Wte_Currency_Converter_Helper_Functions::get_instance();
		$currency_converter_enabled = $helper_functions->is_currency_converter_enabled();
		if( $currency_converter_enabled ){ ?>
			<div class="header-t-currnc">			
				<?php echo do_shortcode( '[wte_currency_converter]' ); ?>	
			</div>
		<?php        
		}
	}
}
endif;
add_action( 'triphub_currency_converter', 'triphub_currency_converter' );

if( ! function_exists( 'triphub_content_start' ) ) :
/**
 * Content Start
*/
function triphub_content_start(){ 
	$defaults            = triphub_get_general_defaults();
	$ed_breadcrumb  	 = get_theme_mod( 'ed_breadcrumb', $defaults['ed_breadcrumb'] );
	$ed_blog_title       = get_theme_mod( 'ed_blog_title', $defaults['ed_blog_title'] );
	$ed_blog_desc        = get_theme_mod( 'ed_blog_desc', $defaults['ed_blog_desc'] );
	$blog_alignment      = get_theme_mod( 'blog_alignment', $defaults['blog_alignment'] );
	$archive_title       = get_theme_mod( 'ed_archive_title', $defaults['ed_archive_title'] );
	$archive_desc        = get_theme_mod( 'ed_archive_description', $defaults['ed_archive_description'] );
	$archive_count       = get_theme_mod( 'ed_archive_post_count', $defaults['ed_archive_post_count'] );
	$archive_alignment   = get_theme_mod( 'archive_alignment', $defaults['archive_alignment'] );
	$container_layout    = get_theme_mod( 'layout', $defaults['layout'] );
	$archive_image       = get_theme_mod( 'archive_header_image', $defaults['archive_header_image']);
	$blog_image          = get_theme_mod( 'blog_header_image', $defaults['blog_header_image']);
	$single_post_layout  = get_theme_mod( 'single_post_layout', $defaults['single_post_layout'] );
	$post_meta_structure = get_theme_mod( 'single_post_meta_order', $defaults['single_post_meta_order'] );

	$class = '';
	$page_hdr_class = '';
	if( is_archive() || is_search() ) {
		$class = $archive_alignment;
		$page_hdr_class = ($ed_breadcrumb || $archive_title || $archive_desc) ? 'page-header-wrap' : 'no-header-text';
	}
	if( is_home() ) {
		$class = $blog_alignment;
		$page_hdr_class = ($ed_breadcrumb || $ed_blog_title || $ed_blog_desc) ? 'page-header-wrap' : 'no-header-text';
	}

	if( ( !is_404() && ! is_front_page() && !triphub_is_elementor_activated_post())){
		triphub_page_header_banner( $archive_image, $blog_image ); 
			?>
			<div class="container">
				<?php 
				triphub_breadcrumb();
				
				if( !is_page()) echo '<div class="' . esc_attr( $page_hdr_class ) . '" data-alignment="title-' . esc_attr( $class ) . '">';
					if( is_home() ){
						triphub_get_ed_blog_title();								
						triphub_get_ed_blog_desc();
					}
					
					if( is_archive() ){
						if( is_author() ){
							if( get_the_author_meta( 'description' ) ){ ?>
								<section class="triphub-author-box">
									<div class="author-section">
										<div class="author-top-wrap">
											<div class="img-holder">
												<?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?>
											</div>
											<div class="author-meta">
												<?php printf( esc_html__( '%1$s %2$s%3$s%4$s', 'triphub' ), '<h3 class="author-name">', '<span class="vcard">', esc_html( get_the_author_meta( 'display_name' ) ), '</span></h3>' );                
													echo '<div class="author-description">' . wp_kses_post( get_the_author_meta( 'description' ) ) . '</div>';
												?>
											</div>
										</div>
									</div>
								</section>
								<?php 
							}
						}else{			
							if( $archive_title ) the_archive_title();
						} 
					}
					
					if( is_page_template( 'templates/template-trip-listing.php') ){
						the_archive_description( '<div class="archive-description">', '</div>' );
					}

					if( is_search() ){ ?>
						<section class="search-result-wrapper">
							<div class="triphub-searchres-inner">
								<?php get_search_form(); ?>
							</div>
						</section>
						<?php
					}
					/**
					 * Show post count on search and archive pages
					 */
					if( ( $archive_count && ( is_category() || is_tag() || is_author() ) )
						|| is_search() 
					) {
						echo '<section class="triphub-search-count">';
						triphub_search_post_count();
						echo '</section>';
					}

					if( triphub_is_wte_advanced_search_active() && wte_advanced_search_is_search_page()){
						the_title( '<h1 class="page-title">', '</h1>' );
						echo '<span class="tmp-no-of-trips">';
						echo '</span>';
					}

					if( is_page_template( array( 'templates/template-destination.php','templates/template-activities.php','templates/template-trip_types.php','templates/review.php','templates/template-trip-listing.php' ) ) ){
                        the_title( '<h1 class="page-title">', '</h1>' );
                    }
				if( !is_page() ) echo '</div>'; ?>
			</div>
		</div><!-- page-header-top -->
	<?php }
	
	if( is_page() ){
		$page_layout      = get_theme_mod( 'page_layout', $defaults['page_layout'] );
		$container_layout = ( $page_layout === 'default' ) ? $container_layout : $page_layout;
	}

	if( is_home() || is_archive() || is_search() ){
		$archive_layout   = get_theme_mod( 'archive_page_layout', $defaults['archive_page_layout'] );
		$container_layout = ( $archive_layout === 'default' ) ? $container_layout : $archive_layout;
	}

	$enable_container_meta = get_post_meta(get_the_ID(), '_triphub_enable_container', true);
	$is_enable_container = !empty( $enable_container_meta ) && $enable_container_meta == 'on' ? 'container' : '';

	$class  = ( $container_layout == 'full_width_stretched' && !is_404() ) ? 'container-full' : 'page-wrapper '.$is_enable_container.''; 

	if( is_singular('post') && $single_post_layout === 'two' ){
		
		$post_crop_img  = get_theme_mod( 'ed_crop_single_image', $defaults[ 'ed_crop_single_image' ] );
		$image_size 	= ( ! $post_crop_img ) ? 'full' : 'triphub-single-layout-two'; ?>
		<div class="banner-wrapper">
			<?php if( has_post_thumbnail() ){
				echo '<div class="post-thumbnail">'; 
					the_post_thumbnail( $image_size, 'itemprop=image' );  
				echo '</div>';
			} else {
				triphub_get_fallback_svg( $image_size );
			} ?>
			<div class="content-wrap">
				<div class="container">
					<?php triphub_categories(); ?>
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header>     
					<div class="entry-meta-pri">
						<div class="entry-meta-sec">
							<?php foreach( $post_meta_structure as $post_meta ){
								if( $post_meta == 'author' ) triphub_posted_by();
								if( $post_meta == 'date' ) triphub_posted_on();				
								if( $post_meta == 'comment' ) triphub_comment_link();				
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php 
	}
	
	if( is_singular( 'trip' ) ){
		if(!triphub_is_elementor_activated_post()){
			triphub_single_trip_feature_image();
		}else {
			$post_id = get_the_ID();
			$elementor_layout = get_post_meta( $post_id ,'_wp_page_template' );
			if ( isset( $elementor_layout ) && is_array( $elementor_layout ) && isset($elementor_layout[0]) 
				&& ('elementor_theme' === $elementor_layout[0] || 'default' === $elementor_layout[0]) ){
					triphub_single_trip_feature_image();
			}
		}
		
	}

	if( !is_404() ) { ?>
		<div class="site-content">		
			<div class="<?php echo esc_attr( $class ); ?>">
				<div class="main-content-wrapper">
					 <?php triphub_archive_tax_description(); ?>
				
	<?php	
	}
}
endif;
add_action( 'triphub_content', 'triphub_content_start',20 );

if( ! function_exists( 'triphub_navigation' ) ) :
/**
 * Navigation
*/
function triphub_navigation(){
	$defaults = triphub_get_general_defaults();
	$ed_post_pagination = get_theme_mod( 'ed_post_pagination',$defaults['ed_post_pagination'] );

	if( is_singular( 'post' ) && $ed_post_pagination ){

		if( ! $ed_post_pagination ) return;
		$next_post = get_next_post();
        $prev_post = get_previous_post();
		
		if( $prev_post || $next_post ){?>            
			<nav class="navigation post-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Post Navigation', 'triphub' ); ?></h2>
				<div class="post-nav-links">
					<?php if( $prev_post ){ ?>
						<div class="nav-holder nav-previous">
							<div class="meta-nav"><a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>"><?php esc_html_e( 'Previous Article', 'triphub' ); ?></a></div>
							<span class="entry-title"><a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></a></span>
						</div>
					<?php } if( $next_post ){ ?>
						<div class="nav-holder nav-next">
							<div class="meta-nav"><a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"><?php esc_html_e( 'Next Article', 'triphub' ); ?></a></div>
							<span class="entry-title"><a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></a></span>
						</div>
					<?php } ?>
				</div>
			</nav>        
			<?php
		}
	}else{
		$pagination = get_theme_mod( 'post_navigation', $defaults['post_navigation'] );
		
		switch( $pagination ){	
			
			case 'numbered': // Numbered Pagination
			
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous', 'triphub' ),
				'next_text'          => __( 'Next', 'triphub' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'triphub' ) . ' </span>',
			) );
			
			break;
			
			case 'load_more': // Load More Button
			case 'infinite_scroll': // Auto Infinite Scroll
			
			echo '<div class="ajax-pagination"></div>';
			
			break;
			
			default:
			
			the_posts_navigation();
			
			break;
		}
	}
}
endif;
add_action( 'triphub_after_posts_content', 'triphub_navigation' );
add_action( 'triphub_after_post_loop', 'triphub_navigation', 10 );

if ( ! function_exists( 'triphub_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function triphub_post_thumbnail() {
	$defaults           = triphub_get_general_defaults();
	$ed_page_image      = get_theme_mod( 'ed_page_image', $defaults[ 'ed_page_image' ] );
	$post_crop_img      = get_theme_mod( 'ed_crop_single_image', $defaults[ 'ed_crop_single_image' ] );
	$blog_layout        = get_theme_mod( 'blog_page_layout', $defaults[ 'blog_page_layout' ]  );
	$archive_layout     = get_theme_mod( 'archive_page_layout', $defaults[ 'archive_page_layout' ]  );
	$single_post_layout = get_theme_mod( 'single_post_layout', $defaults['single_post_layout'] );

	if ( post_password_required() || is_attachment() ) {
		return;
	}

	$sidebar            = triphub_sidebar();
	$blog_image_size    = triphub_blog_layout_image_size();
	$archive_image_size = triphub_archive_layout_image_size();

	if( ( is_singular('post') && ! $post_crop_img ) ){
		$image_size = 'full';
	}else{
		$image_size = $sidebar ? 'triphub-withsidebar' : 'triphub-fullwidth';
	}

	if( is_singular('post') && $single_post_layout === 'one' ){
		if( has_post_thumbnail() ){
			echo '<div class="post-thumbnail">'; 
				the_post_thumbnail( $image_size, 'itemprop=image' );  
			echo '</div>';
		}
	}elseif( is_page() ){
		if( has_post_thumbnail() && $ed_page_image ){
			echo '<div class="post-thumbnail">'; 
				the_post_thumbnail( $image_size, 'itemprop=image' );  
			echo '</div>';
		}
	}elseif( is_search() || is_archive() || is_home() ){

		$image_size = is_home() ? $blog_image_size : $archive_image_size;
		if( has_post_thumbnail() ){ 
			if( (is_home() && $blog_layout === 'three') || ( (is_search() || is_archive()) && $archive_layout === 'three') ) 
			echo '<div class="feature-wrap">';
				echo '<div class="post-thumbnail"><a href="'.esc_url( get_the_permalink() ).'">';
						the_post_thumbnail(
							$image_size,
							array(
								'alt' => the_title_attribute(
									array(
										'echo' => false,
									)
								),
							)
						);
				echo '</a></div>';
			if( (is_home() && $blog_layout === 'three') || ( (is_search() || is_archive()) && $archive_layout === 'three') ) {
				triphub_categories();
				echo '</div>';	
			}
		}
	}elseif( is_singular('trip') ){
		$image_size = 'triphub-single-layout-two';
		if( has_post_thumbnail() ){
			echo '<div class="post-thumbnail">';
			the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
			echo '</div>';    
		}
	}else{
		if( has_post_thumbnail() && ! is_single()){ 
			echo '<div class="post-thumbnail"><a href="'.esc_url( get_the_permalink() ).'">';
					the_post_thumbnail(
						$image_size,
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
			echo '</a></div>';
		}elseif(! is_single()){
			triphub_get_fallback_svg( $image_size );
		}
	}
}
endif;
add_action( 'triphub_before_page_entry_content', 'triphub_post_thumbnail', 15 );
add_action( 'triphub_before_post_entry_content', 'triphub_post_thumbnail', 15 );
add_action( 'triphub_before_trip_entry_content', 'triphub_post_thumbnail', 10 );

if( ! function_exists( 'triphub_entry_header' ) ) :
/**
 * Entry Header
*/
function triphub_entry_header(){ 
	$defaults            = triphub_get_general_defaults();
	$meta_structure      = get_theme_mod( 'blog_meta_order', $defaults['blog_meta_order'] );
	$post_meta_structure = get_theme_mod( 'single_post_meta_order', $defaults['single_post_meta_order'] );
	$page_title          = get_theme_mod( 'ed_page_title', $defaults['ed_page_title'] );
	$blog_layout         = get_theme_mod( 'blog_page_layout', $defaults[ 'blog_page_layout' ]  );
	$blog_ed_category    = get_theme_mod( 'blog_ed_category', $defaults[ 'blog_ed_category' ]  );
	$archive_layout      = get_theme_mod( 'archive_page_layout', $defaults[ 'archive_page_layout' ]  );
	$single_post_layout  = get_theme_mod( 'single_post_layout', $defaults['single_post_layout'] );

	if( is_single() &&  $single_post_layout === 'one') triphub_categories();

	if ( ! is_singular() ) echo '<div class="archive-outer-wrap">'; 

	echo '<header class="entry-header">';
		if( is_home() || is_archive() || is_search() ){
			if( (is_home() && $blog_ed_category && $blog_layout !== 'three') || ((is_search() || is_archive()) && $archive_layout !== 'three') ){
				triphub_categories();
			} 
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}elseif( is_page() ){
			if( $page_title ) the_title( '<h1 class="entry-title">', '</h1>' );
		}elseif( is_single() &&  $single_post_layout === 'one' ){
			the_title( '<h1 class="entry-title">', '</h1>' );
		}
	echo '</header>';     

	if ( ! is_page() ) : ?>
		<div class="entry-meta-pri">
			<div class="entry-meta-sec">
				<?php
					if( is_home() ){
						foreach( $meta_structure as $meta ){
							if( $meta == 'author' ) triphub_posted_by();
							if( $meta == 'date' ) triphub_posted_on();				
							if( $meta == 'comment' ) triphub_comment_link();				
						}
					}elseif( is_single() &&  $single_post_layout === 'one' ){
						foreach( $post_meta_structure as $post_meta ){
							if( $post_meta == 'author' ) triphub_posted_by();
							if( $post_meta == 'date' ) triphub_posted_on();				
							if( $post_meta == 'comment' ) triphub_comment_link();				
						}
					}elseif( !is_single() ){
						triphub_posted_by();
						triphub_posted_on();				
						triphub_comment_link();	
					}					
				?>
			</div>
		</div><!-- .entry-meta-pri -->
		<?php
	endif; 
}
endif;
add_action( 'triphub_before_page_entry_content', 'triphub_entry_header', 20 );
add_action( 'triphub_before_post_entry_content', 'triphub_entry_header', 20 );

if( ! function_exists( 'triphub_entry_content' ) ) :
/**
 * Entry Header
*/
function triphub_entry_content(){  
	$defaults     = triphub_get_general_defaults();
	$itemprop     = ( triphub_get_schema_type() === 'microdata' ) ? ' itemprop="text"' : '';
	$content_type = get_theme_mod( 'blog_content', $defaults['blog_content'] );
	
	echo '<div class="entry-content-wrap clear"'. $itemprop .'>';	
		if( ( is_home() && $content_type == 'content' && ! has_excerpt() ) || is_singular() ){ 
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'triphub' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
				
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'triphub' ),
					'after'  => '</div>',
				)
			);
		}else{ 
			the_excerpt();
		}
	echo '</div>'; 
}
endif;
add_action( 'triphub_page_entry_content', 'triphub_entry_content', 15 );
add_action( 'triphub_post_entry_content', 'triphub_entry_content', 15 );

if ( ! function_exists( 'triphub_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function triphub_entry_footer() {
	$defaults          = triphub_get_general_defaults();
	$ed_post_tags      = get_theme_mod( 'ed_post_tags', $defaults['ed_post_tags'] );
	$ed_social_sharing = get_theme_mod( 'ed_social_sharing', $defaults['ed_social_sharing'] );

	if( ! is_singular() ){
		echo '<footer class="entry-footer triphub-flex">';
			$read_more      = get_theme_mod( 'blog_read_more', $defaults['blog_read_more'] );
			$readmore_style = get_theme_mod( 'read_more_style', $defaults['read_more_style'] );
			$class          = ( $readmore_style == 'button' ) ? ' button-style' : '';

			if( $read_more ) echo '<div class="readmore-btn-wrap"><a href="' . esc_url( get_the_permalink() ) . '" class="btn-readmore' . esc_attr( $class )  . '"><span class="read-more-text">' . esc_html( $read_more ) . '</span></a></div>';
		echo '</footer>'; ?>
		</div><!-- .archive-outer-wrap -->
		<?php
	}

	if( is_single() && $ed_social_sharing && function_exists( 'triphub_social_share' ) ) triphub_social_share();

	if( is_single() && $ed_post_tags ) {
		?>
		<div class="post-tags-wrap">
			<span class="post-tags">
				<?php triphub_tags(); ?>
			</span>
		</div>
		<?php 
	}
}
endif;
add_action( 'triphub_page_entry_content', 'triphub_entry_footer', 20 );
add_action( 'triphub_post_entry_content', 'triphub_entry_footer', 20 );

if( ! function_exists( 'triphub_author' ) ) :
/**
 * Author Section
*/
function triphub_author(){ 
	$defaults           = triphub_get_general_defaults();
	$ed_author          = get_theme_mod( 'ed_author', $defaults['ed_author'] );
	$author_title       = get_the_author_meta( 'display_name' );
	$author_description = get_the_author_meta( 'description' );

	if( $ed_author && $author_title && $author_description ) { ?>
		<div class="author-wrapper">
			<div class="img-holder">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?>
			</div>
			<div class="author-top-wrap">
				<div class="author-meta">
					<?php 
						echo '<h3 class="author-name"><span class="vcard">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</span></h3>';
						echo '<div class="author-description">' . wp_kses_post( get_the_author_meta( 'description' ) ) . '</div>';
					?>
				</div>
				<?php 
					if( triphub_pro_is_activated() && function_exists( 'triphub_author_social' ) ){
						?>
							<div class="author-social-links"><?php triphub_author_social(); ?></div>
						<?php 
					}
				?>
				
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="view-all-auth"><?php esc_html_e( 'View All Articles', 'triphub' ); ?></a>
			</div>
		</div>
	<?php
	}
}
endif;
add_action( 'triphub_after_post_loop', 'triphub_author', 20 );

if( ! function_exists( 'triphub_related_posts' ) ) :
/**
 * Related Posts 
*/
function triphub_related_posts(){ 
	$defaults = triphub_get_general_defaults();
	$ed_post_related = get_theme_mod( 'ed_post_related', $defaults['ed_post_related'] ); 
	
	if( $ed_post_related ) triphub_get_posts_list( 'related' );    
}
endif;

if( ! function_exists( 'triphub_related_post_location' ) ) :
/**
 * Related Posts Location
*/
function triphub_related_post_location(){
	$defaults 			   = triphub_get_general_defaults();
	$related_post_location = get_theme_mod( 'related_posts_location', $defaults['related_posts_location']  );
	$location_hook 	  	   = $related_post_location === 'below' ? 'triphub_after_post_loop' : 'triphub_before_footer_post_loop';
	add_action( $location_hook, 'triphub_related_posts', 5 );
}
endif;
add_action( 'wp', 'triphub_related_post_location', 10 );

if( ! function_exists( 'triphub_comment' ) ) :
/**
 * Comments Template 
*/
function triphub_comment(){
	$defaults = triphub_get_general_defaults();
	$ed_single_comments = get_theme_mod( 'ed_single_comments', $defaults['ed_single_comments'] ); 

	// If comments are open or we have at least one comment, load up the comment template.
	if( $ed_single_comments && ( comments_open() || get_comments_number() ) ) :
		comments_template();
	endif;
}
endif;

if( ! function_exists( 'triphub_comment_location' ) ) :
/**
 * Comments Template Location
*/
function triphub_comment_location(){
	$defaults 		  = triphub_get_general_defaults();
	$comment_location = get_theme_mod( 'single_comment_location', $defaults['single_comment_location']  );
	$location_hook 	  = $comment_location === 'below' ? 'triphub_after_post_loop' : 'triphub_before_footer_post_loop';
	add_action( $location_hook, 'triphub_comment', 10 );
}
endif;
add_action( 'wp', 'triphub_comment_location', 10 );

if( ! function_exists( 'triphub_latest_posts' ) ) :
/**
 * Latest Posts
*/
function triphub_latest_posts(){ 
	$defaults       = triphub_get_general_defaults();
	$ed_latest_post = get_theme_mod( 'ed_latest_post', $defaults['ed_latest_post'] );
	
	if( $ed_latest_post ) triphub_get_posts_list( 'latest' );
}
endif;
add_action( 'triphub_latest_posts', 'triphub_latest_posts' );

if( ! function_exists( 'triphub_content_end' ) ) :
/**
 * Content End
*/
function triphub_content_end(){ 
	if( !is_404()){ ?>
				</div><!-- .main-content-wrapper -->
			</div><!-- .container -->
		</div><!-- .site-content -->
	<?php }
}
endif;
add_action( 'triphub_before_footer', 'triphub_content_end', 20 );

if( ! function_exists( 'triphub_footer_start' ) ) :
/**
 * Footer Start
*/
function triphub_footer_start(){ ?>
	<footer id="colophon" class="site-footer" <?php triphub_microdata( 'footer' ); ?>>
	<?php
}
endif;
add_action( 'triphub_footer', 'triphub_footer_start', 20 );

if( ! function_exists( 'triphub_footer_top' ) ) :
/**
 * Footer Top
*/
function triphub_footer_top(){   
	
	$footer_sidebars = array( 'footer-one', 'footer-two', 'footer-three', 'footer-four' );
	$active_sidebars = array();
	$col             = 0;

	foreach ( $footer_sidebars as $sidebar ) {
		if( is_active_sidebar( $sidebar ) ){
			array_push( $active_sidebars, $sidebar );
		}
	}
	
	$sidebar_count = count( $active_sidebars );
	switch( $sidebar_count ){
		case 1:
			$col = 12;
		break;
		case 2:
			$col = 6;
		break;
		case 3:
			$col = 4;
		break;
		case 4:
			$col = 3;
		break;
	}
					
	if( $active_sidebars ){ ?>
		<div class="footer-wrap-main">
			<div class="triphub-footer-adjs">
				<div class="container">
					<div class="triphub-flex triphub-col-<?php echo esc_attr( $col ); ?>">
						<?php foreach( $active_sidebars as $active ){ ?>
							<div class="triphub-foot-main-col">
								<?php dynamic_sidebar( $active ); ?>	
							</div>
						<?php } ?>
					</div>
				</div><!-- .container -->
			</div><!-- .triphub-footer-adjs -->
		</div><!-- .footer-wrap-main -->
		<?php 
	}
}
endif;
add_action( 'triphub_footer', 'triphub_footer_top', 30 );

if( ! function_exists( 'triphub_footer_bottom' ) ) :
/**
 * Footer Bottom
*/
function triphub_footer_bottom(){ ?>
	<div class="footer-b">
		<div class="container">             
			<div class="footer-b-wrap">
				<div class="site-info">
					<div class="footer-cop">
						<?php 
							triphub_get_footer_copyright();
							if( triphub_pro_is_activated() ){
								$partials = new triphub_Pro_Partials;
								$partials->triphub_pro_ed_author_link();
								$partials->triphub_pro_ed_wp_link();
							} else {
								echo '<span class="author-link">'.
								__( ' TripHub by ', 'triphub' ) .'
								<a href="' . esc_url( 'https://wptravelengine.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'MD Shakibul Islam', 'triphub' ) . '.</a></span>';
								printf( esc_html__( '%1$s Powered by %2$s%3$s', 'triphub' ), '<span class="wp-link">', '<a href="'. esc_url( 'https://wordpress.org/', 'triphub' ) .'" rel="nofollow" target="_blank">WordPress</a>.', '</span>' );
							}
						?> 
					</div>
					<?php if( has_nav_menu( 'footer' ) || current_user_can( 'manage_options' ) || function_exists( 'the_privacy_policy_link' ) ){ ?>
						<nav class="footer-inf">
							<?php
								wp_nav_menu( array(
									'theme_location' => 'footer',
									'menu_class'     => 'footer_menu',
									'fallback_cb'    => false,
								) );
								if ( function_exists( 'the_privacy_policy_link' ) ) {
									the_privacy_policy_link();
								}
							?>
						</nav><!-- Footer Privacy -->
					<?php }
					?>
				</div>
			</div>   
			<?php triphub_footer_payments(); ?>        
		</div>
	</div>			            
	<?php	
	
}
endif;
add_action( 'triphub_footer', 'triphub_footer_bottom', 40 );

if( ! function_exists( 'triphub_footer_end' ) ) :
/**
 * Footer End 
*/
function triphub_footer_end(){ ?>
	</footer><!-- #colophon -->
	<?php
}
endif;
add_action( 'triphub_footer', 'triphub_footer_end', 50 );

if( ! function_exists( 'triphub_scrolltotop' ) ) :
	/**
	 * Scroll To Top
	 */
	function triphub_scrolltotop(){
		$defaults    = triphub_get_general_defaults();
		$scrolltotop = get_theme_mod( 'ed_scroll_top', $defaults['ed_scroll_top'] );
		if( $scrolltotop ){ ?>
			<div class="to_top">
				<span class="icon-arrow-up">
					<svg xmlns="http://www.w3.org/2000/svg" width="19.555" height="11.1" viewBox="0 0 19.555 11.1">
				  <g id="Group_5791" data-name="Group 5791" transform="translate(-1287.75 -692.239)">
					<g id="Group_5789" data-name="Group 5789" transform="translate(1 2.98)">
					  <rect id="Rectangle_1779" data-name="Rectangle 1779" width="2" height="13.698" rx="1" transform="translate(1295.205 690.672) rotate(-45)"/>
					</g>
					<rect id="Rectangle_1779-2" data-name="Rectangle 1779" width="2" height="13.698" rx="1" transform="translate(1297.436 692.239) rotate(45)"/>
				  </g>
				</svg>
				</span>
			</div>
			<?php
		}
	}
endif;
add_action( 'triphub_after_footer', 'triphub_scrolltotop', 20 );

if( ! function_exists( 'triphub_page_end' ) ) :
/**
 * Page End
*/
function triphub_page_end(){ ?>
		</div><!-- #page -->
	<?php
}
endif;
add_action( 'triphub_after_footer', 'triphub_page_end', 30 );