<?php
/**
 * Header template
 *
 * @package Rampart
 * @since 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php do_action( 'head_top' ); ?>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title(); ?></title>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php do_action( 'head_bottom' ); ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<a class="skip-link" href="#content"><?php _e( 'Skip to main content', 'rampart' ); ?></a>
	<div id="page">

		<?php do_action( 'header_before' ); ?>
		<div id="header" class="site-header">
			<div class="wrap">
				<?php do_action( 'header_top' ); ?>

				<div id="branding" role="banner">
					<?php echo apply_filters( 'site_name', '<p class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo('name') . '</a></p>' ); ?>
					<?php echo apply_filters( 'site_description', '<p class="site-description">' . get_bloginfo( 'description' ) . '</p>' ); ?>
				</div><!--#branding-->

				<?php if( has_nav_menu( 'header-menu' ) ) { ?>
					<div role="navigation">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'header-menu',
								'fallback_cb' => false
							) );
						?>
					</div>
				<?php } ?>

				<?php do_action( 'header_bottom' ); ?>
			</div><!--.wrap-->
		</div><!--#header-->
		<?php do_action( 'header_after' ); ?>

		<div id="main">
			<div class="wrap">
