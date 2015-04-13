<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Cartel
 */
?>
	<div id="secondary" class="sidebar-widgets" role="complementary">
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>	<?php endif; // end sidebar widget area ?>
		<?php get_template_part( 'sponsors' ); ?>
	</div><!-- #secondary -->
