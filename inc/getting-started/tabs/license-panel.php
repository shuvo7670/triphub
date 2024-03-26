<?php
/**
 * Right Buttons Panel.
 *
 * @package triphub
 */
?>
<div class="panel-right">
	<!-- Activate license -->
	<?php do_action( 'travel_pro_updates_pro_html' ); ?>

	<?php if( !triphub_pro_is_activated() ): ?>
		<!-- Upgrade to Pro -->
		<div class="panel-aside">
			<h4><?php esc_html_e( 'Upgrade to Pro', 'triphub' ); ?></h4>
			<p><?php esc_html_e( 'The Pro version of this theme includes tons of additional settings.You can change the layouts for header, blog, archive and single post. In addition, you can advanced settings for optimizing your website performance. In addition to this, the Pro version also offer multiple layouts to choose from for building your website.', 'triphub' ); ?></p>
			<a class="button button-primary" href="https://wptravelengine.com/wordpress-travel-themes/travel-monster-pro/" title="<?php esc_attr_e( 'Read More about Pro version', 'triphub' ); ?>" target="_blank">
				<?php esc_html_e( 'Read More about Pro version', 'triphub' ); ?>
			</a>
		</div><!-- .panel-aside knowledge base -->
	<?php endif; ?>
	
	<!-- Knowledge base -->
	<div class="panel-aside">
		<h4><?php esc_html_e( 'Visit the Knowledge Base', 'triphub' ); ?></h4>
		<p><?php esc_html_e( 'Need help with using the WordPress as quickly as possible? Visit our well-organized Knowledge Base!', 'triphub' ); ?></p>
		<p><?php esc_html_e( 'Our Knowledge Base has step-by-step tutorials, from installing the WordPress to working with themes and more.', 'triphub' ); ?></p>

		<a class="button button-primary" href="https://docs.wptravelengine.com/docs/travel-monster/" title="<?php esc_attr_e( 'Visit the knowledge base', 'triphub' ); ?>" target="_blank">
            <?php esc_html_e( 'Visit the Knowledge Base', 'triphub' ); ?>
        </a>
	</div><!-- .panel-aside knowledge base -->
</div><!-- .panel-right -->