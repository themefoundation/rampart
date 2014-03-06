<?php
/**
 * Customizer Logo Upload
 *
 * Adds logo image upload to the theme customizer
 *
 * @package Rampart
 * @version 1.0
 */

/**
 * Adds the logo upload to the theme customizer
 *
 * @since 1.0
 */
function thmfdn_logo_customizer( $wp_customize ) {
	$wp_customize->add_section(
		'thmfdn_logo',
		array(
			'title' => 'Logo',
			'description' => 'Upload a logo image',
			'priority' => 35,
		)
	);

	$wp_customize->add_setting( 'logo' );
	 
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'logo',
			array(
				'label' => 'Logo upload',
				'section' => 'thmfdn_logo',
				'settings' => 'logo'
			)
		)
	);
}
add_action( 'customize_register', 'thmfdn_logo_customizer' );
