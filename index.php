<?php
/**
 * Index template
 *
 * @package Rampart
 * @since 1.0
 */
?>

<?php get_header(); ?>

<div id="primary">
	<?php do_action( 'content_before' ); ?>

	<div id="content" class="hfeed" role="main">
		<?php do_action( 'content_top' ); ?>

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( has_post_thumbnail() ) { ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a>
					<?php } ?>
					<h2 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
					</h2>
					
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!--.entry-content-->
				</div>

			<?php endwhile; ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/404' ); ?>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/nav', 'archive' ); ?>

		<?php do_action( 'content_bottom' ); ?>
	</div><!-- #content -->
	
	<?php do_action( 'content_after' ); ?>
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>