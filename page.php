<?php
/**
 * Single page template
 *
 * @package Rampart
 * @since 1.0
 */
?>

<?php get_header(); ?>

<div id="primary">
	<?php do_action( 'content_before' ); ?>

	<div id="content" role="main" itemprop="mainContentOfPage">
		<?php do_action( 'content_top' ); ?>

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1 class="entry-title" itemprop="headline">
						<?php the_title(); ?>
					</h1>
					
					<div class="entry-content" itemprop="text">
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

<?php get_sidebar(); ?>
<?php get_footer(); ?>