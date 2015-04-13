<?php

add_theme_support( 'woocommerce' );

add_filter( 'woocommerce_enqueue_styles', '__return_false' );



/* Declare new image sizes */
/* ---------------------------------------------- */

global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'shopp_woocommerce_image_dimensions', 1 );
 
function shopp_woocommerce_image_dimensions() {
  	$catalog = array(
		'width' 	=> '320',	// px
		'height'	=> '400',	// px
		'crop'		=> 1 		// true
	);
 
	$single = array(
		'width' 	=> '500',	// px
		'height'	=> '999',	// px
		'crop'		=> 0 		// false
	);
 
	$thumbnail = array(
		'width' 	=> '120',	// px
		'height'	=> '120',	// px
		'crop'		=> 0 		// false
	);
 
	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}


/* Breadcrumbs */
/* ---------------------------------------------- */


function woocommerce_custom_breadcrumb(){
	if (function_exists('woocommerce_breadcrumb')){
    woocommerce_breadcrumb();}
}

add_action( 'woo_custom_breadcrumb', 'woocommerce_custom_breadcrumb' );

add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs' );

function jk_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => ' &#47; ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
        );
}





/* Set number of product columns to 4 */
/* ---------------------------------------------- */


add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 4; //4 products per row
	}
}


/* Change upsell count to 4 */
/* ---------------------------------------------- */

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );
 
if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
	function woocommerce_output_upsells() {
	    woocommerce_upsell_display( 4,4 ); // Display 4 products in rows of 4
	}
}




/* Set products per page */
/* ---------------------------------------------- */

$perpage = 12;
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.$perpage.';' ), 20 );




/* Dump woocommerce pagination for wp_pagenavi */
/* ---------------------------------------------- */

remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
 
function woocommerce_pagination(){
   if (function_exists('wp_pagenavi')){ wp_pagenavi(); }

}
add_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);



/* Add to cart move */

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10);


/* Product page */
/* ---------------------------------------------- */

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title',5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price',10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt',20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart',30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta',40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing',50);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title',5);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price',20);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt',10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart',30);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta',40);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing',50); 