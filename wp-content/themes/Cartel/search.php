<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Cartel
 */

get_header(); ?>
<div id="subheader">
	<div class="container"><div class="row">
		<div class="col-md-12">
			<h2><?php printf( __( 'Search Results for: %s', 'cartel' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
			<?php woocommerce_custom_breadcrumb(); ?>
		</div>
	</div></div>
</div>


<div class="container"><div class="row">
<div class="col-md-8">
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>


			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'search' ); ?>

			<?php endwhile; ?>

			<?php if (function_exists('wp_pagenavi')){ wp_pagenavi(); } ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->
</div>

<div class="col-md-4">
	<?php get_sidebar(); ?>
</div>	

</div></div>
<?php get_footer(); ?>
