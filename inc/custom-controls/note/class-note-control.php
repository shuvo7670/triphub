<?php
/**
 * TripHub Customizer Note Control.
 * 
 * @package triphub
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Triphub_Note_Control' ) ){

	class Triphub_Note_Control extends WP_Customize_Control {
		public $group;
		public $collapsed = true;
		
		public function to_json() {
			parent::to_json();
			$this->json['group']           = $this->group;
			$this->json['collapsed']       = $this->collapsed;
		}

		public function render_content(){ ?>
			<div class="<?php if ( $this->collapsed !== true ) echo 'is-active'; if ( $this->group ) echo '_' . $this->group; ?>">
				<span class="customize-control-title">
					<?php echo wp_kses_post( $this->label ); ?>
				</span>
		
				<?php if( $this->description ){ ?>
					<span class="description customize-control-description">
					<?php echo wp_kses_post( $this->description ); ?>
					</span>
				<?php } ?>
			</div>
			<?php
        }
	}
}