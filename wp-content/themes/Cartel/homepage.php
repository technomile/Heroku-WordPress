<?php
/**
 * The template for displaying homepage.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 Template name: Homepage
 *
 * @package Cartel
 */
 
get_header(); ?>
 
<!-- slideshow  -->
<div class="home-slideshow">
<div class="flexslider">
<ul class="slides">
<?php

$slidecount = ft_of_get_option('slide_number','4');

$args = array( 'posts_per_page' => $slidecount, 'post_type' => 'slide');
$myposts = get_posts( $args );
foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
<?php $slidelink = get_post_meta($post->ID, '_slide_link', true); ?>
<li>

	
		<?php 
		$thumb = get_post_thumbnail_id();
		$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
		$image = aq_resize( $img_url, 1280, 500, true ); //resize & crop the image
		?>
		<?php if($image) : ?>
			<a href="<?php echo $slidelink ?>"><img src="<?php echo $image ?>" alt="<?php the_title(); ?>" /></a>
		<?php endif; ?>
		
		<div class="container"><div class="row">
		<div class="col-md-8">
			<div class="flex-caption">
				
				<h2> <?php the_title(); ?> </h2>
				<span> <?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?> </span>
				
			</div>
				
			</div>
		</div></div>
		
</li>

<?php endforeach; 
wp_reset_postdata();?>
</ul>
</div>
</div>

<!-- slideshow  -->


<!-- Features -->
<div class="home-features"><div class="container"><div class="row">
	<?php if ( ! dynamic_sidebar( 'home-widget' ) ) : ?>	<?php endif; // end sidebar widget area ?>
</div></div></div>
<!-- Features -->


<!-- Banners -->
<div class="home-banners"><div class="container"><div class="row">
	<div class="col-sm-4">
		<?php $imgurl = ft_of_get_option('banner_image1',''); ?>
		<a href="<?php echo ft_of_get_option('banner_link1',''); ?>">  <img src="<?php echo aq_resize(  $imgurl , 720, 400, true ) ?>" alt="banner" /> </a> 
	</div>
	<div class="col-sm-4">
	<?php $imgurl = ft_of_get_option('banner_image2',''); ?>
		<a href="<?php echo ft_of_get_option('banner_link2',''); ?>">  <img src="<?php echo aq_resize(  $imgurl , 720, 400, true ) ?>" alt="banner" /> </a>
	</div>
	<div class="col-sm-4">
	<?php $imgurl = ft_of_get_option('banner_image3',''); ?>
		<a href="<?php echo ft_of_get_option('banner_link3',''); ?>">  <img src="<?php echo aq_resize(  $imgurl , 720, 400, true ) ?>" alt="banner" />  </a>
	</div>	
</div></div></div>
<!-- Banners -->


<!-- Products -->
<div class="home-products"><div class="container"><div class="row">
	<div class="col-md-12">
		<div class="sec-title">
			<h2><?php _e( 'Top rated products', 'cartel' ); ?></h2>
			<span> <?php _e( 'Checkout the most trending items in our shop', 'cartel' ); ?> </span>
		</div>
		<?php  echo do_shortcode("[top_rated_products per_page='4']"); ?>
	</div>
	
	<div class="col-md-12">
		<div class="sec-title">
			<h2><?php _e( 'Latest products', 'cartel' ); ?></h2>
			<span> <?php _e( 'Checkout the latest arrivals in our shop', 'cartel' ); ?> </span>
		</div>
			<?php  echo do_shortcode("[recent_products per_page='4']"); ?>
	</div>
	
</div></div></div>
<!-- Products -->


<!-- Blog posts -->
<div class="home-blog"><div class="container"><div class="row">
	<div class="col-md-12"> 
		<div class="sec-title">
			<h2><?php _e( 'From the blog', 'cartel' ); ?></h2>	
			<span> <?php _e( 'Latest news and articles from our blog', 'cartel' ); ?> </span>
		</div>
	</div>

<?php
$args = array( 'posts_per_page' => 3);
$myposts = get_posts( $args );
foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
	<div class="col-sm-4 home-post">
		<div class="homepost-content">
		<?php 
		$thumb = get_post_thumbnail_id();
		$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
		$image = aq_resize( $img_url, 720, 400, true ); //resize & crop the image
		?>
		<?php if($image) : ?>
			<a href="<?php the_permalink(); ?>"><img src="<?php echo $image ?>" alt="<?php the_title(); ?>" /></a>
		<?php endif; ?>
		<div class="homepost-entry">
			<h3> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h3>
			<div class="entry-meta">
				<?php cartel_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php the_excerpt(); ?>
		</div>
		
			
		</div>
	
</div>
<?php endforeach; 
wp_reset_postdata();?>
</div></div></div>
<!-- Blog posts -->


<!-- Testimonials -->
<div class="home-testimonials"><div class="container"><div class="row">
	<?php $testim = ft_of_get_option('testim_number',''); ?>
	<?php if ( shortcode_exists( 'woothemes_testimonials' ) ) { 
		do_action( 'woothemes_testimonials', array( 'limit' => $testim,'size' => 80, 'orderby' => 'date' ) );
	} ?> 
	
	
</div></div></div>
<!-- Testimonials -->

<?php get_footer(); ?>
