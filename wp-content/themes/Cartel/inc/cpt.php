<?php 

if ( ! function_exists('slide_post') ) {

// Register Custom Post Type
function slide_post() {

	$labels = array(
		'name'                => _x( 'Slides', 'Post Type General Name', 'cartel' ),
		'singular_name'       => _x( 'Post Type', 'Post Type Singular Name', 'cartel' ),
		'menu_name'           => __( 'Slides', 'cartel' ),
		'parent_item_colon'   => __( 'Parent Item:', 'cartel' ),
		'all_items'           => __( 'All Slides', 'cartel' ),
		'view_item'           => __( 'View Slide', 'cartel' ),
		'add_new_item'        => __( 'Add New Slide', 'cartel' ),
		'add_new'             => __( 'Add New', 'cartel' ),
		'edit_item'           => __( 'Edit Slide', 'cartel' ),
		'update_item'         => __( 'Update Slide', 'cartel' ),
		'search_items'        => __( 'Search Slide', 'cartel' ),
		'not_found'           => __( 'Not found', 'cartel' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'cartel' ),
	);
	$args = array(
		'label'               => __( 'slide', 'cartel' ),
		'description'         => __( 'Slide item', 'cartel' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => false,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-images-alt2',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'slide', $args );

}

// Hook into the 'init' action
add_action( 'init', 'slide_post', 0 );

}