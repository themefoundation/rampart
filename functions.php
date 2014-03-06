<?php
/**
 * Functions
 *
 * This file contains functions to extend the functionality of the
 * Rampart theme
 *
 * @package Rampart
 * @version 1.0
 */

//TODO: fix mo.js to handle multiple mobile menus with one menu button.

// Loads customizer options.
require_once( 'includes/customizer-layout.php' );

// Loads customizer logo upload.
require_once( 'includes/customizer-logo.php' );

// Loads customizer options.
require_once( 'includes/widget-areas.php' );

// Loads widgetize functionality.
require_once( 'includes/widgetize.php' );

/**
 * Runs initialization routine
 *
 * @since 1.0
 */
function thmfdn_init() {

	// Sets content width.
	if ( ! isset( $content_width ) ) $content_width = 650;

	// Adds automatic feed link support.
	add_theme_support( 'automatic-feed-links' );

	// Adds freatured image support
	add_theme_support( 'post-thumbnails' );


	// Loads stylesheet for the post editor.
	add_editor_style( 'css/editor-style.css' );

	// Adds default navigation menus
	register_nav_menu( 'header-menu', __( 'Header Menu', 'rampart' ) );
	register_nav_menu( 'footer-menu', __( 'Footer Menu', 'rampart' ) );

}
add_action( 'init', 'thmfdn_init' );

if ( ! function_exists( 'thmfdn_image_sizes' ) ) :
/**
 * Sets image sizes
 *
 * @since 1.0
 */
function thmfdn_image_sizes() {

	// Sets default featured image size.
	set_post_thumbnail_size( 600, 264, true );

	// Sets image size for the portfolio custom post type
	add_image_size( 'custom-content-portfolio-single', 1250 );
	add_image_size( 'custom-content-portfolio-archive', 300, 300, true );

}
endif;
add_action( 'init', 'thmfdn_image_sizes' );

/**
 * Ensures that the title tag will never be empty
 *
 * @return string Returns the site description if no title is available.
 * @since 1.0
 */
function thmfdn_expand_title( $title ) {
	if( empty( $title ) ) {
		return get_bloginfo('name') . ' - ' . get_bloginfo( 'description' );
	} else {
		return $title;
	}
}
add_filter( 'wp_title', 'thmfdn_expand_title' );

/**
 * Loads scripts and styles
 *
 * @since 1.0
 */
function thmfdn_enqueue() {
	wp_enqueue_style( 'thmfdn_typography_styles', get_template_directory_uri() . '/css/cadence.css' );
	wp_enqueue_style( 'thmfdn_menu_styles', get_template_directory_uri() . '/css/mo.css' );
	wp_enqueue_style( 'thmfdn_stylesheet', get_stylesheet_uri() );
	wp_enqueue_style( 'thmfdn_lines', get_template_directory_uri() . '/css/lines.css' );

	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'thmfdn_mojs', get_template_directory_uri() . '/js/mo.js', 'jquery' );
	wp_enqueue_script( 'thmfdn_rampart', get_template_directory_uri() . '/js/rampart.js', 'thmfdn_mojs' );

	/**
	 * Detect plugin. For use on Front End only.
	 */
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'custom-content-portfolio/portfolio.php' ) ) {
		wp_enqueue_style( 'thmfdn_custom_content_portfolio', get_template_directory_uri() . '/css/custom-content-portfolio.css' );
	}

}
add_filter( 'wp_enqueue_scripts', 'thmfdn_enqueue' );

/**
 * Adds custom background support
 *
 * @since 1.0
 */
function thmfdn_custom_background() {
	$defaults = array(
		'default-color' => '#ffffff',
	);
	add_theme_support( 'custom-background', $defaults );
}
add_action( 'init', 'thmfdn_custom_background' );

/**
 * Adds layout class to body tag
 *
 * @return array Array of classes used for the body tag.
 * @since 1.0
 */
function thmfdn_layout_class( $classes ) {
	$classes[] =  get_theme_mod( 'layout', 'sidebar-content-sidebar' );
	return $classes;
}
add_filter( 'body_class', 'thmfdn_layout_class' );

/**
 * Displays logo
 *
 * Displays the logo image if one has been uploaded
 *
 * @return string
 * @since 1.0
 */
function thmfdn_logo( $site_name ) {
	$logo = get_theme_mod( 'logo' );
	if ( !empty( $logo ) ) {
		return '<p class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '"><img id="logo" src="' . $logo . '">' . get_bloginfo('name') . '</a></p>';
	} else {
		return $site_name;
	}
}
add_filter( 'site_name', 'thmfdn_logo' );

/**
 * Removes sidebars based on layout options
 *
 * @since 1.0
 */
function thmfdn_control_sidebars( $classes ) {
	
	switch ( get_theme_mod( 'layout', 'sidebar-content-sidebar' ) ) {
		case 'content-only':
			unregister_sidebar( 'sidebar-1' );
			unregister_sidebar( 'sidebar-2' );
			break;
		case 'content-sidebar':
			unregister_sidebar( 'sidebar-2' );
			break;
		case 'sidebar-content':
			unregister_sidebar( 'sidebar-2' );
			break;
	}
}
add_filter( 'widgets_init', 'thmfdn_control_sidebars' );

/**
 * Adds page template layout class to body tag
 *
 * @since 1.0
 */
function thmfdn_page_template_layout_class( $classes ) {
	
	// Checks for full width page template
	if ( is_page_template( 'page-templates/full-width.php' ) ) {
		$classes[] =  'content-full-width';
	}

	// Checks for no sidebars page template
	if ( is_page_template( 'page-templates/no-sidebars.php' ) ) {
		$classes[] =  'content-only';
	}
	return $classes;
}
add_filter( 'body_class', 'thmfdn_page_template_layout_class' );