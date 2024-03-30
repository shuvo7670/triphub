<?php

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists('Triphub_Assets') ) {

    /**
     * Assets handlers class
     */
    class Triphub_Assets {

        /**
         * Class constructor
         */
        function __construct() {
            // Theme setup and enqueue files
            add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );

        }

        /**
         * All available scripts
         *
         * @return array
         */
        public function get_scripts() {
            return [
                'popper' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/js/popper.min.js',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/js/popper.min.js' ),
                    'deps'    => [ 'jquery' ]
                ],
                'appear' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/js/jquery.appear.min.js',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/js/jquery.appear.min.js' ),
                    'deps'    => [ 'jquery' ]
                ],
                'bootstrap' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/js/bootstrap.min.js',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/js/bootstrap.min.js' ),
                    'deps'    => [ 'jquery' ]
                ],
                'counterup' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/js/jquery.counterup.min.js',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/js/jquery.counterup.min.js' ),
                    'deps'    => [ 'jquery' ]
                ],
                'nice-select' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/js/jquery.nice-select.min.js',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/js/jquery.nice-select.min.js' ),
                    'deps'    => [ 'jquery' ]
                ],
                'magnific-popup' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/js/magnific-popup.min.js',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/js/magnific-popup.min.js' ),
                    'deps'    => [ 'jquery' ]
                ],
                'odometer' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/js/odometer.min.js',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/js/odometer.min.js' ),
                    'deps'    => [ 'jquery' ]
                ],
                'owl-carousel' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/js/owl.carousel.min.js',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/js/owl.carousel.min.js' ),
                    'deps'    => [ 'jquery' ]
                ],
                'slick' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/js/slick.min.js',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/js/slick.min.js' ),
                    'deps'    => [ 'jquery' ]
                ],
                'wow' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/js/wow.min.js',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/js/wow.min.js' ),
                    'deps'    => [ 'jquery' ]
                ],
                'main' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/js/main.js',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/js/main.js' ),
                    'deps'    => [ 'jquery' ]
                ],
            ];
        }

        /**
         * All available styles
         *
         * @return array
         */
        public function get_styles() {
            return [
                'animate' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/css/animate.css',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/css/animate.css' ),
                ],
                'bootstrap' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/css/bootstrap.min.css',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/css/bootstrap.min.css' ),
                ],
                'flaticon' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/css/flaticon.css',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/css/flaticon.css' ),
                ],
                'font-awesome' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/css/font-awesome-pro.css',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/css/font-awesome-pro.css' ),
                ],
                'line-awesome' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/css/line-awesome.css',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/css/line-awesome.css' ),
                ],
                'magnific-popup' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/css/magnific-popup.css',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/css/magnific-popup.css' ),
                ],
                'nice-select' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/css/nice-select.css',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/css/nice-select.css' ),
                ],
                'odometer' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/css/odometer.min.css',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/css/odometer.min.css' ),
                ],
                'owl-carousel' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/css/owl.carousel.css',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/css/owl.carousel.css' ),
                ],
                'slick' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/css/slick.css',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/css/slick.css' ),
                ],
                'style' => [
                    'src'     => TRIPHUB_ASSETS_ROOT . '/css/style.css',
                    'version' => filemtime( TRIPHUB_ASSETS_ROOT_DIR . '/css/style.css' ),
                ],
            ];
        }

        /**
         * Triphub register scripts and styles 
         * 
         * @since 1.0.0
         * @return void
         */
        public function register_assets() {
            $scripts = $this->get_scripts();
            $styles  = $this->get_styles();

            foreach ( $styles as $handle => $style ) {
                $deps = isset( $style['deps'] ) ? $style['deps'] : false;
                
                wp_enqueue_style( $handle, $style['src'], $deps, $style['version'], 'all' );
            }

            foreach ( $scripts as $handle => $script ) {
                $deps = isset( $script['deps'] ) ? $script['deps'] : false;

                wp_enqueue_script( $handle, $script['src'], $deps, $script['version'], true );
            }

        }
    }
}

// Assets object
new Triphub_Assets();