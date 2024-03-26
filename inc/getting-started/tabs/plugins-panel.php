<?php
/**
 * Help Panel.
 *
 * @package triphub
 */
?>
<!-- Updates panel -->
<div id="plugins-panel" class="panel-left visible">
	<h4><?php esc_html_e( 'Recommended Plugins', 'triphub' ); ?></h4>
	<p><?php esc_html_e( 'Below is a list of recommended plugins to install that will help you get the best out of Travel Monster. Though every plugin is optional, it is recommended that you at least install WP Travel Engine & One Click Demo Import plugin to create a website similar to the Travel Monster demo.', 'triphub' ); ?></p>

	<hr/>

	<?php 
	$free_plugins = array(           
        'wp-travel-engine' => array(
            'plugin_name'        => __( 'WP Travel Engine','triphub' ),
            'slug'               => 'wp-travel-engine',
            'filename'           => 'wp-travel-engine/wp-travel-engine.php',
            'settings-link'      => admin_url( 'edit.php?post_type=trip&page=class-wp-travel-engine-admin.php' ),
            'settings-link-text' => __( 'Settings','triphub' ),
        ),    
        'wte-elementor-widgets' => array(
            'plugin_name'        => __( 'WP Travel Engine - Addons for Elementor','triphub' ),
            'slug'               => 'wte-elementor-widgets',
            'filename'           => 'wte-elementor-widgets/wte-elementor-widgets.php'
        ),    
        'demo-importer-plus' => array(
            'plugin_name'        => __( 'Demo Importer Plus','triphub' ),
            'slug'               => 'demo-importer-plus',
            'filename'           => 'demo-importer-plus/demo-importer-plus.php',
            'settings-link'      => admin_url( 'themes.php?page=demo-importer-plus' ),
            'settings-link-text' => __( 'Settings','triphub' ),
		),
        'elementor' => array(
            'plugin_name'        => __( 'Elementor','triphub' ),
            'slug'               => 'elementor',
            'filename'           => 'elementor/elementor.php',
            'settings-link'      => admin_url( 'admin.php?page=elementor' ),
            'settings-link-text' => __( 'Settings','triphub' ),
		),
        'mega-elements-addons-for-elementor' => array(
            'plugin_name'        => __( 'Elementor','triphub' ),
            'slug'               => 'mega-elements-addons-for-elementor',
            'filename'           => 'mega-elements-addons-for-elementor/mega-elements-addons-for-elementor.php',
            'settings-link'      => admin_url( 'admin.php?page=mega-elements#mega-elements-general' ),
            'settings-link-text' => __( 'Settings','triphub' ),
		),
        'travel-booking-toolkit' => array(
            'plugin_name'        => __( 'Elementor','triphub' ),
            'slug'               => 'travel-booking-toolkit',
            'filename'           => 'travel-booking-toolkit/travel-booking-toolkit.php',
		)
    );

	if( $free_plugins ){ ?>
		<h4 class="recomplug-title"><?php esc_html_e( 'Free Plugins', 'triphub' ); ?></h4>
		<p><?php esc_html_e( 'These Free Plugins might be handy for you.', 'triphub' ); ?></p>
		<div class="recomended-plugin-wrap">
    		<?php
    		foreach( $free_plugins as $slug => $plugin ) {
    			$info     = triphub_call_plugin_api( $plugin['slug'] );
    			$icon_url = triphub_check_for_icon( $info->icons );
                $plugin_active_status = '';
                if ( is_plugin_active( $plugin['filename'] ) ) {
                    $plugin_active_status = ' active';
                }
                 ?>    
    			<div class="recom-plugin-wrap">
    				<div class="plugin-img-wrap">
    					<img src="<?php echo esc_url( $icon_url ); ?>" />
    					<div class="version-author-info">
    						<span class="version"><?php printf( esc_html__( 'Version %s', 'triphub' ), $info->version ); ?></span>
    						<span class="seperator">|</span>
    						<span class="author"><?php echo esc_html( strip_tags( $info->author ) ); ?></span>
    					</div>
    				</div>
    				<div class="plugin-title-install clearfix">
    					<span class="title" title="<?php echo esc_attr( $info->name ); ?>">
    						<?php echo esc_html( $info->name ); ?>	
    					</span>
                        <div class="button-wrap <?php echo esc_attr( $plugin_active_status ); ?>" id="gs-<?php echo esc_attr( $slug ); ?>" data-slug="gs-<?php echo esc_attr( $slug ); ?>">
                           <div class="gs-recommended-plugin">
                            <?php 
                                if ( ! is_plugin_active( $plugin['filename'] ) ) {
                                    if ( file_exists( WP_CONTENT_DIR . '/plugins/' . $plugin['filename'] ) ) {
                                        //activate if there is file on the wp-content/plugins ?>
                                        <a class="activate-now button button-primary " data-slug="<?php echo esc_attr( $slug ); ?>" href="#" aria-label="<?php echo esc_attr( $plugin['plugin_name'] ); ?>" data-init="<?php echo esc_attr( $plugin['filename'] ); ?>" data-settings-link="<?php if( isset( $plugin['settings-link'] ) ) echo esc_url( $plugin['settings-link'] ); ?>" data-settings-link-text="<?php if( isset( $plugin['settings-link-text'] ) ) echo esc_attr( $plugin['settings-link-text'] ); ?>">
                                                <?php echo esc_html( 'Activate','the-schema' ); ?>        
                                            </a>
                                    <?php }else{ //install if there are not any plugins which are listed on wp-content/plugins ?>   
                                        <a class="install-now button " data-slug="<?php echo esc_attr( $slug ); ?>" href="#" aria-label="<?php echo esc_attr( $plugin['plugin_name'] ); ?>" data-init="<?php echo esc_attr( $plugin['filename'] ); ?>" data-settings-link="<?php if( isset( $plugin['settings-link'] ) ) echo esc_url( $plugin['settings-link'] ); ?>" data-settings-link-text="<?php if( isset( $plugin['settings-link-text'] ) ) echo esc_attr( $plugin['settings-link-text'] ); ?>">
                                                <?php echo esc_html( 'Install and Activate','the-schema' ); ?>        
                                            </a>
                                    <?php }
                                }else{ ?>
                                      <a href="#" class="deactivate-now button" data-init="<?php echo esc_attr( $plugin['filename'] ); ?>" aria-label="<?php echo esc_attr( $plugin['plugin_name'] ); ?>" data-settings-link="<?php if( isset( $plugin['settings-link'] ) ) echo esc_url( $plugin['settings-link'] ); ?>" data-settings-link-text="<?php if( isset( $plugin['settings-link-text'] ) ) echo esc_attr( $plugin['settings-link-text'] ); ?>">
                                            <?php echo esc_html( 'Deactivate','the-schema' ); ?>
                                        </a>
                                        <?php
                                        if ( isset( $plugin['settings-link'] ) ) { ?>
                                            <a class="gs-recommended-plugin-links button" data-slug="<?php echo esc_attr( $slug ); ?>" href="<?php if( isset( $plugin['settings-link'] ) ) echo esc_url( $plugin['settings-link'] ); ?>"><?php if( isset( $plugin['settings-link-text'] ) ) echo esc_attr( $plugin['settings-link-text'] ); ?></a>  
                                        <?php } ?>
                                <?php }
                            ?>
                           </div>
                        </div>
    				</div>
    			</div>
    			<?php
    		} 
            ?>
		</div>
	<?php
	} 
?>
</div><!-- .panel-left -->