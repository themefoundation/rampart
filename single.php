<?php
/**
 * Single post template
 *
 * @package Rampart
 * @since 1.0
 */
?>

<?php get_header(); ?>

<div id="primary">
	<?php do_action( 'content_before' ); ?>

	<div id="content" role="main" itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/Blog">
		<?php do_action( 'content_top' ); ?>

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
					<?php if ( has_post_thumbnail() ) { ?>
						<?php the_post_thumbnail(); ?>
					<?php } ?>

					<h1 class="entry-title" itemprop="headline">
						<?php the_title(); ?>
					</h1>

					<?php get_template_part( 'template-parts/entry', 'meta-top' ); ?>
					
					<div class="entry-content" itemprop="text">
						<?php the_content(); ?>
					</div><!--.entry-content-->

					<?php get_template_part( 'template-parts/entry', 'meta-bottom' ); ?>

					<?php comments_template(); ?> 
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