<?php
/*
Plugin Name: SendGrid
Plugin URI: http://wordpress.org/plugins/sendgrid-email-delivery-simplified/
Description: Email Delivery. Simplified. SendGrid's cloud-based email infrastructure relieves businesses of the cost and complexity of maintaining custom email systems. SendGrid provides reliable delivery, scalability and real-time analytics along with flexible APIs that make custom integration a breeze.
Version: 1.5.1
Author: SendGrid
Author URI: http://sendgrid.com
License: GPLv2
*/

$plugin = plugin_basename( __FILE__ );

if ( version_compare( phpversion(), '5.3.0', '<' ) ) {
  add_action( 'admin_notices', 'php_version_error' );
  
  /**
  * Display the notice if PHP version is lower than plugin need
  *
  * return void
  */
  function php_version_error()
  {
    echo '<div class="error"><p>'.__('SendGrid: Plugin require PHP >= 5.3.0.') . '</p></div>';
  }
} else {
  require_once plugin_dir_path( __FILE__ ) . '/lib/class-sendgrid-tools.php';
  require_once plugin_dir_path( __FILE__ ) . '/lib/class-sendgrid-settings.php';
  require_once plugin_dir_path( __FILE__ ) . '/lib/class-sendgrid-statistics.php';
  require_once plugin_dir_path( __FILE__ ) . '/lib/overwrite-sendgrid-methods.php';
  require_once plugin_dir_path( __FILE__ ) . '/lib/class-sendgrid-smtp.php';

  // Initialize SendGrid Settings
  new Sendgrid_Settings( $plugin );

  // Initialize SendGrid Statistics
  new Sendgrid_Statistics();
}
