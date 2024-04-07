<?php 
use Elementor\Plugin;

class Triphub_Helper {
    public function __construct() {
        add_action('triphub_page_before', array($this, 'open_container'));
        add_action('triphub_page_after', array($this, 'close_container'));
        add_action('triphub_post_before', array($this, 'post_open_container'));
        add_action('triphub_post_after', array($this, 'post_close_container'));
    }

    public static function is_elementor()
		{
			if (self::triphub_default_page()) {
				return false;
			}
			if (did_action('elementor/loaded')) {
				return Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor();
			} else {
				return false;
			}
		}

    /**
     * Is Blog Pages
     *
     * @since   1.2.0
     */
    public static function triphub_default_page()
    {
        return ((((is_search()) || is_archive()) ||  (is_author()) || (is_category()) || (is_home()) || (is_tag()))) ? true : false;
    }

    /**
     * Open Page Container.
     *
     * @since   1.0.0
     */
    public function open_container()
    {
        if( !self::is_elementor() ) {
            ?>
                <div class="container">
                    <div class="pt-80 pb-80">
            <?php
        }
    }

    /**
     * Close Page Container.
     *
     * @since   1.0.0
     */
    public function close_container()
    {
        if( !self::is_elementor() ) {
            ?>
                    </div>
                </div>
            <?php
        }
    }

}
new Triphub_Helper();