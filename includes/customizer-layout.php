<?php
/**
 * Customizer Layout Options
 *
 * Adds layout options to the WordPress theme customizer.
 *
 * @package Rampart
 * @version 1.0
 */

/**
 * Adds the layout options to the theme customizer
 *
 * @since 1.0
 */
function thmfdn_layout_customizer( $wp_customize ) {
	$wp_customize->add_section(
		'thmfdn_layout',
		array(
			'title' => 'Layout',
			'description' => 'Content and sidebar layout.',
			'priority' => 35,
		)
	);

	$wp_customize->add_setting(
		'layout',
		array(
			'default' => 'sidebar-content-sidebar',
			'sanitize_callback' => 'thmfdn_sanitize_layout',
		)
	);
	 
	$wp_customize->add_control(
		'layout',
		array(
			'type' => 'radio',
			'label' => 'Columns',
			'section' => 'thmfdn_layout',
			'choices' => array(
				'content-only' => 'No Sidebars',
				'content-sidebar' => 'Content|Sidebar',
				'sidebar-content' => 'Sidebar|Content',
				'content-sidebar-sidebar' => 'Content|Sidebar|Sidebar',
				'sidebar-sidebar-content' => 'Sidebar|Sidebar|Content',
				'sidebar-content-sidebar' => 'Sidebar|Content|Sidebar',
			),
		)
	);
}
add_action( 'customize_register', 'thmfdn_layout_customizer' );

/**
 * Sanitizes the layout control input
 *
 * @return string
 * @since 1.0
 */
function thmfdn_sanitize_layout( $input ) {
	$valid = array(
		'content-only' => 'No Sidebars',
		'content-sidebar' => 'Content|Sidebar',
		'sidebar-content' => 'Sidebar|Content',
		'content-sidebar-sidebar' => 'Content|Sidebar|Sidebar',
		'sidebar-sidebar-content' => 'Sidebar|Sidebar|Content',
		'sidebar-content-sidebar' => 'Sidebar|Content|Sidebar',
	);
 
	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}