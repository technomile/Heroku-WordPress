<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Cartel
 */

get_header(); ?>

<div id="subheader">
	<div class="container"><div class="row">
		<div class="col-md-12">
			<h2><?php _e( 'Page not found', 'cartel' ); ?></h2>
			<?php woocommerce_custom_breadcrumb(); ?>
		</div>
	</div></div>
</div>


<div class="container"><div class="row">

<div class="col-md-12">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'cartel' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. ', 'cartel' ); ?></p>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->
</div>
</div></div>
<?php get_footer(); ?>