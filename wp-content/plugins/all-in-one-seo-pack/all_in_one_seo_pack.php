<?php
/*
Plugin Name: All In One SEO Pack
Plugin URI: http://semperfiwebdesign.com
Description: Out-of-the-box SEO for your WordPress blog. <a href="admin.php?page=all-in-one-seo-pack/aioseop_class.php">Options configuration panel</a> | <a href="http://semperplugins.com/plugins/all-in-one-seo-pack-pro-version/?loc=plugins" target="_blank">Upgrade to Pro Version</a> | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=mrtorbert%40gmail%2ecom&item_name=All%20In%20One%20SEO%20Pack&item_number=Support%20Open%20Source&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8">Donate</a> | <a href="http://semperplugins.com/support/" >Support</a> |  <a href="https://www.amazon.com/wishlist/1NFQ133FNCOOA/ref=wl_web" target="_blank" title="Amazon Wish List">Amazon Wishlist</a>
Version: 2.2.5.1
Author: Michael Torbert
Author URI: http://michaeltorbert.com
*/

/*
Copyright (C) 2008-2014 Michael Torbert, semperfiwebdesign.com (michael AT semperfiwebdesign DOT com)
Original code by uberdose of uberdose.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

//register_activation_hook(__FILE__,'aioseop_activate_pl');

/**
 * @package All-in-One-SEO-Pack
 * @version 2.2.5.1
 */

global $aioseop_plugin_name;
$aioseop_plugin_name = 'All in One SEO Pack';
if ( ! defined( 'AIOSEOP_PLUGIN_NAME' ) )
    define( 'AIOSEOP_PLUGIN_NAME', $aioseop_plugin_name );

if ( ! defined( 'AIOSEOP_VERSION' ) )
    define( 'AIOSEOP_VERSION', '2.2.5.1' );

if ( ! defined( 'AIOSEOP_PLUGIN_DIR' ) ) {
    define( 'AIOSEOP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
} elseif ( AIOSEOP_PLUGIN_DIR != plugin_dir_path( __FILE__ ) ) {
	add_action( 'admin_notices', create_function( '', 'echo "' . "<div class='error'>" . sprintf(
				__( "%s detected a conflict; please deactivate the plugin located in %s.", 'all_in_one_seo_pack' ),
				$aioseop_plugin_name, AIOSEOP_PLUGIN_DIR ) . "</div>" . '";' ) );
	return;
}

if ( ! defined( 'AIOSEOP_PLUGIN_BASENAME' ) )
    define( 'AIOSEOP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

if ( ! defined( 'AIOSEOP_PLUGIN_DIRNAME' ) )
    define( 'AIOSEOP_PLUGIN_DIRNAME', dirname( AIOSEOP_PLUGIN_BASENAME ) );

if ( ! defined( 'AIOSEOP_PLUGIN_URL' ) )
    define( 'AIOSEOP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

if ( ! defined( 'AIOSEOP_PLUGIN_IMAGES_URL' ) )
    define( 'AIOSEOP_PLUGIN_IMAGES_URL', AIOSEOP_PLUGIN_URL . 'images/' );

if ( ! defined( 'AIOSEOP_BASELINE_MEM_LIMIT' ) )
	define( 'AIOSEOP_BASELINE_MEM_LIMIT', 268435456 ); // 256MB

if ( ! defined( 'WP_CONTENT_URL' ) )
    define( 'WP_CONTENT_URL', site_url() . '/wp-content' );
if ( ! defined( 'WP_ADMIN_URL' ) )
    define( 'WP_ADMIN_URL', site_url() . '/wp-admin' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
    define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
    define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
    define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

global $aiosp, $aioseop_options, $aioseop_modules, $aioseop_module_list, $aiosp_activation, $aioseop_mem_limit, $aioseop_get_pages_start, $aioseop_admin_menu;
$aioseop_get_pages_start = $aioseop_admin_menu = 0;

$aioseop_options = get_option( 'aioseop_options' );

$aioseop_mem_limit = @ini_get( 'memory_limit' );

if ( !function_exists( 'aioseop_convert_bytestring' ) ) {
	function aioseop_convert_bytestring( $byteString ) {
		$num = 0;
		preg_match( '/^\s*([0-9.]+)\s*([KMGTPE])B?\s*$/i', $byteString, $matches );
		if ( !empty( $matches ) ) {
			$num = ( float )$matches[1];
			switch ( strtoupper( $matches[2] ) ) {
				case 'E': $num = $num * 1024;
				case 'P': $num = $num * 1024;
				case 'T': $num = $num * 1024;
				case 'G': $num = $num * 1024;
				case 'M': $num = $num * 1024;
				case 'K': $num = $num * 1024;
			}
		}
		return intval( $num );
	}
}

if ( is_array( $aioseop_options ) && isset( $aioseop_options['modules'] ) && isset( $aioseop_options['modules']['aiosp_performance_options'] ) ) {
	$perf_opts = $aioseop_options['modules']['aiosp_performance_options'];
	if ( isset( $perf_opts['aiosp_performance_memory_limit'] ) )
		$aioseop_mem_limit = $perf_opts['aiosp_performance_memory_limit'];
	if ( isset( $perf_opts['aiosp_performance_execution_time'] ) && ( $perf_opts['aiosp_performance_execution_time'] !== '' ) ) {
		@ini_set( 'max_execution_time', (int)$perf_opts['aiosp_performance_execution_time'] );
		@set_time_limit( (int)$perf_opts['aiosp_performance_execution_time'] );
	}
} else {
	$aioseop_mem_limit = aioseop_convert_bytestring( $aioseop_mem_limit );
	if ( ( $aioseop_mem_limit > 0 ) && ( $aioseop_mem_limit < AIOSEOP_BASELINE_MEM_LIMIT ) )
		$aioseop_mem_limit = AIOSEOP_BASELINE_MEM_LIMIT;
}

if ( !empty( $aioseop_mem_limit ) ) {
	if ( !is_int( $aioseop_mem_limit ) )
		$aioseop_mem_limit = aioseop_convert_bytestring( $aioseop_mem_limit );
	if ( ( $aioseop_mem_limit > 0 ) && ( $aioseop_mem_limit <= AIOSEOP_BASELINE_MEM_LIMIT ) )
		@ini_set( 'memory_limit', $aioseop_mem_limit );
}

$aiosp_activation = false;
$aioseop_module_list = Array( 'sitemap', 'opengraph', 'robots', 'file_editor', 'importer_exporter', 'performance' ); // list all available modules here

if ( class_exists( 'All_in_One_SEO_Pack' ) ) {
	add_action( 'admin_notices', create_function( '', 'echo "<div class=\'error\'>The All In One SEO Pack class is already defined";'
	. "if ( class_exists( 'ReflectionClass' ) ) { \$r = new ReflectionClass( 'All_in_One_SEO_Pack' ); echo ' in ' . \$r->getFileName(); } "
	. ' echo ", preventing All In One SEO Pack from loading.</div>";' ) );
	return;	
}

/**
 * Check if we just got activated.
 */
if ( !function_exists( 'aioseop_activate' ) ) {
	function aioseop_activate() {
	  global $aiosp_activation;
	  $aiosp_activation = true;
	  delete_transient( "aioseop_oauth_current" );
	}
}

register_activation_hook( __FILE__, 'aioseop_activate' );

add_action( 'plugins_loaded', 'aioseop_init_class' );

if ( !function_exists( 'aioseop_init_class' ) ) {
	function aioseop_init_class() {
		global $aiosp;
		require_once( AIOSEOP_PLUGIN_DIR . 'aioseop_functions.php' );
		require_once( AIOSEOP_PLUGIN_DIR . 'aioseop_class.php' );
		$aiosp = new All_in_One_SEO_Pack();
		
		if ( aioseop_option_isset( 'aiosp_unprotect_meta' ) )
			add_filter( 'is_protected_meta', 'aioseop_unprotect_meta', 10, 3 );
		
		add_action( 'init', array( $aiosp, 'add_hooks' ) );
		
		if ( defined( 'DOING_AJAX' ) && !empty( $_POST ) && !empty( $_POST['action'] ) && ( $_POST['action'] === 'aioseop_ajax_scan_header' ) ) {
			remove_action( 'init', array( $aiosp, 'add_hooks' ) );
			add_action('admin_init', 'aioseop_scan_post_header' );
			add_action('shutdown', 'aioseop_ajax_scan_header' ); // if the action doesn't run -- pdb
			include_once(ABSPATH . 'wp-admin/includes/screen.php');
			global $current_screen;
			if ( class_exists( 'WP_Screen' ) )
				$current_screen = WP_Screen::get( 'front' );
		}
	}
}

add_action( 'init', 'aioseop_load_modules', 1 );
//add_action( 'after_setup_theme', 'aioseop_load_modules' );

if ( is_admin() ) {
	add_action( 'wp_ajax_aioseop_ajax_save_meta',	'aioseop_ajax_save_meta' );
	add_action( 'wp_ajax_aioseop_ajax_save_url',	'aioseop_ajax_save_url' );
	add_action( 'wp_ajax_aioseop_ajax_delete_url',	'aioseop_ajax_delete_url' );
	add_action( 'wp_ajax_aioseop_ajax_scan_header',	'aioseop_ajax_scan_header' );
	add_action( 'wp_ajax_aioseop_ajax_save_settings', 'aioseop_ajax_save_settings');
	add_action( 'wp_ajax_aioseop_ajax_get_menu_links', 'aioseop_ajax_get_menu_links');
}
	
if ( !function_exists( 'aioseop_scan_post_header' ) ) {
	function aioseop_scan_post_header() {
		require_once( ABSPATH . WPINC . '/default-filters.php' );
		global $wp_query;
		$wp_query->query_vars['paged'] = 0;
		query_posts('post_type=post&posts_per_page=1');
		if (have_posts()) the_post();
	}
}