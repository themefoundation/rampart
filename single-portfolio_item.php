<?php
/**
 * Single portfolio item template
 *
 * @package Rampart
 * @since 1.0
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
					<?php if ( has_post_thumbnail() ) { ?>
						<?php the_post_thumbnail( 'custom-content-portfolio-single' ); ?>
					<?php } ?>

					<h1 class="entry-title">
						<?php the_title(); ?>
					</h1>

					<?php $portfolio_item_url = get_post_meta( $post->ID, 'portfolio_item_url', true ); ?>
					<?php if ( !empty( $portfolio_item_url ) ) { ?>
						<div class="entry-meta entry-meta-top">
							<span class="portfolio-item-url"><a href="<?php echo $portfolio_item_url; ?>"><?php echo $portfolio_item_url; ?></a></span>
						</div><!--.entry-meta-top-->
					<?php } ?>

					<div class="entry-content">
						<?php the_content(); ?>
					</div><!--.entry-content-->

					<?php if ( is_array( get_the_terms( $post->ID, 'portfolio' ) ) ) { ?>
						<div class="entry-meta entry-meta-bottom">
							<span class="portfolio-item-url"><?php echo get_the_term_list( $post->ID, 'portfolio' ); ?></span>
						</div><!--.entry-meta-bottom-->
					<?php } ?>

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