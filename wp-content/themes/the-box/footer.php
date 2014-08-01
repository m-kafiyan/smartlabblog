<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package thebox
 * @since thebox 1.0
 */
?>
		
	</div><!-- #main .site-main -->

	<!-- #colophon .site-footer -->
</div><!-- #page -->
<footer id="colophon" class="site-footer clearfix" role="contentinfo">

		<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
			<div id="tertiary" class="clearfix">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			</div>
		<?php endif; // end footer widget area ?>
		
		<p class="credits">
			<?php do_action( 'thebox_credits' ); ?>
			&copy; <?php the_time('Y') ?> by <?php bloginfo( 'name' ); ?>
			<span class="sep"> / </span>
			<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'thebox' ); ?>" rel="generator">
				<?php printf( __( 'Proudly powered by %s', 'thebox' ), 'WordPress' ); ?>
			</a>
			
		</p>

	</footer>

<?php wp_footer(); ?>

</body>
</html>