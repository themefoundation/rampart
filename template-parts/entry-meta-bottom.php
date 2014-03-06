<?php
/**
 * Entry meta bottom
 *
 * Displays post meta information below post content.
 *
 * @package Rampart
 * @since 1.0
 */
?>
<div class="entry-meta entry-meta-bottom">
	<span class="the-author-posts-link">
		<?php _e( 'Author:', 'rampart' ); ?>
		<?php the_author_posts_link(); ?>
	</span>
	<span class="the-category">
		<?php _e( 'Posted in: ', 'rampart' ); ?>
		<?php the_category( ',' ); ?>
	</span>
	<span class="the-tags">
		<?php the_tags(); ?>
	</span>
</div><!--.entry-meta-top-->