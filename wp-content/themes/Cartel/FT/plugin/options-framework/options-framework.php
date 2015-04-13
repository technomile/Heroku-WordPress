<?php
/**
 * Options Framework
 *
 * @package   Options Framework
 * @author    Devin Price <devin@wptheming.com>
 * @license   GPL-2.0+
 * @link      http://wptheming.com
 * @copyright 2013 WP Theming
 *
 * @wordpress-plugin
 * Plugin Name: Options Framework
 * Plugin URI:  http://wptheming.com
 * Description: A framework for building theme options.
 * Version:     1.8.0
 * Author:      Devin Price
 * Author URI:  http://wptheming.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: optionsframework
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) )
	die;

function ft_op_init()
{
	if (!file_exists(get_template_directory() . '/ft-options.php'))
			return;

	//  If user can't edit theme options, exit
	if ( !current_user_can( 'edit_theme_options' ) )
			return;

	// Load translation files
	load_plugin_textdomain( 'ft_optionsframework', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	// Loads the required Options Framework classes.
	require plugin_dir_path( __FILE__ ) . 'includes/class-options-framework.php';
	require plugin_dir_path( __FILE__ ) . 'includes/class-options-framework-admin.php';
	require plugin_dir_path( __FILE__ ) . 'includes/class-options-interface.php';
	require plugin_dir_path( __FILE__ ) . 'includes/class-options-media-uploader.php';
	require plugin_dir_path( __FILE__ ) . 'includes/class-options-sanitization.php';

	// Instantiate the main plugin class.
	$options_framework = new FT_OP;
	$options_framework->init();

	// Instantiate the options page.
	$options_framework_admin = new FT_OP_Admin;
	$options_framework_admin->init();

	// Instantiate the media uploader class
	$options_framework_media_uploader = new FT_OP_Media_Uploader;
	$options_framework_media_uploader->init();
}
add_action('init', 'ft_op_init', 20);

/**
 * Helper function to return the theme option value.
 * If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * Not in a class to support backwards compatibility in themes.
 */
if ( ! function_exists( 'ft_all_option' ) ) {
	function ft_all_option()
	{
		return get_option('ft_op');
	}
}
if ( ! function_exists( 'ft_of_get_option' ) ) {
	function ft_of_get_option( $name, $default = false )
	{
			$config = ft_all_option();

			if ( ! isset( $config['id'] ) )
				return $default;

			$options = get_option( $config['id'] );

			if ( isset( $options[$name] ) )
				return $options[$name];

			return $default;
	}
}