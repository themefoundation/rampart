<?php

/**
 * Single page template with no sidebars and full width content
 *
 * @package Rampart
 * @since 1.0
 */

/*
Template Name: Full Width
*/
?>

<?php get_header(); ?>

<div id="primary">
	<?php do_action( 'content_before' ); ?>

	<div id="content" role="main">
		<?php do_action( 'content_top' ); ?>

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1 class="entry-title">
						<?php the_title(); ?>
					</h1>
					
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!--.entry-content-->
				</div>

			<?php endwhile; ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/404' ); ?>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/nav', 'single' ); ?>

		<?php do_action( 'content_bottom' ); ?>
	</div><!-- #content -->
	
	<?php do_action( 'content_after' ); ?>
</div><!-- #primary -->

<?php get_footer(); ?>