<?php
/**
 * Travel Monster Widget Areas
 * 
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @package Travel Monster
*/

if( ! function_exists( 'triphub_widgets_init' ) ):
/**
 * Register Widget Areas
*/
function triphub_widgets_init() {
    $title_class = '';

    $sidebars = array(
        'sidebar'   => array(
            'name'        => __( 'Sidebar', 'triphub' ),
            'id'          => 'sidebar', 
            'description' => __( 'Default Sidebar', 'triphub' ),
        ),
        'footer-one'=> array(
            'name'        => __( 'Footer One', 'triphub' ),
            'description' => __( 'Add footer one widgets here.', 'triphub' ),
        ),
        'footer-two'=> array(
            'name'        => __( 'Footer Two', 'triphub' ),
            'description' => __( 'Add footer two widgets here.', 'triphub' ),
        ),
        'footer-three'=> array(
            'name'        => __( 'Footer Three', 'triphub' ),
            'description' => __( 'Add footer three widgets here.', 'triphub' ),
        ),
        'footer-four'=> array(
            'name'        => __( 'Footer Four', 'triphub' ),
            'description' => __( 'Add footer four widgets here.', 'triphub' ),
        )
    );
    
    foreach( $sidebars as $id => $sidebar ){
        register_sidebar( array(
            'name'          => esc_html( $sidebar['name'] ),
            'id'            => esc_attr( $id ),
            'description'   => esc_html( $sidebar['description'] ),
            'before_widget' => '<section id="%1$s" class="widget ' . esc_attr( $title_class ) . ' %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => apply_filters( 'triphub_widget_before_title', '<h2 class="widget-title" itemprop="name">' ),
            'after_title'   => apply_filters( 'triphub_widget_after_title', '</h2>' ),
        ) );
    }
}
endif;
add_action( 'widgets_init', 'triphub_widgets_init' );