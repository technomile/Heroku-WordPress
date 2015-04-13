<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Cartel
 */

get_header(); ?>

<div id="subheader">
	<div class="container"><div class="row">
		<div class="col-md-12">
			<h2>
						<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							printf( __( 'Author: %s', 'cartel' ), '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :
							printf( __( 'Day: %s', 'cartel' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( 'Month: %s', 'cartel' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'cartel' ) ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Year: %s', 'cartel' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'cartel' ) ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'cartel' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							_e( 'Galleries', 'cartel');

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'cartel');

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'cartel' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'cartel' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'cartel' );

						elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
							_e( 'Statuses', 'cartel' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							_e( 'Audios', 'cartel' );

						elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
							_e( 'Chats', 'cartel' );

						else :
							_e( 'Archives', 'cartel' );

						endif;
					?>
			</h2>
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

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

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
