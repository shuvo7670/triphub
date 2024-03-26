<?php
/**
 * Single Trip header
 * 
 * This template can be overridden by copying it to yourtheme/wp-travel-engine/single-trip/title.php.
 * 
 * @package Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes/templates
 * @since 1.0.0
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
if ( class_exists( 'Wte_Trip_Review_Init' ) ) {
    $idNum         = (!isset($id)) || (isset($id) && empty($id))? get_the_ID() : $id;
    $review_obj    = new Wte_Trip_Review_Init();
    $comment_datas = $review_obj->pull_comment_data( $idNum );
}

$wp_travel_engine_setting = get_post_meta( get_the_ID(), 'wp_travel_engine_setting', true );
?>
<header class="entry-header">
    <h1 class="entry-title" itemprop="name">
    <?php the_title(); ?>
    </h1>
    <?php if ( isset( $wp_travel_engine_setting['trip_duration'] ) && $wp_travel_engine_setting['trip_duration'] != '' ){ ?>
        <div class="duration-days">
            <span class="duration"><?php echo number_format_i18n( $duration ); ?></span>
            <span class="days">
                <?php
                    if ( 'days' === $duration_unit ) $value = sprintf( _n( '%s Day', '%s Days', $duration, 'triphub' ), number_format_i18n( $duration ) );
                    if ( 'hours' === $duration_unit ) $value = sprintf( _n( '%s Hour', '%s Hours', $duration, 'triphub' ),  number_format_i18n( $duration ) );
                    echo preg_replace('/^[\d .-]+/','', $value);
                ?>
            </span>
        </div>
    <?php } if ( ! empty( $comment_datas ) ){ ?>
        <div class="average-rating">
            <?php
            $icon_type               = '';
            $icon_fill_color         = '#F39C12'; ?>
            <div
                class="agg-rating trip-review-stars <?php echo ! empty( $review_icon_type ) ? 'svg-trip-adv' : 'trip-review-default'; ?>"
                data-icon-type='<?php echo esc_attr( $icon_type ); ?>' data-rating-value="<?php echo esc_attr( $comment_datas['aggregate'] ); ?>"
                data-rateyo-rated-fill="<?php echo esc_attr( $icon_fill_color ); ?>"
                data-rateyo-read-only="true"
            >
            </div>
            <a class="tmp-rating-text" href="#tmp-overall-rating">
                <?php echo esc_html( $comment_datas['i'] );
                if( $comment_datas['i']=="1" ) { 
                    echo esc_html( ' Review','triphub' ); 
                }else{
                    echo esc_html( ' Reviews','triphub' ); 
                } ?>
            </a>
        </div>
	<?php } ?>
    <?php do_action('wp_travel_engine_header_hook'); ?>
</header>
<!-- ./entry-header -->
<?php
