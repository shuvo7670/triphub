<?php
/**
 * TripHub Plugin Recommend Control
 * 
 * @package triphub
 */

if( ! class_exists( 'WP_Customize_Control' ) ){
	return null;
}

if( ! class_exists( 'Triphub_Plugin_Install_Helper' ) ){
	return;
}

/**
 * A custom text control for Contact info.
 */
class triphub_Plugin_Recommend_Control extends WP_Customize_Control {

	public $slug = '';

	public function __construct($manager, $id, $args = array()) {
		$this->slug = $args['plugin_slug'];
		parent::__construct($manager, $id, $args);
	}

	/**
	 * Enqueue function.
	 */
	public function enqueue() {
		Triphub_Plugin_Install_Helper::instance()->enqueue_scripts();
	}

	/**
	 * Render content for the control.
	 */
	public function render_content() {
		?>
	    <span class="customize-control-title">
			<?php echo esc_html($this->label); ?>
		</span>

		<?php if ($this->description) {?>
			<span class="description customize-control-description">
			<?php echo wp_kses_post($this->description); ?>
			</span>
		<?php }

		$instll_btn = $this->create_plugin_install_button($this->slug);
		echo sprintf( '%s', $instll_btn );
	}

	/**
	 * Create plugin install button.
	 *
	 * @param string $slug plugin slug.
	 *
	 * @return bool
	 */
	public function create_plugin_install_button($slug) {
		return Triphub_Plugin_Install_Helper::instance()->get_button_html($slug);
	}
}
