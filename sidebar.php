<?php
/**
 * Sidebar template
 *
 * @package Rampart
 * @since 1.0
 */
?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>

	<?php do_action( 'sidebars_before' ); ?>
	<div id="secondary" class="sidebar" role="complementary">
		<?php do_action( 'sidebar_top' ); ?>

		<?php dynamic_sidebar( 'sidebar-1' ); ?>

		<?php do_action( 'sidebar_bottom' ); ?>
	</div><!-- #sidebar-->

<?php } ?>

<?php if ( is_active_sidebar( 'sidebar-2' ) ) { ?>

	<div id="tertiary" class="sidebar" role="complementary">
		<?php do_action( 'sidebar_top' ); ?>

		<?php dynamic_sidebar( 'sidebar-2' ); ?>

		<?php do_action( 'sidebar_bottom' ); ?>
	</div><!-- #sidebar-->

<?php } ?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>

	<?php do_action( 'sidebars_after' ); ?>

<?php }
