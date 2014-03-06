<?php
/**
 * Footer template
 *
 * @package Rampart
 * @since 1.0
 */
?>

			</div><!--.wrap-->
		</div><!--#main-->

		<?php do_action( 'footer_before' ); ?>
			<div id="footer" class="site-footer">
				<div class="wrap">
					<?php do_action( 'footer_top' ); ?>

					<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'fallback_cb' => '', 'items_wrap' => '<ul id="%1$s" class="%2$s" role="navigation">%3$s</ul>' ) ); ?>

					<?php echo apply_filters( 'site_credits', '<p class="site-credits">&copy;  <a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo('name') . '</a></p>' ); ?>

					<?php do_action( 'footer_bottom' ); ?>
				</div><!--.wrap-->
			</div><!--#footer-->
		<?php do_action( 'footer_after' ); ?>

	</div><!--#page-->

	<?php wp_footer(); ?>

</body>
</html>