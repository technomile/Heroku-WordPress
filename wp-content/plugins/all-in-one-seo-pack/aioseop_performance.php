<?php
/**
 * @package All-in-One-SEO-Pack
 */
/**
 * The Performance class.
 */
if ( !class_exists( 'All_in_One_SEO_Pack_Performance' ) ) {
	class All_in_One_SEO_Pack_Performance extends All_in_One_SEO_Pack_Module {

		protected $module_info = Array( );

		function All_in_One_SEO_Pack_Performance( $mod ) {
			$this->name = __('Performance', 'all_in_one_seo_pack');		// Human-readable name of the plugin
			$this->prefix = 'aiosp_performance_';						// option prefix
			$this->file = __FILE__;									// the current file
			parent::__construct();
			
			$this->help_text = Array(
				"memory_limit"		=> __( "This setting allows you to raise your PHP memory limit to a reasonable value. Note: WordPress core and other WordPress plugins may also change the value of the memory limit.", 'all_in_one_seo_pack' ),
				"execution_time"	=> __( "This setting allows you to raise your PHP execution time to a reasonable value.", 'all_in_one_seo_pack' ),
				"force_rewrites"	=> __( "Use output buffering to ensure that the title gets rewritten. Enable this option if you run into issues with the title tag being set by your theme or another plugin.", 'all_in_one_seo_pack' )
			);
						
			$this->default_options = array(
					'memory_limit'		=> Array(	'name'	  => __( 'Raise memory limit',  'all_in_one_seo_pack' ),
				 						  			'default'	  => '256M', 'type' => 'select',
										  			'initial_options' => Array( 0 => __( "Use the system default", 'all_in_one_seo_pack' ), '32M' => '32MB', '64M' => '64MB', '128M' => '128MB', '256M' => '256MB' ) ),
					'execution_time'	=> Array(	'name'	  => __( 'Raise execution time',  'all_in_one_seo_pack' ),
				 						  			'default'	  => '', 'type' => 'select',
										  			'initial_options' => Array( '' => __( "Use the system default", 'all_in_one_seo_pack' ), 30 => '30s', 60 => '1m', 120 => '2m', 300 => '5m', 0 => __( 'No limit', 'all_in_one_seo_pack' ) ) )
				 );

			$this->help_anchors = Array(
				'memory_limit'   => '#raise-memory-limit',
				'execution_time' => '#raise-execution-time',
				'force_rewrites' => '#force-rewrites'
			);
			
			global $aiosp, $aioseop_options;
			if ( aioseop_option_isset( 'aiosp_rewrite_titles' ) && $aioseop_options['aiosp_rewrite_titles'] ) {
				$this->default_options['force_rewrites']	= Array(
								'name' => __( 'Force Rewrites:', 'all_in_one_seo_pack' ), 
								'default' => 1, 'type' => 'radio',
								'initial_options' => Array( 1 => __( 'Enabled', 'all_in_one_seo_pack' ),
															0 => __( 'Disabled', 'all_in_one_seo_pack' ) )
								);
			}
			
			$this->layout = Array(
				'default' => Array(
						'name' => $this->name,
						'help_link' => 'http://semperplugins.com/documentation/performance-settings/',
						'options' => array_keys( $this->default_options )
					)
			);
			
			$system_status = Array(
							'status' => Array( 'default' => '', 'type' => 'html', 'label' => 'none', 'save' => false ),
			);
			
			$this->layout['system_status'] = Array(
					'name' => __( 'System Status', 'all_in_one_seo_pack' ),
					'help_link' => 'http://semperplugins.com/documentation/performance-settings/',
					'options' => array_keys( $system_status )
				);
				
			$this->default_options = array_merge( $this->default_options, $system_status );
			
			$this->add_help_text_links();
			
			add_filter( $this->prefix . 'display_options', Array( $this, 'display_options_filter' ), 10, 2 );
			add_filter( $this->prefix . 'update_options', Array( $this, 'update_options_filter' ), 10, 2 );
			add_action( $this->prefix . 'settings_update', Array( $this, 'settings_update_action' ), 10, 2 );
		}
		
		function update_options_filter( $options, $location ) {
			if ( $location == null ) {
				if ( isset( $options[ $this->prefix . 'force_rewrites' ] ) )
					unset( $options[ $this->prefix . 'force_rewrites' ] );
			}
			return $options;
		}
		
		function display_options_filter( $options, $location ) {
			if ( $location == null ) {
				$options[ $this->prefix . 'force_rewrites' ] = 1;
				global $aiosp;
				if ( aioseop_option_isset( 'aiosp_rewrite_titles' ) ) {
					$opts = $aiosp->get_current_options( Array(), null );
					$options[ $this->prefix . 'force_rewrites' ] = $opts['aiosp_force_rewrites'];
				}
			}
			return $options;
		}
		
		function settings_update_action( $options, $location ) {
			if ( $location == null ) {
				if ( isset( $_POST[ $this->prefix . 'force_rewrites' ] ) ) {
					$force_rewrites = $_POST[ $this->prefix . 'force_rewrites' ];
					if ( ( $force_rewrites == 0 ) || ( $force_rewrites == 1 ) ) {
						global $aiosp;
						$opts = $aiosp->get_current_options( Array(), null );
						$opts['aiosp_force_rewrites'] = $force_rewrites;
						$aiosp->update_class_option( $opts );
						wp_cache_flush();
					}
				}
			}
		}
		
		function add_page_hooks() {
			$memory_usage = memory_get_peak_usage() / 1024 / 1024;
			if ( $memory_usage > 32 ) {
				unset( $this->default_options['memory_limit']['initial_options']['32M'] );
				if ( $memory_usage > 64 )  unset( $this->default_options['memory_limit']['initial_options']['64M'] );
				if ( $memory_usage > 128 ) unset( $this->default_options['memory_limit']['initial_options']['128M'] );
				if ( $memory_usage > 256 ) unset( $this->default_options['memory_limit']['initial_options']['256M'] );
			}
			$this->update_options();
			parent::add_page_hooks();
		}
		
		function settings_page_init() {
			$this->default_options['status']['default'] = $this->get_serverinfo();
		}
		
		function menu_order() {
			return 7;
		}
		
		function get_serverinfo() {
		    global $wpdb;
			global $wp_version;

		        $sqlversion = $wpdb->get_var("SELECT VERSION() AS version");
		        $mysqlinfo = $wpdb->get_results("SHOW VARIABLES LIKE 'sql_mode'");
		        if (is_array($mysqlinfo)) $sql_mode = $mysqlinfo[0]->Value;
		        if (empty($sql_mode)) $sql_mode = __('Not set', 'all_in_one_seo_pack' );
		        if(ini_get('safe_mode')) $safe_mode = __('On', 'all_in_one_seo_pack' );
		        else $safe_mode = __('Off', 'all_in_one_seo_pack' );
		        if(ini_get('allow_url_fopen')) $allow_url_fopen = __('On', 'all_in_one_seo_pack' );
		        else $allow_url_fopen = __('Off', 'all_in_one_seo_pack' );
		        if(ini_get('upload_max_filesize')) $upload_max = ini_get('upload_max_filesize');
		        else $upload_max = __('N/A', 'all_in_one_seo_pack' );
		        if(ini_get('post_max_size')) $post_max = ini_get('post_max_size');
		        else $post_max = __('N/A', 'all_in_one_seo_pack' );
		        if(ini_get('max_execution_time')) $max_execute = ini_get('max_execution_time');
		        else $max_execute = __('N/A', 'all_in_one_seo_pack' );
		        if(ini_get('memory_limit')) $memory_limit = ini_get('memory_limit');
		        else $memory_limit = __('N/A', 'all_in_one_seo_pack' );
		        if (function_exists('memory_get_usage')) $memory_usage = round(memory_get_usage() / 1024 / 1024, 2) . __(' MByte', 'all_in_one_seo_pack' );
		        else $memory_usage = __('N/A', 'all_in_one_seo_pack' );
		        if (is_callable('exif_read_data')) $exif = __('Yes', 'all_in_one_seo_pack' ). " ( V" . $this->substr(phpversion('exif'),0,4) . ")" ;
		        else $exif = __('No', 'all_in_one_seo_pack' );
		        if (is_callable('iptcparse')) $iptc = __('Yes', 'all_in_one_seo_pack' );
		        else $iptc = __('No', 'all_in_one_seo_pack' );
		        if (is_callable('xml_parser_create')) $xml = __('Yes', 'all_in_one_seo_pack' );
		        else $xml = __('No', 'all_in_one_seo_pack' );

			if ( function_exists( 'wp_get_theme' ) ) {
				$theme = wp_get_theme();
			} else {
				$theme = get_theme( get_current_theme() );
			}


			if ( function_exists( 'is_multisite' ) ) {
				if ( is_multisite() ) {
					$ms = __('Yes', 'all_in_one_seo_pack' );
				} else {
					$ms = __('No', 'all_in_one_seo_pack' );
				}

			} else $ms = __('N/A', 'all_in_one_seo_pack' );

			$siteurl = get_option('siteurl');
			$homeurl = get_option('home');
			$db_version = get_option('db_version');

			$debug_info = Array(
			        __('Operating System', 'all_in_one_seo_pack' )			=> PHP_OS,
			        __('Server', 'all_in_one_seo_pack' )				=> $_SERVER["SERVER_SOFTWARE"],
			        __('Memory usage', 'all_in_one_seo_pack' )			=> $memory_usage,
			        __('MYSQL Version', 'all_in_one_seo_pack' )			=> $sqlversion,
			        __('SQL Mode', 'all_in_one_seo_pack' )				=> $sql_mode,
			        __('PHP Version', 'all_in_one_seo_pack' )			=> PHP_VERSION,
			        __('PHP Safe Mode', 'all_in_one_seo_pack' )			=> $safe_mode,
			        __('PHP Allow URL fopen', 'all_in_one_seo_pack' )		=> $allow_url_fopen,
			        __('PHP Memory Limit', 'all_in_one_seo_pack' )			=> $memory_limit,
			        __('PHP Max Upload Size', 'all_in_one_seo_pack' )		=> $upload_max,
			        __('PHP Max Post Size', 'all_in_one_seo_pack' )			=> $post_max,
			        __('PHP Max Script Execute Time', 'all_in_one_seo_pack' )	=> $max_execute,
			        __('PHP Exif support', 'all_in_one_seo_pack' )			=> $exif,
			        __('PHP IPTC support', 'all_in_one_seo_pack' )			=> $iptc,
			        __('PHP XML support', 'all_in_one_seo_pack' )			=> $xml,
				__('Site URL', 'all_in_one_seo_pack' )				=> $siteurl,
				__('Home URL', 'all_in_one_seo_pack' )				=> $homeurl,
				__('WordPress Version', 'all_in_one_seo_pack' )			=> $wp_version,
				__('WordPress DB Version', 'all_in_one_seo_pack' )		=> $db_version,
				__('Multisite', 'all_in_one_seo_pack' )				=> $ms,
				__('Active Theme', 'all_in_one_seo_pack' )			=> $theme['Name'].' '.$theme['Version']
			);
			$debug_info['Active Plugins'] = null;
			$active_plugins = $inactive_plugins = Array();
			$plugins = get_plugins();
			foreach ($plugins as $path => $plugin) {
				if ( is_plugin_active( $path ) ) {
					$debug_info[$plugin['Name']] = $plugin['Version'];
				} else {
					$inactive_plugins[$plugin['Name']] = $plugin['Version'];
				}
			}
			$debug_info['Inactive Plugins'] = null;
			$debug_info = array_merge( $debug_info, (array)$inactive_plugins );

			$mail_text = __( "All in One SEO Pack Pro Debug Info", 'all_in_one_seo_pack' ) . "\r\n------------------\r\n\r\n";
			$page_text = "";
			if ( !empty( $debug_info ) )
				foreach($debug_info as $name => $value) {
					if ($value !== null) {
						$page_text .= "<li><strong>$name</strong> $value</li>";
						$mail_text .= "$name: $value\r\n";
					} else {
						$page_text .= "</ul><h2>$name</h2><ul class='sfwd_debug_settings'>";
						$mail_text .= "\r\n$name\r\n----------\r\n";
					}
				}

			do if ( !empty( $_REQUEST['sfwd_debug_submit'] ) ) {
				$nonce=$_REQUEST['sfwd_debug_nonce'];
				if (! wp_verify_nonce($nonce, 'sfwd-debug-nonce') ) {
					echo "<div class='sfwd_debug_error'>" . __( "Form submission error: verification check failed.", 'all_in_one_seo_pack' ) . "</div>";
					break;
				}
				$email = '';
				if ( !empty( $_REQUEST['sfwd_debug_send_email'] ) ) $email = sanitize_email( $_REQUEST['sfwd_debug_send_email'] );
				if ( $email ) {
					if ( wp_mail( $email, sprintf( __( "SFWD Debug Mail From Site %s.", 'all_in_one_seo_pack'), $siteurl), $mail_text ) ) {
						echo "<div class='sfwd_debug_mail_sent'>" . sprintf( __( "Sent to %s.", 'all_in_one_seo_pack' ), $email ) . "</div>";
					} else {
						echo "<div class='sfwd_debug_error'>" . sprintf( __( "Failed to send to %s.", 'all_in_one_seo_pack' ),  $email ) . "</div>";
					}
				} else {
					echo "<div class='sfwd_debug_error'>" . __( 'Error: please enter an e-mail address before submitting.', 'all_in_one_seo_pack' ) . "</div>";
				}
			} while(0); // control structure for use with break
			$nonce = wp_create_nonce('sfwd-debug-nonce');
			$buf =	"<ul class='sfwd_debug_settings'>\n{$page_text}\n</ul>\n<p>\n" .
					'<input name="sfwd_debug_send_email" type="text" value="" placeholder="' . __( "E-mail debug information", 'all_in_one_seo_pack' ) . '"><input name="sfwd_debug_nonce" type="hidden" value="' .
					$nonce . '"><input name="sfwd_debug_submit" type="submit" value="' . __( 'Submit', 'all_in_one_seo_pack' ) . '" class="button-primary"><p>';
			return $buf;
		}
	}
}