<?php
/**
 * Themeclub Panel.
 *
 * @package triphub
 */
?>
<!-- More themes -->
<div id="themes-panel" class="panel-left">
	<div class="theme-intro">
		<div class="theme-intro-left">
			<p><?php printf( __( 'Travel Monster is compatible with WP Travel Engine and all its add-ons, designed especially for building SEO-friendly and feature-rich travel and tour websites. You can add extensive functionality to your travel website, be it setting a fixed tour departure date or a group discount or adding those glorious reviews on your website.  
				<br><br>
				Upgrade to WP Travel Engine add-ons and %1$s save $132 off on Travel Agency plan%2$s today.', 'triphub' ), '<strong>', '</strong>' ); ?></p>
		</div>
		<div class="theme-intro-right">
			<a class="button-primary club-button" href="<?php echo esc_url( 'https://wptravelengine.com/pricing/' ); ?>" target="_blank"><?php esc_html_e( 'Learn about the Add-ons', 'triphub' ); ?>
                <i class="fas fa-arrow-right"></i>
            </a>
		</div>
	</div>
	<span class="theme-loader" style="display: none;"><i class="fas fa-spinner fa-spin"></i></span>
	<div class="theme-list"></div><!-- .theme-list -->
</div><!-- .panel-left updates -->