<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Cartel
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site">

	<header id="masthead" class="site-header" role="banner">
	
		<div class="topbar">
			<div class="container"><div class="row">
				<div class="col-xs-6 top-left">
					<?php echo ft_of_get_option('header_text','Enter some info here'); ?>
				</div>
				<div class="col-xs-6 top-right">
					<?php wp_loginout(); ?> 
					<?php if ( !is_user_logged_in() ) { ?>
					<a href="<?php echo wp_registration_url(); ?>" title="Register"><?php _e('Register','cartel'); ?></a>
					<?php } ?>
				</div>
			</div></div>
		</div> <!-- end-topbar -->
			
		<div class="midhead">
			<div class="container"><div class="row"><div class="col-md-12">
			
				<div class="site-branding">

	<?php if (get_theme_mod(FT_scope::tool()->optionsName . '_logo', '') != '') { ?>
				<h1 class="site-title logo"><a class="mylogo" rel="home" href="<?php bloginfo('siteurl');?>/" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><img relWidth="<?php echo intval(get_theme_mod(FT_scope::tool()->optionsName . '_maxWidth', 0)); ?>" relHeight="<?php echo intval(get_theme_mod(FT_scope::tool()->optionsName . '_maxHeight', 0)); ?>" id="ft_logo" src="<?php echo get_theme_mod(FT_scope::tool()->optionsName . '_logo', ''); ?>" alt="" /></a></h1>
	<?php } else { ?>
				<h1 class="site-title logo"><a id="blogname" rel="home" href="<?php bloginfo('siteurl');?>/" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
	<?php } ?>

					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</div>
				
				<div class="topcart">
					<?php if (class_exists('WooCommerce_Widget_DropdownCart')): ?>
						<?php the_widget( 'WooCommerce_Widget_DropdownCart' ); ?> 
					<?php endif; ?>
				</div>
				
			</div></div></div>
		</div> <!-- end-midhead -->
		
		<div class="main-menu">
			<div class="container"><div class="row">
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary','menu_id' => 'cartel' ) ); ?>
				</nav><!-- #site-navigation -->
				<div class="search-button">
					<i class="fa fa-search"></i>
				</div>
			</div></div>
		</div> <!-- end-main-menu -->
		
		<div class="search-box">
			<div class="container"><div class="row"><div class="col-md-12">
				<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
				
					<input type="search" class="search-field" placeholder="Type and hit Enter to search" value="" name="s" title="Search for:" />
				
				</form>
			</div></div></div>
		</div>
		
	</header><!-- #masthead -->

	<div id="content" class="site-content">
