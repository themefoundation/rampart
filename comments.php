<?php
/**
 * Comments template
 *
 * @package Rampart
 * @since 1.0
 */

// Exits if password is required, but has not been entered.
if ( post_password_required() ) {
	return;
}

?>

<div id="comments">
	<?php if ( have_comments() ) { ?>

		<h2 class="comments-title">
			<?php
				printf(
					_n(
						'One Comment on %2$s',
						'%1$s Comments on %2$s',
						get_comments_number(),
						'rampart'
					),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h2>

		<ol class="comment-list">
			<?php echo wp_list_comments(); ?>
		</ol><!-- .comment-list -->

		<div class="comment-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
			<?php paginate_comments_links(); ?>
		</div>

	<?php } ?>

	<?php if ( !comments_open() && get_comments_number() ) { ?>
		<p class="no-comments">
			<?php _e( 'Comments are closed', 'rampart' ); ?>
		</p>
	<?php } ?>

	<?php comment_form(); ?>
</div>
