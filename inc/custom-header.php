<?php
/**
 * 
 * Custom header for the theme
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package TripHub
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses triphub_header_style()
 */
function triphub_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'triphub_custom_header_args',
			array(
				'default-image'      => '',
				'default-text-color' => '000000',
				'width'              => 1000,
				'height'             => 250,
				'flex-height'        => true,
				'header-text'        => false,
				'video'				 => true,
				'wp-head-callback'   => 'triphub_header_style',
			)
		)
	);
}
add_action( 'after_setup_theme', 'triphub_custom_header_setup' );

if ( ! function_exists( 'triphub_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see triphub_custom_header_setup().
	 */
	function triphub_header_style() {
		$defaults           = triphub_get_site_defaults();
		$color_defaults     = triphub_get_color_defaults();
		$hide_title         = get_theme_mod( 'hide_title', $defaults['hide_title'] );
		$hide_tagline       = get_theme_mod( 'hide_tagline', $defaults['hide_tagline'] );
		$site_title_color   = get_theme_mod( 'site_title_color', $color_defaults['site_title_color'] );
		$site_tagline_color = get_theme_mod( 'site_tagline_color', $color_defaults['site_tagline_color'] );
		?>
		<style type="text/css">
		<?php if ( $hide_title  ) { ?>
				.site-title {
					position: absolute;
					clip: rect(1px, 1px, 1px, 1px);
				}
			<?php }else{ ?>
				.site-branding .site-title a{
					color: <?php echo esc_attr( $site_title_color ); ?>;
				}
			<?php } ?>

			<?php if ( $hide_tagline ) { ?>
				.site-description {
					position: absolute;
					clip: rect(1px, 1px, 1px, 1px);
				}
			<?php }else{ ?>
				.site-branding .site-description {
					color: <?php echo esc_attr( $site_tagline_color ); ?>;
				}
			<?php } ?>
		</style>
		<?php
	}
endif;
