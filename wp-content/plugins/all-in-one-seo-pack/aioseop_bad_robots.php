<?php
/**
 * @package All-in-One-SEO-Pack 
 */
/**
 * The Bad Robots class.
 */
if ( !class_exists( 'All_in_One_SEO_Pack_Bad_Robots' ) ) {
	class All_in_One_SEO_Pack_Bad_Robots extends All_in_One_SEO_Pack_Module {
		function __construct( ) {
			$this->name = __('Bad Bot Blocker', 'all_in_one_seo_pack');	// Human-readable name of the plugin
			$this->prefix = 'aiosp_bad_robots_';						// option prefix
			$this->file = __FILE__;									// the current file
			parent::__construct();
			
			$help_text = Array(
				'block_bots' =>   __( 'Block requests from user agents that are known to misbehave.', 'all_in_one_seo_pack' ),
				'block_refer' =>  __( 'Block referral spam.', 'all_in_one_seo_pack' ),
				'track_blocks'=>  __( 'Log and show recent requests from blocked bots.', 'all_in_one_seo_pack' ),
				'htaccess_rules'=>__( 'Block bad robots via Apaache .htaccess rules. Warning: this will change your web server configuration, make sure you are able to edit this file manually as well.', 'all_in_one_seo_pack' ),
				'edit_blocks' =>  __( 'Check this to edit the list of disallowed user agents for blocking bad bots.', 'all_in_one_seo_pack' ),
				'blocklist'   =>  __( 'This is the list of disallowed user agents used for blocking bad bots.', 'all_in_one_seo_pack' ),
				'referlist'   =>  __( 'This is the list of disallowed referers used for blocking bad bots.', 'all_in_one_seo_pack' ),
				'blocked_log' =>  __( 'Shows log of most recent requests from blocked bots. Note: this will not track any bots that were already blocked at the web server / .htaccess level.', 'all_in_one_seo_pack' ),
			);
			
			$this->default_options = array(
				'block_bots' => Array( 'name' =>   __( 'Block Bad Bots', 'all_in_one_seo_pack' ) ),
				'block_refer'  => Array( 'name' => __( 'Block Referral Spam', 'all_in_one_seo_pack' ) ),
				'track_blocks' => Array( 'name' => __( 'Track Blocked Bots', 'all_in_one_seo_pack' ) ),
				'htaccess_rules' => Array( 'name' => __( 'Add rules to .htaccess', 'all_in_one_seo_pack' ) ),
				'edit_blocks'  => Array( 'name' => __( 'Edit Blocklists', 'all_in_one_seo_pack' ) ),
				'blocklist'	   => Array( 'name' => __( 'User Agent Blocklist', 'all_in_one_seo_pack' ), 'type' => 'textarea', 'rows' => 5, 'cols' => 120, 'condshow' => Array( "{$this->prefix}edit_blocks" => 'on' ), 'default' => join( "\n", $this->default_bad_bots() ) ),
				'referlist'	   => Array( 'name' => __( 'Referer Blocklist', 'all_in_one_seo_pack' ), 'type' => 'textarea', 'rows' => 5, 'cols' => 120, 'condshow' => Array( "{$this->prefix}edit_blocks" => 'on', "{$this->prefix}block_refer" => 'on',  ), 'default' => join( "\n", $this->default_bad_referers() )  ),
				'blocked_log'  => Array( 'name' => __( 'Log Of Blocked Bots', 'all_in_one_seo_pack' ), 'default' => __( 'No requests yet.', 'all_in_one_seo_pack' ), 'type' => 'html', 'disabled' => 'disabled', 'save' => false, 'label' => 'top', 'rows' => 5, 'cols' => 120, 'style' => 'min-width:950px', 'condshow' => Array( "{$this->prefix}track_blocks" => 'on' ) )
			);
			$is_apache = false;
			if ( ( !empty($_SERVER['SERVER_SOFTWARE'] ) && stristr( $_SERVER['SERVER_SOFTWARE'], 'Apache' ) !== false ) ) {
				$is_apache = true;
				add_action( $this->prefix . 'settings_update',  Array( $this, 'generate_htaccess_blocklist' ), 10 );		
			} else {
				unset( $this->default_options["htaccess_rules"] );
				unset( $help_text["htaccess_rules"] );
			}
			
			if ( !empty( $help_text ) )
				foreach( $help_text as $k => $v )
					$this->default_options[$k]['help_text'] = $v;
			
			add_filter( $this->prefix . 'display_options',  Array( $this, 'filter_display_options' ) );
			
			// load initial options / set defaults
			$this->update_options( );
			
			if ( $this->option_isset( 'edit_blocks' ) ) {
				add_filter( $this->prefix . 'badbotlist',  Array( $this, 'filter_bad_botlist' ) );
				if ( $this->option_isset( 'block_refer' ) ) {
					add_filter( $this->prefix . 'badreferlist',  Array( $this, 'filter_bad_referlist' ) );
				}
			}
			
			if ( $this->option_isset( 'block_bots' ) ) {
				if ( !$this->allow_bot() ) {
					status_header( 503 );
					$ip = $_SERVER['REMOTE_ADDR'];
					$user_agent = $_SERVER['HTTP_USER_AGENT'];
					$this->blocked_message( sprintf( __( "Blocked bot with IP %s -- matched user agent %s found in blocklist.", 'all_in_one_seo_pack' ), $ip, $user_agent ) );
					exit();
				} elseif ( $this->option_isset( 'block_refer' ) && $this->is_bad_referer() ) {
					status_header( 503 );
					$ip = $_SERVER['REMOTE_ADDR'];
					$referer = $_SERVER['HTTP_REFERER'];
					$this->blocked_message( sprintf( __( "Blocked bot with IP %s -- matched referer %s found in blocklist.", 'all_in_one_seo_pack' ), $ip, $referer ) );
				}
			}
		}
		
		function generate_htaccess_blocklist() {
			if ( !$this->option_isset( 'htaccess_rules' ) ) return;
			if ( function_exists( 'apache_get_modules' ) ) {
				$modules = apache_get_modules();
				foreach( Array( 'mod_authz_host', 'mod_setenvif' ) as $m ) {
					if ( !in_array( $m, $modules ) ) {
						aioseop_output_notice( sprintf( __( "Apache module %s is required!", 'all_in_one_seo_pack' ), $m ), "", "error" );
					}
				}
			}
			$botlist = $this->default_bad_bots();
			$botlist = apply_filters( $this->prefix . "badbotlist", $botlist );
			if ( !empty( $botlist ) ) {
				$regex = $this->quote_list_for_regex( $botlist, '"' );
				$htaccess = Array();
				$htaccess[] = 'SetEnvIfNoCase User-Agent "' . $regex . '" bad_bot';
				if ( $this->option_isset( 'edit_blocks' ) && $this->option_isset( 'block_refer' ) && $this->option_isset( 'referlist' ) ) {
					$referlist = $this->default_bad_referers();
					$referlist = apply_filters( $this->prefix . "badreferlist", $botlist );
					if ( !empty( $referlist ) ) {
						$regex = $this->quote_list_for_regex( $referlist, '"' );
						$htaccess[] = 'SetEnvIfNoCase Referer "' . $regex . '" bad_bot';
					}
				}
				$htaccess[] = 'Deny from env=bad_bot';
				if ( insert_with_markers( get_home_path() . '.htaccess', $this->name, $htaccess ) ) {
					aioseop_output_notice( __( "Updated .htaccess rules.", 'all_in_one_seo_pack' ) );
				} else {
					aioseop_output_notice( __( "Failed to update .htaccess rules!", 'all_in_one_seo_pack' ), "", "error" );
				}
			} else {
				aioseop_output_notice( __( "No rules to update!", 'all_in_one_seo_pack' ), "", "error" );				
			}
		}
		
		function filter_bad_referlist( $referlist ) {
			if ( $this->option_isset( 'edit_blocks' ) && $this->option_isset( 'block_refer' ) && $this->option_isset( 'referlist' ) ) {
				$referlist = explode( "\n", $this->options["{$this->prefix}referlist"] );
			}
			return $referlist;
		}
		
		function filter_bad_botlist( $botlist ) {
			if ( $this->option_isset( 'edit_blocks' ) && $this->option_isset( 'blocklist' ) ) {
				$botlist = explode( "\n", $this->options["{$this->prefix}blocklist"] );
			}
			return $botlist;
		}
		
		/** Updates blocked log messages. **/
		function blocked_message( $msg ) {
			if ( empty( $this->options["{$this->prefix}blocked_log"] ) ) $this->options["{$this->prefix}blocked_log"] = '';
			$this->options["{$this->prefix}blocked_log"] = date( 'Y-m-d H:i:s' ) . " {$msg}\n" . $this->options["{$this->prefix}blocked_log"];
			if ( $this->strlen( $this->options["{$this->prefix}blocked_log"] ) > 4096 ) {
				$end = $this->strrpos( $this->options["{$this->prefix}blocked_log"], "\n" );
				if ( $end === false ) $end = 4096;
				$this->options["{$this->prefix}blocked_log"] = $this->substr( $this->options["{$this->prefix}blocked_log"], 0, $end );
			}
			$this->update_class_option( $this->options );
		}
		
		/** Add in options for status display on settings page, sitemap rewriting on multisite. **/
		function filter_display_options( $options ) {
			if ( $this->option_isset( 'blocked_log' ) ) $options["{$this->prefix}blocked_log"] = '<pre>' . $options["{$this->prefix}blocked_log"] . '</pre>';
			return $options;
		}
	}
}
