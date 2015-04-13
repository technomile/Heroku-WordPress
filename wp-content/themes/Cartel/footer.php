<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Cartel
 */
?>

	</div><!-- #content -->
	
	<div id="footer-widget-area">
		<div class="container"><div class="row">
			<?php if ( ! dynamic_sidebar( 'footer-widget' ) ) : ?>		<?php endif; // end  widget area ?>
		</div></div>
	</div>
	
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container"><div class="row">
			<div class="site-info col-md-6">
				Copyright &copy; <?php echo date('Y');?> <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> - <?php bloginfo('description'); ?>.-
				<?php fflink(); ?> | <a href="http://fabthemes.com/<?php echo FT_scope::tool()->themeName ?>/" ><?php echo FT_scope::tool()->themeName ?> WordPress Theme</a>
			</div><!-- .site-info -->
		</div></div>

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
