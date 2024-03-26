<?php 
/**
* Travel Monster Metabox for Sidebar Layout
*
* @package Travel Monster
*
*/ 

function triphub_add_sidebar_layout_box(){
    $post_id   = isset( $_GET['post'] ) ? $_GET['post'] : '';
    $template  = get_post_meta( $post_id, '_wp_page_template', true );
    $templates = array( 'templates/template-destination.php','templates/template-activities.php','templates/template-trip_types.php');

    /**
     * Remove sidebar metabox in specific page template.
    */
    if( ! in_array( $template, $templates ) ){
        add_meta_box( 
            'triphub_sidebar_layout',
            __( 'Sidebar Layout', 'triphub' ),
            'triphub_sidebar_layout_callback', 
            array( 'page','post' ),
            'normal',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'triphub_add_sidebar_layout_box' );

$triphub_sidebar_layout = array(    
    'default-sidebar'=> array(
    	 'value'     => 'default-sidebar',
    	 'label'     => __( 'Default Sidebar', 'triphub' ),
    	 'thumbnail' => get_template_directory_uri() . '/images/default-sidebar.png'
   	),
    'right-sidebar' => array(
         'value'     => 'right-sidebar',
         'label'     => __( 'Right Sidebar', 'triphub' ),
         'thumbnail' => get_template_directory_uri() . '/images/right-sidebar.png'
    ),
    'left-sidebar' => array(
        'value'     => 'left-sidebar',
        'label'     => __( 'Left Sidebar', 'triphub' ),
        'thumbnail' => get_template_directory_uri() . '/images/left-sidebar.png'
    ),
    'no-sidebar'     => array(
        'value'     => 'no-sidebar',
        'label'     => __( 'Full Width', 'triphub' ),
        'thumbnail' => get_template_directory_uri() . '/images/full-width.png'
    ),
    'fullwidth-centered' => array(
        'value'     => 'fullwidth-centered',
        'label'     => __( 'Full Width Centered', 'triphub' ),
        'thumbnail' => get_template_directory_uri() . '/images/full-width-centered.png'
    )
);

function triphub_sidebar_layout_callback(){
    global $post , $triphub_sidebar_layout;
    wp_nonce_field( basename( __FILE__ ), 'triphub_nonce' ); 
    if( get_post_meta( $post->ID, '_triphub_sidebar_layout', true ) ){
        $layout = get_post_meta( $post->ID, '_triphub_sidebar_layout', true );
    }else{
        $layout = 'default-sidebar';
    }
    ?>     
    <table class="form-table">
        <tr>
            <td colspan="4"><em class="f13"><?php esc_html_e( 'Choose Sidebar Template', 'triphub' ); ?></em></td>
        </tr>    
        <tr>
            <td>
                <?php  
                    foreach( $triphub_sidebar_layout as $field ){ ?>
                        <div class="hide-radio radio-image-wrapper" style="float:left; margin-right:30px;">
                            <input id="<?php echo esc_attr( $field['value'] ); ?>" type="radio" name="triphub_sidebar_layout" value="<?php echo esc_attr( $field['value'] ); ?>" <?php checked( $layout, $field['value'] ); ?>/>
                            <label class="description" for="<?php echo esc_attr( $field['value'] ); ?>">
                                <img src="<?php echo esc_url( $field['thumbnail'] ); ?>" alt="<?php echo esc_attr( $field['label'] ); ?>" />                               
                            </label>
                        </div>
                        <?php 
                    } // end foreach 
                ?>
                <div class="clear"></div>
            </td>
        </tr>
    </table>
 <?php 
}

function triphub_save_sidebar_layout( $post_id ){
    global $triphub_sidebar_layout;

    // Verify the nonce before proceeding.
    if( !isset( $_POST[ 'triphub_nonce' ] ) || !wp_verify_nonce( $_POST[ 'triphub_nonce' ], basename( __FILE__ ) ) )
        return;
    
    // Stop WP from clearing custom fields on autosave
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  
        return;

    if( 'page' == $_POST['post_type'] ){  
        if( ! current_user_can( 'edit_page', $post_id ) ) return $post_id;  
    }elseif( ! current_user_can( 'edit_post', $post_id ) ){  
        return $post_id;  
    }
    
    $layout = isset( $_POST['triphub_sidebar_layout'] ) ? sanitize_key( $_POST['triphub_sidebar_layout'] ) : 'default-sidebar';

    if( array_key_exists( $layout, $triphub_sidebar_layout ) ){
        update_post_meta( $post_id, '_triphub_sidebar_layout', $layout );
    }else{
        delete_post_meta( $post_id, '_triphub_sidebar_layout' );
    }   
}
add_action( 'save_post' , 'triphub_save_sidebar_layout' );