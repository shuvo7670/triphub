<?php
/**
 * Title Setting
 *
 * @package TripHub
 */

function triphub_customize_register_titleofcustomizer_section( $wp_customize ) {

    $wp_customize->add_section(
		new Triphub_Group_Title(
			$wp_customize,
			'core',
            array(
                'title'    => __( 'Core', 'triphub' ),
                'priority' => 99,
            )
		)
	);

	$wp_customize->add_section(
		new Triphub_Group_Title(
			$wp_customize,
			'general',
            array(
                'title' => __( 'General Settings', 'triphub' ),
				'priority' => 5,
            )
		)
	);

	$wp_customize->add_section(
		new Triphub_Group_Title(
			$wp_customize,
			'posts',
            array(
                'title' => __( 'Posts & Pages', 'triphub' ),
				'priority' => 61,
            )
		)
	);

	if( triphub_pro_is_activated() ){
		$wp_customize->add_section(
			new Triphub_Group_Title(
				$wp_customize,
				'misc_settings',
				array(
					'title' => __( 'Misc Settings', 'triphub' ),
					'priority' => 90,
				)
			)
		);
	}

}
add_action( 'customize_register', 'triphub_customize_register_titleofcustomizer_section' );