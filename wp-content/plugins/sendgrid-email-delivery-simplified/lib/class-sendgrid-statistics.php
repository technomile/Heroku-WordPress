<?php

class Sendgrid_Statistics
{
  public function __construct()
  {
    // Add SendGrid widget in dashboard
    add_action( 'wp_dashboard_setup', array( __CLASS__, 'add_dashboard_widget' ) );

    // Add SendGrid stats page in menu
    add_action( 'admin_menu', array( __CLASS__, 'add_statistics_menu' ) );

    // Add SendGrid javascripts in header
    add_action( 'admin_enqueue_scripts', array( __CLASS__, 'add_headers' ) );

    // Add SendGrid page for get statistics through ajax
    add_action( 'wp_ajax_sendgrid_get_stats', array( __CLASS__, 'get_ajax_statistics' ) );
  }

  /**
   * Verify if SendGrid username and password provided are correct and
   * initialize function for add widget in dashboard
   *
   * @return void
   */
  public static function add_dashboard_widget()
  {
    if ( ! Sendgrid_Tools::check_username_password( Sendgrid_Tools::get_username(), Sendgrid_Tools::get_password() ) ) {
      return;
    }

    add_meta_box( 'sendgrid_statistics_widget', 'SendGrid Wordpress Statistics', array( __CLASS__, 'show_dashboard_widget' ),
      'dashboard', 'normal', 'high' );
  }

  /**
   * Display SendGrid widget content
   *
   * @return void
   */
  public static function show_dashboard_widget()
  {
    require plugin_dir_path( __FILE__ ) . '../view/partials/sendgrid_stats_widget.php';
  }

  /**
   * Add SendGrid statistics page in the menu
   *
   * @return void
   */
  public static function add_statistics_menu()
  {
    if ( ! Sendgrid_Tools::check_username_password( Sendgrid_Tools::get_username(), Sendgrid_Tools::get_password() ) ) {
      return;
    }

    add_dashboard_page( "SendGrid Statistics", "SendGrid Statistics", "manage_options", "sendgrid-statistics",
      array( __CLASS__, "show_statistics_page" ) );
  }

  /**
   * Display SendGrid statistics page
   *
   * @return void
   */
  public static function show_statistics_page()
  {
    require plugin_dir_path( __FILE__ ) . '../view/sendgrid_stats.php';
  }

  /**
   * Include css & javascripts we need for SendGrid statistics page and widget
   *
   * @return void;
   */
  public static function add_headers( $hook )
  {
    if ( "index.php" != $hook && SENDGRID_PLUGIN_STATISTICS != $hook ) {
      return;
    }

    // Javascript
    wp_enqueue_script( 'sendgrid-stats', plugin_dir_url( __FILE__ ) . '../view/js/sendgrid.stats.js', array('jquery') );
    wp_enqueue_script( 'jquery-flot', plugin_dir_url( __FILE__ ) . '../view/js/jquery.flot.js', array('jquery') );
    wp_enqueue_script( 'jquery-flot-time', plugin_dir_url( __FILE__ ) . '../view/js/jquery.flot.time.js', array('jquery') );
    wp_enqueue_script( 'jquery-flot-tofflelegend', plugin_dir_url( __FILE__ ) . '../view/js/jquery.flot.togglelegend.js', array('jquery') );
    wp_enqueue_script( 'jquery-flot-symbol', plugin_dir_url( __FILE__ ) . '../view/js/jquery.flot.symbol.js', array('jquery') );
    wp_enqueue_script('jquery-ui-datepicker', plugin_dir_url( __FILE__ ) . '../view/js/jquery.ui.datepicker.js', array('jquery', 'jquery-ui-core') );

    // CSS
    wp_enqueue_style( 'jquery-ui-datepicker', plugin_dir_url( __FILE__ ) . '../view/css/datepicker/smoothness/jquery-ui-1.10.3.custom.css' );
    wp_enqueue_style( 'sendgrid', plugin_dir_url( __FILE__ ) . '../view/css/sendgrid.css' );

    wp_localize_script( 'sendgrid-stats', 'sendgrid_vars',
      array(
        'sendgrid_nonce' => wp_create_nonce('sendgrid-nonce')
      )
    );
  }

  /**
   * Get SendGrid stats from API and return JSON response,
   * this function work like a page and is used for ajax request by javascript functions
   *
   * @return void;
   */
  public static function get_ajax_statistics()
  {
    if ( ! isset( $_POST['sendgrid_nonce'] ) || ! wp_verify_nonce( $_POST['sendgrid_nonce'], 'sendgrid-nonce') ) {
      die( 'Permissions check failed' );
    }

    $parameters = array();
    $parameters['api_user']  = Sendgrid_Tools::get_username();
    $parameters['api_key']   = Sendgrid_Tools::get_password();
    $parameters['data_type'] = 'global';
    $parameters['metric']    = 'all';

    if ( array_key_exists( 'days', $_POST ) ) {
      $parameters['days'] = $_POST['days'];
    } else {
      $parameters['start_date'] = $_POST['start_date'];
      $parameters['end_date']   = $_POST['end_date'];
    }

    if ( $_POST['type'] && 'general' != $_POST['type'] ) {
      if( 'wordpress' == $_POST['type'] ) {
        $parameters['category'] = 'wp_sendgrid_plugin';
      } else {
        $parameters['category'] = urlencode( $_POST['type'] );
      }
    }

    echo Sendgrid_Tools::curl_request( 'api/stats.get.json', $parameters );

    die();
  }

}
