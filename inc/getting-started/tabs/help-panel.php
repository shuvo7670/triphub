<?php
/**
 * Help Panel.
 *
 * @package triphub
 */
?>
<!-- Help file panel -->
<div id="help-panel" class="panel-left">
    <div class="panel-aside">
        <h4><?php esc_html_e( 'View Our Documentation Link', 'triphub' ); ?></h4>
        <p><?php esc_html_e( 'Are you new to WordPress? Our extensive documentation has step by step guide to create an attractive website.', 'triphub' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( 'https://docs.wptravelengine.com/docs/travel-monster/' ); ?>" title="<?php esc_attr_e( 'Visit the Documentation', 'triphub' ); ?>" target="_blank">
            <?php esc_html_e( 'View Documentation', 'triphub' ); ?>
        </a>
    </div><!-- .panel-aside -->
    
    <div class="panel-aside">
        <h4><?php esc_html_e( 'Support Ticket', 'triphub' ); ?></h4>
        <p><?php printf( __( 'It\'s always a good idea to visit our %1$sKnowledge Base%2$s before you send us a support ticket.', 'triphub' ), '<a href="'. esc_url( 'https://docs.wptravelengine.com/docs/travel-monster/' ) .'" target="_blank">', '</a>' ); ?></p>
        <p><?php printf( __( 'If the Knowledge Base didn\'t answer your queries, submit us a %1$sSupport Ticket%2$s here. Our response time usually is less than a business day, except on the weekends.', 'triphub' ), '<a href="'. esc_url( 'https://wptravelengine.com/support-ticket/' ) .'" target="_blank">', '</a>' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( 'https://wptravelengine.com/support-ticket/' ); ?>" title="<?php esc_attr_e( 'Visit the Support', 'triphub' ); ?>" target="_blank">
            <?php esc_html_e( 'Contact Support', 'triphub' ); ?>
        </a>
    </div><!-- .panel-aside -->

    <div class="panel-aside">
        <h4><?php esc_html_e( 'View Our Demo', 'triphub' ); ?></h4>
        <p><?php esc_html_e( 'Visit the demo of our theme to get more ideas about the design and layout of our theme.', 'triphub' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( 'https://wptravelenginedemo.com/' . triphub_THEME_TEXTDOMAIN . '/' ); ?>" title="<?php esc_attr_e( 'Visit the Demo', 'triphub' ); ?>" target="_blank">
            <?php esc_html_e( 'View Demo', 'triphub' ); ?>
        </a>
    </div><!-- .panel-aside -->
</div>