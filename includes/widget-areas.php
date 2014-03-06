<?php
/**
 * Widget areas
 *
 * This file registers the widget areas. Widget areas not intended for the
 * standard sidebars are assigned to specific action hooks.
 *
 * @package Rampart
 * @version 1.0
 */

/**
 * Registers sidebars
 *
 * @since 1.0
 */
function thmfdn_register_sidebars() {

	// Registers the main sidebar widget area.
	register_sidebar(
		array(
			'name' => __( 'Main Sidebar', 'rampart' ),
			'id' => 'sidebar-1',
			'description' => __( 'This is the main sidebar.', 'rampart' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);

	// Registers the additional sidebar widget area.
	register_sidebar(
		array(
			'name' => __( 'Additional Sidebar', 'rampart' ),
			'id' => 'sidebar-2',
			'description' => __( 'This is the secondary sidebar.', 'rampart' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);

	// Registers the widget area before the header.
	register_sidebar(
		array(
			'name' => __( 'Before Header', 'rampart' ),
			'id' => 'header-before',
			'description' => __( 'Displayed above the header area.', 'rampart' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);

	// Registers the widget area in the header.
	register_sidebar(
		array(
			'name' => __( 'Inside Header', 'rampart' ),
			'id' => 'header-inside',
			'description' => __( 'Displayed in the header area.', 'rampart' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);

	// Registers the widget area after the header.
	register_sidebar(
		array(
			'name' => __( 'After Header', 'rampart' ),
			'id' => 'header-after',
			'description' => __( 'Displayed below the header area.', 'rampart' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);

	// Registers the widget area before the footer.
	register_sidebar(
		array(
			'name' => __( 'Before Footer', 'rampart' ),
			'id' => 'footer-before',
			'description' => __( 'Displayed above the footer area.', 'rampart' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);

	// Registers the widget area before the footer.
	register_sidebar(
		array(
			'name' => __( 'Inside Footer', 'rampart' ),
			'id' => 'footer-inside',
			'description' => __( 'Displayed in the footer area.', 'rampart' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);

	// Registers the widget area before the footer.
	register_sidebar(
		array(
			'name' => __( 'After Footer', 'rampart' ),
			'id' => 'footer-after',
			'description' => __( 'Displayed below the footer area.', 'rampart' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);

}
add_action( 'widgets_init', 'thmfdn_register_sidebars' );

/**
 * Displays the Before Header widget area
 *
 * @since 1.0
 */
function thmfdn_before_header_widgets() {
	if ( is_active_sidebar( 'header-before' ) ) {
		?>

			<div class="site-header header-before">
				<div class="wrap">
					<?php dynamic_sidebar( 'header-before' ); ?>
				</div><!--.wrap-->
			</div><!--.site-header-->

		<?php
	}
}
add_action( 'header_before', 'thmfdn_before_header_widgets' );

/**
 * Displays the Inside Header widget area
 *
 * @since 1.0
 */
function thmfdn_inside_header_widgets() {
	if ( is_active_sidebar( 'header-inside' ) ) {
		?>
			<div class="header-inside">
				<?php dynamic_sidebar( 'header-inside' ); ?>
			</div><!--.header-inside-->
		<?php
	}
}
add_action( 'header_bottom', 'thmfdn_inside_header_widgets' );

/**
 * Displays the After Header widget area
 *
 * @since 1.0
 */
function thmfdn_after_header_widgets() {
	if ( is_active_sidebar( 'header-after' ) ) {
		?>

			<div class="site-header header-after">
				<div class="wrap">
					<?php dynamic_sidebar( 'header-after' ); ?>
				</div><!--.wrap-->
			</div><!--.site-header-->

		<?php
	}
}
add_action( 'header_after', 'thmfdn_after_header_widgets' );

/**
 * Displays the Before Footer widget area
 *
 * @since 1.0
 */
function thmfdn_before_footer_widgets() {
	if ( is_active_sidebar( 'footer-before' ) ) {
		?>

			<div class="site-footer footer-before">
				<div class="wrap widgetize-count-<?php echo count( thmfdn_count_widgets( 'footer-before' ) ); ?>">
					<?php dynamic_sidebar( 'footer-before' ); ?>
				</div><!--.wrap-->
			</div><!--.site-footer-->

		<?php
	}
}
add_action( 'footer_before', 'thmfdn_before_footer_widgets' );

/**
 * Displays the Inside Footer widget area
 *
 * @since 1.0
 */
function thmfdn_inside_footer_widgets() {
	if ( is_active_sidebar( 'footer-inside' ) ) {
		echo '<div class="footer-inside widgetize-count-' . count( thmfdn_count_widgets( 'footer-before' ) ) . '">';
		dynamic_sidebar( 'footer-inside' );
		echo '</div>';
	}
}
add_action( 'footer_top', 'thmfdn_inside_footer_widgets' );

/**
 * Displays the After Footer widget area
 *
 * @since 1.0
 */
function thmfdn_after_footer_widgets() {
	if ( is_active_sidebar( 'footer-after' ) ) {
		?>

			<div class="site-footer footer-after">
				<div class="wrap">
					<?php dynamic_sidebar( 'footer-after' ); ?>
				</div><!--.wrap-->
			</div><!--.site-footer-->

		<?php
	}
}
add_action( 'footer_after', 'thmfdn_after_footer_widgets' );


/**
 * Counts the number of widgets in a widget area
 *
 * @since 1.0
 */
function thmfdn_count_widgets( $widget_area_id ) {
	global $wp_registered_sidebars;
	$widget_areas = wp_get_sidebars_widgets();

	if( empty( $widget_areas[$widget_area_id] ) ) {
		return false;
	} else {
		return $widget_areas[$widget_area_id];
	}

}
