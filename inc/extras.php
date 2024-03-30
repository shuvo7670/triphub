<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package TripHub
 */

if (!function_exists('triphub_posted_on')):
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function triphub_posted_on() {
        $defaults = triphub_get_general_defaults();

        $ed_updated_post_date = get_theme_mod('ed_post_update_date', $defaults['ed_post_update_date']);

        $time_string = '<time class="entry-date published updated" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';
        $on = ''; //dont display anything when the post is created first
        if (get_the_time('U') !== get_the_modified_time('U')) {
            if ($ed_updated_post_date) {
                $time_string = '<time class="entry-date published updated" datetime="%3$s" itemprop="dateModified">%4$s</time><time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time>';
                $on = __('Updated on ', 'triphub');
            }
            else {
                $time_string = '<time class="entry-date published" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';
            }
        }
        else {
            $time_string = '<time class="entry-date published updated" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';
        }

        $time_string = sprintf($time_string, esc_attr(get_the_date(DATE_W3C)) , esc_html(get_the_date()) , esc_attr(get_the_modified_date(DATE_W3C)) , esc_html(get_the_modified_date()));

        $posted_on = sprintf('%1$s %2$s', '<span class="poson">' . esc_html($on) . '</span>', $time_string);

        echo '<span class="posted-on meta-common">' . $posted_on . '</span>';
    }
endif;

if (!function_exists('triphub_posted_by')):
    /**
     * Prints HTML with meta information for the current author.
     */
    function triphub_posted_by() {
        global $post;
        $author_id = $post->post_author;

        $byline = sprintf(
        /* translators: %s: post author. */
        esc_html('%s') , '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID', $author_id))) . '" itemprop="url"><span itemprop="name">' . esc_html(get_the_author_meta('display_name', $author_id)) . '</span></a></span>'); ?>
		<span class="posted-by author vcard meta-common" <?php triphub_microdata('person'); ?>>
			<?php echo $byline; ?>
		</span>
	<?php
    }
endif;

if (!function_exists('triphub_categories')):
    /**
     * Post Category
     */
    function triphub_categories() {
        if ('post' === get_post_type()) {
            $categories_list = get_the_category_list(' ');
            if ($categories_list) {
                echo '<div class="cat-links meta-common">' . $categories_list . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                
            }
        }
    }
endif;

if (!function_exists('triphub_tags')):
    /**
     * Post Category
     */
    function triphub_tags() {
        if ('post' === get_post_type()) {
            $tags_list = get_the_tag_list('', ' ');
            if ($tags_list) {
                echo '<span class="tags-links">' . '<span class="tagtext">' . esc_html__('Tagged In', 'triphub') . '</span>' . $tags_list . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                
            }
        }
    }
endif;

if (!function_exists('triphub_comment_link')):
    /**
     * Comments
     */
    function triphub_comment_link() {
        if (!post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comment-link-wrap meta-common">';
            comments_popup_link(sprintf(wp_kses(
            /* translators: %s: post title */
            __('Write a Comment<span class="screen-reader-text"> on %s</span>', 'triphub') , array(
                'span' => array(
                    'class' => array() ,
                ) ,
            )) , get_the_title()));
            echo '</span>';
        }
    }
endif;

if (!function_exists('wp_body_open')):
    /**
     * Shim for sites older than 5.2.
     *
     * @link https://core.trac.wordpress.org/ticket/12563
     */
    function wp_body_open() {
        do_action('wp_body_open');
    }
endif;

if (!function_exists('triphub_get_schema_type')):
    /**
     * Schema Type
     */
    function triphub_get_schema_type() {
        return apply_filters('triphub_schema_type', 'microdata');
    }
endif;

if (!function_exists('triphub_get_microdata')):
    /**
     * Microdata Schema
     *
     * @param string $context The element to target
     * @return string final attribute
     */
    function triphub_get_microdata($context) {
        $data = false;

        if ('microdata' !== triphub_get_schema_type()) {
            return false;
        }

        if ('head' === $context) {
            $data = 'itemtype="http://schema.org/WebSite" itemscope';
        }

        if ('body' === $context) {
            $type = 'WebPage';

            if (is_home() || is_archive() || is_attachment() || is_tax() || is_single()) {
                $type = 'Blog';
            }

            if (is_search()) {
                $type = 'SearchResultsPage';
            }

            $type = apply_filters('triphub_body_itemtype', $type);

            $data = sprintf('itemtype="https://schema.org/%s" itemscope', esc_html($type));
        }

        if ('header' === $context) {
            $data = 'itemtype="https://schema.org/WPHeader" itemscope';
        }

        if ('navigation' === $context) {
            $data = 'itemtype="https://schema.org/SiteNavigationElement" itemscope';
        }

        if ('organization' === $context) {
            $data = 'itemtype="https://schema.org/Organization" itemscope';
        }

        if ('person' === $context) {
            $data = 'itemtype="https://schema.org/Person" itemscope';
        }

        if ('article' === $context) {
            $type = apply_filters('triphub_article_itemtype', 'CreativeWork');

            $data = sprintf('itemtype="https://schema.org/%s" itemscope', esc_html($type));
        }

        if ('post-author' === $context) {
            $data = 'itemprop="author" itemtype="https://schema.org/Person" itemscope';
        }

        if ('comment-body' === $context) {
            $data = 'itemtype="https://schema.org/UserComments" itemscope';
        }

        if ('comment-author' === $context) {
            $data = 'itemprop="creator" itemtype="https://schema.org/Person" itemscope';
        }

        if ('sidebar' === $context) {
            $data = 'itemtype="https://schema.org/WPSideBar" itemscope';
        }

        if ('footer' === $context) {
            $data = 'itemtype="https://schema.org/WPFooter" itemscope';
        }

        if ($data) {
            return apply_filters("triphub_{$context}_microdata", $data);
        }
    }
endif;

if (!function_exists('triphub_microdata')):
    /**
     * Output our microdata for an element.
     *
     * @param $context The element to target.
     * @return string The microdata.
     */
    function triphub_microdata($context) {
        echo triphub_get_microdata($context); // WPCS: XSS ok, sanitization ok.
        
    }
endif;

if (!function_exists('triphub_site_branding')):
    /**
     * Site Branding
     */
    function triphub_site_branding($mobile = false) { ?>
		<div class="site-branding" <?php triphub_microdata('organization'); ?>>
			<div class="text-logo">
				<?php
        the_custom_logo();
        ?>
				<div class="site-title-description">
					<?php if (is_front_page() && is_home() && !$mobile) { ?>
						<h1 class="site-title" itemprop="name">
							<a href="<?php echo esc_url(home_url('/')); ?>" rel="home" itemprop="url">
								<?php bloginfo('name'); ?>
							</a>
						</h1>
					<?php
        }
        else { ?>
						<p class="site-title" itemprop="name">
							<a href="<?php echo esc_url(home_url('/')); ?>" rel="home" itemprop="url">
								<?php bloginfo('name'); ?>
							</a>
						</p>
					<?php
        }
        $triphub_description = get_bloginfo('description', 'display');
        if ($triphub_description || is_customize_preview()) { ?>
						<p class="site-description" itemprop="description"><?php echo $triphub_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            
            ?></p>
					<?php
        } ?>
				</div>
			</div><!-- .text-logo -->
		</div><!-- .site-branding -->
		<?php
    }
endif;

if (!function_exists('triphub_primary_navigation')):
    /**
     * Primary Navigation
     */
    function triphub_primary_navigation() {
        $defaults     = triphub_get_general_defaults(); 
        $menu_stretch = get_theme_mod('header_strech_menu', $defaults['header_strech_menu'] );
        $data_stretch = $menu_stretch ? 'data-stretch=yes' : 'data-stretch=no';
        $header_layout = get_theme_mod('header_layout', $defaults['header_layout']);
        if (has_nav_menu('primary') || current_user_can('manage_options')) { ?>
			<div class="triphub-nav-wrapper">
				<nav id="site-navigation" class="primary-navigation" <?php triphub_microdata('navigation'); ?> <?php echo esc_attr($data_stretch); ?>>
					<?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_id' => 'primary-menu',
                            'menu_class' => 'primary-menu-wrapper',
                            'container_class' => 'primary-menu-container',
                            'fallback_cb' => 'triphub_primary_menu_fallback',
                        ));
                    ?>
				</nav><!-- #site-navigation -->
				<?php if ($header_layout === 'one' && !wp_is_mobile()) triphub_header_search(); ?>
			</div><!-- .triphub-nav-wrapper -->
		<?php
        }
    }
endif;

if (!function_exists('triphub_primary_menu_fallback')):
    /**
     * Fallback for primary menu
     */
    function triphub_primary_menu_fallback() {
        if (current_user_can('manage_options')) {
            echo '<ul id="primary-menu" class="menu">';
            echo '<li><a href="' . esc_url(admin_url('nav-menus.php')) . '">' . esc_html__('Click here to add a menu', 'triphub') . '</a></li>';
            echo '</ul>';
        }
    }
endif;

if (!function_exists('triphub_secondary_navigation')):
    /**
     * secondary Navigation
     */
    function triphub_secondary_navigation() {
        if (triphub_pro_is_activated() && defined('triphub_PRO_PATH')) {
            $defaults = triphub_get_general_defaults();
            $header = get_theme_mod('header_layout', $defaults['header_layout']);
            if ($header === 'two' || $header === 'three' || $header === 'four') return;
        }
        if (has_nav_menu('secondary') || current_user_can('manage_options')) { ?>
			<div class="triphub-nav-wrapper">
				<nav id="site-navigation" class="secondary-navigation" <?php triphub_microdata('navigation'); ?>>
					<?php
            wp_nav_menu(array(
                'theme_location' => 'secondary',
                'menu_id' => 'secondary-menu',
                'menu_class' => 'secondary-menu-wrapper',
                'container_class' => 'secondary-menu-container',
                'fallback_cb' => 'triphub_secondary_menu_fallback',
            ));
            ?>
				</nav><!-- #site-navigation -->
			</div><!-- .triphub-nav-wrapper -->
		<?php
        }
    }
endif;

if (!function_exists('triphub_secondary_menu_fallback')):
    /**
     * Fallback for secondary menu
     */
    function triphub_secondary_menu_fallback() {
        if (current_user_can('manage_options')) {
            echo '<ul id="secondary-menu" class="menu">';
            echo '<li><a href="' . esc_url(admin_url('nav-menus.php')) . '">' . esc_html__('Click here to add a menu', 'triphub') . '</a></li>';
            echo '</ul>';
        }
    }
endif;

if (!function_exists('triphub_mobile_header')):
    /**
     * TripHub Mobile Header
     */
    function triphub_mobile_header() {
        $defaults = triphub_get_general_defaults();
        $vip_image = get_theme_mod('header_contact_image', $defaults['header_contact_image']);
        $menu_social = get_theme_mod('ed_mobile_social_media', $defaults['ed_mobile_social_media']);
        $menu_search = get_theme_mod('ed_mobile_search', $defaults['ed_mobile_search']);
        $menu_phone = get_theme_mod('ed_mobile_phone', $defaults['ed_mobile_phone']);
        $menu_email = get_theme_mod('ed_mobile_email', $defaults['ed_mobile_email']);
        $vip_img_id = attachment_url_to_postid($vip_image);
        ?>
		<div class="mobile-header">
			<div class="mobile-header-t">
				<div class="container">
					<?php triphub_site_branding(true); ?>
				</div>
			</div>
			<div class="mobile-header-b">
				<div class="srch-moblop-wrap">
					<?php
        if ($menu_search) {
            echo '<div class="mobile-search-wrap">';
            triphub_header_search(true);
            echo '</div>';
                }
        ?>
					<div class="mobile-menu-op-wrap">
						<button class="mobile-menu-opener" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle">
							<span></span>
						</button>
						<?php triphub_header_mobile_menu_label(); ?>
					</div>
				</div>
			</div>
			<div class="mobile-menu-wrapper  mobile-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">
				<div class="mobile-menu" aria-label="<?php esc_attr_e('Mobile', 'triphub'); ?>">
					<button class="btn-menu-close close-main-nav-toggle" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal"></button>
					<?php
                    /** 
                     * Primary Navigation
                     *
                     */
                    triphub_primary_navigation();
                    /** 
                     * Secondary Navigation
                     *
                     */
                    triphub_secondary_navigation();
                    /** 
                     * Currency Converter and Language Switcher
                     *
                     */
                    if (triphub_is_currency_converter_activated() || triphub_is_polylang_active() || triphub_is_wpml_active()) { ?>
                            <div class=" languagendcurrency-wrap">
                                <?php
                                /**
                                 * Language Switcher
                                 */
                                do_action('triphub_language_switcher'); ?>
                                <?php
                                /**
                                 * Currency Converter
                                 */
                                do_action('triphub_currency_converter'); ?>
                            </div>
                            <?php } ?>
                                <div class="vib-whats">
                                    <?php if ($vip_image) { ?>
                                        <div class="vib-whats-dp">
                                            <?php echo wp_get_attachment_image($vip_img_id); ?>
                                        </div>
                                    <?php } if ($menu_social || $menu_phone || $menu_email) { ?>
                                        <div class="mobile-contact-social-wrap">
                                            <?php if ($menu_phone || $menu_email) { ?>
                                                <div class="vib-whats-txt">
                                                    <?php
                                                        if ($menu_phone) {
                                                            if (triphub_pro_is_activated()) triphub_header_phone_label();
                                                            triphub_header_phone();
                                                        }
                                                        if ($menu_email) {
                                                            if (triphub_pro_is_activated()) triphub_header_email_label();
                                                            triphub_header_email();
                                                        }
                                                    ?>
                                                </div>
                                                <?php } if ($menu_social) { ?>
                                                <div class="social-media-wrap">
                                                    <?php
                                                        $social_icons = new triphub_Social_Lists;
                                                        $social_icons->triphub_social_links(); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="overlay"></div>
                </div><!-- mobile-header -->
            <?php
    }
endif;

if (!function_exists('triphub_sticky_header')):
    /**
     * TripHub Sticky Header
     */
    function triphub_sticky_header() {
        $defaults = triphub_get_general_defaults();
        $header_width = get_theme_mod('header_width_layout', $defaults['header_width_layout']);
        $add_class = 'fullwidth' === $header_width ? 'container-full' : 'container';
        $ed_sticky = get_theme_mod('ed_sticky_header', $defaults['ed_sticky_header']);
        if ($ed_sticky) { ?>
		<div class="sticky-holder">
			<div class="<?php echo esc_attr($add_class); ?>">
				<?php triphub_site_branding(true); ?>
				<div class="navigation-wrap">
					<?php triphub_primary_navigation(false); ?>
					<?php if (get_theme_mod('ed_header_button_sticky', $defaults['ed_header_button_sticky'])) triphub_primary_header_button(); ?>
				</div>
			</div><!-- container -->
		</div>
	<?php
        }
    }
endif;

if (!function_exists('triphub_page_header_banner')):
    /**
     * Page header banner for archives
     *
     * @param int $archive_image
     * @param int $blog_image
     * @return void
     */
    function triphub_page_header_banner($archive_image, $blog_image) {
        if (is_category() || is_tag()) {
            $cat_id = get_queried_object()->term_id;
            if (!empty($cat_id)) {
                $image_id = get_term_meta($cat_id, 'tmp-category-image-id', true);
                $img_atts = wp_get_attachment_image_src($image_id, 'full');
            }
        }
        ?>
		<div class="page-header-top" <?php if ((is_category() || is_tag()) && isset($img_atts) && !empty($img_atts)) {
            echo ' style="background-image: url(' . esc_url($img_atts[0]) . ')" data-bg-image="yes"';
        }
        else if (is_home()) {
            $bg_img = wp_get_attachment_image_url($blog_image, 'triphub-header-bg-img');
            if ($bg_img) echo ' style="background-image: url(' . esc_url($bg_img) . ')" data-bg-image="yes"';
        }
        else if ((is_archive() || is_search()) && isset($archive_image) || is_page_template(array(
            'templates/template-destination.php',
            'templates/template-activities.php',
            'templates/template-trip_types.php',
            'templates/review.php',
            'templates/template-trip-listing.php'
        ))) {
            $bg_img = wp_get_attachment_image_url($archive_image, 'triphub-header-bg-img');

            if (is_page_template(array(
                'templates/template-destination.php',
                'templates/template-activities.php',
                'templates/template-trip_types.php',
                'templates/review.php',
                'templates/template-trip-listing.php'
            ))) {
                if (has_post_thumbnail(get_the_ID())) {
                    $bg_img = get_the_post_thumbnail_url(get_the_ID() , 'triphub-header-bg-img');
                }
            }

            if ($bg_img) echo ' style="background-image: url(' . esc_url($bg_img) . ')" data-bg-image="yes"';
        }
        ?>>
		<?php
    }
endif;

if (!function_exists('triphub_archive_tax_description')):
    function triphub_archive_tax_description(){
        $queried_object = get_queried_object();
        if( is_tax( 'destination' ) || is_tax( 'activities' ) || is_tax( 'trip_types' )  ){
            $short_desc   = get_term_meta ( $queried_object->term_id, 'wte-shortdesc-textarea',true );
            if( $short_desc ){
                echo wpautop( wp_kses_post( $short_desc ) );
            }
        }
    }
endif;


if (!function_exists('triphub_comment_callback')):
    /**
     * Callback function for Comment List *
     *
     * @link https://codex.wordpress.org/Function_Reference/wp_list_comments
     */
    function triphub_comment_callback($comment, $args, $depth) {
        if ('div' == $args['style']) {
            $tag = 'div';
            $add_below = 'comment';
        }
        else {
            $tag = 'li';
            $add_below = 'div-comment';
        } ?>
			<<?php echo $tag ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">

				<?php if ('div' != $args['style']): ?>
					<article id="div-comment-<?php comment_ID() ?>" class="comment-body" <?php triphub_microdata('comment-body'); ?>>
					<?php
        endif; ?>

					<footer class="comment-meta">
						<div class="comment-author vcard">
							<?php if ($args['avatar_size'] != 0) {
                                echo get_avatar($comment, $args['avatar_size']); } ?>
						</div><!-- .comment-author vcard -->
					</footer>

					<div class="text-holder">
						<div class="top">
							<div class="left">
								<?php if ($comment->comment_approved == '0'): ?>
									<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'triphub'); ?></em>
									<br />
								<?php endif; ?>
								<b class="fn" <?php triphub_microdata('comment-author'); ?>><?php echo get_comment_author_link(); ?></b><span class="says"><?php esc_html_e('says:', 'triphub'); ?></span>
								<div class="comment-metadata commentmetadata">
									<a href="<?php echo esc_url(htmlspecialchars(get_comment_link($comment->comment_ID))); ?>">
										<time itemprop="commentTime" datetime="<?php echo esc_attr(get_gmt_from_date(get_comment_date() . get_comment_time() , 'Y-m-d H:i:s')); ?>"><?php printf(esc_html__('%1$s at %2$s', 'triphub') , get_comment_date() , get_comment_time()); ?></time>
									</a>
								</div>
							</div>
						</div>
						<div class="comment-content" itemprop="commentText"><?php comment_text(); ?></div>
						<div class="reply">
							<?php comment_reply_link(array_merge($args, array(
                                'add_below' => $add_below,
                                'depth' => $depth,
                                'max_depth' => $args['max_depth']
                            ))); ?>
						</div>
					</div><!-- .text-holder -->

					<?php if ('div' != $args['style']): ?>
					</article><!-- .comment-body -->
				<?php
        endif;
    }
endif;

if (!function_exists('triphub_breadcrumb_icons_list')):
    /**
     * Breadcrumbs Icon List
     */
    function triphub_breadcrumb_icons_list($separator_icon = 'one') {

        switch ($separator_icon) {
            case 'one':
                return '<svg width="15" height="15" viewBox="0 0 20 20"><path d="M7.7,20c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1.1,0-1.5l8.1-8.1L6.7,1.8c-0.4-0.4-0.4-1.1,0-1.5
				c0.4-0.4,1.1-0.4,1.5,0l9.1,9.1c0.4,0.4,0.4,1.1,0,1.5l-8.8,8.9C8.2,19.9,7.9,20,7.7,20z" opacity="0.7"/></svg>';
            break;
            case 'two':
                return '<svg width="15" height="15" viewBox="0 0 20 20"><polygon points="7,0 18,10 7,20 " opacity="0.7"/></svg>';
            break;
            case 'three':
                return '<svg width="15" height="15" viewBox="0 0 20 20"><path d="M6.1,20c-0.2,0-0.3,0-0.5-0.1c-0.5-0.2-0.7-0.8-0.4-1.3l9.5-17.9C15,0.1,15.6,0,16.1,0.2
				c0.5,0.2,0.7,0.8,0.4,1.3L6.9,19.4C6.8,19.8,6.5,19.9,6.1,20z" opacity="0.7"/></svg>';
            break;

            default:
                # code...
                
            break;
        }
    }
endif;

if (!function_exists('triphub_breadcrumb')):
    /**
     * Breadcrumbs
     */
    function triphub_breadcrumb() {
        global $post;
        $defaults         = triphub_get_general_defaults();
        $post_page        = get_option('page_for_posts');
        $show_front       = get_option('show_on_front');
        $ed_breadcrumb    = get_theme_mod('ed_breadcrumb', $defaults['ed_breadcrumb']);
        $home_text        = get_theme_mod('home_text', $defaults['home_text']);
        $separator_icon   = get_theme_mod('separator_icon', $defaults['separator_icon']);
        $delimiter        = '<span class="separator">' . triphub_breadcrumb_icons_list($separator_icon) . '</span>';
        $before           = '<span class="current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
        $after            = '</span>';
        $trip_class       = '';
        if (is_singular('trip')) {
            $wpte_trip_images = get_post_meta($post->ID, 'wpte_gallery_id', true);
            if (!has_post_thumbnail() && !(isset($wpte_trip_images['enable']) && $wpte_trip_images['enable'] == '1' && count($wpte_trip_images) > 1)) $trip_class = " no-trip-post-img";
        }
        if (!$ed_breadcrumb) return;
        //settings from the theme
        if (!is_front_page()) {
            $depth = 1; ?>
					<div id="crumbs" class="triphub-breadcrumb-main-wrap<?php echo esc_attr($trip_class); ?>" itemscope itemtype="http://schema.org/BreadcrumbList">
						<div class="triphub-breadcrumbs">
							<?php echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a href="' . esc_url(home_url()) . '" itemprop="item"><span itemprop="name" class="home-text">' . esc_html($home_text) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '</span>';

            if (is_home()) {
                $depth = 2;
                echo $before . '<a itemprop="item" href="' . esc_url(get_the_permalink()) . '"><span itemprop="name">' . esc_html(single_post_title('', false)) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            }
            elseif (is_category()) {
                $depth = 2;
                $thisCat = get_category(get_query_var('cat') , false);
                if ($show_front === 'page' && $post_page) { //If static blog post page is set
                    $p = get_post($post_page);
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_permalink($post_page)) . '" itemprop="item"><span itemprop="name">' . esc_html($p->post_title) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '</span>';
                    $depth++;
                }
                if ($thisCat->parent != 0) {
                    $parent_categories = get_category_parents($thisCat->parent, false, ',');
                    $parent_categories = explode(',', $parent_categories);
                    foreach ($parent_categories as $parent_term) {
                        $parent_obj = get_term_by('name', $parent_term, 'category');
                        if (is_object($parent_obj)) {
                            $term_url = get_term_link($parent_obj->term_id);
                            $term_name = $parent_obj->name;
                            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url($term_url) . '"><span itemprop="name">' . esc_html($term_name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '</span>';
                            $depth++;
                        }
                    }
                }
                echo $before . '<a itemprop="item" href="' . esc_url(get_term_link($thisCat->term_id)) . '"><span itemprop="name">' . esc_html(single_cat_title('', false)) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            }
            elseif (triphub_is_wpte_activated() && is_tax(array(
                'activities',
                'destination',
                'trip_types'
            ))) { //Trip Taxonomy pages
                $current_term = $GLOBALS['wp_query']->get_queried_object();
                $tax = array(
                    'activities' => 'templates/template-activities.php',
                    'destination' => 'templates/template-destination.php',
                    'trip_types' => 'templates/template-trip_types.php'
                );

                foreach ($tax as $k => $v) {
                    if (is_tax($k)) {
                        $p_id = triphub_get_page_id_by_template($v);
                        if ($p_id) {
                            echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="' . esc_url(get_permalink($p_id[0])) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_title($p_id[0])) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '</span>';
                        }
                        else {
                            $post_type = get_post_type_object('trip');
                            if ($post_type->has_archive == true) { // For CPT Archive Link
                                // Add support for a non-standard label of 'archive_title' (special use case).
                                $label = !empty($post_type
                                    ->labels
                                    ->archive_title) ? $post_type
                                    ->labels->archive_title : $post_type
                                    ->labels->name;
                                printf('<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="%1$s"><span itemprop="name">%2$s</span></a><meta itemprop="position" content="' . absint($depth) . '" />', esc_url(get_post_type_archive_link(get_post_type())) , $label);
                                echo '' . $delimiter . '</span>';
                            }
                        }

                        $depth = 3;
                        //For trip taxonomy hierarchy
                        $ancestors = get_ancestors($current_term->term_id, $k);
                        $ancestors = array_reverse($ancestors);
                        foreach ($ancestors as $ancestor) {
                            $ancestor = get_term($ancestor, $k);
                            if (!is_wp_error($ancestor) && $ancestor) {
                                echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . esc_url(get_term_link($ancestor)) . '"><span itemprop="name">' . esc_html($ancestor->name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '</span>';
                                $depth++;
                            }
                        }
                    }
                }

                echo $before . '<a itemprop="item" href="' . esc_url(get_term_link($current_term->term_id)) . '"><span itemprop="name">' . esc_html($current_term->name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            }
            elseif (is_tag()) {
                $depth = 2;
                $queried_object = get_queried_object();
                echo $before . '<a itemprop="item" href="' . esc_url(get_term_link($queried_object->term_id)) . '"><span itemprop="name">' . esc_html(single_tag_title('', false)) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            }
            elseif (is_author()) {
                global $author;
                $depth = 2;
                $userdata = get_userdata($author);
                echo $before . '<a itemprop="item" href="' . esc_url(get_author_posts_url($author)) . '"><span itemprop="name">' . esc_html($userdata->display_name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            }
            elseif (is_search()) {
                $depth = 2;
                $request_uri = $_SERVER['REQUEST_URI'];
                echo $before . '<a itemprop="item" href="' . esc_url($request_uri) . '"><span itemprop="name">' . sprintf(__('Search Results for "%s"', 'triphub') , esc_html(get_search_query())) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            }
            elseif (is_day()) {
                $depth = 2;
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_year_link(get_the_time(__('Y', 'triphub')))) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_time(__('Y', 'triphub'))) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '</span>';
                $depth++;
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_month_link(get_the_time(__('Y', 'triphub')) , get_the_time(__('m', 'triphub')))) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_time(__('F', 'triphub'))) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '</span>';
                $depth++;
                echo $before . '<a itemprop="item" href="' . esc_url(get_day_link(get_the_time(__('Y', 'triphub')) , get_the_time(__('m', 'triphub')) , get_the_time(__('d', 'triphub')))) . '"><span itemprop="name">' . esc_html(get_the_time(__('d', 'triphub'))) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            }
            elseif (is_month()) {
                $depth = 2;
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_year_link(get_the_time(__('Y', 'triphub')))) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_time(__('Y', 'triphub'))) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '</span>';
                $depth++;
                echo $before . '<a itemprop="item" href="' . esc_url(get_month_link(get_the_time(__('Y', 'triphub')) , get_the_time(__('m', 'triphub')))) . '"><span itemprop="name">' . esc_html(get_the_time(__('F', 'triphub'))) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            }
            elseif (is_year()) {
                $depth = 2;
                echo $before . '<a itemprop="item" href="' . esc_url(get_year_link(get_the_time(__('Y', 'triphub')))) . '"><span itemprop="name">' . esc_html(get_the_time(__('Y', 'triphub'))) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            }
            elseif (is_single() && !is_attachment()) {
                $depth = 2;
                if (triphub_is_wpte_activated() && get_post_type() === 'trip') { //For Single Trip
                    $depth = 2;
                    $breadcrumb_selected_tax = get_theme_mod('related_trip_taxonomy', 'destination');

                    // Check for page templage
                    $tax_template = triphub_get_page_id_by_template('templates/template-' . $breadcrumb_selected_tax . '.php');

                    if ($tax_template) {
                        echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . esc_url(get_permalink($tax_template[0])) . '"><span itemprop="name">' . esc_html(get_the_title($tax_template[0])) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '</span>';
                    }
                    else {
                        $post_type = get_post_type_object('trip');
                        if ($post_type->has_archive == true) { // For CPT Archive Link
                            // Add support for a non-standard label of 'archive_title' (special use case).
                            $label = !empty($post_type
                                ->labels
                                ->archive_title) ? $post_type
                                ->labels->archive_title : $post_type
                                ->labels->name;
                            printf('<itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="%1$s"><span itemprop="name">%2$s</span></a><meta itemprop="position" content="' . absint($depth) . '" />', esc_url(get_post_type_archive_link(get_post_type())) , $label);
                            echo $delimiter;
                        }
                    }
                    // Check for destination taxonomy hierarchy
                    $depth = 3;
                    $terms = wp_get_post_terms($post->ID, $breadcrumb_selected_tax, array(
                        'orderby' => 'parent',
                        'order' => 'DESC'
                    ));
                    if (!empty($terms) && !is_wp_error($terms)) { //Parents terms
                        $ancestors = get_ancestors($terms[0]->term_id, $breadcrumb_selected_tax);
                        $ancestors = array_reverse($ancestors);
                        foreach ($ancestors as $ancestor) {
                            $ancestor = get_term($ancestor, $breadcrumb_selected_tax);
                            if (!is_wp_error($ancestor) && $ancestor) {
                                echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . esc_url(get_term_link($ancestor)) . '"><span itemprop="name">' . esc_html($ancestor->name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '</span>';
                                $depth++;
                            }
                        }
                        // Last child term
                        echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . esc_url(get_term_link($terms[0])) . '"><span itemprop="name">' . esc_html($terms[0]->name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '</span>';
                        $depth++;
                    }

                    echo $before . '<a href="' . esc_url(get_the_permalink()) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_title()) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
                }
                elseif (get_post_type() != 'post') {
                    $post_type = get_post_type_object(get_post_type());
                    if ($post_type->has_archive == true) { // For CPT Archive Link
                        // Add support for a non-standard label of 'archive_title' (special use case).
                        $label = !empty($post_type
                            ->labels
                            ->archive_title) ? $post_type
                            ->labels->archive_title : $post_type
                            ->labels->name;
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_post_type_archive_link(get_post_type())) . '" itemprop="item"><span itemprop="name">' . esc_html($label) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '</span>';
                        $depth++;
                    }
                    echo $before . '<a href="' . esc_url(get_the_permalink()) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_title()) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
                }
                else { //For Post
                    $cat_object = get_the_category();
                    $potential_parent = 0;

                    if ($show_front === 'page' && $post_page) { //If static blog post page is set
                        $p = get_post($post_page);
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_permalink($post_page)) . '" itemprop="item"><span itemprop="name">' . esc_html($p->post_title) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '</span>';
                        $depth++;
                    }

                    if ($cat_object) { //Getting category hierarchy if any
                        //Now try to find the deepest term of those that we know of
                        $use_term = key($cat_object);
                        foreach ($cat_object as $key => $object) {
                            //Can't use the next($cat_object) trick since order is unknown
                            if ($object->parent > 0 && ($potential_parent === 0 || $object->parent === $potential_parent)) {
                                $use_term = $key;
                                $potential_parent = $object->term_id;
                            }
                        }
                        $cat = $cat_object[$use_term];
                        $cats = get_category_parents($cat, false, ',');
                        $cats = explode(',', $cats);
                        foreach ($cats as $cat) {
                            $cat_obj = get_term_by('name', $cat, 'category');
                            if (is_object($cat_obj)) {
                                $term_url = get_term_link($cat_obj->term_id);
                                $term_name = $cat_obj->name;
                                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url($term_url) . '"><span itemprop="name">' . esc_html($term_name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '</span>';
                                $depth++;
                            }
                        }
                    }
                    echo $before . '<a itemprop="item" href="' . esc_url(get_the_permalink()) . '"><span itemprop="name">' . esc_html(get_the_title()) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
                }
            }
            elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) { //For Custom Post Archive
                $depth = 2;
                $post_type = get_post_type_object(get_post_type());
                if (get_query_var('paged')) {
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_post_type_archive_link($post_type->name)) . '" itemprop="item"><span itemprop="name">' . esc_html($post_type->label) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '/</span>';
                    echo $before . sprintf(__('Page %s', 'triphub') , get_query_var('paged')) . $after; //@todo need to check this
                    
                }
                else {
                    echo $before . '<a itemprop="item" href="' . esc_url(get_post_type_archive_link($post_type->name)) . '"><span itemprop="name">' . esc_html($post_type->label) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
                }
            }
            elseif (is_attachment()) {
                $depth = 2;
                echo $before . '<a itemprop="item" href="' . esc_url(get_the_permalink()) . '"><span itemprop="name">' . esc_html(get_the_title()) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            }
            elseif (is_page() && !$post->post_parent) {
                $depth = 2;
                echo $before . '<a itemprop="item" href="' . esc_url(get_the_permalink()) . '"><span itemprop="name">' . esc_html(get_the_title()) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            }
            elseif (is_page() && $post->post_parent) {
                $depth = 2;
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $current_page = get_post($parent_id);
                    $breadcrumbs[] = $current_page->ID;
                    $parent_id = $current_page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0;$i < count($breadcrumbs);$i++) {
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_permalink($breadcrumbs[$i])) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_title($breadcrumbs[$i])) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $delimiter . '</span>';
                    $depth++;
                }
                echo $before . '<a href="' . get_permalink() . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_title()) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>' . $after;
            }
            elseif (is_404()) {
                $depth = 2;
                echo $before . '<a itemprop="item" href="' . esc_url(home_url()) . '"><span itemprop="name">' . esc_html__('404 Error - Page Not Found', 'triphub') . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            }

            if (get_query_var('paged')) printf(__(' (Page %s)', 'triphub') , get_query_var('paged')); ?>
						</div>
					</div><!-- .crumbs -->
				<?php
        }
    }
endif;

if (!function_exists('triphub_header_search')):
    /**
     * Header Search Markup
     */
    function triphub_header_search($mobile_search = false) {
        $defaults = triphub_get_general_defaults();
        $ed_header_search = get_theme_mod('ed_header_search', $defaults['ed_header_search']);

        if ($ed_header_search || $mobile_search) { ?>
                <div class="search-form-section">
                    <button class="header-search-btn" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13.532" height="13.532" viewBox="0 0 13.532 13.532">
                            <path id="search" d="M31.575,30.447,28.1,26.97A5.6,5.6,0,1,0,26.97,28.1l3.477,3.477ZM19.639,23.629a3.99,3.99,0,1,1,3.99,3.99A3.995,3.995,0,0,1,19.639,23.629Z" transform="translate(-18.043 -18.043)" />
                        </svg>
                    </button>
                    <div class="search-toggle-form search-modal cover-modal" data-modal-target-string=".search-modal">
                        <div class="header-search-inner">
                            <?php get_search_form(); ?>
                            <button class="btn-form-close close" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false"></button>
                        </div>
                    </div>
                </div>
            <?php
        }
    }
endif;

if (!function_exists('triphub_get_posts_list')):
    /**
     * Returns Latest, Related Posts
     */
    function triphub_get_posts_list($status) {
        $defaults = triphub_get_general_defaults();
        global $post;

        $args = array(
            'post_type' => 'post',
            'ignore_sticky_posts' => true
        );

        switch ($status) {
            case 'latest':
                $args['posts_per_page'] = get_theme_mod('no_of_posts_404', $defaults['no_of_posts_404']);
                $class = 'latest-post';
                $post_per_row = get_theme_mod('posts_per_row_404', $defaults['posts_per_row_404']);
                $title = __('Latest Posts', 'triphub');
                $image_size = 'triphub-latest-post';
            break;

            case 'related':
                $args['posts_per_page'] = get_theme_mod('related_post_num', $defaults['related_post_num']);
                $args['post__not_in'] = array(
                    $post->ID
                );
                $args['orderby'] = 'rand';
                $class = 'related-post';
                $post_per_row = get_theme_mod('related_post_row', $defaults['related_post_row']);
                $title = get_theme_mod('single_related_title', $defaults['single_related_title']);
                $related_tax = get_theme_mod('related_taxonomy', 'cat');
                $image_size = 'triphub-latest-post';

                if ($related_tax == 'cat') {
                    $cats = get_the_category($post->ID);
                    if ($cats) {
                        $c = array();
                        foreach ($cats as $cat) {
                            $c[] = $cat->term_id;
                        }
                        $args['category__in'] = $c;
                    }
                }
                elseif ($related_tax == 'tag') {
                    $tags = get_the_tags($post->ID);
                    if ($tags) {
                        $t = array();
                        foreach ($tags as $tag) {
                            $t[] = $tag->term_id;
                        }
                        $args['tag__in'] = $t;
                    }
                }
            break;
        }

        $qry = new WP_Query($args);

        if ($qry->have_posts()) { ?>
					<div class="<?php echo esc_attr($class); ?>" data-row="row-<?php echo esc_attr($post_per_row); ?>">
						<div class="container">
							<?php if ($title) echo '<h2 class="title">' . esc_html($title) . '</h2>'; ?>
							<div class="recomm-artcles-wrap">
								<?php while ($qry->have_posts()) {
                                    $qry->the_post(); ?>
                                    <div class="entry-content-main-wrap">
                                        <?php if (is_404()) {
                                        echo '<div class="404-img-cat-wrap">';
                                    } ?>
                                    <div class="recommended-post-thumb">
                                        <a href="<?php the_permalink(); ?>" rel="prev">
                                            <?php
                                            if (has_post_thumbnail()) {
                                                the_post_thumbnail($image_size, array(
                                                    'itemprop' => 'image'
                                                ));
                                            }else {
                                                triphub_get_fallback_svg($image_size);
                                            } ?>
                                        </a>
                                    </div>
                                    <?php
                                        if (is_404()) {
                                            triphub_categories();
                                            echo '</div>';
                                        }
                                    ?>
                                    <header class="entry-header">
                                        <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    </header>
                                    <?php
                                        if (is_404()) {
                                            echo '<div class="error-entry-meta">';
                                            triphub_posted_by();
                                            triphub_posted_on();
                                            echo '</div>';
                                        } 
                                    ?>
									</div>
								<?php } ?>
							</div><!-- .recomm-artcles-wrap -->
						</div>
					</div><!-- .related-articles/latest-articles -->
				<?php
            wp_reset_postdata();
        }
    }
endif;

if (!function_exists('triphub_search_post_count')):
    /**
     * Search Result Page Count
     */
    function triphub_search_post_count() {
        global $wp_query;
        $found_posts = $wp_query->found_posts;
        $visible_post = get_option('posts_per_page');

        if ($found_posts > 0) {
            echo '<span class="srch-results-cnt">';
            if ($found_posts > $visible_post) {
                printf(esc_html__('Showing %1$s of %2$s Results', 'triphub') , number_format_i18n($visible_post) , number_format_i18n($found_posts));
            }
            else {
                /* translators: 1: found posts. */
                printf(_nx('%s Result', '%s Results', $found_posts, 'found posts', 'triphub') , number_format_i18n($found_posts));
            }
            echo '</span>';
        }
    }
endif;

if (!function_exists('triphub_get_image_sizes')):
    /**
     * Get information about available image sizes
     */
    function triphub_get_image_sizes($size = '') {

        global $_wp_additional_image_sizes;

        $sizes = array();
        $get_intermediate_image_sizes = get_intermediate_image_sizes();

        // Create the full array with sizes and crop info
        foreach ($get_intermediate_image_sizes as $_size) {
            if (in_array($_size, array(
                'thumbnail',
                'medium',
                'medium_large',
                'large'
            ))) {
                $sizes[$_size]['width'] = get_option($_size . '_size_w');
                $sizes[$_size]['height'] = get_option($_size . '_size_h');
                $sizes[$_size]['crop'] = (bool)get_option($_size . '_crop');
            }
            elseif (isset($_wp_additional_image_sizes[$_size])) {
                $sizes[$_size] = array(
                    'width' => $_wp_additional_image_sizes[$_size]['width'],
                    'height' => $_wp_additional_image_sizes[$_size]['height'],
                    'crop' => $_wp_additional_image_sizes[$_size]['crop']
                );
            }
        }
        // Get only 1 size if found
        if ($size) {
            if (isset($sizes[$size])) {
                return $sizes[$size];
            }
            else {
                return false;
            }
        }
        return $sizes;
    }
endif;

if (!function_exists('triphub_get_fallback_svg')):
    /**
     * Get Fallback SVG
     */
    function triphub_get_fallback_svg($post_thumbnail) {
        if (!$post_thumbnail) {
            return;
        }

        $defaults = triphub_get_color_defaults();
        $image_size = triphub_get_image_sizes($post_thumbnail);
        $primary_color = get_theme_mod('primary_color', $defaults['primary_color']);

        if ($image_size) { ?>
					<div class="svg-holder">
						<svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr($image_size['width']); ?> <?php echo esc_attr($image_size['height']); ?>" preserveAspectRatio="none">
							<rect width="<?php echo esc_attr($image_size['width']); ?>" height="<?php echo esc_attr($image_size['height']); ?>" style="fill:<?php echo triphub_sanitize_rgba($primary_color); ?>;opacity: 0.03"></rect>
						</svg>
					</div>
				<?php
        }
    }
endif;

if (!function_exists('triphub_blog_layout_image_size')):
    /**
     *  Blog image sizes
     */
    function triphub_blog_layout_image_size() {
        $defaults = triphub_get_general_defaults();
        $crop_img = get_theme_mod('blog_crop_image', $defaults['blog_crop_image']);
        $blog_layout = get_theme_mod('blog_page_layout', $defaults['blog_page_layout']);
        $sidebar = triphub_sidebar();

        if ($blog_layout == 'one') {
            $image_size = ($sidebar) ? 'triphub-withsidebar' : 'triphub-fullwidth';
        }
        elseif ($blog_layout == 'two') {
            $image_size = 'triphub-blog-list';
        }
        elseif ($blog_layout == 'three') {
            $image_size = ($sidebar) ? 'triphub-blog-grid' : 'triphub-fullwidth';
        }
        else {
            $image_size = 'triphub-withsidebar';
        }

        if (!$crop_img) $image_size = 'full';

        return $image_size;
    }
endif;

if (!function_exists('triphub_archive_layout_image_size')):
    /**
     *  Archive image sizes
     */
    function triphub_archive_layout_image_size() {
        $defaults = triphub_get_general_defaults();
        $archive_layout = get_theme_mod('archive_page_layout', $defaults['archive_page_layout']);
        $sidebar = triphub_sidebar();

        if ($archive_layout == 'one') {
            $image_size = ($sidebar) ? 'triphub-withsidebar' : 'triphub-fullwidth';
        }
        elseif ($archive_layout == 'two') {
            $image_size = 'triphub-blog-list';
        }
        elseif ($archive_layout == 'three') {
            $image_size = ($sidebar) ? 'triphub-blog-grid' : 'triphub-fullwidth';
        }
        else {
            $image_size = 'triphub-withsidebar';
        }

        return $image_size;
    }
endif;

if (!function_exists('triphub_sidebar')):
    /**
     * Return sidebar layouts for pages/posts
     */
    function triphub_sidebar($class = false) {
        global $post;
        $defaults = triphub_get_general_defaults();
        $return = $class ? 'full-width' : false; //Fullwidth
        $layout = get_theme_mod('layout_style', $defaults['layout_style']);

        if (is_home()) {
            $blog_sidebar = get_theme_mod('blog_sidebar_layout', $defaults['blog_sidebar_layout']);
            if (is_active_sidebar('sidebar')) {
                if ($blog_sidebar == 'right-sidebar' || ($blog_sidebar == 'default-sidebar' && $layout == 'right-sidebar')) $return = $class ? 'rightsidebar' : 'sidebar';
                if ($blog_sidebar == 'left-sidebar' || ($blog_sidebar == 'default-sidebar' && $layout == 'left-sidebar')) $return = $class ? 'leftsidebar' : 'sidebar';
            }
            else {
                $return = $class ? 'full-width' : false; //Fullwidth
                
            }
        }

        if (is_archive() || is_search()) {
            $archive_sidebar = get_theme_mod('archive_sidebar_layout', $defaults['archive_sidebar_layout']);
            if (is_active_sidebar('sidebar')) {
                if ($archive_sidebar == 'right-sidebar' || ($archive_sidebar == 'default-sidebar' && $layout == 'right-sidebar')) $return = $class ? 'rightsidebar' : 'sidebar';
                if ($archive_sidebar == 'left-sidebar' || ($archive_sidebar == 'default-sidebar' && $layout == 'left-sidebar')) $return = $class ? 'leftsidebar' : 'sidebar';
            }
            else {
                $return = $class ? 'full-width' : false; //Fullwidth
                
            }
        }

        if (is_singular()) {
            $post_sidebar = get_theme_mod('post_sidebar_layout', $defaults['post_sidebar_layout']); //Global Layout/Position for Posts
            $page_sidebar = get_theme_mod('page_sidebar_layout', $defaults['page_sidebar_layout']); //Global Layout/Position for Pages
            
            /**
             * Individual post/page layout
             */
            if (get_post_meta($post->ID, '_triphub_sidebar_layout', true)) {
                $sidebar_layout = get_post_meta($post->ID, '_triphub_sidebar_layout', true);
            }
            else {
                $sidebar_layout = 'default-sidebar';
            }

            if (is_page()) {
                $templates = array(
                    'templates/template-destination.php',
                    'templates/template-activities.php',
                    'templates/template-trip_types.php'
                );
                if (is_page_template($templates) || (function_exists('wp_travel_engine_is_checkout_page') && wp_travel_engine_is_checkout_page())) {
                    $return = $class ? 'full-width' : false; //Fullwidth
                    
                }
                elseif ($sidebar_layout == 'fullwidth-centered' || ($sidebar_layout == 'default-sidebar' && $page_sidebar == 'fullwidth-centered')) {
                    $return = $class ? 'full-width centered' : false; //Fullwidth
                    
                }
                elseif (is_active_sidebar('sidebar')) {
                    if ($sidebar_layout == 'right-sidebar' || ($sidebar_layout == 'default-sidebar' && $page_sidebar == 'right-sidebar')) $return = $class ? 'rightsidebar' : 'sidebar';
                    if ($sidebar_layout == 'left-sidebar' || ($sidebar_layout == 'default-sidebar' && $page_sidebar == 'left-sidebar')) $return = $class ? 'leftsidebar' : 'sidebar';
                }
                else {
                    $return = $class ? 'full-width' : false; //Fullwidth
                    
                }
            }

            if (is_singular('post')) {
                if ($sidebar_layout == 'fullwidth-centered' || ($sidebar_layout == 'default-sidebar' && $post_sidebar == 'fullwidth-centered')) {
                    $return = $class ? 'full-width centered' : false; //Fullwidth
                    
                }
                elseif (is_active_sidebar('sidebar')) {
                    if ($sidebar_layout == 'right-sidebar' || ($sidebar_layout == 'default-sidebar' && $post_sidebar == 'right-sidebar')) $return = $class ? 'rightsidebar' : 'sidebar';
                    if ($sidebar_layout == 'left-sidebar' || ($sidebar_layout == 'default-sidebar' && $post_sidebar == 'left-sidebar')) $return = $class ? 'leftsidebar' : 'sidebar';
                }
                else {
                    $return = $class ? 'full-width' : false; //Fullwidth
                    
                }
            }
            elseif (is_singular('trip')) {
                $return = $class ? 'rightsidebar' : false; //Rightsidebar
                
            }
        }
        return $return;
    }
endif;

if (!function_exists('triphub_primary_header_button')):
    /**
     * Primary Header Button
     */
    function triphub_primary_header_button() {
        $defaults = triphub_get_general_defaults();
        $header_button_text = get_theme_mod('header_button_label', $defaults['header_button_label']);
        $header_button_link = get_theme_mod('header_button_link', $defaults['header_button_link']);
        $target = get_theme_mod('ed_header_button_newtab', $defaults['ed_header_button_newtab']) ? ' target="_blank"' : '';
        if ($header_button_text && $header_button_link) {
            echo '<div class="btn-book"><a class="btn-primary" href="' . esc_url($header_button_link) . '"' . $target . '>' . triphub_get_header_button() . '</a></div>';
        }
    }
endif;

if (!function_exists('triphub_get_page_id_by_template')):
    /**
     * Returns Page ID by Page Template
     */
    function triphub_get_page_id_by_template($template_name) {
        $args = array(
            'meta_key' => '_wp_page_template',
            'meta_value' => $template_name
        );
        return $pages = get_pages($args);
    }
endif;

if (!function_exists('triphub_apply_theme_shortcode')):
    /**
     * Footer Shortcode
     */
    function triphub_apply_theme_shortcode($string) {
        if (empty($string)) {
            return $string;
        }
        $search = array(
            '[the-year]',
            '[the-site-link]'
        );
        $replace = array(
            date_i18n(esc_html__('Y', 'triphub')) ,
            '<a href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name', 'display')) . '</a>',
        );
        $string = str_replace($search, $replace, $string);
        return $string;
    }
endif;

if ( ! function_exists ( 'triphub_has_contact_image' ) ):
/**
 * Contact Image
 */
function triphub_has_contact_image() {
    $header_layout = get_theme_mod('header_layout', 'one');
    return ($header_layout === 'two' || $header_layout === 'three' || $header_layout === 'four' || $header_layout === 'six') ? true : false;
}
endif;

if (!function_exists('triphub_footer_payments')):
    /**
     * Footer Payments
     */
    function triphub_footer_payments() {
        $defaults = triphub_get_general_defaults();
        $payments_label = get_theme_mod('payment_label', $defaults['payment_label']);
        $payments_image = get_theme_mod('payment_image', $defaults['payment_image']);
        $img_id = attachment_url_to_postid($payments_image);
        if ($payments_label || $payments_image) { ?>
					<div class="payments-showcase">
						<?php if ($payments_label && $payments_image) triphub_payment_label(); ?>
						<?php if ($payments_image) echo wp_get_attachment_image($img_id, 'full'); ?>
					</div>
		<?php
        }
    }
endif;

if (!function_exists('triphub_is_fonts_loaded_locally')):
    /**
     * Check if google fonts are loaded locally
     */
    function triphub_is_fonts_loaded_locally() {
        return get_theme_mod('ed_localgoogle_fonts', false);
    }
endif;

if (!function_exists('triphub_is_classic_editor_activated')):
    /**
     * Checks if classic editor is active or not
     */
    function triphub_is_classic_editor_activated() {
        return class_exists('Classic_Editor') ? true : false;
    }
endif;

if (!function_exists('triphub_is_polylang_active')):
    /**
     * Check if Polylang is active
     */
    function triphub_is_polylang_active() {
        return class_exists('Polylang') ? true : false;
    }
endif;

if (!function_exists('triphub_is_wpml_active')):
    /**
     * Check if WPML is active
     */
    function triphub_is_wpml_active() {
        return class_exists('SitePress') ? true : false;
    }
endif;

if (!function_exists('triphub_is_wpte_activated')):
    /**
     * Check if WP Travel Engine Plugin is installed
     */
    function triphub_is_wpte_activated() {
        return class_exists('Wp_Travel_Engine') ? true : false;
    }
endif;

if (!function_exists('triphub_is_wte_advanced_search_active')):
    /**
     * Check if WTE Advance Search is active
     */
    function triphub_is_wte_advanced_search_active() {
        return class_exists('Wte_Advanced_Search') ? true : false;
    }
endif;

if (!function_exists('triphub_is_wpte_tr_activated')):
    /**
     * Check if WP Travel Engine - Trip Reviews Plugin is installed
     */
    function triphub_is_wpte_tr_activated() {
        return class_exists('Wte_Trip_Review_Init') ? true : false;
    }
endif;

if (!function_exists('triphub_is_wpte_gd_activated')):
    /**
     * Check if WP Travel Engine - Group Discount Plugin is installed
     */
    function triphub_is_wpte_gd_activated() {
        return class_exists('Wp_Travel_Engine_Group_Discount') ? true : false;
    }
endif;

if (!function_exists('triphub_is_currency_converter_activated')):
    /**
     * Check if WP Travel Engine - Wte_Currency_Converter is installed
     */
    function triphub_is_currency_converter_activated() {
        return class_exists('Wte_Currency_Converter') ? true : false;
    }
endif;

if (!function_exists('triphub_is_itinerary_downloader_activated')):
    /**
     * Check if WP Travel Engine - Wte_Itinerary_Downloader is installed
     */
    function triphub_is_itinerary_downloader_activated() {
        return class_exists('Wte_Itinerary_Downloader_Public') ? true : false;
    }
endif;

if (!function_exists('triphub_pro_is_activated')):
    /**
     * Check if TripHub Pro is activated
     */
    function triphub_pro_is_activated() {
        return class_exists('triphub_Pro') ? true : false;
    }
endif;

if (!function_exists('triphub_is_elementor_activated')):
    /**
     * Check if Elementor is activated or not
     */
    function triphub_is_elementor_activated() {
        return class_exists('\Elementor\Plugin') ? true : false;
    }
endif;

/**
 * Checks if elementor has override that particular page/post or not
 */
function triphub_is_elementor_activated_post() {
    if (triphub_is_elementor_activated() && is_singular()) {
        global $post;
        $post_id = $post->ID;
        return \Elementor\Plugin::$instance
            ->documents
            ->get($post_id)->is_built_with_elementor($post_id) ? true : false;
    }
    else {
        return false;
    }
}

/**
 * Add filter only if function exists
 */
if ( function_exists('DEMO_IMPORTER_PLUS_setup')) {
    add_filter(
        'demo_importer_plus_api_url',
        function () {
            return 'https://wptravelenginedemo.com/';
        }
    );
}

if ( ! function_exists('triphub_demo_importer_checked') ):
/**
 * Add filter only if function exists
 */
function triphub_demo_importer_checked() {
    if ( function_exists('DEMO_IMPORTER_PLUS_setup') ) {
        add_filter(
            'demo_importer_plus_api_id',
            function () {
                return  array( '81','73','89','65','183','182', '377', '418', '437' );
            }
        );
    }
}
endif;

/**
 * Function for demo importer
 */
triphub_demo_importer_checked();

/**
 * Filter to modify the Demo Importer Plus link
 */
if ( ! triphub_pro_is_activated() ) {
    add_filter( 'demo_importer_plus_get_pro_text', function() { return __( 'Get TripHub Pro', 'triphub' ); } );
    add_filter( 'demo_importer_plus_get_pro_url', function() { return esc_url('https://wptravelengine.com/wordpress-travel-themes/triphub-pro/'); } );
} else {
    add_filter( 'demo_importer_plus_get_pro_text', '__return_false' );
    add_filter( 'demo_importer_plus_get_pro_url', '__return_false' );
}