<?php
/**
 * The template for displaying woocommerce pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Cartel
 */

get_header(); ?>
<div id="subheader">
	<div class="container"><div class="row">
		<div class="col-md-12">
			<h2><?php _e( 'Shop', 'cartel' ); ?></h2>
			<?php woocommerce_custom_breadcrumb(); ?>
		</div>
	</div></div>
</div>

<div class="container"><div class="row">

<div class="col-md-12">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			

				<?php woocommerce_content(); ?>

			

		</main><!-- #main -->
	</div><!-- #primary -->
</div>

</div></div>
<?php get_footer(); ?>
