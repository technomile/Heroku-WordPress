<?php 
/*
Plugin Name: Quick Page/Post Redirect Plugin
Plugin URI: http://www.fischercreativemedia.com/wordpress-plugins/quick-pagepost-redirect-plugin/
Description: Redirect Pages, Posts or Custom Post Types to another location quickly (for internal or external URLs). Includes individual post/page options, redirects for Custom Post types, non-existant 301 Quick Redirects (helpful for sites converted to WordPress), New Window functionality, and rel=nofollow functionality.
Author: Don Fischer
Author URI: http://www.fischercreativemedia.com/
Donate link: http://www.fischercreativemedia.com/donations/
Version: 5.0.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

 * Copyright (C) 2009-2014 Donald J. Fischer <dfischer [at] fischercreativemedia [dot] com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the [GNU General Public License](http://wordpress.org/about/gpl/)
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * on an "AS IS", but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, see [GNU General Public Licenses](http://www.gnu.org/licenses/),
 * or write to the Free Software Foundation, Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301, USA.
 
==========
You can use the following action hooks with this plugin:

*** Quick Rediects function: use to take over redirect
add_action('qppr_redirect','some_callback_function',10,2);
		arg 1. is Redirect URL
		arg 2. is Redirect Type
*******************************

*** Page/Post Redirects function: use to take over redirect
add_action('qppr_do_redirect','some_callback_function2',10,2);
		arg 1. is Redirect URL
		arg 2. is Redirect Type
*******************************

*** Meta Redirect Action: Used for Meta Redirect Page Headers (so you can add meta tag)
add_action('ppr_meta_head_hook','some_callback',10,3);
       arg 1. URL site
		arg 2. Meta Redirect Time in Seconds
		arg 3. Meta Message to display
Example:
	add_action('ppr_meta_head_hook','override_ppr_metahead',10,3);
	function override_ppr_metahead($refresh_url='',$refresh_secs=0,$messages=''){
        echo '<meta http-equiv="refresh" content="'.$refresh_secs.'; URL='.$refresh_url.'" />'."\n";
        echo '<div id="ppr_custom_message">'. $messages.'</div>'."\n";
        return;
	}
*******************************

*** Meta Redirect Filter: Used for Meta Redirect Page Headers (so you can add meta and message, etc.)
add_filter('ppr_meta_head_hook_filter','some_callback2',10,2);
		arg 1. Meta Tag (fully generated)
		arg 2. Page HTML Message (wrapped in a <div> tag)
Example:
	add_filter('ppr_meta_head_hook_filter','override_ppr_metahead_new');
	function override_ppr_metahead_new($meta_tag='',$meta_message=''){
        $meta = $meta_tag;
        $function = create_function('$content', 'return \'<div id="ppr_custom_message">sample message override</div>\';');
        $function2 = create_function('$title', 'return \'sample message override TITLE\';');
        add_filter('get_content',$function,100,1);
      	add_filter('get_title',$function2,100,1);
        return $meta;
	}
*******************************
*/
global $newqppr, $redirect_plugin;
start_ppr_class();
if (!function_exists('esc_attr')) { // For WordPress < 2.8 function compatibility
	function esc_attr($attr){return attribute_escape( $attr );}
	function esc_url($url){return clean_url( $url );}
}
	
//=======================================
// Main Redirect Class.
//=======================================
class quick_page_post_reds {
	public $ppr_nofollow;
	public $ppr_newindow;
	public $ppr_url;
	public $ppr_url_rewrite;
	public $ppr_type;
	public $ppr_curr_version;
	public $ppr_metaurlnew;
	public $thepprversion;
	public $thepprmeta;
	public $quickppr_redirects;
	public $tohash;
	public $fcmlink;
	public $adminlink;
	public $ppr_all_redir_array;
	public $homelink;
	public $updatemsg;
	public $pproverride_nofollow;
	public $pproverride_newwin;
	public $pproverride_type;
	public $pproverride_active;
	public $pproverride_URL;
	public $pproverride_rewrite;
	public $pprmeta_seconds;
	public $pprmeta_message;
	public $quickppr_redirectsmeta;
	public $quickppr_jquerycache;
	public $pproverride_casesensitive;
	public $ppruse_jquery;
	public $pprptypes_ok;
	
	function __construct() {
		$this->ppr_curr_version 		= '5.0.6';
		$this->ppr_nofollow 			= array();
		$this->ppr_newindow 			= array();
		$this->ppr_url 					= array();
		$this->ppr_url_rewrite 			= array();
		$this->thepprversion 			= get_option( 'ppr_version');
		$this->thepprmeta 				= get_option( 'ppr_meta_clean');
		$this->quickppr_redirects 		= get_option( 'quickppr_redirects');
		$this->quickppr_redirectsmeta	= get_option('quickppr_redirects_meta');
		$this->homelink 				= get_option( 'home');
		$this->pproverride_nofollow 	= get_option( 'ppr_override-nofollow' );
		$this->pproverride_newwin 		= get_option( 'ppr_override-newwindow' );
		$this->ppruse_jquery	 		= get_option( 'ppr_use-jquery' );
		$this->pprptypes_ok				= array();
		$this->pproverride_type 		= get_option( 'ppr_override-redirect-type' );
		$this->pproverride_active 		= get_option( 'ppr_override-active' );
		$this->pproverride_URL 			= get_option( 'ppr_override-URL' );
		$this->pproverride_rewrite		= get_option( 'ppr_override-rewrite' );
		$this->pprmeta_message			= get_option( 'ppr_meta-message' );
		$this->pprmeta_seconds			= get_option( 'ppr_meta-seconds' );
		$this->pproverride_casesensitive= get_option( 'ppr_override-casesensitive' );
		$this->adminlink 				= admin_url('/', 'admin');
		$this->fcmlink					= 'http://www.fischercreativemedia.com/plugins';
		$this->ppr_metaurl				= '';
		$this->quickppr_jquerycache		= ''; //get_option( 'qppr_jQuery_cache' );
		$this->updatemsg				= '';
		if($this->pprmeta_seconds==''){$this->pprmeta_seconds='0';}
		
		//these are for all the time - even if there are overrides
		add_action( 'init', array( $this,'ppr_init_check_version'), 1 );			// checks version of plugin in DB and updates if needed.
	  	add_action( 'init', array( $this,'ppr_parse_request_new') );				// parse query vars
		add_action(	'save_post', array( $this,'ppr_save_metadata'), 11, 2 ); 		// save the custom fields
	  	add_action( 'wp', array( $this, 'ppr_parse_request') );						// parse query vars
		add_action( 'admin_menu', array( $this,'ppr_add_menu' ) ); 					// add the menu items needed
		add_action( 'admin_menu', array( $this,'ppr_add_metabox' ) ); 				// add the metaboxes where needed
		add_action( 'plugin_action_links_' . plugin_basename(__FILE__), array($this,'ppr_filter_plugin_actions') );
		add_filter( 'query_vars', array( $this,'ppr_queryhook' ) ); 
		add_filter( 'plugin_row_meta',  array( $this,'ppr_filter_plugin_links' ), 10, 2 );
		add_action( 'admin_enqueue_scripts' , array( $this,'qppr_admin_scripts' ) );
		//add_filter( 'wp_feed_cache_transient_lifetime',array($this,'ppr_wp_feed_options',10, 2));

		if( $this->pproverride_active!='1' && !is_admin() ){ 							// don't run these if override active is set
			add_action( 'init', array( $this, 'redirect' ), 1 ); 						// add the 301 redirect action, high priority
			add_action( 'init', array( $this, 'redirect_post_type' ), 1 ); 				// add the normal redirect action, high priority
			add_action( 'template_redirect', array( $this, 'ppr_do_redirect' ), 1, 2);	// do the redirects
			add_filter( 'wp_get_nav_menu_items', array( $this, 'ppr_new_nav_menu_fix' ), 1, 1 );
			add_filter( 'wp_list_pages', array( $this, 'ppr_fix_targetsandrels' ) );
			add_filter( 'page_link', array( $this, 'ppr_filter_page_links' ), 20, 2 );
			add_filter( 'post_link', array( $this, 'ppr_filter_page_links'), 20, 2 );
			add_filter( 'post_type_link', array( $this, 'ppr_filter_page_links' ), 20, 2 );
			add_filter( 'get_permalink', array( $this, 'ppr_filter_links' ), 20, 2 );
		}
		add_action('admin_init', array($this,'save_quick_redirects_fields'));
	}
	function save_quick_redirects_fields(){
		if( isset( $_POST['submit_301'] ) ) {
			if(check_admin_referer( 'add_qppr_redirects' )){
				$this->quickppr_redirects = $this->save_redirects( $_POST['quickppr_redirects'] );
				$this->updatemsg ='Quick Redirects Updated.';
			}
		} //if submitted and verified, process the data
	}
	function ppr_add_menu(){
		add_menu_page( 'Redirect Options', 'Redirect Options', 'administrator', 'redirect-options', array($this,'ppr_settings_page'),plugins_url( 'settings-16-icon.png' , __FILE__));
		add_submenu_page( 'redirect-options', 'Quick Redirects', 'Quick Redirects', 'manage_options', 'redirect-updates', array($this,'ppr_options_page') );
		add_submenu_page( 'redirect-options', 'Redirect Summary', 'Redirect Summary', 'manage_options', 'redirect-summary', array($this,'ppr_summary_page') );
		add_submenu_page( 'redirect-options', 'FAQs/Help', 'FAQs/Help', 'manage_options', 'redirect-faqs', array($this,'ppr_faq_page') );
		add_action( 'admin_init', array($this,'register_pprsettings') );
	}
	function qppr_admin_scripts($hook){
		if(in_array($hook, array('edit.php','post.php'))){
			wp_enqueue_script( 'qppr_admin_meta_script', plugins_url('/qppr_admin_script.js', __FILE__ ) , array('jquery'),'5.0.6');
			wp_enqueue_style( 'qppr_admin_meta_style', plugins_url('/qppr_admin_style.css', __FILE__ ) , null ,'5.0.6' );
		}
		return;
	}	
	function register_pprsettings() {
		register_setting( 'ppr-settings-group', 'ppr_use-custom-post-types' );
		register_setting( 'ppr-settings-group', 'ppr_override-nofollow' );
		register_setting( 'ppr-settings-group', 'ppr_override-newwindow' );
		register_setting( 'ppr-settings-group', 'ppr_override-redirect-type' );
		register_setting( 'ppr-settings-group', 'ppr_override-active' );
		register_setting( 'ppr-settings-group', 'ppr_override-URL' );
		register_setting( 'ppr-settings-group', 'ppr_override-rewrite' );
		register_setting( 'ppr-settings-group', 'ppr_meta-seconds' );
		register_setting( 'ppr-settings-group', 'ppr_meta-message' );
		register_setting( 'ppr-settings-group', 'ppr_use-jquery' );
		register_setting( 'ppr-settings-group', 'ppr_qpprptypeok' );
		register_setting( 'ppr-settings-group', 'ppr_override-casesensitive' );
	}
	
	function ppr_wp_feed_options($cache,$url){
		if($url == "http://www.fischercreativemedia.com/?feed=qppr_faqs"){
			$cache = '1';
		}
		return $cache;
	}
	
	function ppr_faq_page(){
		include_once(ABSPATH . WPINC . '/feed.php');
		echo '
		<div class="wrap">
			<style type="text/css">
				.faq-item{border-bottom:1px solid #CCC;padding-bottom:10px;margin-bottom:10px;}
				.faq-item span.qa{color: #21759B;display: block;float: left;font-family: serif;font-size: 17px;font-weight: bold;margin-left: 0;margin-right: 5px;}
				 h3.qa{color: #21759B;margin:0px 0px 10px 0;font-family: serif;font-size: 17px;font-weight: bold;}
				.faq-item .qa-content p:first-child{margin-top:0;}
				.qppr-faq-links {border-bottom: 1px solid #CCCCCC;list-style-position: inside;margin:10px 0 15px 35px;}
				.qppr-faq-answers{list-style-position: inside;margin:10px 0 15px 35px;}
				.toplink{text-align:left;}
				.qa-content div > code{background: none repeat scroll 0 0 #EFEFEF;border: 1px solid #CCCCCC;display: block;margin-left: 35px;overflow-y: auto;padding: 10px 20px;white-space: nowrap;width: 90%;}
			</style>
			<div class="icon32" style="background: url('. plugins_url( "settings-icon.png" , __FILE__ ) . ') no-repeat transparent;"><br/></div>
		 	<h2>Quick Page/Post Redirect FAQs/Help</h2>
			<div align="left"><p>The FAQS are now on a feed that can be updated on the fly. If you have a question and don\'t see an answer, please send an email to <a href="mailto:plugins@fischercreativemedia.com">plugins@fischercreativemedia.com</a> and ask your question. If it is relevant to the plugin, it will be added to the FAQs feed so it will show up here. Please be sure to include the plugin you are asking a question about (Quick Page/Post Redirect Plugin) and any other information like your WordPress version and examples if the plugin is not working correctly for you. THANKS!</p>
			<hr noshade color="#C0C0C0" size="1" />
		';
		$rss 			= fetch_feed('http://www.fischercreativemedia.com/?feed=qppr_faqs');
		$linkfaq 		= array();
		$linkcontent 	= array();
		if (!is_wp_error( $rss ) ) : 
		    $maxitems 	= $rss->get_item_quantity(100); 
		    $rss_items 	= $rss->get_items(0, $maxitems); 
		endif;
			$aqr = 0;
		    if ($maxitems != 0){
			    foreach ( $rss_items as $item ) :
			    	$aqr++; 
			    	$linkfaq[]		= '<li class="faq-top-item"><a href="#faq-'.$aqr.'">'.esc_html( $item->get_title() ).'</a></li>';
				    $linkcontent[] 	= '<li class="faq-item"><a name="faq-'.$aqr.'"></a><h3 class="qa"><span class="qa">Q. </span>'.esc_html( $item->get_title() ).'</h3><div class="qa-content"><span class="qa answer">A. </span>'.$item->get_content().'</div><div class="toplink"><a href="#faq-top">top &uarr;</a></li>';
			    endforeach;
			}
		echo '<a name="faq-top"></a><h2>Table of Contents</h2>';
		echo '<ol class="qppr-faq-links">';
			echo implode("\n",$linkfaq);
		echo '</ol>';
		echo '<h2>Questions/Answers</h2>';
		echo '<ul class="qppr-faq-answers">';
			echo implode("\n",$linkcontent);
		echo '</ul>';
		echo '
			</div>
		</div>';
	}
	function ppr_summary_page() {?>
		<div class="wrap">
		<style type="text/css">
		.ppr-acor{background:#FF0000;display:block;color:#FFFFFF;}
		.ppr-nfor{background:#FFAAAA;display:block;}
		.ppr-nwor{background:#FF9933;display:block;}
		.ppr-rrlor{background:#FFFF66;display:block;}
		.pprdonate{padding:5px;border:1px solid #dadada;font-family:tahoma, arial, helvetica, sans-serif;font-size:12px;float:right;position:absolute;top:25px;right:5px;width:250px;text-align:center;}
		.qform-table td{padding:2px !important;border:1px solid #cccccc;}
		.qform-table .headrow td{font-weight:bold;}
		.qform-table .onrow td{background-color:#eaeaea;}
		.qform-table .offrow td{background-color:#ffffff;}</style>
		<div class="icon32" style="<?php echo 'background: url('.plugins_url( 'settings-icon.png' , __FILE__ ).') no-repeat transparent;';?>"><br></div>
		<h2>Quick Page Post Redirect Summary</h2>
		<p>This is a summary of Individual &amp; Quick 301 Redirects.</p><br/>
		<?php if($this->updatemsg!=''){?><div class="updated settings-error" id="setting-error-settings_updated"><p><strong><?php echo $this->updatemsg;?></strong></p></div><?php } ?>
		<?php $this->updatemsg ='';?>
		 <h2 style="font-size:20px;">Summary</h2>
		    <div align="left">
			<?php 		    		
			if($this->pproverride_active =='1'){echo '<div class="ppr-acor" style="margin:1px 0;width: 250px;font-weight: bold;padding: 2px;">Acitve Override is on - All Redirects are OFF!</div>';}
			if($this->pproverride_nofollow =='1'){echo '<div class="ppr-nfor" style="margin:1px 0;width: 200px;font-weight: bold;padding: 2px;">No Follow Override is on!</div>';}
			if($this->pproverride_newwin =='1'){echo '<div class="ppr-nwor" style="margin:1px 0;width: 200px;font-weight: bold;padding: 2px;">New Window Override is on!</div>';}
			if($this->pproverride_rewrite =='1'){echo '<div class="ppr-rrlor" style="margin:1px 0;width: 200px;font-weight: bold;padding: 2px;">Rewrite Override is on!</div>';}
			?>
		    <table class="form-table qform-table" width="100%">
		        <tr valign="top" class="headrow">
		        	<td width="50" align="left">ID</td>
		        	<td width="75" align="left">post type</td>
		        	<td width="65" align="center">active</td>
		        	<td width="65" align="center">no follow</td>
		        	<td width="65" align="center">new win</td>
		        	<td width="60" align="center">type</td>
		        	<td width="50" align="center">rewrite</td>
		        	<td align="left">original URL</td>
		        	<td align="left">redirect to URL</td>

		        </tr>
		<?php 
			$tempReportArray = array();
			$tempa = array();
			$tempQTReportArray = array();
			if( !empty( $this->quickppr_redirects)){
				foreach($this->quickppr_redirects as $key=>$redir){
					$tempQTReportArray = array('url'=>$key,'destinaition'=>$redir);
					$qr_nofollow = $this->quickppr_redirectsmeta[$key]['nofollow'];
					$qr_newwindow = $this->quickppr_redirectsmeta[$key]['newwindow'];
					if($qr_nofollow ==''){$qr_nofollow = '0';}
					if($qr_newwindow ==''){$qr_newwindow = '0';}
					if($this->pproverride_nofollow == '1'){$qr_nofollow = '<span class="ppr-nfor">1</span>';}
					if($this->pproverride_newwin == '1'){$qr_newwindow= '<span class="ppr-nwor">1</span>';}
					if($this->pproverride_rewrite == '1'){$qrtrewrit= '<span class="ppr-rrlor">1</span>';$qrtredURL = '<span class="ppr-rrlor">'.$this->pproverride_URL.'</span>';}else{$qrtrewrit = 'N/A';$qrtredURL =$redir;}
					if($this->pproverride_active =='1'){$qrtactive = '<span class="ppr-acor">0</span>';}else{$qrtactive= 1;}

					$tempReportArray[] = array(
						'_pprredirect_active' => $qrtactive,
						'_pprredirect_rewritelink' => $qrtrewrit,
						'_pprredirect_relnofollow' => $qr_nofollow,
						'_pprredirect_newwindow' => $qr_newwindow,
						'_pprredirect_type' => 'Quick',
						'post_type' => 'N/A',
						'id' => 'N/A',
						'origurl' => $key,
						'_pprredirect_url' => $qrtredURL
						);
				}
			}
			if(!empty($this->ppr_all_redir_array)){
				foreach($this->ppr_all_redir_array as $key=>$result){
					$tempa['id']= $key;
					$tempa['post_type'] = get_post_type( $key );
					if(count($result)>0){
						foreach($result as $metakey => $metaval){
							$tempa[$metakey] = $metaval;
						}
					}
					$tempReportArray[] = $tempa;
					unset($tempa);
				}
			}
			if(!empty($tempReportArray)){
				$pclass = 'onrow';
				foreach($tempReportArray as $reportItem){
					$tactive = $reportItem['_pprredirect_active'];
					if($this->pproverride_active =='1'){$tactive = '<span class="ppr-acor">0</span>';}
					
					$trewrit = $reportItem['_pprredirect_rewritelink'];
					$tnofoll = $reportItem['_pprredirect_relnofollow'];
					$tnewwin = $reportItem['_pprredirect_newwindow'];
					$tretype = $reportItem['_pprredirect_type'];
					$tredURL = $reportItem['_pprredirect_url'];
					$tpotype = $reportItem['post_type'];
					$tpostid = $reportItem['id'];
					
					if($tnewwin == '0' || $tnewwin == ''){$tnewwin = '0';}elseif($tnewwin == 'N/A'){$tnewwin = 'N/A';}elseif($tnewwin == '_blank'){$tnewwin = '1';};
					if($this->pproverride_nofollow =='1'){$tnofoll = '<span class="ppr-nfor">1</span>';}
					if($this->pproverride_newwin =='1'){$tnewwin= '<span class="ppr-nwor">1</span>';}
					if($this->pproverride_rewrite =='1'){$trewrit= '<span class="ppr-rrlor">1</span>';$tredURL = '<span class="ppr-rrlor">'.$this->pproverride_URL.'</span>';}
					
					if(isset($reportItem['origurl'])){
						$toriurl = $reportItem['origurl'];
					}else{
						$toriurl = get_permalink($tpostid);
					}
					if($pclass == 'offrow'){$pclass = 'onrow';}else{$pclass = 'offrow';}
					if($tredURL == 'http://www.example.com' || $tredURL == '<span class="ppr-rrlor">http://www.example.com</span>'){$tredURL='<strong>N/A - redirection will not occur</strong>';}
				?>     
		        <tr valign="top" class="<?php echo $pclass;?>">
		        	<td width="50" align="left"><?php echo $tpostid;?></td>
		        	<td width="75" align="left"><?php echo $tpotype;?></td>
		        	<td width="65" align="center"><?php echo $tactive;?></td>
		        	<td width="65" align="center"><?php echo $tnofoll;?></td>
		        	<td width="65" align="center"><?php echo $tnewwin;?></td>
		        	<td width="60" align="center"><?php echo $tretype;?></td>
		        	<td width="50" align="center"><?php echo $trewrit;?></td>
		        	<td align="left"><?php echo $toriurl;?></td>
		        	<td align="left"><?php echo $tredURL;?></td>
		        </tr>
				<?php }
			}
		 ?>
		    </table>
		</div>
		</div>
	<?php 
	} 

	function ppr_settings_page() {
		if(isset($_GET['update'])){
			if($_GET['update']=='3'){$this->updatemsg ='All Quick Redirects deleted from database.';}
			if($_GET['update']=='2'){$this->updatemsg ='All Regular Redirects deleted from database.';}
			if($_GET['update']=='4'){$this->updatemsg ='Quick Redirects Imported & Replaced.';}
			if($_GET['update']=='5'){$this->updatemsg ='Quick Redirects Imported & Added to Existing Redirects.';}
		}
	?>
	<div class="wrap" style="position:relative;">
	<style type="text/css">
	.qppr-posttypes{overflow: hidden;}
	.qppr-ptype{float: left; width: auto;}
	.qpprform label {float:left;display:block;width:290px;margin-left:15px;}
	.qpprform .submit{clear:both;}
	.qpprform span{font-size:11px;color:#21759B;display:inline-block;margin-left:15px;}
	.pprdonate{border: 1px solid #DADADA;font-family: tahoma,arial,helvetica,sans-serif;font-size: 12px;overflow: hidden;padding: 5px;position: absolute;right: 0;text-align: center;top: 0;width: 160px;}
	.pprdonate form{display:block;}
	.settings-error{display:inline-block;width:70%;}
	.ppr-type-name{display:inline-block;margin:0 25px 0 2px;}
	</style>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#qppr_import_qr_button").click(function(event){
				jQuery('#qppr_addto_form').css({'display':'none'});
				if(jQuery('#qppr_import_form').css('display')=='block'){
					jQuery('#qppr_import_form').css({'display':'none'});
				}else{
					jQuery('#qppr_import_form').css({'display':'block'});
				}
				event.preventDefault();
			});
			jQuery("#qppr_addto_qr_button").click(function(event){
				jQuery('#qppr_import_form').css({'display':'none'});
				if(jQuery('#qppr_addto_form').css('display')=='block'){
					jQuery('#qppr_addto_form').css({'display':'none'});
				}else{
					jQuery('#qppr_addto_form').css({'display':'block'});
				}
				event.preventDefault();
			});
			jQuery("#import_redirects_add_qppr").click(function(event){
				if(jQuery("[name|=qppr_file_add]").attr('value')==''){
					alert('select a file');
					event.preventDefault();
					return false;
				}
			});
			jQuery("#import_redirects_qppr").click(function(event){
				if(jQuery("[name|=qppr_file]").attr('value')==''){
					alert('select a file');
					event.preventDefault();
					return false;
				}
			});
		});		
		function check_file(fname){
		    str		=	fname.value.toUpperCase();
		    suffix	=	".TXT";
		    if(!(str.indexOf(suffix, str.length - suffix.length) !== -1)){
		    	alert('File type not allowed,\nAllowed file: *.txt');
		        fname.value	= '';
		    }
		}
		//function goOnConfirm(message, href) {if (confirm(message)) document.location.href = '/wp-admin/admin.php'+href;}
		function goOnConfirm(message, href) {if (confirm(message)) document.location.href = '<?php echo admin_url("admin.php"); ?>'+href;}
		
	</script>
	<div class="icon32" style="<?php echo 'background: url('.plugins_url( 'settings-icon.png' , __FILE__ ).') no-repeat transparent;';?>"><br></div>
	<h2>Quick Page Post Redirect Options & Settings</h2>
	<?php if($this->updatemsg!=''){?><div class="updated" id="setting-error-settings_updated"><p><strong><?php echo $this->updatemsg;?></strong></p></div><?php } ?>
	<?php $this->updatemsg ='';//reset message;?>
	<div class="pprdonate">
	<div style="overflow: hidden; width: 161px; text-align: center;">
	<div style="overflow: hidden; width: 161px; text-align: center; float: left;"><form action="https://www.paypal.com/cgi-bin/webscr" method="post"><input name="cmd" value="_s-xclick" type="hidden"/><input name="hosted_button_id" value="8274582" type="hidden"/><input alt="PayPal - The safer, easier way to pay online!" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" type="image"> <img src="https://www.paypal.com/en_US/i/scr/pixel.gif" alt="" border="0" height="1" width="1"></form></div>
	If you enjoy or find any of our plugins useful, please donate a few dollars to help with future development and updates. We thank you in advance.</div>
	</div>

	<div align="left">
	<table style="border-collapse: collapse" class="form-table">
        <tr valign="top">
        	<td><h2 style="font-size:20px;">Import/Export</h2></td>
        </tr>
        <tr valign="top">
        	<td><label>Export Redirects </label><input class="button-secondary qppr_export_qr" type="button" name="qppr_export_qr" value="EXPORT all Quick Redirects (Encoded)" onclick="document.location='<?php echo wp_nonce_url( admin_url('admin.php?page=redirect-options&ftype=encoded').'&action=export_redirects_qppr', 'export-redirects-qppr'); ?>';" /> OR <input class="button-secondary qppr_export_qr" type="button" name="qppr_export_qr" value="EXPORT all Quick Redirects (PIPE Separated)" onclick="document.location='<?php echo wp_nonce_url( admin_url('admin.php?page=redirect-options').'&action=export_redirects_qppr&ftype=pipe', 'export-redirects-qppr'); ?>';" /></td>
        </tr>
        <tr valign="top">
        	<td>
        		<label>Import Redirects </label>
        		<input class="button-secondary qppr_import_qr" type="button" id="qppr_import_qr_button" name="qppr_import_qr" value="RESTORE Saved Quick Redirects" /> OR <input class="button-secondary qppr_addto_qr" type="button" id="qppr_addto_qr_button" name="qppr_addto_qr" value="ADD TO Quick Redirects" />
				<div id="qppr_import_form" class="hide-if-js">
					<form action="<?php echo admin_url('admin.php?page=redirect-options'); ?>" method="post" enctype="multipart/form-data">
						<p style="margin:1em 0;"><label>Select Quick Redirects file to import:</label> <input type="file" name="qppr_file" onchange="check_file(this);" /></p>
						<p class="submit"><?php wp_nonce_field( 'import_redirects_qppr' ); ?><input class="button-primary" type="submit" id="import_redirects_qppr" name="import_redirects_qppr" value="IMPORT & REPLACE Current Quick Redirects" /></p>
					</form>
				</div>
				<div id="qppr_addto_form" class="hide-if-js">
					<form action="<?php echo admin_url('admin.php?page=redirect-options'); ?>" method="post" enctype="multipart/form-data">
						<p style="margin:.5em 0 1em 1em;color:#444;">
							The import file should be a text file with one rediect per line, PIPE separated, in this format:<br/><code>redirect|destination|newwindow|nofollow</code><br/>for Example:<br/>
							<code>/old-location.htm|http://some.com/new-destination/|0|1<br/>/dontate/|http://example.com/destination/|1|1</code><br/><br/>
							<strong>IMPORTANT:</strong> Make Sure any destinations that might have a PIPE in the querystring data are URL encoded!<br/><br/>
							<label>Select Quick Redirects file to import:</label> <input type="file" name="qppr_file_add" onchange="check_file(this);" />
						</p>
						<p class="submit">
							<?php wp_nonce_field( 'import_redirects_add_qppr' ); ?><input class="button-primary" type="submit" id="import_redirects_add_qppr" name="import_redirects_add_qppr" value="ADD TO Current Quick Redirects" />
						</p>
					</form>
				</div>

        	</td>
        </tr>
        <tr valign="top">
        	<td>
        		<hr noshade color="#EAEAEA" size="1">
        	</td>
        </tr>
	</table>
	</div>

	<form method="post" action="options.php" class="qpprform">
	    <?php settings_fields( 'ppr-settings-group' ); ?>
	    <table class="form-table">
	        <tr valign="top">
	        	<td><h2 style="font-size:20px;">Basic Settings</h2></td>
	        </tr>
	        <tr valign="top">
	        	<td><label>Use with Custom Post Types?</label> <input type="checkbox" name="ppr_use-custom-post-types" value="1"<?php if(get_option('ppr_use-custom-post-types')=='1'){echo ' checked="checked" ';} ?>/>
	    <?php
	    $ptypes = get_post_types();
	    $ptypesok = $this->pprptypes_ok;
	    if(!is_array($ptypesok)){$ptypesok = get_option( 'ppr_qpprptypeok' );}
	    if(!is_array($ptypesok)){$ptypesok = array();}
	    $ptypeHTML = '<div class="qppr-posttypes">';
	    foreach($ptypes as $ptype){
	    	if($ptype != 'nav_menu_item' && $ptype != 'attachment' && $ptype != 'revision'){
		    	if(in_array($ptype,$ptypesok)){
		    		$ptypecheck = ' checked="checked"';
		    	}else{
		    		$ptypecheck = '';
		    	}
		    	$ptypeHTML .= '<div class="qppr-ptype"><input class="qppr-ptypecb" type="checkbox" name="ppr_qpprptypeok[]" value="'.$ptype.'"'.$ptypecheck.' /> <div class="ppr-type-name">'.$ptype.'</div></div>';
	    	}
	    }
	    $ptypeHTML .= '</div>';
	    ?>
			</td>
	        </tr>
	        <tr valign="top">
	        	<td><label><span style="color:#FF0000;font-weight:bold;font-size:100%;margin-left:0px;">Hide</span> meta box for following Post Types:</label><?php echo $ptypeHTML;?></td>
	        </tr>
	        <!--tr valign="top">
	        	<td><label>Use with jQuery? <i><font size="2" color="#FF0000">(unavailable at this time)</font></i></label> <input type="checkbox" name="ppr_use-jquery" value="1"<?php if(get_option('ppr_use-jquery')=='1'){echo ' checked="checked" ';} ?>/> <input type="checkbox" name="ppr_use-jquery" value="0" disabled /><span>disabled in current version<!--Increases effectiveness of plugin. If you have a jQuery conflict, try turning this off.></span></td>
	        </tr-->
	        <tr valign="top">
	        	<td><label>Meta Refresh Time (in seconds):</label> <input type="text" size="5" name="ppr_meta-seconds" value="<?php echo get_option('ppr_meta-seconds');?>" /> <span>Only needed for Meta Refresh. 0=default (instant)</span></td>
	        </tr>
	        <tr valign="top">
	        	<td><label>Meta Refresh Message:</label> <input type="text" size="25" name="ppr_meta-message" value="<?php echo get_option('ppr_meta-message');?>" /> <span>Default is blank. Message to display while waiting for refresh.</span></td>
	        </tr>
	        <tr valign="top">
	        	<td><h2 style="font-size:20px;">Master Override Options</h2><b>NOTE: </b>These will override all individual settings.</td>
	        </tr>
	        <tr valign="top">
	        	<td><label>Turn OFF all Redirects? </label><input type="checkbox" name="ppr_override-active" value="1"<?php if(get_option('ppr_override-active')=='1'){echo ' checked="checked" ';} ?>/> <span>Includes Quick 301 Redirects when "use with jQuery" is also selected.</span></td>
	        </tr>
	        <tr valign="top">
	        	<td><label>Make ALL Redirects have <code>rel="nofollow"</code>? </label><input type="checkbox" name="ppr_override-nofollow" value="1"<?php if(get_option('ppr_override-nofollow')=='1'){echo ' checked="checked" ';} ?>/> <span>Will not work on Quick Redirects at this time.<!--Includes Quick 301 Redirects when "use with jQuery" is also selected.--></span></td>
	        </tr>
	        <tr valign="top">
	        	<td><label>Make ALL Redirects open in a New Window? </label><input type="checkbox" name="ppr_override-newwindow" value="1"<?php if(get_option('ppr_override-newwindow')=='1'){echo ' checked="checked" ';} ?>/> <span>Will not work on Quick Redirects at this time.<!--Includes Quick 301 Redirects when "use with jQuery" is also selected.--></span></td>
	        </tr>
	        <tr valign="top">
	        	<td><label>Make ALL Redirects this type: </label>
	        	<select name="ppr_override-redirect-type">
	        		<option value="0">Use Individual Settings</option>
	        		<option value="301" <?php if( get_option('ppr_override-redirect-type')=='301') {echo ' selected="selected" ';} ?>>301 Permanant Redirect</option>
	        		<option value="302" <?php if( get_option('ppr_override-redirect-type')=='302') {echo ' selected="selected" ';} ?>>302 Temporary Redirect</option>
	        		<option value="307" <?php if( get_option('ppr_override-redirect-type')=='307') {echo ' selected="selected" ';} ?>>307 Temporary Redirect</option>
	        		<option value="meta" <?php if(get_option('ppr_override-redirect-type')=='meta'){echo ' selected="selected" ';} ?>>Meta Refresh Redirect</option>
	        	</select>
	        	<span> (Quick 301 Redirects will always be 301)</span></td>
	        </tr>
	        <tr valign="top">
	        	<td><label>Make ALL redirects Case Sensitive? </label><input type="checkbox" name="ppr_override-casesensitive" value="1"<?php if(get_option('ppr_override-casesensitive')=='1'){echo ' checked="checked" ';} ?>/> <span> Makes URLs CaSe SensiTivE - i.e., /somepage/ DOES NOT EQUAL /SoMEpaGe/</span></td>
	        </tr>
	        <tr valign="top">
	        	<td><label>Make ALL Redirects go to this URL: </label><input type="text" size="50" name="ppr_override-URL" value="<?php echo get_option('ppr_override-URL'); ?>"/> <span>Use full URL including <code>http://</code>.</span></td>
	        </tr>
	        <tr valign="top">
	        	<td><label>Rewrite ALL Redirects URLs to Show in LINK? </label><input type="checkbox" name="ppr_override-rewrite" value="1"<?php if(get_option('ppr_override-rewrite')=='1'){echo ' checked="checked" ';} ?>/> <span>Makes link show redirect URL instead of the original URL. Will not work on Quick Redirects at this time.<!--ONLY includes Quick 301 Redirects when "use with jQuery" is also selected.--></span></td>
	        </tr>
	        <tr valign="top">
	        	<td><h2 style="font-size:20px;">Plugin Clean Up</h2><b>NOTE: </b>This will DELETE all redirects - so be careful with this.</td>
	        </tr>
	        <tr valign="top">
	        	<td><label>Delete Redirects? </label><input class="button-secondary qppr_delete_reg" type="button" name="qppr_delete_reg" value="Delete all Page/Post Redirects" onclick="goOnConfirm('Are you sure you want to PERMANENTLY Delets ALL Regular Redirects?' , '?page=redirect-options&qppr_delete_reg=1');" /> <input class="button-secondary qppr_delete_qr" type="button" name="qppr_delete_qr" value="Delete all Quick Redirects" onclick="goOnConfirm('Are you sure you want to PERMANENTLY Delets ALL Quick Redirects?' , '?page=redirect-options&qppr_delete_qr=1');" /></td>
	        </tr>
	    </table>
	    <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
	</form>
	</div>
	<?php } 
	
	function ppr_options_page(){
	//generate the options page in the wordpress admin
		//$tohash = $this->homelink.'/';
		$tohash = site_url('/', 'admin');
		?>
		<div class="wrap">
		<div class="icon32" style="<?php echo 'background: url('.plugins_url( 'settings-icon.png' , __FILE__ ).') no-repeat transparent;';?>"><br></div>
		<script type="text/javascript">jQuery(document).ready(function() { var mainurl = '<?php echo site_url('/', 'admin') ;?>'; jQuery(".delete-qppr").click(function(){ var thepprdel = jQuery(this).attr('id'); if(confirm('Are you sure you want to delete this redirect?')){ jQuery.ajax({ url: mainurl,data : "pprd="+thepprdel+"&scid=<?php echo md5($tohash);?>", success: function(data, textStatus){ jQuery('#row'+thepprdel).remove(); }, complete: function(){ jQuery(".pprnewwin").each(function (i) { jQuery(this).attr('name','quickppr_redirects[newwindow]['+jQuery(".pprnewwin").index(this)+']'); }); jQuery(".pprnofoll").each(function (i) { jQuery(this).attr('name','quickppr_redirects[nofollow]['+jQuery(".pprnofoll").index(this)+']'); }); } }); return false; }else{ return false; } }); jQuery("#hidepprjqmessage").click(function(){ jQuery.ajax({ url: mainurl,data : "pprhidemessage=1", success: function(data){ jQuery('#usejqpprmessage').remove(); } }); return false; }); jQuery("#hidepprjqmessage2").click(function(){ jQuery.ajax({ url: mainurl,data : "pprhidemessage=2", success: function(data){ jQuery('#usejqpprmessage2').remove(); } }); return false; }); });</script>
		<style type="text/css">div.info{background-color:#dceff8;border-color:#c00;margin: 5px 0 15px;padding: 5px;border:1px solid #2e92c1;border-radius: 3px;}div.info a{color:#2e92c1;}.usejqpprmessage{overflow:hidden;}.hidepprjqmessage{float:right;font-size:11px;}.delete-qppr{border: 1px solid #FFBBBB;display: inline-block;font-weight: bold;padding: 0 5px;text-decoration: none;text-transform: uppercase;}</style>
		<h2>Quick 301 Redirects</h2>
		<?php if($this->updatemsg!=''){?><div class="updated settings-error" id="setting-error-settings_updated"><p><strong><?php echo $this->updatemsg;?></strong></p></div><?php } ?>
		<?php $this->updatemsg ='';//reset message;?>
		<?php $isJQueryOn = get_option('ppr_use-jquery');$isJQueryMsgHidden = get_option('qppr_jQuery_hide_message');$isJQueryMsgHidden2 = get_option('qppr_jQuery_hide_message2');?>
		<!--
		<?php if($isJQueryOn == '' && ($isJQueryMsgHidden =='' || $isJQueryMsgHidden =='0')){?>
			<div class="usejqpprmessage error below-h2" id="usejqpprmessage"><code>Use with jQuery</code> option is turned off in plugin settings.<br/>In order to use NW (open in a new window) or NF (add rel="nofollow") options for Quick Redirects, you must have it enabled.<br/>
			<div class="hidepprjqmessage" style=""><a href="javascript:void(0);" id="hidepprjqmessage">hide this message</a></div></div>
		<?php }elseif($isJQueryMsgHidden2 !='1'){ ?>
			<div class="usejqpprmessage info below-h2" id="usejqpprmessage2">The <b>NW </b>(open in a new window)<b> NF</b> (nofollow) options are new for this version.<br/>To use them, just click the appropriate option and update. Then, any link in the page that has the request URL will be updated with these options (as long as you have <code>use with jQuery</code> enabled in the plugin settings.
			<div class="hidepprjqmessage" style=""><a href="javascript:void(0);" id="hidepprjqmessage2">hide this message</a></div></div>
		<?php }else{ ?>
		<br/>
		<?php }?>
		-->This section is useful if you have links from an old site and need to have them redirect to a new location on the current site, or if you have an existing URL that you need to send some place else and you don't want to have a Page or Post created to use the other Page/Post Redirect option.
		To add these additional 301 redirects, put the URL you want to redirect into the Request field and the place it should redirect to in the Destination field. To delete a redirect, click the 'x' next to the Destination Field. 
		<!--If you want the redirect to open in a new window or to add rel=nofollow to the link, select the NW (new Window) or NF (no Follow) boxes next to the appropriate redirect (must enable 'use jQuery' in settings for this to work).-->
		<br/>
		<br/><b style="color:red;">IMPORTANT TROUBLE SHOOTING NOTES:</b> 
		<ol style="margin-top:5px;">
			<li style="color:#214070;margin-left:15px;list-style-type:disc;">Until some jQuery issues are resolved, the New Window and No Follow features will not work for Quick Redirects.</li>
			<li style="color:#214070;margin-left:15px;list-style-type:disc;">The <b>Request</b> field should be relative to the ROOT directory and contain the <code>/</code> at the beginning.</li>
			<li style="color:#214070;margin-left:15px;list-style-type:disc;">The <b>Destination</b> field can be any valid URL or relative path (from root).</li>
			<!--li style="color:#214070;margin-left:25px;list-style-type:disc;">In order for NW (open in a new window) or NF (rel=&quot;nofollow&quot;) options to work with Quick Redirects, you need to have:
			<ol>
				<li>&quot;Use with jQuery&quot; option selected in the settings page</li>
				<li>A link that uses the request url SOMEWHERE in your site page - i.e., in a menu, content, sidebar, etc. </li>
				<li>The open in a new window or nofollow settings will not happen if someone just types the old link in the URL or if that come from a bookmark or link outside your site - in essence, there needs to be a link that they click on in your site so that the jQuery script can add the appropriate <code>target</code> and <code>rel</code> properties to the link to make it work.</li>
			</ol>
			</li-->
			
		</ol>
		<form method="post" action="admin.php?page=redirect-updates">
       <?php wp_nonce_field( 'add_qppr_redirects' ); ?>
		<table>
			<tr>
				<th align="left">Request</th>
				<th align="left">Destination</th>
				<th align="left">NW</th>
				<th align="left">NF</th>
				<th align="left">Delete</th>
			</tr>
			<tr>
				<td><small>example: <code>/about.htm</code> or <code>/directory/landing/</code></small></td>
				<td><small>example: <code><?php echo $this->homelink; ?>/about/</code></small></td>
				<td>&nbsp;</td>
			</tr>
			<?php echo $this->expand_redirects(); ?>
			<tr>
				<td><input type="text" name="quickppr_redirects[request][]" value="" style="width:27em" />&nbsp;&raquo;&nbsp;</td>
				<td><input type="text" name="quickppr_redirects[destination][]" value="" style="width:27em;" /></td>
				<td align="center"><input class="pprnewwin" type="checkbox" name="quickppr_redirects[newwindow][<?php if(count($this->quickppr_redirects)==0){echo '0';}else{echo (count($this->quickppr_redirects));}?>]" value="1" title="open in a New Window" /></td>
				<td align="center"><input class="pprnofoll" type="checkbox" name="quickppr_redirects[nofollow][<?php if(count($this->quickppr_redirects)==0){echo '0';}else{echo (count($this->quickppr_redirects));}?>]" value="1" title="add No Follow" /></td>
				<td align="center"></td>
			</tr>
		</table>
		
		<p class="submit">
		<input type="submit" name="submit_301" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
		</form>
		</div>
		
		<?php
	} 

	function save_redirects($data){
	// Save the redirects from the options page to the database
		$redirects = array();
		$redirectsmeta = array();
		for($i = 0; $i < sizeof($data['request']); ++$i) {
			$request 		= sanitize_text_field(trim($data['request'][$i]));
			$destination 	= sanitize_text_field(trim($data['destination'][$i]));
			$newwin 		= sanitize_text_field(trim($data['newwindow'][$i]));
			$nofoll 		= sanitize_text_field(trim($data['nofollow'][$i]));
			if(strpos($request,'/',0) !== 0 && strpos($request,'http',0) !== 0){$request = '/'.$request;} // adds root marker to front if not there
			if((strpos($request,'.') === false && strpos($request,'?') === false) && strpos($request,'/',strlen($request)-1) === false){$request = $request.'/';} // adds end folder marker if not a file end
			if (($request == '' || $request == '/') && $destination == '') { continue;} elseif($request != '' && $request != '/' && $destination == '' ){$redirects[$request] = $this->homelink.'/';}else { $redirects[$request] = $destination; }
			$redirectsmeta[$request]['newwindow'] = ($newwin == '1' || $newwin =='0') ? $newwin : '0' ;
			$redirectsmeta[$request]['nofollow'] = ($nofoll == '1' || $nofoll == '0') ? $nofoll : '0' ;
		}
		update_option('quickppr_redirects', sanitize_option('quickppr_redirects',$redirects));
		update_option('quickppr_redirects_meta', sanitize_option('quickppr_redirects_meta',$redirectsmeta));
		$this->quickppr_redirectsmeta = get_option('quickppr_redirects_meta');
		$this->quickppr_redirects = get_option('quickppr_redirects');
		return $redirects;
	}
	
	function expand_redirects(){
	//utility function to return the current list of redirects as form fields
		$output = '';
		if (!empty($this->quickppr_redirects)) {
			$ww=1;
			foreach ($this->quickppr_redirects as $request => $destination) {
				$newWindow = $this->quickppr_redirectsmeta[$request]['newwindow'];
				$noFollow  = $this->quickppr_redirectsmeta[$request]['nofollow'];
				if($newWindow == '1'){$newChecked = ' checked="checked"';}else{$newChecked = '';}
				if($noFollow == '1'){$noChecked = ' checked="checked"';}else{$noChecked = '';}
				$output .= '
				<tr id="rowpprdel-'.$ww.'">
					<td><input type="text" name="quickppr_redirects[request][]" value="'.esc_attr($request).'" style="width:27em" />&nbsp;&raquo;&nbsp;</td>
					<td><input type="text" name="quickppr_redirects[destination][]" value="'.esc_attr($destination).'" style="width:27em;" /></td>
					<td align="center"><input class="pprnewwin" type="checkbox" name="quickppr_redirects[newwindow]['.($ww - 1).']" value="1"'.$newChecked.' title="open in a New Window" /></td>
					<td align="center"><input class="pprnofoll" type="checkbox" name="quickppr_redirects[nofollow]['.($ww - 1).']" value="1"'.$noChecked.' title="add No Follow" /></td>
					<td align="center">&nbsp;&nbsp;<a href="javascript:void();" id="pprdel-'.$ww.'" class="delete-qppr">X</a>&nbsp;</td>
				</tr>
				';
				$ww++;
			}
		}
		return $output;
	}
	

	function ppr_filter_links ($link = '', $post = array()) {
		if(isset($post->ID)){	
			$id = $post->ID;
		}else{
			$id = $post;
		}
		$newCheck = $this->ppr_all_redir_array;
		if(!is_array($newCheck)){$newCheck = array();}
		if(array_key_exists($id, $newCheck)){
			$matchedID = $newCheck[$id];
			if($matchedID['_pprredirect_rewritelink'] == '1' || $this->pproverride_rewrite =='1'){ // if rewrite link is checked or override is set
				if($this->pproverride_URL ==''){$newURL = $matchedID['_pprredirect_url'];}else{$newURL = $this->pproverride_URL;} // check override
				if(strpos($newURL,$this->homelink)>=0 || strpos($newURL,'www.')>=0 || strpos($newURL,'http://')>=0 || strpos($newURL,'https://')>=0){
					$link = esc_url( $newURL );
				}else{
					$link = esc_url( $this->homelink.'/'. $newURL );
				}
			}
		}

		return $link;
	}
	function ppr_filter_page_links ($link, $post) {
		if(isset($post->ID)){	
			$id = $post->ID;
		}else{
			$id = $post;
		}
		$newCheck = $this->ppr_all_redir_array;
		if(!is_array($newCheck)){$newCheck = array();}
		if(array_key_exists($id, $newCheck)){
			$matchedID = $newCheck[$id];
			if($matchedID['_pprredirect_rewritelink'] == '1' || $this->pproverride_rewrite =='1'){ // if rewrite link is checked
				if($this->pproverride_URL ==''){$newURL = $matchedID['_pprredirect_url'];}else{$newURL = $this->pproverride_URL;} // check override
				if(strpos($newURL,$this->homelink)>=0 || strpos($newURL,'www.')>=0 || strpos($newURL,'http://')>=0 || strpos($newURL,'https://')>=0){
					$link = esc_url( $newURL );
				}else{
					$link = esc_url( $this->homelink.'/'. $newURL );
				}
			}
		}

		return $link;
	}
	
	
	function ppr_add_metabox(){
		if( function_exists( 'add_meta_box' ) ) {
			$usetypes = get_option('ppr_use-custom-post-types')!= '' ? get_option('ppr_use-custom-post-types') : '0';
			if($usetypes == '1'){
				$post_types_temp = get_post_types();
				if(count($post_types_temp)==0){
					$post_types_temp = array('page' => 'page','post' => 'post','attachment' => 'attachment','nav_menu_item' => 'nav_menu_item');
				}
			}else{
				$post_types_temp = array('page' => 'page','post' => 'post'/*,'attachment' => 'attachment','nav_menu_item' => 'nav_menu_item'*/);
			}
			unset($post_types_temp['revision']); //remove revions from array if present as they are not needed.
			unset($post_types_temp['attachment']); //remove from array if present as they are not needed.
			unset($post_types_temp['nav_menu_item']); //remove from array if present as they are not needed.
			$ptypesok = $this->pprptypes_ok;
			if($ptypesok==''){$ptypesok = array();}
			if(!is_array($ptypesok)){$ptypesok = array();}
			foreach($post_types_temp as $type){
				if(!in_array($type,$ptypesok)){
					add_meta_box( 'edit-box-ppr', 'Quick Page/Post Redirect', array($this,'edit_box_ppr_1'), $type, 'normal', 'high' ); 
				}
			}
		}
	}
	
	function get_main_array(){
		global $wpdb;
		$theArray = array();
		$theArrayNW = array();
		$theArrayNF = array();
		$theqsl = "SELECT * FROM $wpdb->postmeta a, $wpdb->posts b  WHERE a.`post_id`=b.`ID` AND b.`post_status`!='trash' AND (a.`meta_key` = '_pprredirect_active' OR a.`meta_key` = '_pprredirect_rewritelink' OR a.`meta_key` = '_pprredirect_newwindow' OR a.`meta_key` = '_pprredirect_relnofollow' OR a.`meta_key` = '_pprredirect_type' OR a.`meta_key` = '_pprredirect_url') ORDER BY a.`post_id` ASC;";
		$thetemp = $wpdb->get_results($theqsl);
		if(count($thetemp)>0){
			foreach($thetemp as $key){
				$theArray[$key->post_id][$key->meta_key] = $key->meta_value;
			}
			foreach($thetemp as $key){
				// defaults
				if(!isset($theArray[$key->post_id]['_pprredirect_rewritelink'])){$theArray[$key->post_id]['_pprredirect_rewritelink']	= 0;}
				if(!isset($theArray[$key->post_id]['_pprredirect_url'])){$theArray[$key->post_id]['_pprredirect_url']					= '';}
				if(!isset($theArray[$key->post_id]['_pprredirect_type'] )){$theArray[$key->post_id]['_pprredirect_type']				= 302;}
				if(!isset($theArray[$key->post_id]['_pprredirect_relnofollow'])){$theArray[$key->post_id]['_pprredirect_relnofollow']	= 0;}
				if(!isset($theArray[$key->post_id]['_pprredirect_newwindow'] ))	{$theArray[$key->post_id]['_pprredirect_newwindow']		= 0;}
				if(!isset($theArray[$key->post_id]['_pprredirect_active'] )){$theArray[$key->post_id]['_pprredirect_active']			= 0;}
				
				if($theArray[$key->post_id]['_pprredirect_newwindow']!= '0' || $this->pproverride_newwin =='1'){
					$theArrayNW[$key->post_id] = get_permalink($key->ID);
				}
				
				if($theArray[$key->post_id]['_pprredirect_relnofollow']!= '0' || $this->pproverride_nofollow =='1'){
					$theArrayNF[$key->post_id] = get_permalink($key->ID);
				}
			}

		}
		$this->ppr_newwindow = $theArrayNW;
		$this->ppr_nofollow = $theArrayNF;
		return $theArray;
	}
	
	function get_value($theval='none'){
		return isset($this->$theval) ? $this->$theval : 0;
	}
	
	function ppr_addmetatohead_theme(){
		$themsgmeta = '';
		$themsgmsg 	= '';
		$hook_name 	= 'ppr_meta_head_hook';
		// check URL override
	    if($this->pproverride_URL !=''){$urlsite = $this->pproverride_URL;} else {$urlsite = $this->ppr_metaurl;}
	    $this->pproverride_URL = ''; //reset
	    if($this->pprmeta_seconds==''){$this->pprmeta_seconds='0';}
		$themsgmeta =  '<meta http-equiv="refresh" content="'.$this->pprmeta_seconds.'; URL='.$urlsite.'" />'."\n";
		if($this->pprmeta_message!='' && $this->pprmeta_seconds!='0'){$themsgmsg =  '<div style="margin-top:20px;text-align:center;">'.$this->pprmeta_message.'</div>'."\n";}
		if( has_action($hook_name)){
			do_action( $hook_name,$urlsite,$this->pprmeta_seconds,$this->pprmeta_message);
			return;
		}elseif( has_filter($hook_name.'_filter')){
			$themsgmeta = apply_filters($hook_name, $themsgmeta,$themsgmsg);
			echo $themsgmeta;
			return;
		}else{
			echo $themsgmeta;
			echo $themsgmsg;
			exit; //stop loading page so meta can do it's job without rest of page loading.
		}
	}

	function ppr_queryhook($vars) {
		$vars[] = 'pprd';
		$vars[] = 'scid';
		$vars[] = 'pprjq';
		$vars[] = 'ver';
		$vars[] = 'pprhidemessage';
		$vars[] = 'qppr_delete_reg';
		$vars[] = 'qppr_delete_qr';
		$vars[] = 'ftype';
		return $vars;
	}
	function ppr_parse_request_new($wp) {
		global $wp, $wpdb;
		if(is_admin() && (isset($_GET['qppr_delete_reg']) || isset($_GET['qppr_delete_qr']))){
			if( $_GET['qppr_delete_reg'] =='1'){
				global $wpdb;
				$wpdb->query("DELETE FROM $wpdb->postmeta WHERE `meta_key` = '_pprredirect_active' OR `meta_key` = '_pprredirect_rewritelink' OR `meta_key` = '_pprredirect_newwindow' OR `meta_key` = '_pprredirect_relnofollow' OR `meta_key` = '_pprredirect_type' OR `meta_key` = '_pprredirect_url';");
				//wp_redirect('admin.php?page=redirect-options&update=2&settings-updated=true',200);
				wp_redirect(admin_url('admin.php?page=redirect-options&update=2&settings-updated=true'));
				exit;
			}elseif($_GET['qppr_delete_qr'] =='1'){
				delete_option('quickppr_redirects');
				delete_option('quickppr_redirects_meta');
				//wp_redirect('admin.php?page=redirect-options&update=3&settings-updated=true',200);
				wp_redirect(admin_url('admin.php?page=redirect-options&update=3&settings-updated=true'));
				exit;
			}elseif($_GET['qppr_export_qr'] =='1'){
				wp_die('This option is not available at this time.','Quick Page/Post Redirect Plugin - Export',array('back_link'=>true));
				exit;
			}elseif($_GET['qppr_import_qr'] =='1'){
				wp_die('This option is not available at this time.','Quick Page/Post Redirect Plugin - Import',array('back_link'=>true));
				exit;
			}
		}elseif ( isset($_GET['action']) && $_GET['action'] == 'export_redirects_qppr' ) {
			$newQPPR_Array = array();
			check_admin_referer('export-redirects-qppr');
			$type	= (isset($_GET['ftype']) && ($_GET['ftype']=='encoded' || $_GET['ftype'] =='pipe')) ? $wpdb->escape($_GET['ftype']) : 'pipe' ; // can be 'encoded' or 'pipe';
			header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' ); 
			header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' ); 
			header( 'Cache-Control: no-store, no-cache, must-revalidate' ); 
			header( 'Cache-Control: post-check=0, pre-check=0', false ); 
			header( 'Pragma: no-cache' ); 
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header("Content-Disposition: attachment; filename=qppr-quick-redirects-export-".date('U').".txt;");
			$newQPPR_Array['quickppr_redirects'] = get_option('quickppr_redirects');
			$newQPPR_Array['quickppr_redirects_meta'] = get_option('quickppr_redirects_meta');
			if($type == 'encoded'){
				die('QUICKPAGEPOSTREDIRECT'.base64_encode(serialize($newQPPR_Array)));
			}else{
				if(is_array($newQPPR_Array)){
					$qpprs = $newQPPR_Array['quickppr_redirects'];
					$qpprm = $newQPPR_Array['quickppr_redirects_meta'];
					foreach($qpprs as $key=>$val){
						$nw = (isset($qpprm[$key]['newwindow']) && $qpprm[$key]['newwindow']=='1') ? $qpprm[$key]['newwindow'] : '0' ;
						$nf = (isset($qpprm[$key]['nofollow']) && $qpprm[$key]['nofollow'] == '1') ? $qpprm[$key]['nofollow'] : '0' ;
						$temps = str_replace('|','%7C',$key).'|'.str_replace('|','%7C',$val).'|'.$nw.'|'.$nf;
						if($temps!='|||'){
							$newline[] = $temps;
						}
					}
					$newfile 	= implode("\r\n",$newline);
				}else{
					$newfile = $newtext;
				}
				die($newfile);				
			}
			exit;
		} elseif( isset($_POST['import_redirects_qppr']) && isset($_FILES['qppr_file']) ) {
			check_admin_referer( 'import_redirects_qppr' );
			if ( $_FILES['qppr_file']['error'] > 0 ) {
				wp_die('An error occured during the file upload. Please fix your server configuration and retry.', 'SERVER ERROR - Could Not Load',array('response'=>'200','back_link'=>'1'));
				exit;
			} else {
				$config_file = file_get_contents( $_FILES['qppr_file']['tmp_name'] );
				if ( substr($config_file, 0, strlen('QUICKPAGEPOSTREDIRECT')) !== 'QUICKPAGEPOSTREDIRECT' ) {
					if(strpos($config_file,'|') !== false){
						$text		= explode("\r\n",$config_file);
						$newfile1 	= array();
						if(is_array($text)){
							foreach($text as $nl){
								if($nl!=''){
									$elem = explode('|',$nl);
									$newfile1['quickppr_redirects'][sanitize_text_field($elem[0])] = sanitize_text_field($elem[1]);
									$nw = isset($elem[2]) && $elem[2] == '1' ? '1' : '';
									$nf = isset($elem[3]) && $elem[3] == '1' ? '1' : '';
									$newfile1['quickppr_redirects_meta'][$elem[0]]['newwindow'] = $nw;
									$newfile1['quickppr_redirects_meta'][$elem[0]]['newwindow'] = $nf;
								}
							}
							if(is_array($newfile1)){
								if(isset($newfile1['quickppr_redirects'])){update_option('quickppr_redirects', $newfile1['quickppr_redirects']);}
								if(isset($newfile1['quickppr_redirects_meta'])){update_option('quickppr_redirects_meta', $newfile1['quickppr_redirects_meta']);}
							}
						}
						wp_redirect(admin_url('admin.php?page=redirect-options&update=4'),302);
					}else{
						wp_die('This does not look like a Quick Page Post Redirect config file - it is possibly damaged or corrupt.', 'ERROR - Not a valid File',array('response'=>'200','back_link'=>'1'));
						exit;
					}
				} else {
					$config_file = unserialize(base64_decode(substr($config_file, strlen('QUICKPAGEPOSTREDIRECT'))));
					if ( !is_array($config_file) ) {
						wp_die('This does not look like a Quick Page Post Redirect config file - it is possibly damaged or corrupt.', 'ERROR - Not a valid File',array('response'=>'200','back_link'=>'1'));
						exit;
					} else {
						$newQPPRRedirects 	= $config_file['quickppr_redirects'];
						$newQPPRMeta 		= $config_file['quickppr_redirects_meta'];
						update_option('quickppr_redirects', $newQPPRRedirects);
						update_option('quickppr_redirects_meta', $newQPPRMeta);
						wp_redirect(admin_url('admin.php?page=redirect-options&update=4'),302);
					}
				}
			}
		} elseif( isset($_POST['import_redirects_add_qppr']) && isset($_FILES['qppr_file_add']) ) {
			check_admin_referer( 'import_redirects_add_qppr' );
			if ( $_FILES['qppr_file_add']['error'] > 0 ) {
				wp_die('An error occured during the file upload. Please fix your server configuration and retry.', 'SERVER ERROR - Could Not Load',array('response'=>'200','back_link'=>'1'));
				exit;
			} else {
				$config_file = file_get_contents( $_FILES['qppr_file_add']['tmp_name'] );
				if ( strpos($config_file,'|') === false ) {
					wp_die('This does not look like the file is in the correct format - it is possibly damaged or corrupt.<br/>be sure the redirects are 1 per line and the redirect and destination are seperated by a PIPE (|).<br/>Example:<br/><br/><code>redirect|destination</code>', 'ERROR - Not a valid File',array('response'=>'200','back_link'=>'1'));
					exit;
				} else {
					$tempArr	= array();
					$tempMArr	= array();
					$QR_Array 	= explode("\n",$config_file);
					if(!empty($QR_Array) && is_array($QR_Array)):
						foreach($QR_Array as $qrtoadd):
							if($qrtoadd != '' && strpos($qrtoadd,'|') !== false){
								$item = explode('|',str_replace(array("\r","\n"), array('',''),$qrtoadd));	
								if(is_array($item) && !empty($item)){
									$tempArr[sanitize_text_field($item[0])] = sanitize_text_field($item[1]);
									if(isset( $item[2]) || isset( $item[3])){
										$newwin = (isset($item[2]) && ($item[2] != '' && $item[2] != '0')) ? 1 : '';
										$nofoll = (isset($item[3]) && ($item[3] != '' && $item[3] != '0')) ? 1 : '';
										$tempMArr[$item[0]]['newwindow'] 	= $newwin;
										$tempMArr[$item[0]]['nofollow'] 	= $nofoll;
									}else{
										$tempMArr[$item[0]]['newwindow'] = '';
										$tempMArr[$item[0]]['nofollow'] = '';
									}
								}
							}
						endforeach;	
						if(!empty($tempArr)){
							$temp = get_option('quickppr_redirects');
							$currQRs = ($temp !='' && is_array($temp)) ? $temp : array();
							$resultQR = array_merge($currQRs, $tempArr);
							update_option('quickppr_redirects',$resultQR);
						}
						if(!empty($tempMArr)){
							$temp = get_option('quickppr_redirects_meta');
							$currQRM = ($temp !='' && is_array($temp)) ? $temp : array();
							$resultQRM = array_merge($currQRM, $tempMArr);
							update_option('quickppr_redirects_meta',$resultQRM);
						}
						wp_redirect(admin_url('admin.php?page=redirect-options&update=5'),302);
						exit;
					else:
						wp_die('Does not look like there are any valid items to import - check the file and try again.', 'ERROR - No Valid items to add.',array('response'=>'200','back_link'=>'1'));
						exit;
					endif;
				}
			}
		}		return;
	}
	function ppr_parse_request($wp) {
		global $wp;
		if(array_key_exists('pprd', $wp->query_vars) && array_key_exists('scid', $wp->query_vars)){
			$tohash = get_bloginfo('url').'/';
			if( $wp->query_vars['pprd'] !='' && $wp->query_vars['scid'] == md5($tohash)){
				$theDel = str_replace('pprdel-','',$wp->query_vars['pprd']);
				$redirects = get_option('quickppr_redirects');
				$redirectsmeta = get_option('quickppr_redirects_meta');
				if (!empty($redirects)) {
					$ww=1;
					foreach ($redirects as $request => $destination) {
						if($ww != (int)$theDel){
							$quickppr_redirects[$request] = $destination;
							$quickppr_redirectsmeta[$request] = $redirectsmeta[$request];
						}
					$ww++;
					}
				} // end if
				update_option('quickppr_redirects',$quickppr_redirects);
				update_option('quickppr_redirects_meta',$quickppr_redirectsmeta);
				echo 1;
				exit;
			}else{
				echo 0;
				exit;
			}
		}elseif(array_key_exists('pprhidemessage', $wp->query_vars)){
			if( $wp->query_vars['pprhidemessage'] =='1'){
				update_option('qppr_jQuery_hide_message','1');
				echo '1';
				exit;
			}elseif($wp->query_vars['pprhidemessage'] =='2'){
				update_option('qppr_jQuery_hide_message2','1');
				echo '1';
				exit;
			}
			return;
		}else{
			return;
		}
	}
	
	function ppr_init_check_version() {
	// checks version of plugin in DB and updates if needed.
		$this->ppr_all_redir_array	= $this->get_main_array();
		$this->pprptypes_ok			= get_option( 'ppr_qpprptypeok' );
		
		global $wpdb;
		if($this->thepprversion != $this->ppr_curr_version){
			update_option( 'ppr_use-jquery','0'); //default to off
			update_option( 'ppr_override-casesensitive', '1' );
			$this->ppruse_jquery 	= '0';
			$this->pproverride_casesensitive = '1';
			update_option( 'ppr_version', $this->ppr_curr_version );
		}
		if($this->thepprmeta != '1'){
			update_option( 'ppr_meta_clean', '1' );
			$wpdb->query("UPDATE $wpdb->postmeta SET `meta_key` = CONCAT('_',`meta_key`) WHERE `meta_key` = 'pprredirect_active' OR `meta_key` = 'pprredirect_rewritelink' OR `meta_key` = 'pprredirect_newwindow' OR `meta_key` = 'pprredirect_relnofollow' OR `meta_key` = 'pprredirect_type' OR `meta_key` = 'pprredirect_url';");
		}
	}

	function ppr_filter_plugin_actions($links){
		$new_links = array();
		$new_links[] = '<a href="'.$this->fcmlink.'/donations/">Donate</a>';
		return array_merge($links,$new_links );
	}
	
	function ppr_filter_plugin_links($links, $file){
		if ( $file == plugin_basename(__FILE__) ){
			$links[] = '<a href="'.$this->adminlink.'admin.php?page=redirect-updates">Quick Redirects</a>';
			$links[] = '<a href="'.$this->adminlink.'admin.php?page=redirect-faqs">FAQ</a>';
			$links[] = '<a target="_blank" href="'.$this->fcmlink.'/donations/">Donate</a>';
		}
		return $links;
	}
	
	function edit_box_ppr_1() {
	// Prints the inner fields for the custom post/page section 
		global $post;
		$ppr_option1='';
		$ppr_option2='';
		$ppr_option3='';
		$ppr_option4='';
		$ppr_option5='';
		// Use nonce for verification ... ONLY USE ONCE!
		wp_nonce_field( 'pprredirect_noncename', 'pprredirect_noncename', false, true );
		// The actual fields for data entry
		$pprredirecttype = get_post_meta($post->ID, '_pprredirect_type', true) !='' ? get_post_meta($post->ID, '_pprredirect_type', true) : "";
		$pprredirecturl =  get_post_meta($post->ID, '_pprredirect_url', true)!='' ? get_post_meta($post->ID, '_pprredirect_url', true) : "";
		echo '<label for="pprredirect_active" style="padding:2px 0;"><input type="checkbox" name="pprredirect_active" value="1" '. checked('1',get_post_meta($post->ID,'_pprredirect_active',true),0).' />&nbsp;Make Redirect <b>Active</b>.<span class="qppr_meta_help_wrap"><span class="qppr_meta_help_icon">?</span><span class="qppr_meta_help">Check to turn on or redirect will not work.</span></span></label><br />';
		echo '<label for="pprredirect_newwindow" style="padding:2px 0;"><input type="checkbox" name="pprredirect_newwindow" id="pprredirect_newwindow" value="_blank" '. checked('_blank',get_post_meta($post->ID,'_pprredirect_newwindow',true),0).'>&nbsp;Open redirect link in a <b>new window.</b><span class="qppr_meta_help_wrap"><span class="qppr_meta_help_icon">?</span><span class="qppr_meta_help">May not work in all cases.</span></span></label><br />';
		echo '<label for="pprredirect_relnofollow" style="padding:2px 0;"><input type="checkbox" name="pprredirect_relnofollow" id="pprredirect_relnofollow" value="1" '. checked('1',get_post_meta($post->ID,'_pprredirect_relnofollow',true),0).'>&nbsp;Add <b>rel="nofollow"</b> to redirect link.<span class="qppr_meta_help_wrap"><span class="qppr_meta_help_icon">?</span><span class="qppr_meta_help">May not work in all cases.</span></span></label><br />';
		echo '<label for="pprredirect_rewritelink" style="padding:2px 0;"><input type="checkbox" name="pprredirect_rewritelink" id="pprredirect_rewritelink" value="1" '. checked('1',get_post_meta($post->ID,'_pprredirect_rewritelink',true),0).'>&nbsp;<b>Show</b> the Redirect URL instead of original URL. <span class="qppr_meta_help_wrap"><span class="qppr_meta_help_icon">?</span><span class="qppr_meta_help">May not always work and will only show the link - <strong><em>but NOT in the Address bar, just the link itself.</em></strong></span></span></label><br /><br />';
		//echo '<label for="pprredirect_casesensitive" style="padding:2px 0;"><input type="checkbox" name="pprredirect_casesensitive" id="pprredirect_casesensitive" value="1" '. checked('1',get_post_meta($post->ID,'_pprredirect_casesensitive',true),0).'>&nbsp;Make the Redirect Case Insensitive.</label><br /><br />';
		echo '<label for="pprredirect_url"><b>Redirect URL:</b></label><br />';
		echo '<input type="text" style="width:75%;margin-top:2px;margin-bottom:2px;" name="pprredirect_url" value="'.$pprredirecturl.'" /><span class="qppr_meta_help_wrap"><span class="qppr_meta_help_icon">?</span><span class="qppr_meta_help"><br />(i.e., <strong>http://example.com</strong> or <strong>/somepage/</strong> or <strong>p=15</strong> or <strong>155</strong>. Use <b>FULL URL</b> <i>including</i> <strong>http://</strong> for all external <i>and</i> meta redirects.)</span></span><br /><br />';
		echo '<label for="pprredirect_type"><b>Type of Redirect:</b></label><br />';
		
		switch($pprredirecttype):
			case "":
				$ppr_option2=" selected";//default
				break;
			case "301":
				$ppr_option1=" selected";
				break;
			case "302":
				$ppr_option2=" selected";
				break;
			case "307":
				$ppr_option3=" selected";
				break;
			case "meta":
				$ppr_option5=" selected";
				break;
		endswitch;
		
		echo '
		<select style="margin-top:2px;margin-bottom:2px;width:40%;" name="pprredirect_type">
		<option value="301" '.$ppr_option1.'>301 Permanent</option>
		<option value="302" '.$ppr_option2.'>302 Temporary</option>
		<option value="307" '.$ppr_option3.'>307 Temporary</option>
		<option value="meta" '.$ppr_option5.'>Meta Redirect</option>
		</select><span class="qppr_meta_help_wrap"><span class="qppr_meta_help_icon">?</span><span class="qppr_meta_help">Default is 302 (Temporary Redirect). </span></span><br /><br />
		';
		echo '<b>NOTE:</b> For a Page or Post (or Custom Post) Redirect to work, it may need to be published first and then saved again as a Draft. If you do not already have a page/post created you can add a \'Quick\' redirect using the <a href="./admin.php?page=redirect-updates">Quick Redirects</a> method.';
	}
	function appip_parseURI($url){
		/*
		[scheme]
		[host]
		[user]
		[pass]
		[path]
		[query]
		[fragment]
		*/
		$strip_protocol = 0;
		$tostrip = '';
		//if($url == '' || $url == 'http://' || $url == 'https://' ){ return $url;}
		
		if(substr($url,0,2) == 'p=' || substr($url,0,8) == 'page_id='){ // page or post id
			$url = network_site_url().'/?'.$url;
		}elseif(is_numeric($url)){ // page or post id
			$url = network_site_url().'/?'.$url;
		}elseif($url == "/" ){ // root
			$url = network_site_url().'/';
		}elseif(substr($url,0,1) == '/' ){ // relative to root
			$url =  network_site_url().$url;
			$strip_protocol = 1;
			$tostrip = network_site_url(); 
		}elseif(substr($url,0,7) != 'http://' && substr($url,0,8) != 'https://' ){ // no protocol so add it
			//$url = "http://".$url;
			//desided not to add it automatically.
		}
		$info = @parse_url($url);
		if($strip_protocol == 1 && $tostrip != '' ){
			$info['url'] = str_replace($tostrip, '', $url);
		}else{
			$info['url'] = $url;
		}
		return $info;
	}
	
	function isOne_none($val=''){ //true (1) or false =''
		if($val == '_blank'){
			return $val;
		}elseif($val == '1' || $val == 'true' || $val === true ){
			return 1;
		}
		return '';
	}
	
	function ppr_save_metadata($post_id, $post) {
		if($post->post_type == 'revision'){return;}
		// verify authorization
		if(isset($_POST['pprredirect_noncename'])){
			if ( !wp_verify_nonce( $_REQUEST['pprredirect_noncename'], 'pprredirect_noncename' )) {
				return $post_id;
			}
		}
		// check allowed to editing
		if ( !current_user_can('edit_posts', $post_id)){
				return $post_id;
		}
		if(!empty($my_meta_data)){unset($my_meta_data);}
		$my_meta_data = array();
		if(isset($_POST['pprredirect_active']) || isset($_POST['pprredirect_url']) || isset($_POST['pprredirect_type']) || isset($_POST['pprredirect_newwindow']) || isset($_POST['pprredirect_relnofollow'])):
			// find & save the form data & put it into an array
			$my_meta_data['_pprredirect_active'] 		= isset($_REQUEST['pprredirect_active']) 		? sanitize_meta( '_pprredirect_active', $this->isOne_none(intval( $_REQUEST['pprredirect_active'])), 'post' ) : '';
			$my_meta_data['_pprredirect_newwindow'] 	= isset($_REQUEST['pprredirect_newwindow']) 	? sanitize_meta( '_pprredirect_newwindow', $this->isOne_none( $_REQUEST['pprredirect_newwindow']), 'post' ) 	: '';
			$my_meta_data['_pprredirect_relnofollow'] 	= isset($_REQUEST['pprredirect_relnofollow']) 	? sanitize_meta( '_pprredirect_relnofollow', $this->isOne_none(intval( $_REQUEST['pprredirect_relnofollow'])), 'post' ) 	: '';
			$my_meta_data['_pprredirect_type'] 			= isset($_REQUEST['pprredirect_type']) 			? sanitize_meta( '_pprredirect_type', sanitize_text_field( $_REQUEST['pprredirect_type'] ), 'post' )		: '';
			$my_meta_data['_pprredirect_rewritelink'] 	= isset($_REQUEST['pprredirect_rewritelink']) 	? sanitize_meta( '_pprredirect_rewritelink', $this->isOne_none(intval( $_REQUEST['pprredirect_rewritelink'])), 'post' )	: '';
			$my_meta_data['_pprredirect_url']    		= isset($_REQUEST['pprredirect_url']) 			? sanitize_meta( '_pprredirect_url', ( $_REQUEST['pprredirect_url'] ), 'post' )			: ''; 

			$info = $this->appip_parseURI($my_meta_data['_pprredirect_url']);
			//$my_meta_data['_pprredirect_url'] = esc_url_raw($info['url']);
			$my_meta_data['_pprredirect_url'] = $info['url'];

			if($my_meta_data['_pprredirect_url'] == 'http://' || $my_meta_data['_pprredirect_url'] == 'https://' || $my_meta_data['_pprredirect_url'] == ''){
				$my_meta_data['_pprredirect_url'] 		= ''; //reset to nothing
				$my_meta_data['_pprredirect_type'] 		= NULL; //clear Type if no URL is set.
				$my_meta_data['_pprredirect_active'] 	= NULL; //turn it off if no URL is set
				$my_meta_data['_pprredirect_rewritelink'] = NULL;  //turn it off if no URL is set
				$my_meta_data['_pprredirect_newwindow']	= NULL; //turn it off if no URL is set
				$my_meta_data['_pprredirect_relnofollow'] = NULL; //turn it off if no URL is set
			}
			
			// Add values of $my_meta_data as custom fields
			if(count($my_meta_data)>0){
				foreach ($my_meta_data as $key => $value) { 
					$value = implode(',', (array)$value);
					if($value == '' || $value == NULL || $value == ','){ 
						delete_post_meta($post->ID, $key); 
					}else{
						if(get_post_meta($post->ID, $key, true) != '') {
							update_post_meta($post->ID, $key, $value);
						} else { 
							add_post_meta($post->ID, $key, $value);
						}
					}
				}
			}
		endif;
	}
	
	function ppr_fix_targetsandrels($pages) {
		$ppr_url 		= array();
		$ppr_newindow 	= array();
		$ppr_nofollow 	= array();
		
		if (empty($ppr_url) && empty($ppr_newindow) && empty($ppr_nofollow)){
			$thefirstppr = array();
			if(!empty($this->ppr_all_redir_array)){
				foreach($this->ppr_all_redir_array as $key => $pprd){
					foreach($pprd as $ppkey => $pprs){
						$thefirstppr[$key][$ppkey] = $pprs;
						$thefirstppr[$key]['post_id'] = $key;
					}
				}
			}
			if(!empty($thefirstppr)){
				foreach($thefirstppr as $ppitems){
					if($ppitems['_pprredirect_active'] == 1 && $this->pproverride_newwin =='1'){ // check override of NEW WINDOW
							$ppr_newindow[] = $ppitems['post_id'];
					}else{
						if($ppitems['_pprredirect_active'] == 1 && $ppitems['_pprredirect_newwindow'] === '_blank'){
							$ppr_newindow[] = $ppitems['post_id'];
						}
					}
					
					if($ppitems['_pprredirect_active']==1 && $this->pproverride_nofollow =='1'){ //check override of NO FOLLOW
						$ppr_nofollow[] = $ppitems['post_id'];
					}else{
						if($ppitems['_pprredirect_active']==1 && $ppitems['_pprredirect_relnofollow'] == 1){
							$ppr_nofollow[] = $ppitems['post_id'];
						}
					}
					
					if($ppitems['_pprredirect_active']==1 && $this->pproverride_rewrite =='1'){ //check override of REWRITE
						if($this->pproverride_URL!=''){
							$ppr_url_rewrite[] = $ppitems['post_id'];
							$ppr_url[$ppitems['post_id']]['URL'] = $this->pproverride_URL; //check override of URL
						}elseif($ppitems['_pprredirect_url']!=''){
							$ppr_url_rewrite[] = $ppitems['post_id'];
							$ppr_url[$ppitems['post_id']]['URL'] = $ppitems['_pprredirect_url'];
						}
					}else{
						if($ppitems['_pprredirect_active']==1 && $ppitems['_pprredirect_rewritelink'] == '1' && $ppitems['_pprredirect_url']!=''){
							$ppr_url_rewrite[] = $ppitems['post_id'];
							$ppr_url[$ppitems['post_id']]['URL'] = $ppitems['_pprredirect_url'];
						}
					}
				}
			}

			if (count($ppr_newindow)<0 && count($ppr_nofollow)<0){
				return $pages;
			}
		}
		
		$this_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		if(count($ppr_nofollow)>=1) {
			foreach($ppr_nofollow as $relid){
			$validexp="@\<li(?:.*?)".$relid."(?:.*?)\>\<a(?:.*?)rel\=\"nofollow\"(?:.*?)\>@i";
			$found = preg_match_all($validexp, $pages, $matches);
				if($found!=0){
					$pages = $pages; //do nothing 'cause it is already a rel=nofollow.
				}else{
					$pages = preg_replace('@<li(.*?)-'.$relid.'(.*?)\>\<a(.*?)\>@i', '<li\1-'.$relid.'\2><a\3 rel="nofollow">', $pages);
				}
			}
		}
		
		if(count($ppr_newindow)>=1) {
			foreach($ppr_newindow as $p){
				$validexp="@\<li(?:.*?)".$p."(?:.*?)\>\<a(?:.*?)target\=(?:.*?)\>@i";
				$found = preg_match_all($validexp, $pages, $matches);
				if($found!=0){
					$pages = $pages; //do nothing 'cause it is already a target=_blank.
				}else{
					$pages = preg_replace('@<li(.*?)-'.$p.'(.*?)\>\<a(.*?)\>@i', '<li\1-'.$p.'\2><a\3 target="_blank">', $pages);
				}
			}
		}
		return $pages;
	}
	
	function redirect_post_type(){
		return;
		//not needed at this time
	}
	
	function getAddress(){
	// utility function to get the full address of the current request - credit: http://www.phpro.org/examples/Get-Full-URL.html
		if(!isset($_SERVER['HTTPS'])){$_SERVER['HTTPS']='';}
		$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http'; //check for https
		return $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; //return the full address
	}
	
	function redirect(){
	
		// Read the list of redirects and if the current page is found in the list, send the visitor on her way
		if (!empty($this->quickppr_redirects) && !is_admin()) {
			$userrequest 	= str_replace(get_option('home'),'',$this->getAddress());
			//get the query string if there is one so that it can be preserved
			$finalQS = '';
			if(isset($_GET)){ 
				$useURLQS = array();
				if(count($_GET) >= 1){
					foreach($_GET as $key => $value){$useURLQS[] = $key.'='.$value;}
					$finalQS = '?'.implode('&',$useURLQS);
					$userrequest = preg_replace('/\?.*/', '', $userrequest);
				}
			}
			//end QS preservation

			$needle 		= $this->pproverride_casesensitive ? $userrequest : strtolower($userrequest);
			$haystack 		= $this->pproverride_casesensitive ? $this->quickppr_redirects : array_change_key_case($this->quickppr_redirects);
			$index 			= false;
			
			if(array_key_exists($needle, $haystack)){
				$index = $needle;
			} elseif(strpos($needle,'/') === false) {
				if(array_key_exists('/'.$needle.'/', $haystack)){
					$index = '/'.$needle.'/';
				}
			}else{
				if(array_key_exists($needle.'/', $haystack)){
					$index = $needle.'/';
				}elseif(array_key_exists($needle.$finalQS, $haystack)){ //check if QS data might be part of the URL and not supposed to be added back.
					$index = $needle.$finalQS;
					$finalQS = ''; //remove it
				}
			}
			if($index){
				$val = $haystack[$index];
				if($val) {
					$useURL = $this->pproverride_URL != '' ? $this->pproverride_URL : $val;
					$useURL .= $finalQS; //add QS back
					//$this->pproverride_type = 301;
					$qpprRedType = 301;
					do_action('qppr_redirect',$useURL,$qpprRedType);
					if($qpprRedType == 'meta'){
						$this->ppr_metaurl = $useURL;
						add_action('wp_head', array($this,'ppr_addmetatohead_theme'),1);
					}else{
						wp_redirect($useURL,$qpprRedType);
						exit();
					}
				}	
			}
		}
	}

	function ppr_do_redirect(){
	// Read the list of redirects and if the current page is found in the list, send the visitor on her way
		global $post;
		if (count($this->ppr_all_redir_array)>0 && (is_single() || is_singular() || is_page())) {
			if(isset($this->ppr_all_redir_array[$post->ID])){
				$isactive = $this->ppr_all_redir_array[$post->ID]['_pprredirect_active'];
				$redrtype = $this->ppr_all_redir_array[$post->ID]['_pprredirect_type'];
				$redrurl  = $this->ppr_all_redir_array[$post->ID]['_pprredirect_url'];
				if($isactive == 1 && $redrurl != '' && $redrurl != 'http://www.example.com'){
					if($redrtype === 0){$redrtype = '200';}
					if($redrtype === ''){$redrtype = '302';}
					
					if( strpos($redrurl, 'http://')=== 0 || strpos($redrurl, 'https://')=== 0){
						$urlsite=$redrurl;
					}elseif(strpos($redrurl, 'www')=== 0){ //check if they have full url but did not put http://
						$urlsite='http://'.$redrurl;
					}elseif(is_numeric($redrurl)){ // page/post number
						$urlsite=$this->homelink.'/?p='.$redrurl;
					}elseif(strpos($redrurl,'/') === 0){ // relative to root	
						$urlsite = $this->homelink.$redrurl;
					}else{	// we assume they are using the permalink / page name??
						$urlsite=$this->homelink.'/'.$redrurl;
					}
					// check if override is set for all redirects to go to one URL
					if($this->pproverride_URL !=''){$urlsite=$this->pproverride_URL;} 
					if($this->pproverride_type!='0' && $this->pproverride_type!=''){$redrtype = $this->pproverride_type;} //override check
					if($redrtype == 'meta'){
						$this->ppr_metaurl = $redrurl;
						add_action('wp_head', array($this,'ppr_addmetatohead_theme'),1);
					}else{
						do_action('qppr_do_redirect',$urlsite,$this->pproverride_type);
						wp_redirect($urlsite,$redrtype);
						exit();
					}
				}
			}
		}
	}
	
	function ppr_new_nav_menu_fix($ppr){
		$newmenu = array();
		if(!empty($ppr)){
			foreach($ppr as $ppd){
				if(isset($this->ppr_all_redir_array[$ppd->object_id])){
					$theIsActives 	= $this->ppr_all_redir_array[$ppd->object_id]['_pprredirect_active'];
					$theNewWindow 	= $this->ppr_all_redir_array[$ppd->object_id]['_pprredirect_newwindow'];
					$theNoFollow 	= $this->ppr_all_redir_array[$ppd->object_id]['_pprredirect_relnofollow'];
					$theRewrite 	= $this->ppr_all_redir_array[$ppd->object_id]['_pprredirect_rewritelink'];
					$theRedURL	 	= $this->ppr_all_redir_array[$ppd->object_id]['_pprredirect_url'];
					
					if($this->pproverride_URL !=''){$theRedURL = $this->pproverride_URL;} // check override

					if($theIsActives == '1' && $theNewWindow === '_blank'){
						$ppd->target = '_blank';
						$ppd->classes[] = 'ppr-new-window';
					}
					if($theIsActives == '1' && $theNoFollow == '1'){
						$ppd->xfn = 'nofollow';
						$ppd->classes[] = 'ppr-nofollow';
					}
					if($theIsActives == '1' && $theRewrite == '1' && $theRedURL != ''){
						$ppd->url = $theRedURL;
						$ppd->classes[] = 'ppr-rewrite';
	
					}
				}
				$newmenu[] = $ppd;
			}
		}
		return $newmenu;
	}

}
//=======================================
// END Main Redirect Class.
//=======================================
function start_ppr_class(){
	global $newqppr, $redirect_plugin;
	$redirect_plugin = $newqppr = new quick_page_post_reds(); // call our class
}
?>