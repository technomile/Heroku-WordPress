<?php
/**
 * @package All-in-One-SEO-Pack
 */
/**
 * Include the module base class.
 */
require_once( 'aioseop_module_class.php' );
/**
 * The main class.
 */
class All_in_One_SEO_Pack extends All_in_One_SEO_Pack_Module {

	/** The current version of the plugin. **/
 	var $version = AIOSEOP_VERSION;
 	
 	/** Max numbers of chars in auto-generated description */
 	var $maximum_description_length = 160;
 	
 	/** Minimum number of chars an excerpt should be so that it can be used
 	 * as description. Touch only if you know what you're doing
 	 */
 	var $minimum_description_length = 1;
 	
	/** Whether output buffering is already being used during forced title rewrites. **/
 	var $ob_start_detected = false;

 	/** The start of the title text in the head section for forced title rewrites. **/
 	var $title_start = -1;
 	
 	/** The end of the title text in the head section for forced title rewrites. **/
 	var $title_end = -1;
 	
 	/** The title before rewriting */
 	var $orig_title = '';
 	 	
 	/** Filename of log file. */
 	var $log_file;
 	
 	/** Flag whether there should be logging. */
 	var $do_log;

	var $token;
	var $secret;
	var $access_token;
	var $ga_token;
	var $account_cache;
	var $profile_id;
	var $meta_opts = false;
	var $is_front_page = null;
 	
	function All_in_One_SEO_Pack() {
		global $aioseop_options;
		$this->log_file = dirname( __FILE__ ) . '/all_in_one_seo_pack.log';
	
		if ( !empty( $aioseop_options ) && isset( $aioseop_options['aiosp_do_log'] ) && $aioseop_options['aiosp_do_log'] )
			$this->do_log = true;
		else
			$this->do_log = false;

		$this->init();
		
		$this->name = sprintf( __( '%s Plugin Options', 'all_in_one_seo_pack' ), AIOSEOP_PLUGIN_NAME );
		$this->menu_name = __( 'General Settings', 'all_in_one_seo_pack' );
		
		$this->prefix = 'aiosp_';						// option prefix
		$this->option_name = 'aioseop_options';
		$this->store_option = true;
		$this->file = __FILE__;								// the current file
		parent::__construct();
		
		$this->help_text = Array(
			"donate"				=> __( "All donations support continued development of this free software.", 'all_in_one_seo_pack'),
			"can"					=> __( "This option will automatically generate Canonical URLs for your entire WordPress installation.  This will help to prevent duplicate content penalties by <a href=\'http://googlewebmastercentral.blogspot.com/2009/02/specify-your-canonical.html\' target=\'_blank\'>Google</a>.", 'all_in_one_seo_pack'),
			"no_paged_canonical_links"=> __( "Checking this option will set the Canonical URL for all paginated content to the first page.", 'all_in_one_seo_pack'),
			"customize_canonical_links"=> __( "Checking this option will allow you to customize Canonical URLs for specific posts.", 'all_in_one_seo_pack'),
			"can_set_protocol" => __( "Set protocol for canonical URLs.", 'all_in_one_seo_pack' ),
			"use_original_title"	=> __( "Use wp_title to set the title; disable this option if you run into conflicts with the title being set by your theme or another plugin.", 'all_in_one_seo_pack' ),
			"do_log"				=> __( "Check this and All in One SEO Pack will create a log of important events (all_in_one_seo_pack.log) in its plugin directory which might help debugging. Make sure this directory is writable.", 'all_in_one_seo_pack' ),
			"home_title"			=> __( "As the name implies, this will be the Meta Title of your homepage. This is independent of any other option. If not set, the default Site Title (found in WordPress under Settings, General, Site Title) will be used.", 'all_in_one_seo_pack' ), 
			"home_description"		=> __( "This will be the Meta Description for your homepage. This is independent of any other option. The default is no Meta Description at all if this is not set.", 'all_in_one_seo_pack' ), 
			"home_keywords"			=> __( "Enter a comma separated list of your most important keywords for your site that will be written as Meta Keywords on your homepage. Don\'t stuff everything in here.", 'all_in_one_seo_pack' ), 
			"togglekeywords"		=> __( "This option allows you to toggle the use of Meta Keywords throughout the whole of the site.", 'all_in_one_seo_pack' ), 
			"use_categories"		=> __( "Check this if you want your categories for a given post used as the Meta Keywords for this post (in addition to any keywords you specify on the Edit Post screen).", 'all_in_one_seo_pack' ),
			"use_tags_as_keywords"	=> __( "Check this if you want your tags for a given post used as the Meta Keywords for this post (in addition to any keywords you specify on the Edit Post screen).", 'all_in_one_seo_pack' ),
			"dynamic_postspage_keywords"=> 	__( "Check this if you want your keywords on your Posts page (set in WordPress under Settings, Reading, Front Page Displays) to be dynamically generated from the keywords of the posts showing on that page.  If unchecked, it will use the keywords set in the edit page screen for the posts page.", 'all_in_one_seo_pack'),
			"rewrite_titles"		=> __( "Note that this is all about the title tag. This is what you see in your browser's window title bar. This is NOT visible on a page, only in the title bar and in the source code. If enabled, all page, post, category, search and archive page titles get rewritten. You can specify the format for most of them. For example: Using the default post title format below, Rewrite Titles will write all post titles as 'Post Title | Blog Name'. If you have manually defined a title using All in One SEO Pack, this will become the title of your post in the format string.", 'all_in_one_seo_pack' ),
			"cap_titles"			=> __( "Check this and Search Page Titles and Tag Page Titles will have the first letter of each word capitalized.", 'all_in_one_seo_pack' ),
			"cap_cats"				=> __( "Check this and Category Titles will have the first letter of each word capitalized.", 'all_in_one_seo_pack'),
			"page_title_format"		=>
				__( "This controls the format of the title tag for Pages.<br />The following macros are supported:", 'all_in_one_seo_pack' )
				. '<ul><li>' . __( '%blog_title% - Your blog title', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%blog_description% - Your blog description', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%page_title% - The original title of the page', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%category_title% - The (main) category of the page', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%category% - Alias for %category_title%', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( "%page_author_login% - This page's author' login", 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( "%page_author_nicename% - This page's author' nicename", 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( "%page_author_firstname% - This page's author' first name (capitalized)", 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( "%page_author_lastname% - This page's author' last name (capitalized)", 'all_in_one_seo_pack' ) . '</li>' . 
				'</ul>',
			"post_title_format"		=> 
				__( "This controls the format of the title tag for Posts.<br />The following macros are supported:", 'all_in_one_seo_pack' )
				. '<ul><li>' . __( '%blog_title% - Your blog title', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%blog_description% - Your blog description', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%post_title% - The original title of the post', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%category_title% - The (main) category of the post', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%category% - Alias for %category_title%', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( "%post_author_login% - This post's author' login", 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( "%post_author_nicename% - This post's author' nicename", 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( "%post_author_firstname% - This post's author' first name (capitalized)", 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( "%post_author_lastname% - This post's author' last name (capitalized)", 'all_in_one_seo_pack' ) . '</li>' . 
				'</ul>',
			"category_title_format"	=> 
				__( "This controls the format of the title tag for Category Archives.<br />The following macros are supported:", 'all_in_one_seo_pack' ) .
				'<ul><li>' . __( '%blog_title% - Your blog title', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%blog_description% - Your blog description', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%category_title% - The original title of the category', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%category_description% - The description of the category', 'all_in_one_seo_pack' ) . '</li></ul>',
			"archive_title_format"	=> 
				__( "This controls the format of the title tag for Custom Post Archives.<br />The following macros are supported:", 'all_in_one_seo_pack' ) . 
				'<ul><li>' . __( '%blog_title% - Your blog title', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%blog_description% - Your blog description', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%archive_title - The original archive title given by wordpress', 'all_in_one_seo_pack' ) . '</li></ul>',
			"date_title_format"	=> 
				__( "This controls the format of the title tag for Date Archives.<br />The following macros are supported:", 'all_in_one_seo_pack' ) . 
				'<ul><li>' . __( '%blog_title% - Your blog title', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%blog_description% - Your blog description', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%date% - The original archive title given by wordpress, e.g. "2007" or "2007 August"', 'all_in_one_seo_pack' ) . '</li><li>' .
				__( '%day% - The original archive day given by wordpress, e.g. "17"', 'all_in_one_seo_pack' ) . '</li><li>' .
				__( '%month% - The original archive month given by wordpress, e.g. "August"', 'all_in_one_seo_pack' ) . '</li><li>' .
				__( '%year% - The original archive year given by wordpress, e.g. "2007"', 'all_in_one_seo_pack' ) . '</li></ul>',
			"author_title_format"	=> 
				__( "This controls the format of the title tag for Author Archives.<br />The following macros are supported:", 'all_in_one_seo_pack' ) . 
				'<ul><li>' . __( '%blog_title% - Your blog title', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%blog_description% - Your blog description', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%author% - The original archive title given by wordpress, e.g. "Steve" or "John Smith"', 'all_in_one_seo_pack' ) . '</li></ul>',
			"tag_title_format"	=> 
				__( "This controls the format of the title tag for Tag Archives.<br />The following macros are supported:", 'all_in_one_seo_pack' ) . 
				'<ul><li>' . __( '%blog_title% - Your blog title', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%blog_description% - Your blog description', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%tag% - The name of the tag', 'all_in_one_seo_pack' ) . '</li></ul>',
			"search_title_format"	=> 
				__( "This controls the format of the title tag for the Search page.<br />The following macros are supported:", 'all_in_one_seo_pack' ) . 
				'<ul><li>' . __( '%blog_title% - Your blog title', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%blog_description% - Your blog description', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%search% - What was searched for', 'all_in_one_seo_pack' ) . '</li></ul>',
			"description_format"	=> __( "This controls the format of Meta Descriptions.The following macros are supported:", 'all_in_one_seo_pack' ) . 
				'<ul><li>' . __( '%blog_title% - Your blog title', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%blog_description% - Your blog description', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%description% - The original description as determined by the plugin, e.g. the excerpt if one is set or an auto-generated one if that option is set', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%post_title% - The original title of the post', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%wp_title% - The original wordpress title, e.g. post_title for posts', 'all_in_one_seo_pack' ) . '</li></ul>',
			"404_title_format"	=> __( "This controls the format of the title tag for the 404 page.<br />The following macros are supported:", 'all_in_one_seo_pack' ) .
				'<ul><li>' . __( '%blog_title% - Your blog title', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%blog_description% - Your blog description', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%request_url% - The original URL path, like "/url-that-does-not-exist/"', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%request_words% - The URL path in human readable form, like "Url That Does Not Exist"', 'all_in_one_seo_pack' ) . '</li><li>' . 
				__( '%404_title% - Additional 404 title input"', 'all_in_one_seo_pack' ) . '</li></ul>',
			"paged_format"	=> __( "This string gets appended/prepended to titles of paged index pages (like home or archive pages).", 'all_in_one_seo_pack' )
				. __( 'The following macros are supported:', 'all_in_one_seo_pack' )
				. '<ul><li>' . __( '%page% - The page number', 'all_in_one_seo_pack' ) . '</li></ul>',
			"enablecpost"			=> __( "Check this if you want to use All in One SEO Pack with any Custom Post Types on this site.", 'all_in_one_seo_pack' ),
			"cpostadvanced" 		=> __( "This will show or hide the advanced options for SEO for Custom Post Types.", 'all_in_one_seo_pack' ),
			"cpostactive" 			=> __( "Use these checkboxes to select which Post Types you want to use All in One SEO Pack with.", 'all_in_one_seo_pack' ),
			"cposttitles" 			=> __( "This allows you to set the title tags for each Custom Post Type.", 'all_in_one_seo_pack' ),
			"posttypecolumns" 		=> __( "This lets you select which screens display the SEO Title, SEO Keywords and SEO Description columns.", 'all_in_one_seo_pack' ),
			"admin_bar" 			=> __( "Check this to add All in One SEO Pack to the Admin Bar for easy access to your SEO settings.", 'all_in_one_seo_pack' ),
			"custom_menu_order" 	=> __( "Check this to move the All in One SEO Pack menu item to the top of your WordPress Dashboard menu.", 'all_in_one_seo_pack' ),
			"google_verify" 		=> __( "Enter your verification code here to verify your site with Google Webmaster Tools.<br /><a href='http://semperplugins.com/documentation/google-webmaster-tools-verification/' target='_blank'>Click here for documentation on this setting</a>", 'all_in_one_seo_pack' ),
			"bing_verify" 			=> __( "Enter your verification code here to verify your site with Bing Webmaster Tools.<br /><a href='http://semperplugins.com/documentation/bing-webmaster-verification/' target='_blank'>Click here for documentation on this setting</a>", 'all_in_one_seo_pack' ),
			"pinterest_verify" 		=> __( "Enter your verification code here to verify your site with Pinterest.<br /><a href='http://semperplugins.com/documentation/pinterest-site-verification/' target='_blank'>Click here for documentation on this setting</a>", 'all_in_one_seo_pack' ),
			"google_publisher"		=> __( "Enter your Google+ Profile URL here to add the rel=“author” tag to your site for Google authorship. It is recommended that the URL you enter here should be your personal Google+ profile.  Use the Advanced Authorship Options below if you want greater control over the use of authorship.", 'all_in_one_seo_pack' ),
			"google_disable_profile"=> __( "Check this to remove the Google Plus field from the user profile screen.", 'all_in_one_seo_pack' ),
			"google_author_advanced"=> __( "Enable this to display advanced options for controlling Google Plus authorship information on your website.", 'all_in_one_seo_pack' ),
			"google_author_location"=> __( "This option allows you to control which types of pages you want to display rel=\"author\" on for Google authorship. The options include the Front Page (the homepage of your site), Posts, Pages, and any Custom Post Types. The Everywhere Else option includes 404, search, categories, tags, custom taxonomies, date archives, author archives and any other page template.", 'all_in_one_seo_pack' ),
			"google_enable_publisher"=> __( "This option allows you to control whether rel=\"publisher\" is displayed on the homepage of your site. Google recommends using this if the site is a business website.", 'all_in_one_seo_pack' ),
			"google_specify_publisher"=> __( "The Google+ profile you enter here will appear on your homepage only as the rel=\"publisher\" tag. It is recommended that the URL you enter here should be the Google+ profile for your business.", 'all_in_one_seo_pack' ),
			"google_sitelinks_search"=> __( "Add markup to display the Google Sitelinks Search Box next to your search results in Google.", 'all_in_one_seo_pack' ),
			"google_connect"		=> __( "Press the connect button to connect with Google Analytics; or if already connected, press the disconnect button to disable and remove any stored analytics credentials.", 'all_in_one_seo_pack' ),
			"google_analytics_id"	=> __( "Enter your Google Analytics ID here to track visitor behavior on your site using Google Analytics.", 'all_in_one_seo_pack' ),
			"ga_use_universal_analytics" => __( "Use the new Universal Analytics tracking code for Google Analytics.", 'all_in_one_seo_pack' ),
			"ga_advanced_options"	=> __( "Check to use advanced Google Analytics options.", 'all_in_one_seo_pack' ),
			"ga_domain"				=> __( "Enter your domain name without the http:// to set your cookie domain.", 'all_in_one_seo_pack' ),
			"ga_multi_domain"		=> __( "Use this option to enable tracking of multiple or additional domains.", 'all_in_one_seo_pack' ),
			"ga_addl_domains"		=> __( "Add a list of additional domains to track here.  Enter one domain name per line without the http://.", 'all_in_one_seo_pack' ),			
			"ga_anonymize_ip"		=> __( "This enables support for IP Anonymization in Google Analytics.", 'all_in_one_seo_pack' ),	
			"ga_display_advertising"=> __( "This enables support for the Display Advertiser Features in Google Analytics.", 'all_in_one_seo_pack' ),
			"ga_exclude_users"		=> __( "Exclude logged-in users from Google Analytics tracking by role.", 'all_in_one_seo_pack' ),
			"ga_track_outbound_links"=> __( "Check this if you want to track outbound links with Google Analytics.", 'all_in_one_seo_pack' ),
			"ga_link_attribution"=> __( "This enables support for the Enhanced Link Attribution in Google Analytics.", 'all_in_one_seo_pack' ),
			"ga_enhanced_ecommerce" => __( "This enables support for the Enhanced Ecommerce in Google Analytics.", 'all_in_one_seo_pack' ),
			"cpostnoindex" 			=> __( "Set the default NOINDEX setting for each Post Type.", 'all_in_one_seo_pack' ),
			"cpostnofollow" 		=> __( "Set the default NOFOLLOW setting for each Post Type.", 'all_in_one_seo_pack' ),
			"category_noindex"		=> 	__( "Check this to ask search engines not to index Category Archives. Useful for avoiding duplicate content.", 'all_in_one_seo_pack' ),
			"archive_date_noindex"	=> 	__( "Check this to ask search engines not to index Date Archives. Useful for avoiding duplicate content.", 'all_in_one_seo_pack' ),
			"archive_author_noindex"=> 	__( "Check this to ask search engines not to index Author Archives. Useful for avoiding duplicate content.", 'all_in_one_seo_pack' ),
			"tags_noindex"			=> __( "Check this to ask search engines not to index Tag Archives. Useful for avoiding duplicate content.", 'all_in_one_seo_pack' ),
			"search_noindex"		=> 	__( "Check this to ask search engines not to index the Search page. Useful for avoiding duplicate content.", 'all_in_one_seo_pack' ),
			"404_noindex"		=> 	__( "Check this to ask search engines not to index the 404 page.", 'all_in_one_seo_pack' ),
			"paginated_noindex"		=> 	__( "Check this to ask search engines not to index paginated pages/posts. Useful for avoiding duplicate content.", 'all_in_one_seo_pack' ),
			"paginated_nofollow"		=> 	__( "Check this to ask search engines not to follow links from paginated pages/posts. Useful for avoiding duplicate content.", 'all_in_one_seo_pack' ),
			'noodp'			 	 => __( 'Check this box to ask search engines not to use descriptions from the Open Directory Project for your entire site.', 'all_in_one_seo_pack' ),
			'cpostnoodp'		 => __( "Set the default noodp setting for each Post Type.", 'all_in_one_seo_pack' ),
			'noydir'			 => __( 'Check this box to ask Yahoo! not to use descriptions from the Yahoo! directory for your entire site.', 'all_in_one_seo_pack' ),
			'cpostnoydir'		 => __( "Set the default noydir setting for each Post Type.", 'all_in_one_seo_pack' ),
			"skip_excerpt"		 => __( "Check this and your Meta Descriptions won't be generated from the excerpt.", 'all_in_one_seo_pack' ),
			"generate_descriptions"	=> __( "Check this and your Meta Descriptions will be auto-generated from your excerpt or content.", 'all_in_one_seo_pack' ),
			"run_shortcodes"	=> __( "Check this and shortcodes will get executed for descriptions auto-generated from content.", 'all_in_one_seo_pack' ),
			"hide_paginated_descriptions"=> __( "Check this and your Meta Descriptions will be removed from page 2 or later of paginated content.", 'all_in_one_seo_pack' ),
			"dont_truncate_descriptions"=> __( "Check this to prevent your Description from being truncated regardless of its length.", 'all_in_one_seo_pack' ),
			"schema_markup"=> __( "Check this to support Schema.org markup, i.e., itemprop on supported metadata.", 'all_in_one_seo_pack' ),
			"unprotect_meta"		=> __( "Check this to unprotect internal postmeta fields for use with XMLRPC. If you don't know what that is, leave it unchecked.", 'all_in_one_seo_pack' ),
			"ex_pages" 				=> 	__( "Enter a comma separated list of pages here to be excluded by All in One SEO Pack.  This is helpful when using plugins which generate their own non-WordPress dynamic pages.  Ex: <em>/forum/, /contact/</em>  For instance, if you want to exclude the virtual pages generated by a forum plugin, all you have to do is add forum or /forum or /forum/ or and any URL with the word \"forum\" in it, such as http://mysite.com/forum or http://mysite.com/forum/someforumpage here and it will be excluded from All in One SEO Pack.", 'all_in_one_seo_pack' ),
			"post_meta_tags"		=> __( "What you enter here will be copied verbatim to the header of all Posts. You can enter whatever additional headers you want here, even references to stylesheets.", 'all_in_one_seo_pack' ),
			"page_meta_tags"		=> __( "What you enter here will be copied verbatim to the header of all Pages. You can enter whatever additional headers you want here, even references to stylesheets.", 'all_in_one_seo_pack' ),
			"front_meta_tags"		=> 	__( "What you enter here will be copied verbatim to the header of the front page if you have set a static page in Settings, Reading, Front Page Displays. You can enter whatever additional headers you want here, even references to stylesheets. This will fall back to using Additional Page Headers if you have them set and nothing is entered here.", 'all_in_one_seo_pack' ),
			"home_meta_tags"		=> 	__( "What you enter here will be copied verbatim to the header of the home page if you have Front page displays your latest posts selected in Settings, Reading.  It will also be copied verbatim to the header on the Posts page if you have one set in Settings, Reading. You can enter whatever additional headers you want here, even references to stylesheets.", 'all_in_one_seo_pack' ),
		);
		
		$this->help_anchors = Array(
			'can'		  => '#canonical-urls',
			'no_paged_canonical_links' => '#no-pagination-for-canonical-urls',
			'customize_canonical_links' => '#enable-custom-canonical-urls',
			'use_original_title' => '#use-original-title',
			'schema_markup' => '#use-schema-markup',
			'do_log' => '#log-important-events',
			'home_title' => '#home-title',
			'home_description' => '#home-description',
			'home_keywords' => '#home-keywords',
			'togglekeywords' => '#use-keywords',
			'use_categories' => '#use-categories-for-meta-keywords',
			'use_tags_as_keywords' => '#use-tags-for-meta-keywords',
			'dynamic_postspage_keywords' => '#dynamically-generate-keywords-for-posts-page',
			'rewrite_titles' => '#rewrite-titles',
			'cap_titles' => '#capitalize-titles',
			'page_title_format' => '#title-format-fields',
			'post_title_format' => '#title-format-fields',
			'category_title_format' => '#title-format-fields',
			'archive_title_format' => '#title-format-fields',
			'date_title_format' => '#title-format-fields',
			'author_title_format' => '#title-format-fields',
			'tag_title_format' => '#title-format-fields',
			'search_title_format' => '#title-format-fields',
			'404_title_format' => '#title-format-fields',
			'enablecpost' => '#seo-for-custom-post-types',
			'cpostadvanced' => '#enable-advanced-options',
			'cpostactive' => '#seo-on-only-these-post-types',
			'cposttitles' => '#custom-titles',
			'posttypecolumns' => '#show-column-labels-for-custom-post-types',
			'admin_bar' => '#display-menu-in-admin-bar',
			'custom_menu_order' => '#display-menu-at-the-top',
			'google_verify' => '',
			'bing_verify' => '',
			'pinterest_verify' => '',
			'google_publisher' => '#google-plus-default-profile',
			'google_disable_profile' => '#disable-google-plus-profile',
			'google_author_advanced' => '#advanced-authorship-options',
			'google_author_location' => '#display-google-authorship',
			'google_enable_publisher' => '#display-publisher-meta-on-front-page',
			'google_specify_publisher' => '#specify-publisher-url',
			'google_analytics_id' => 'http://semperplugins.com/documentation/setting-up-google-analytics/',
			'ga_use_universal_analytics' => '#use-universal-analytics',
			'ga_domain' => '#tracking-domain',
			'ga_multi_domain' => '#track-multiple-domains-additional-domains',
			'ga_addl_domains' => '#track-multiple-domains-additional-domains',
			'ga_anonymize_ip' => '#anonymize-ip-addresses',
			'ga_display_advertising' => '#display-advertiser-tracking',
			'ga_exclude_users' => '#exclude-users-from-tracking',
			'ga_track_outbound_links' => '#track-outbound-links',
			'ga_link_attribution' => '#enhanced-link-attribution',
			'ga_enhanced_ecommerce' => '#enhanced-ecommerce',
			'cpostnoindex' => '#use-noindex-for-paginated-pages-posts',
			'cpostnofollow' => '#use-nofollow-for-paginated-pages-posts',
			'noodp' => '#exclude-site-from-the-open-directory-project',
			'noydir' => '#exclude-site-from-yahoo-directory',
			'generate_descriptions' => '#autogenerate-descriptions',
			'run_shortcodes' => '#run-shortcodes-in-autogenerated-descriptions',
			'hide_paginated_descriptions' => '#remove-descriptions-for-paginated-pages',
			'dont_truncate_descriptions' => '#never-shorten-long-descriptions',
			'unprotect_meta' => '#unprotect-post-meta-fields',
			'ex_pages' => '#exclude-pages',
			'post_meta_tags' => '#additional-post-headers',
			'page_meta_tags' => '#additional-page-headers',
			'front_meta_tags' => '#additional-front-page-headers',
			'home_meta_tags' => '#additional-blog-page-headers'
		);

		$meta_help_text = Array(
			'snippet'			 => __( 'A preview of what this page might look like in search engine results.', 'all_in_one_seo_pack' ),
			'title'				 => __( 'A custom title that shows up in the title tag for this page.', 'all_in_one_seo_pack' ),
			'description'		 => __( 'The META description for this page. This will override any autogenerated descriptions.', 'all_in_one_seo_pack' ),
			'keywords'			 => __( 'A comma separated list of your most important keywords for this page that will be written as META keywords.', 'all_in_one_seo_pack' ),
			'custom_link'		 => __( "Override the canonical URLs for this post.", 'all_in_one_seo_pack'),
			'noindex'			 => __( 'Check this box to ask search engines not to index this page.', 'all_in_one_seo_pack' ),
			'nofollow'			 => __( 'Check this box to ask search engines not to follow links from this page.', 'all_in_one_seo_pack' ),
			'noodp'			 	 => __( 'Check this box to ask search engines not to use descriptions from the Open Directory Project for this page.', 'all_in_one_seo_pack' ),
			'noydir'			 => __( 'Check this box to ask Yahoo! not to use descriptions from the Yahoo! directory for this page.', 'all_in_one_seo_pack' ),
			'titleatr'			 => __( 'Set the title attribute for menu links.', 'all_in_one_seo_pack' ),
			'menulabel'			 => __( 'Set the label for this page menu item.', 'all_in_one_seo_pack' ),
			'sitemap_exclude'	 => __( "Don't display this page in the sitemap.", 'all_in_one_seo_pack' ),
			'disable'			 => __( 'Disable SEO on this page.', 'all_in_one_seo_pack' ),
			'disable_analytics'	 => __( 'Disable Google Analytics on this page.', 'all_in_one_seo_pack' )
		);
		
		$this->default_options = array( 
			   "donate" => Array( 
				       'name' => __( 'I enjoy this plugin and have made a donation:', 'all_in_one_seo_pack' ) ),
		   "home_title"=> Array( 
				'name' => __( 'Home Title:', 'all_in_one_seo_pack' ), 
				'default' => null, 'type' => 'textarea', 'sanitize' => 'text',
				'count' => true, 'rows' => 1, 'cols' => 60 ),
		   "home_description"=> Array( 
				'name' => __( 'Home Description:', 'all_in_one_seo_pack' ), 
				'default' => '', 'type' => 'textarea', 'sanitize' => 'text',
				'count' => true, 'cols' => 80, 'rows' => 2 ),
		   "togglekeywords" => Array( 
				'name' => __( 'Use Keywords:', 'all_in_one_seo_pack' ), 
				'default' =>  0,
				'type' => 'radio',
			    'initial_options' => Array( 0 => __( 'Enabled', 'all_in_one_seo_pack' ),
			                                1 => __( 'Disabled', 'all_in_one_seo_pack' ) )
				),
		   "home_keywords"=> Array( 
				'name' => __( 'Home Keywords (comma separated):', 'all_in_one_seo_pack' ), 
				'default' => null, 'type' => 'textarea', 'sanitize' => 'text',
				'condshow' => Array( "aiosp_togglekeywords" => 0 ) ),
		   "can"=> Array(
				'name' => __( 'Canonical URLs:', 'all_in_one_seo_pack' ),
				'default' => 1),
		   "no_paged_canonical_links"=> Array(
				'name' => __( 'No Pagination for Canonical URLs:', 'all_in_one_seo_pack' ),
				'default' => 0,
				'condshow' => Array( "aiosp_can" => 'on' ) ),
		   "customize_canonical_links"	=> Array(
				'name' => __( 'Enable Custom Canonical URLs:', 'all_in_one_seo_pack' ),
				'default' => 0,
				'condshow' => Array( "aiosp_can" => 'on' ) ),
			"can_set_protocol" => Array(
				'name' => __( 'Set Protocol For Canonical URLs:', 'all_in_one_seo_pack' ),
				'type' => 'radio',
				'default' => 'auto',
				'initial_options' => Array( 'auto' => __( 'Auto', 'all_in_one_seo_pack' ),
											'http' => __( 'HTTP', 'all_in_one_seo_pack' ),
											'https' => __( 'HTTPS', 'all_in_one_seo_pack' ) ),
				'condshow' => Array( "aiosp_can" => 'on' )
				),
			"rewrite_titles"=> Array( 
				'name' => __( 'Rewrite Titles:', 'all_in_one_seo_pack' ), 
				'default' => 1,
				'type' => 'radio',
				'initial_options' => Array( 1 => __( 'Enabled', 'all_in_one_seo_pack' ),
											0 => __( 'Disabled', 'all_in_one_seo_pack' ) )
				),
			"force_rewrites"=> Array( 
				'name' => __( 'Force Rewrites:', 'all_in_one_seo_pack' ), 
				'default' => 1,
				'type' => 'hidden',
				'prefix' => $this->prefix,
				'initial_options' => Array( 1 => __( 'Enabled', 'all_in_one_seo_pack' ),
											0 => __( 'Disabled', 'all_in_one_seo_pack' ) )
				),
			"use_original_title"=> Array(
					'name' => __( 'Use Original Title:', 'all_in_one_seo_pack' ),
					'type' => 'radio',
					'default' => 0,
					'initial_options' => Array( 1 => __( 'Enabled', 'all_in_one_seo_pack' ),
												0 => __( 'Disabled', 'all_in_one_seo_pack' ) )					
				),
			"cap_titles"=> Array(
				'name' => __( 'Capitalize Titles:', 'all_in_one_seo_pack' ), 'default' => 1),
			"cap_cats"=> Array(
				'name' => __( 'Capitalize Category Titles:', 'all_in_one_seo_pack' ), 'default' => 1),
		   "page_title_format"=> Array( 
				'name' => __( 'Page Title Format:', 'all_in_one_seo_pack' ), 
				'type' => 'text', 'default' => '%page_title% | %blog_title%',
				'condshow' => Array( "aiosp_rewrite_titles" => 1 ) ),
		   "post_title_format"=> Array( 
				'name' => __( 'Post Title Format:', 'all_in_one_seo_pack' ), 
				'type' => 'text', 'default' => '%post_title% | %blog_title%',
				'condshow' => Array( "aiosp_rewrite_titles" => 1 ) ),
		   "category_title_format"=> Array( 
				'name' => __( 'Category Title Format:', 'all_in_one_seo_pack' ), 
				'type' => 'text', 'default' => '%category_title% | %blog_title%',
				'condshow' => Array( "aiosp_rewrite_titles" => 1 ) ),
		   "archive_title_format"=> Array(
				'name' => __( 'Archive Title Format:', 'all_in_one_seo_pack' ), 
				'type' => 'text', 'default' => '%archive_title% | %blog_title%',
				'condshow' => Array( "aiosp_rewrite_titles" => 1 ) ),
		   "date_title_format"=> Array(
				'name' => __( 'Date Archive Title Format:', 'all_in_one_seo_pack' ), 
				'type' => 'text', 'default' => '%date% | %blog_title%',
				'condshow' => Array( "aiosp_rewrite_titles" => 1 ) ),
			"author_title_format"=> Array(
				'name' => __( 'Author Archive Title Format:', 'all_in_one_seo_pack' ), 
				'type' => 'text', 'default' => '%author% | %blog_title%',
				'condshow' => Array( "aiosp_rewrite_titles" => 1 ) ),
		   "tag_title_format"=> Array( 
				'name' => __( 'Tag Title Format:', 'all_in_one_seo_pack' ), 
				'type' => 'text', 'default' => '%tag% | %blog_title%',
				'condshow' => Array( "aiosp_rewrite_titles" => 1 ) ),
		   "search_title_format"=> Array( 
				'name' => __( 'Search Title Format:', 'all_in_one_seo_pack' ), 
				'type' => 'text', 'default' => '%search% | %blog_title%',
				'condshow' => Array( "aiosp_rewrite_titles" => 1 ) ),
		   "description_format"=> Array( 
				'name' => __( 'Description Format', 'all_in_one_seo_pack' ), 
				'type' => 'text', 'default' => '%description%',
				'condshow' => Array( "aiosp_rewrite_titles" => 1 ) ),
		   "404_title_format"=> Array( 
				'name' => __( '404 Title Format:', 'all_in_one_seo_pack' ), 
				'type' => 'text', 'default' => 'Nothing found for %request_words%',
				'condshow' => Array( "aiosp_rewrite_titles" => 1 ) ),
			"paged_format"=> Array(
				'name' => __( 'Paged Format:', 'all_in_one_seo_pack' ),
				'type' => 'text', 'default' => ' - Part %page%',
				'condshow' => Array( "aiosp_rewrite_titles" => 1 ) ),
			"enablecpost"=> Array(
				'name' => __( 'SEO for Custom Post Types:', 'all_in_one_seo_pack' ),
				'default' => 'on',
				'type' => 'radio',
				'initial_options' => Array( 'on' => __( 'Enabled', 'all_in_one_seo_pack' ),
											0 => __( 'Disabled', 'all_in_one_seo_pack' ) )
				),
			"cpostadvanced" => Array(
				'name' => __( 'Enable Advanced Options:', 'all_in_one_seo_pack' ), 
				'default' => 0, 'type' => 'radio',
				'initial_options' => Array( 'on' => __( 'Enabled', 'all_in_one_seo_pack' ),
											0 => __( 'Disabled', 'all_in_one_seo_pack' ) ),
				'label' => null,
				'condshow' => Array( "aiosp_enablecpost" => 'on' )
				),
			"cpostactive" => Array(
				'name' => __( 'SEO on only these post types:', 'all_in_one_seo_pack' ), 
				'type' => 'multicheckbox', 'default' => array('post', 'page'),
				'condshow' => Array( 'aiosp_enablecpost' => 'on', 'aiosp_cpostadvanced' => 'on' )
				),
			"cpostnoindex" => Array(
				'name' => __( 'Default to NOINDEX:', 'all_in_one_seo_pack' ), 
				'type' => 'multicheckbox', 'default' => array(),
				'condshow' => Array( 'aiosp_enablecpost' => 'on', 'aiosp_cpostadvanced' => 'on' )
				),
			"cpostnofollow" => Array(
				'name' => __( 'Default to NOFOLLOW:', 'all_in_one_seo_pack' ), 
				'type' => 'multicheckbox', 'default' => array(),
				'condshow' => Array( 'aiosp_enablecpost' => 'on', 'aiosp_cpostadvanced' => 'on' )
				),
			"cpostnoodp"=> Array(
					'name' => __( 'Default to NOODP:', 'all_in_one_seo_pack' ),
					'type' => 'multicheckbox', 'default' => array(),
					'condshow' => Array( 'aiosp_enablecpost' => 'on', 'aiosp_cpostadvanced' => 'on' )
				),
			"cpostnoydir"=> Array(
				'name' => __( 'Default to NOYDIR:', 'all_in_one_seo_pack' ),
				'type' => 'multicheckbox', 'default' => array(),
				'condshow' => Array( 'aiosp_enablecpost' => 'on', 'aiosp_cpostadvanced' => 'on' )
				),
			"cposttitles" => Array(
				'name' => __( 'Custom titles:', 'all_in_one_seo_pack' ), 
				'type' => 'checkbox', 'default' => 0,
				'condshow' => Array( "aiosp_rewrite_titles" => 1, 'aiosp_enablecpost' => 'on', 'aiosp_cpostadvanced' => 'on' )
				),
			"posttypecolumns" => Array(
				'name' => __( 'Show Column Labels for Custom Post Types:', 'all_in_one_seo_pack' ),
				'type' => 'multicheckbox', 'default' =>  array('post', 'page') ),
			"admin_bar" => Array(
				'name' => __( 'Display Menu In Admin Bar:', 'all_in_one_seo_pack' ), 'default' => 'on',
				),
			"custom_menu_order" => Array(
				'name' => __( 'Display Menu At The Top:', 'all_in_one_seo_pack' ), 'default' => 'on',
				),
			"google_verify" => Array(
				'name' => __( 'Google Webmaster Tools:', 'all_in_one_seo_pack' ), 'default' => '', 'type' => 'text'
				),
			"bing_verify" => Array(
				'name' => __( 'Bing Webmaster Center:', 'all_in_one_seo_pack' ), 'default' => '', 'type' => 'text'
				),
			"pinterest_verify" => Array(
				'name' => __( 'Pinterest Site Verification:', 'all_in_one_seo_pack' ), 'default' => '', 'type' => 'text'
				),
			"google_publisher"=> Array(
				'name' => __( 'Google Plus Default Profile:', 'all_in_one_seo_pack' ), 'default' => '', 'type' => 'text'
				),
			"google_disable_profile"=> Array(
				'name' => __( 'Disable Google Plus Profile:', 'all_in_one_seo_pack' ), 'default' => 0, 'type' => 'checkbox'
				),
			"google_sitelinks_search" => Array(
					'name' => __( 'Display Sitelinks Search Box:', 'all_in_one_seo_pack' )
			),
			"google_author_advanced" => Array(
					'name' => __( 'Advanced Authorship Options:', 'all_in_one_seo_pack' ), 
					'default' => 0, 'type' => 'radio',
					'initial_options' => Array( 'on' => __( 'Enabled', 'all_in_one_seo_pack' ),
												0 => __( 'Disabled', 'all_in_one_seo_pack' ) ),
					'label' => null
					),
			"google_author_location"=> Array(
				'name' => __( 'Display Google Authorship:', 'all_in_one_seo_pack' ), 'default' => array( 'all' ), 'type' => 'multicheckbox',
				'condshow' => Array( 'aiosp_google_author_advanced' => 'on' )
				),
			"google_enable_publisher" => Array(
				'name' => __( 'Display Publisher Meta on Front Page:', 'all_in_one_seo_pack' ), 
				'default' => 'on', 'type' => 'radio',
				'initial_options' => Array( 'on' => __( 'Enabled', 'all_in_one_seo_pack' ),
											0 => __( 'Disabled', 'all_in_one_seo_pack' ) ),
				'condshow' => Array( 'aiosp_google_author_advanced' => 'on' )
				),
			"google_specify_publisher" => Array(
					'name' => __( 'Specify Publisher URL:', 'all_in_one_seo_pack' ), 'type' => 'text',
					'condshow' => Array( 'aiosp_google_author_advanced' => 'on', 'aiosp_google_enable_publisher' => 'on' )
				),
			"google_connect"=>Array( 'name' => __( 'Connect With Google Analytics', 'all_in_one_seo_pack' ), 
				),
			"google_analytics_id"=> Array(
				'name' => __( 'Google Analytics ID:', 'all_in_one_seo_pack' ),
				'default' => null, 'type' => 'text', 'placeholder' => 'UA-########-#' ),
			"ga_use_universal_analytics" => Array(
				'name' => __( 'Use Universal Analytics:', 'all_in_one_seo_pack' ),
				'default' => 0,
				 'condshow' => Array( 'aiosp_google_analytics_id' => Array( 'lhs' => 'aiosp_google_analytics_id', 'op' => '!=', 'rhs' => '' ) ) ),
			"ga_advanced_options"=> Array(
				'name' => __( 'Advanced Analytics Options:', 'all_in_one_seo_pack' ),
				'default' => 'on',
				'type' => 'radio',
				'initial_options' => Array( 'on' => __( 'Enabled', 'all_in_one_seo_pack' ),
											0 => __( 'Disabled', 'all_in_one_seo_pack' ) ),
				'condshow' => Array( 'aiosp_google_analytics_id' => Array( 'lhs' => 'aiosp_google_analytics_id', 'op' => '!=', 'rhs' => '' ) ) ),
			"ga_domain"=> Array(
				'name' => __( 'Tracking Domain:', 'all_in_one_seo_pack' ),
				'type' => 'text',
				'condshow' => Array( 'aiosp_google_analytics_id' => Array( 'lhs' => 'aiosp_google_analytics_id', 'op' => '!=', 'rhs' => '' ), 'aiosp_ga_advanced_options' => 'on') ),
			"ga_multi_domain"=> Array(
				'name' => __( 'Track Multiple Domains:', 'all_in_one_seo_pack' ),
				'default' => 0,
				'condshow' => Array( 'aiosp_google_analytics_id' => Array( 'lhs' => 'aiosp_google_analytics_id', 'op' => '!=', 'rhs' => '' ), 'aiosp_ga_advanced_options' => 'on' ) ),
			"ga_addl_domains" => Array(
								'name' => __( 'Additional Domains:', 'all_in_one_seo_pack' ),
								'type' => 'textarea',
								'condshow' => Array( 'aiosp_google_analytics_id' => Array( 'lhs' => 'aiosp_google_analytics_id', 'op' => '!=', 'rhs' => '' ), 'aiosp_ga_advanced_options' => 'on', 'aiosp_ga_multi_domain' => 'on' ) ),
			"ga_anonymize_ip"=> Array(
				'name' => __( 'Anonymize IP Addresses:', 'all_in_one_seo_pack' ),
				'type' => 'checkbox',
				'condshow' => Array( 'aiosp_google_analytics_id' => Array( 'lhs' => 'aiosp_google_analytics_id', 'op' => '!=', 'rhs' => '' ), 'aiosp_ga_advanced_options' => 'on' ) ),
			"ga_display_advertising"=> Array(
				'name' => __( 'Display Advertiser Tracking:', 'all_in_one_seo_pack' ),
				'type' => 'checkbox',
				'condshow' => Array( 'aiosp_google_analytics_id' => Array( 'lhs' => 'aiosp_google_analytics_id', 'op' => '!=', 'rhs' => '' ), 'aiosp_ga_advanced_options' => 'on' ) ),
			"ga_exclude_users"=> Array(
				'name' => __( 'Exclude Users From Tracking:', 'all_in_one_seo_pack' ),
				'type' => 'multicheckbox',
				'condshow' => Array( 'aiosp_google_analytics_id' => Array( 'lhs' => 'aiosp_google_analytics_id', 'op' => '!=', 'rhs' => '' ), 'aiosp_ga_advanced_options' => 'on' ) ),
			"ga_track_outbound_links"=> Array(
				'name' => __( 'Track Outbound Links:', 'all_in_one_seo_pack' ),
				'default' => 0,
				 'condshow' => Array( 'aiosp_google_analytics_id' => Array( 'lhs' => 'aiosp_google_analytics_id', 'op' => '!=', 'rhs' => '' ), 'aiosp_ga_advanced_options' => 'on' ) ),
			"ga_link_attribution"=> Array(
				'name' => __( 'Enhanced Link Attribution:', 'all_in_one_seo_pack' ),
				'default' => 0,
				 'condshow' => Array( 'aiosp_google_analytics_id' => Array( 'lhs' => 'aiosp_google_analytics_id', 'op' => '!=', 'rhs' => '' ), 'aiosp_ga_advanced_options' => 'on' ) ),
			"ga_enhanced_ecommerce"=> Array(
				'name' => __( 'Enhanced Ecommerce:', 'all_in_one_seo_pack' ),
				'default' => 0,
				 'condshow' => Array( 'aiosp_google_analytics_id' => Array( 'lhs' => 'aiosp_google_analytics_id', 'op' => '!=', 'rhs' => '' ), 'aiosp_ga_use_universal_analytics' => 'on', 'aiosp_ga_advanced_options' => 'on' ) ),			
			"use_categories"=> Array(
				'name' => __( 'Use Categories for META keywords:', 'all_in_one_seo_pack' ),
				'default' => 0,
				'condshow' => Array( "aiosp_togglekeywords" => 0 ) ),
			"use_tags_as_keywords" => Array(
				'name' => __( 'Use Tags for META keywords:', 'all_in_one_seo_pack' ),
				'default' => 1,
				'condshow' => Array( "aiosp_togglekeywords" => 0 ) ),
			"dynamic_postspage_keywords"=> Array(
				'name' => __( 'Dynamically Generate Keywords for Posts Page:', 'all_in_one_seo_pack' ),
				'default' => 1,
				'condshow' => Array( "aiosp_togglekeywords" => 0 ) ),
			"category_noindex"=> Array(
				'name' => __( 'Use noindex for Categories:', 'all_in_one_seo_pack' ),
				'default' => 1),
			"archive_date_noindex"=> Array(
				'name' => __( 'Use noindex for Date Archives:', 'all_in_one_seo_pack' ),
				'default' => 1),
			"archive_author_noindex"=> Array(
				'name' => __( 'Use noindex for Author Archives:', 'all_in_one_seo_pack' ),
				'default' => 1),
			"tags_noindex"=> Array(
				'name' => __( 'Use noindex for Tag Archives:', 'all_in_one_seo_pack' ),
				'default' => 0),
			"search_noindex"=> Array(
				'name' => __( 'Use noindex for the Search page:', 'all_in_one_seo_pack' ),
				'default' => 0),
			"404_noindex"=> Array(
				'name' => __( 'Use noindex for the 404 page:', 'all_in_one_seo_pack' ),
				'default' => 0),
			"paginated_noindex"	=> Array(
				'name' => __( 'Use noindex for paginated pages/posts:', 'all_in_one_seo_pack' ),
				'default' => 0),
			"paginated_nofollow"=> Array(
				'name' => __( 'Use nofollow for paginated pages/posts:', 'all_in_one_seo_pack' ),
				'default' => 0),
			"noodp"=> Array(
				'name' => __( 'Exclude site from the Open Directory Project:', 'all_in_one_seo_pack' ),
				'default' => 0),
			"noydir"=> Array(
				'name' => __( 'Exclude site from Yahoo! Directory:', 'all_in_one_seo_pack' ),
				'default' => 0),
			"skip_excerpt"=> Array(
				'name' => __( 'Avoid Using The Excerpt In Descriptions:', 'all_in_one_seo_pack' ),
				'default' => 0 ),
			"generate_descriptions"=> Array(
				'name' => __( 'Autogenerate Descriptions:', 'all_in_one_seo_pack' ),
				'default' => 1),
			"run_shortcodes"=> Array(
				'name' => __( 'Run Shortcodes In Autogenerated Descriptions:', 'all_in_one_seo_pack' ),
				'default' => 0,
				'condshow' => Array( 'aiosp_generate_descriptions' => 'on' ) ),
			"hide_paginated_descriptions"=> Array(
				'name' => __( 'Remove Descriptions For Paginated Pages:', 'all_in_one_seo_pack' ),
				'default' => 0),
			"dont_truncate_descriptions"=> Array(
				'name' => __( 'Never Shorten Long Descriptions:', 'all_in_one_seo_pack' ),
				'default' => 0),
			"schema_markup"=> Array(
				'name' => __( 'Use Schema.org Markup', 'all_in_one_seo_pack' ),
				'default' => 1),
			"unprotect_meta"=> Array(
				'name' => __( 'Unprotect Post Meta Fields:', 'all_in_one_seo_pack' ),
				'default' => 0),
			"ex_pages" => Array(
				'name' => __( 'Exclude Pages:', 'all_in_one_seo_pack' ),
				'type' => 'textarea', 'default' =>  '' ),
			"post_meta_tags"=> Array(
				'name' => __( 'Additional Post Headers:', 'all_in_one_seo_pack' ),
				'type' => 'textarea', 'default' => '', 'sanitize' => 'default' ),
			"page_meta_tags"=> Array(
				'name' => __( 'Additional Page Headers:', 'all_in_one_seo_pack' ),
				'type' => 'textarea', 'default' => '', 'sanitize' => 'default' ),
			"front_meta_tags"=> Array(
				'name' => __( 'Additional Front Page Headers:', 'all_in_one_seo_pack' ),
				'type' => 'textarea', 'default' => '', 'sanitize' => 'default' ),
			"home_meta_tags"=> Array(
				'name' => __( 'Additional Blog Page Headers:', 'all_in_one_seo_pack' ),
				'type' => 'textarea', 'default' => '', 'sanitize' => 'default' ),
			"do_log"=> Array(
				'name' => __( 'Log important events:', 'all_in_one_seo_pack' ),
				'default' => null ),
			);

			$this->locations = Array(
					'default' => Array( 'name' => $this->name, 'prefix' => 'aiosp_', 'type' => 'settings', 'options' => null ),
				    'aiosp' => Array( 'name' => $this->plugin_name, 'type' => 'metabox', 'prefix' => '', 'help_link' => 'http://semperplugins.com/sections/postpage-settings/',
																	'options' => Array( 'edit', 'nonce-aioseop-edit', 'upgrade', 'snippet', 'title', 'description', 'keywords', 'custom_link', 'noindex', 'nofollow', 'noodp', 'noydir', 'titleatr', 'menulabel', 'sitemap_exclude', 'disable', 'disable_analytics' ),
																	'default_options' => Array( 
																		'edit' 				 => Array( 'type' => 'hidden', 'default' => 'aiosp_edit', 'prefix' => true, 'nowrap' => 1 ),
																		'nonce-aioseop-edit' => Array( 'type' => 'hidden', 'default' => null, 'prefix' => false, 'nowrap' => 1 ),
																		'upgrade' 			 => Array( 'type' => 'html', 'label' => 'none',
																										'default' => '<a target="__blank" href="http://semperplugins.com/plugins/all-in-one-seo-pack-pro-version/?loc=meta">' 
																										. __( 'Upgrade to All in One SEO Pack Pro Version', 'all_in_one_seo_pack' ) . '</a>'
																					 		),
																		'snippet'			 => Array( 'name' => __( 'Preview Snippet', 'all_in_one_seo_pack' ), 'type' => 'custom', 'label' => 'top', 
																									   'default' => '
																									<script>
																									jQuery(document).ready(function() {
																										jQuery("#aiosp_title_wrapper").bind("input", function() {
																										    jQuery("#aioseop_snippet_title").text(jQuery("#aiosp_title_wrapper input").val().replace(/<(?:.|\n)*?>/gm, ""));
																										});
																										jQuery("#aiosp_description_wrapper").bind("input", function() {
																										    jQuery("#aioseop_snippet_description").text(jQuery("#aiosp_description_wrapper textarea").val().replace(/<(?:.|\n)*?>/gm, ""));
																										});
																									});
																									</script>
																									<div class="preview_snippet"><div id="aioseop_snippet"><h3><a>%s</a></h3><div><div><cite id="aioseop_snippet_link">%s</cite></div><span id="aioseop_snippet_description">%s</span></div></div></div>' ),
																		'title'				 => Array( 'name' => __( 'Title', 'all_in_one_seo_pack' ), 'type' => 'text', 'count' => true, 'size' => 60 ),
																		'description'		 => Array( 'name' => __( 'Description', 'all_in_one_seo_pack' ), 'type' => 'textarea', 'count' => true, 'cols' => 80, 'rows' => 2 ),
																		'keywords'			 => Array( 'name' => __( 'Keywords (comma separated)', 'all_in_one_seo_pack' ), 'type' => 'text' ),
																		'custom_link'		 => Array( 'name' => __( 'Custom Canonical URL', 'all_in_one_seo_pack' ), 'type' => 'text', 'size' => 60 ),																		
																		'noindex'			 => Array( 'name' => __( "Robots Meta NOINDEX", 'all_in_one_seo_pack' ), 'default' => '' ),
																		'nofollow'			 => Array( 'name' => __( "Robots Meta NOFOLLOW", 'all_in_one_seo_pack' ), 'default' => '' ),
																		'noodp'			 	 => Array( 'name' => __( "Robots Meta NOODP", 'all_in_one_seo_pack' ) ),
																		'noydir'			 => Array( 'name' => __( "Robots Meta NOYDIR", 'all_in_one_seo_pack' ) ),
																		'titleatr'			 => Array( 'name' => __( 'Title Attribute', 'all_in_one_seo_pack' ), 'type' => 'text', 'size' => 60 ),
																		'menulabel'			 => Array( 'name' => __( 'Menu Label', 'all_in_one_seo_pack' ), 'type' => 'text', 'size' => 60 ),
																		'sitemap_exclude'	 => Array( 'name' => __( 'Exclude From Sitemap', 'all_in_one_seo_pack' ) ),
																		'disable'			 => Array( 'name' => __( 'Disable on this page/post', 'all_in_one_seo_pack' ) ),
																		'disable_analytics'	 => Array( 'name' => __( 'Disable Google Analytics', 'all_in_one_seo_pack' ), 'condshow' => Array( 'aiosp_disable' => 'on' ) ) ),
																	'display' => null )
				);
		
			if ( !empty( $meta_help_text ) )
				foreach( $meta_help_text as $k => $v )
					$this->locations['aiosp']['default_options'][$k]['help_text'] = $v;

			$this->layout = Array(
				'default' => Array(
						'name' => __( 'General Settings', 'all_in_one_seo_pack' ),
						'help_link' => 'http://semperplugins.com/documentation/general-settings/',
						'options' => Array() // this is set below, to the remaining options -- pdb
					),
				'home'  => Array(
						'name' => __( 'Home Page Settings', 'all_in_one_seo_pack' ),
						'help_link' => 'http://semperplugins.com/documentation/home-page-settings/',
						'options' => Array( 'home_title', 'home_description', 'home_keywords' )
					),
				'keywords' => Array(
					'name' => __( 'Keyword Settings', 'all_in_one_seo_pack' ),
					'help_link' => 'http://semperplugins.com/documentation/keyword-settings/',
					'options' => Array( "togglekeywords", "use_categories", "use_tags_as_keywords", "dynamic_postspage_keywords" )
					),
				'title'	=> Array(
						'name' => __( 'Title Settings', 'all_in_one_seo_pack' ),
						'help_link' => 'http://semperplugins.com/documentation/title-settings/',
						'options' => Array( "rewrite_titles", "force_rewrites", "cap_titles", "cap_cats", "page_title_format", "post_title_format", "category_title_format", "archive_title_format", "date_title_format", "author_title_format",
						 					"tag_title_format", "search_title_format", "description_format", "404_title_format", "paged_format" )						
					),
				'cpt' => Array(
						'name' => __( 'Custom Post Type Settings', 'all_in_one_seo_pack' ),
						'help_link' => 'http://semperplugins.com/documentation/custom-post-type-settings/',
						'options' => Array( "enablecpost", "cpostadvanced", "cpostactive", "cposttitles" )
					),
				'display' => Array(
						'name' => __( 'Display Settings', 'all_in_one_seo_pack' ),
						'help_link' => 'http://semperplugins.com/documentation/display-settings/',
						'options' => Array( "posttypecolumns", "admin_bar", "custom_menu_order" )
					),
				'webmaster' => Array(
						'name' => __( 'Webmaster Verification', 'all_in_one_seo_pack' ),
						'help_link' => 'http://semperplugins.com/sections/webmaster-verification/',
						'options' => Array( "google_verify", "bing_verify", "pinterest_verify" )
					),
				'google' => Array(
						'name' => __( 'Google Settings', 'all_in_one_seo_pack' ),
						'help_link' => 'http://semperplugins.com/documentation/google-settings/',
						'options' => Array( "google_publisher", "google_disable_profile", "google_sitelinks_search", "google_author_advanced", "google_author_location", "google_enable_publisher" , "google_specify_publisher",
											"google_connect", 
											"google_analytics_id", "ga_use_universal_analytics", "ga_advanced_options", "ga_domain", "ga_multi_domain", "ga_addl_domains", "ga_anonymize_ip", "ga_display_advertising", "ga_exclude_users", "ga_track_outbound_links", "ga_link_attribution", "ga_enhanced_ecommerce" )
					),
				'noindex' => Array(
						'name' => __( 'Noindex Settings', 'all_in_one_seo_pack' ),
						'help_link' => 'http://semperplugins.com/documentation/noindex-settings/',
						'options' => Array( 'cpostnoindex', 'cpostnofollow', 'cpostnoodp', 'cpostnoydir', 'category_noindex', 'archive_date_noindex', 'archive_author_noindex', 'tags_noindex', 'search_noindex', '404_noindex', 'paginated_noindex', 'paginated_nofollow', 'noodp', 'noydir' )						
					),
				'advanced' => Array(
						'name' => __( 'Advanced Settings', 'all_in_one_seo_pack' ),
						'help_link' => 'http://semperplugins.com/documentation/advanced-settings/',
						'options' => Array( 'generate_descriptions', 'skip_excerpt', 'run_shortcodes', 'hide_paginated_descriptions', 'dont_truncate_descriptions', 'unprotect_meta', 'ex_pages', 'post_meta_tags', 'page_meta_tags', 'front_meta_tags', 'home_meta_tags' )
					)
				);

			$other_options = Array();
			foreach( $this->layout as $k => $v )
				$other_options = array_merge( $other_options, $v['options'] );
			
			$this->layout['default']['options'] = array_diff( array_keys( $this->default_options ), $other_options );
			
			if ( is_admin() ) {
				$this->add_help_text_links();
				add_action( "aioseop_global_settings_header",	Array( $this, 'display_right_sidebar' ) );
				add_action( "aioseop_global_settings_footer",	Array( $this, 'display_settings_footer' ) );
				add_action( "output_option", Array( $this, 'custom_output_option' ), 10, 2 );
			}
	}
	
	function get_page_snippet_info() {
		static $info = Array();
		if ( !empty( $info ) )
			return $info;
		global $post, $aioseop_options, $wp_query;
		$title = $url = $description = $term = '';
		$p = $post; $w = $wp_query;
		if ( !is_object( $post ) ) $post = $this->get_queried_object();
		if ( empty( $this->meta_opts ) )
			$this->meta_opts = $this->get_current_options( Array(), 'aiosp' );
		if ( !is_object( $post ) && is_admin() && !empty( $_GET ) && !empty( $_GET['post_type'] ) && !empty( $_GET['taxonomy'] ) && !empty( $_GET['tag_ID'] ) ) {
			$term = get_term_by( 'id', $_GET['tag_ID'], $_GET['taxonomy'] );
		}
		if ( is_object( $post ) ) {
			$opts = $this->meta_opts;
			$post_id = $p->ID;
			if (! $post->post_modified_gmt != '' )
				$wp_query = new WP_Query( array( 'p' => $post_id, 'post_type' => $post->post_type ) );
			if ( $post->post_type == 'page' )
				$wp_query->is_page = true;
			elseif ( $post->post_type == 'attachment' )
				$wp_query->is_attachment = true;
			else
				$wp_query->is_single = true;
			if ( empty( $this->is_front_page ) ) $this->is_front_page = false;
			if 	( get_option( 'show_on_front' ) == 'page' ) {
				if ( is_page() && $post->ID == get_option( 'page_on_front' ) )
					$this->is_front_page = true;
				elseif ( $post->ID == get_option( 'page_for_posts' ) )
					$wp_query->is_home = true;
			}
			$wp_query->queried_object = $post;
			if ( !empty( $post ) && !$wp_query->is_home && !$this->is_front_page ) {
				$title = $this->internationalize( get_post_meta( $post->ID, "_aioseop_title", true ) );
				if ( empty( $title ) ) $title = $post->post_title;
			}
			$title_format = '';
			if ( empty( $title ) ) {
				$title = $this->wp_title();
			}
			$description = $this->get_main_description( $post );
			if ( empty( $title_format ) ) {
				if ( is_page() )
					$title_format = $aioseop_options['aiosp_page_title_format'];
				elseif ( is_single() || is_attachment() )
					$title_format = $this->get_post_title_format();
			}
			if ( empty( $title_format ) ) {
				$title_format = '%post_title%';
			}
		} else if ( is_object( $term ) ) {
			if ( $_GET['taxonomy'] == 'category' ) {
				query_posts( Array( 'cat' => $_GET['tag_ID'] ) );
			} else if ( $_GET['taxonomy'] == 'post_tag' ) {
				query_posts( Array( 'tag' => $term->slug ) );
			} else {
				query_posts( Array( 'page' => '', $_GET['taxonomy'] => $term->slug, 'post_type' => $_GET['post_type'] ) );					
			}
			if ( empty( $this->meta_opts ) )
				$this->meta_opts = $this->get_current_options( Array(), 'aiosp' );
			$title = $this->get_tax_name( $_GET['taxonomy'] );
			$title_format = $this->get_tax_title_format();
			$opts = $this->meta_opts;
			if ( !empty( $opts ) ) $description = $opts['aiosp_description'];
			if ( empty( $description ) ) $description = term_description();
			$description = $this->internationalize( $description );
		}

		$show_page = true;
		if ( !empty( $aioseop_options["aiosp_no_paged_canonical_links"] ) ) $show_page = false;
		if ( $aioseop_options['aiosp_can'] ) {
			if ( !empty( $aioseop_options['aiosp_customize_canonical_links'] ) && !empty( $opts['aiosp_custom_link'] ) ) $url = $opts['aiosp_custom_link'];
			if ( empty( $url ) )
				$url = $this->aiosp_mrt_get_url( $wp_query, $show_page );
			$url = apply_filters( 'aioseop_canonical_url', $url );
		}
		if ( !$url ) $url = get_permalink();
		
		$title = $this->apply_cf_fields( $title );
		$description = $this->apply_cf_fields( $description );
		$description = apply_filters( 'aioseop_description', $description );
		
		$keywords = $this->get_main_keywords();
		$keywords = $this->apply_cf_fields( $keywords );
		$keywords = apply_filters( 'aioseop_keywords', $keywords );
		
		wp_reset_postdata();
		$wp_query = $w; $post = $p;
		$info = Array( 'title' => $title, 'description' => $description, 'keywords' => $keywords, 'url' => $url, 'title_format' => $title_format );		
		return $info;
	}
	
	/*** Use custom callback for outputting snippet ***/
	function custom_output_option( $buf, $args ) {
		if ( $args['name'] == 'aiosp_snippet' )  {
			$args['options']['type'] = 'html';
            $args['options']['nowrap'] = false;
            $args['options']['save'] = false;
			$info = $this->get_page_snippet_info();
			extract( $info );
		} else return '';
		
		if ( $this->strlen( $title ) > 70 ) $title = $this->trim_excerpt_without_filters( $title, 70 ) . '...';
		if ( $this->strlen( $description ) > 156 ) $description = $this->trim_excerpt_without_filters( $description, 156 ) . '...';
		$extra_title_len = 0;
		if ( empty( $title_format ) ) {
			$title = '<span id="aioseop_snippet_title">' . esc_attr( wp_strip_all_tags( $title ) ) . '</span>';
		} else {
			if ( strpos( $title_format, '%blog_title%' ) !== false ) $title_format = str_replace( '%blog_title%', get_bloginfo( 'name' ), $title_format );
			$title_format = $this->apply_cf_fields( $title_format );
			$replace_title = '<span id="aioseop_snippet_title">' . esc_attr( wp_strip_all_tags( $title ) ) . '</span>';
			if ( strpos( $title_format, '%post_title%' ) !== false ) $title_format = str_replace( '%post_title%', $replace_title, $title_format );
			if ( strpos( $title_format, '%page_title%' ) !== false ) $title_format = str_replace( '%page_title%', $replace_title, $title_format );
			if ( strpos( $title_format, '%category_title%' ) !== false ) $title_format = str_replace( '%category_title%', $replace_title, $title_format );
			if ( strpos( $title_format, '%taxonomy_title%' ) !== false ) $title_format = str_replace( '%taxonomy_title%', $replace_title, $title_format );
			if ( strpos( $title_format, '%taxonomy_description%' ) !== false ) $title_format = str_replace( '%taxonomy_description%', $description, $title_format );
			
			$title_format = preg_replace( '/%([^%]*?)%/', '', $title_format );
			$title = $title_format;
			$extra_title_len = strlen( str_replace( $replace_title, '', $title_format ) );
		}
		
		$args['value'] = sprintf( $args['value'], $title, esc_url( $url ), esc_attr( wp_strip_all_tags( $description ) ) );
		$extra_title_len = (int)$extra_title_len;
		$args['value'] .= "<script>var aiosp_title_extra = {$extra_title_len};</script>";
		$buf = $this->get_option_row( $args['name'], $args['options'], $args );

		return $buf;
	}
	
	function add_page_icon() {
		wp_enqueue_script( 'wp-pointer', false, array( 'jquery' ) );
		wp_enqueue_style( 'wp-pointer' );
		$this->add_admin_pointers();
		?>
	    <style>
	        #toplevel_page_all-in-one-seo-pack-aioseop_class .wp-menu-image {
	            background: url(<?php echo AIOSEOP_PLUGIN_IMAGES_URL; ?>shield-sprite-16.png) no-repeat 8px 6px !important;
	        }
			#toplevel_page_all-in-one-seo-pack-aioseop_class .wp-menu-image:before {
				content: '' !important;
			}
	        #toplevel_page_all-in-one-seo-pack-aioseop_class .wp-menu-image img {
	            display: none;
	        }
	        #toplevel_page_all-in-one-seo-pack-aioseop_class:hover .wp-menu-image, #toplevel_page_all-in-one-seo-pack-aioseop_class.wp-has-current-submenu .wp-menu-image {
	            background-position: 8px -26px !important;
	        }
	        #icon-aioseop.icon32 {
	            background: url(<?php echo AIOSEOP_PLUGIN_IMAGES_URL; ?>shield32.png) no-repeat left top !important;
	        }
			#aioseop_settings_header #message {
				padding: 5px 0px 5px 50px;
				background-image: url(<?php echo AIOSEOP_PLUGIN_IMAGES_URL; ?>update32.png);
				background-repeat: no-repeat;
				background-position: 10px;
				font-size: 14px;
				min-height: 32px;
			}

	        @media
	        only screen and (-webkit-min-device-pixel-ratio: 1.5),
	        only screen and (   min--moz-device-pixel-ratio: 1.5),
	        only screen and (     -o-min-device-pixel-ratio: 3/2),
	        only screen and (        min-device-pixel-ratio: 1.5),
	        only screen and (                min-resolution: 1.5dppx) {

	            #toplevel_page_all-in-one-seo-pack-aioseop_class .wp-menu-image {
	                background-image: url('<?php echo AIOSEOP_PLUGIN_IMAGES_URL; ?>shield-sprite-32.png') !important;
	                -webkit-background-size: 16px 48px !important;
	                -moz-background-size: 16px 48px !important;
	                background-size: 16px 48px !important;
	            } 

	            #icon-aioseop.icon32 {
	                background-image: url('<?php echo AIOSEOP_PLUGIN_IMAGES_URL; ?>shield64.png') !important;
	                -webkit-background-size: 32px 32px !important;
	                -moz-background-size: 32px 32px !important;
	                background-size: 32px 32px !important;
	            }
	
				#aioseop_settings_header #message {
					background-image: url(<?php echo AIOSEOP_PLUGIN_IMAGES_URL; ?>update64.png) !important;
				    -webkit-background-size: 32px 32px !important;
				    -moz-background-size: 32px 32px !important;
				    background-size: 32px 32px !important;
				}
	        }
	    </style>
		<script>
			function aioseop_show_pointer( handle, value ) {
				if ( typeof( jQuery ) != 'undefined' ) {
					var p_edge = 'bottom';
					var p_align = 'center';
					if ( typeof( jQuery( value.pointer_target ).pointer) != 'undefined' ) {
						if ( typeof( value.pointer_edge ) != 'undefined' ) p_edge = value.pointer_edge;
						if ( typeof( value.pointer_align ) != 'undefined' ) p_align = value.pointer_align;
						jQuery(value.pointer_target).pointer({
									content    : value.pointer_text,
									position: {
										edge: p_edge,
										align: p_align
									},
									close  : function() {
										jQuery.post( ajaxurl, {
											pointer: handle,
											action: 'dismiss-wp-pointer'
										});
									}
								}).pointer('open');
					}
				}
			}
			<?php 
			if ( !empty( $this->pointers ) ) {
			?>
			if ( typeof( jQuery ) != 'undefined' ) {
				jQuery(document).ready(function() {
					var admin_pointer;
					var admin_index;
					<?php 
						foreach( $this->pointers as $k => $p )
							if ( !empty( $p["pointer_scope"] ) && ( $p["pointer_scope"] == 'global' ) ) {
								?>admin_index = "<?php echo esc_attr($k); ?>";
								admin_pointer = <?php echo json_encode( $p ); ?>;
								aioseop_show_pointer( admin_index, admin_pointer );
								<?php
							}
					?>
				});
			}
			<?php
			}
			?>
		</script>
		<?php
	}
	
	function add_page_hooks() {
		$this->oauth_init();
		$post_objs = get_post_types( '', 'objects' );
		$pt = array_keys( $post_objs );
		$rempost = array( 'revision', 'nav_menu_item' );
		$pt = array_diff( $pt, $rempost );
		$post_types = Array();
		foreach ( $pt as $p ) {
			if ( !empty( $post_objs[$p]->label ) )
				$post_types[$p] = $post_objs[$p]->label;
			else
				$post_types[$p] = $p;
		}
		$this->default_options["posttypecolumns"]['initial_options'] = $post_types;
		$this->default_options["cpostactive"]['initial_options'] = $post_types;
		$this->default_options["cpostnoindex"]['initial_options'] = $post_types;
		$this->default_options["cpostnofollow"]['initial_options'] = $post_types;
		$this->default_options["cpostnoodp"]['initial_options'] = $post_types;
		$this->default_options["cpostnoydir"]['initial_options'] = $post_types;
		$this->default_options["google_author_location"]['initial_options'] = $post_types;
		$this->default_options['google_author_location' ]['initial_options'] = array_merge( Array( 'front' => __( 'Front Page', 'all_in_one_seo_pack' ) ), $post_types, Array( 'all' => __( 'Everywhere Else', 'all_in_one_seo_pack' ) ) );
		$this->default_options["google_author_location"]['default'] = array_keys( $this->default_options["google_author_location"]['initial_options'] );
		
		foreach ( $post_types as $p => $pt ) {
			$field = $p . "_title_format";
			$name = $post_objs[$p]->labels->singular_name;
			if ( !isset( $this->default_options[$field] ) ) {
				$this->default_options[$field] = Array (
						'name' => "$name " . __( 'Title Format:', 'all_in_one_seo_pack' ) . "<br />($p)",
						'type' => 'text',
						'default' => '%post_title% | %blog_title%',
						'condshow' => Array( 'aiosp_rewrite_titles' => 1, 'aiosp_enablecpost' => 'on', 'aiosp_cpostadvanced' => 'on', 'aiosp_cposttitles' => 'on', 'aiosp_cpostactive\[\]' => $p )
				);
				$this->help_text[$field] = __( 'The following macros are supported:', 'all_in_one_seo_pack' )
					. '<ul><li>' . __( '%blog_title% - Your blog title', 'all_in_one_seo_pack' ) . '</li><li>' . 
					__( '%blog_description% - Your blog description', 'all_in_one_seo_pack' ) . '</li><li>' . 
					__( '%post_title% - The original title of the post', 'all_in_one_seo_pack' ) . '</li><li>' . 
					__( '%category_title% - The (main) category of the post', 'all_in_one_seo_pack' ) . '</li><li>' . 
					__( '%category% - Alias for %category_title%', 'all_in_one_seo_pack' ) . '</li><li>' . 
					__( "%post_author_login% - This post's author' login", 'all_in_one_seo_pack' ) . '</li><li>' . 
					__( "%post_author_nicename% - This post's author' nicename", 'all_in_one_seo_pack' ) . '</li><li>' . 
					__( "%post_author_firstname% - This post's author' first name (capitalized)", 'all_in_one_seo_pack' ) . '</li><li>' . 
					__( "%post_author_lastname% - This post's author' last name (capitalized)", 'all_in_one_seo_pack' ) . '</li>' . 
					'</ul>';
				$this->help_anchors[$field] = '#custom-titles';
				$this->layout['cpt']['options'][] = $field;
			}
		}
		global $wp_roles;
		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();			
		}
		$role_names = $wp_roles->get_names();
		ksort( $role_names );
		$this->default_options["ga_exclude_users"]['initial_options'] = $role_names;
        
		$this->setting_options();
		$this->add_help_text_links();
		add_filter( "{$this->prefix}display_options", Array( $this, 'filter_options' ), 10, 2 );
		parent::add_page_hooks();
	}
	
	function add_admin_pointers() {
		$this->pointers['aioseop_menu_220'] = Array( 'pointer_target' => '#toplevel_page_all-in-one-seo-pack-aioseop_class',
												 'pointer_text' => 	'<h3>' . sprintf( __( 'Welcome to Version %s!', 'all_in_one_seo_pack' ), AIOSEOP_VERSION )
													. '</h3><p>' . __( 'Thank you for running the latest and greatest All in One SEO Pack ever! Please review your settings, as we\'re always adding new features for you!', 'all_in_one_seo_pack' ) . '</p>',
												 'pointer_edge' => 'top',
												 'pointer_align' => 'left',
												 'pointer_scope' => 'global'
											);
		$this->pointers['aioseop_welcome_220'] = Array( 'pointer_target' => '#aioseop_top_button',
													'pointer_text' => '<h3>' . sprintf( __( 'Review Your Settings', 'all_in_one_seo_pack' ), AIOSEOP_VERSION )
													. '</h3><p>' . __( 'Thank you for running the latest and greatest All in One SEO Pack ever! New since 2.2: Control who accesses your site with the new Robots.txt Editor and File Editor modules!  Enable them from the Feature Manager.  Remember to review your settings, we have added some new ones!', 'all_in_one_seo_pack' ) . '</p>',
													 'pointer_edge' => 'bottom',
													 'pointer_align' => 'left',
													 'pointer_scope' => 'local'
											 );
		$this->filter_pointers();
	}
	
	function settings_page_init() {
		add_filter( "{$this->prefix}submit_options",	Array( $this, 'filter_submit'   ) );
	}
	
	function enqueue_scripts() {
		add_filter( "{$this->prefix}display_settings",	Array( $this, 'filter_settings' ), 10, 3 );
		add_filter( "{$this->prefix}display_options", Array( $this, 'filter_options' ), 10, 2 );
		parent::enqueue_scripts();
	}
	
	function filter_submit( $submit ) {
		$submit['Submit_Default']['value'] = __( 'Reset General Settings to Defaults', 'all_in_one_seo_pack' ) . ' &raquo;';
		$submit['Submit_All_Default'] = Array( 'type' => 'submit', 'class' => 'button-primary', 'value' => __( 'Reset ALL Settings to Defaults', 'all_in_one_seo_pack' ) . ' &raquo;' );
		return $submit;
	}
	
	/**
	 * Handle resetting options to defaults.
	 */
	function reset_options( $location = null, $delete = false ) {
		if ( $delete === true ) {
			$this->delete_class_option( $delete );
			$this->options = Array();
		}
		$default_options = $this->default_options( $location );
		foreach ( $default_options as $k => $v )
				$this->options[$k] = $v;
		$this->update_class_option( $this->options );
	}

	function get_current_options( $opts = Array(), $location = null, $defaults = null, $post = null ) {
		if ( ( $location === 'aiosp' ) && ( $this->locations[$location]['type'] == 'metabox' ) ) {
			if ( $post == null ) {
				global $post;
			}
			$post_id = $post;
			if ( is_object( $post_id ) )
				$post_id = $post_id->ID;
			$get_opts = $this->default_options( $location );
			$optlist = Array( 'keywords', 'description', 'title', 'custom_link', 'sitemap_exclude', 'disable', 'disable_analytics', 'noindex', 'nofollow', 'noodp', 'noydir', 'titleatr', 'menulabel' );
			if ( !( !empty( $this->options['aiosp_can'] ) ) && ( !empty( $this->options['aiosp_customize_canonical_links'] ) ) ) {
				unset( $optlist["custom_link"] );
			}
			foreach ( $optlist as $f ) {
				$field = "aiosp_$f";
				$meta = get_post_meta( $post_id, '_aioseop_' . $f, true );					
				$get_opts[$field] = htmlspecialchars( stripslashes( $meta ) );
			}
			$opts = wp_parse_args( $opts, $get_opts );
			return $opts;
		} else {
			$options = parent::get_current_options( $opts, $location, $defaults );
			return $options;
		}
	}
	
	function filter_settings( $settings, $location, $current ) {
		if ( $location == null ) {
			$prefix = $this->prefix;
			
			foreach ( Array( 'seopostcol', 'seocustptcol', 'debug_info', 'max_words_excerpt' ) as $opt )
				unset( $settings["{$prefix}$opt"] );
			
			if ( !class_exists( 'DOMDocument' ) ) {
				unset( $settings["{prefix}google_connect"] );
			}
		} elseif ( $location == 'aiosp' ) {
			global $post, $aioseop_sitemap;
			$prefix = $this->get_prefix( $location ) . $location . '_';
			if ( !empty( $post ) ) {
				$post_type = get_post_type( $post );
				if ( !empty( $this->options['aiosp_cpostnoindex'] ) && ( in_array( $post_type, $this->options['aiosp_cpostnoindex'] ) ) ) {
					$settings["{$prefix}noindex"]['type'] = 'select';
					$settings["{$prefix}noindex"]['initial_options'] = Array( '' => __( 'Default - noindex', 'all_in_one_seo_pack' ), 'off' => __( 'index', 'all_in_one_seo_pack' ), 'on' => __( 'noindex', 'all_in_one_seo_pack' ) );
				}
				if ( !empty( $this->options['aiosp_cpostnofollow'] ) && ( in_array( $post_type, $this->options['aiosp_cpostnofollow'] ) ) ) {
					$settings["{$prefix}nofollow"]['type'] = 'select';
					$settings["{$prefix}nofollow"]['initial_options'] = Array( '' => __( 'Default - nofollow', 'all_in_one_seo_pack' ), 'off' => __( 'follow', 'all_in_one_seo_pack' ), 'on' => __( 'nofollow', 'all_in_one_seo_pack' ) );
				}
				if ( !empty( $this->options['aiosp_cpostnoodp'] ) && ( in_array( $post_type, $this->options['aiosp_cpostnoodp'] ) ) ) {
					$settings["{$prefix}noodp"]['type'] = 'select';
					$settings["{$prefix}noodp"]['initial_options'] = Array( '' => __( 'Default - noodp', 'all_in_one_seo_pack' ), 'off' => __( 'odp', 'all_in_one_seo_pack' ), 'on' => __( 'noodp', 'all_in_one_seo_pack' ) );
				}
				if ( !empty( $this->options['aiosp_cpostnoydir'] ) && ( in_array( $post_type, $this->options['aiosp_cpostnoydir'] ) ) ) {
					$settings["{$prefix}noydir"]['type'] = 'select';
					$settings["{$prefix}noydir"]['initial_options'] = Array( '' => __( 'Default - noydir', 'all_in_one_seo_pack' ), 'off' => __( 'ydir', 'all_in_one_seo_pack' ), 'on' => __( 'noydir', 'all_in_one_seo_pack' ) );
				}
				global $post;
				$info = $this->get_page_snippet_info();
				extract( $info );
				$settings["{$prefix}title"]['placeholder'] = $title;
				$settings["{$prefix}description"]['placeholder'] = $description;
				$settings["{$prefix}keywords"]['placeholder'] = $keywords;
			}
			
			if ( !current_user_can( 'update_plugins' ) )
				unset( $settings["{$prefix}upgrade"] );
				
			if ( !is_object( $aioseop_sitemap ) )
				unset( $settings['aiosp_sitemap_exclude'] );
			if ( is_object( $post ) ) {
				if ( $post->post_type != 'page' ) {
					unset( $settings["{$prefix}titleatr"] );
					unset( $settings["{$prefix}menulabel"] );
				}
			}
			if ( !empty( $this->options[$this->prefix . 'togglekeywords'] ) ) {
				unset( $settings["{$prefix}keywords"] );
				unset( $settings["{$prefix}togglekeywords"] );
			} elseif ( !empty( $current["{$prefix}togglekeywords"] ) ) {
				unset( $settings["{$prefix}keywords"] );
			}
			if ( !( !empty( $this->options['aiosp_can'] ) ) && ( !empty( $this->options['aiosp_customize_canonical_links'] ) ) ) {
				unset( $settings["{$prefix}custom_link"] );
			}
		}
		return $settings;
	}
	
	function filter_options( $options, $location ) {
		if ( $location == 'aiosp' ) {
			global $post;
			if ( !empty( $post ) ) {
				$prefix = $this->prefix;
				$post_type = get_post_type( $post );
				foreach( Array( 'noindex', 'nofollow', 'noodp', 'noydir' ) as $no ) {
					if ( empty( $this->options['aiosp_cpost' . $no] ) || ( !in_array( $post_type, $this->options['aiosp_cpost' . $no] ) ) )
						if ( isset( $options["{$prefix}{$no}"] ) && ( $options["{$prefix}{$no}"] != 'on' ) )
							unset( $options["{$prefix}{$no}"] );
				}
			}
		}
		if ( $location == null ) {
			$prefix = $this->prefix;
			if ( isset( $options["{$prefix}rewrite_titles"] ) && ( !empty( $options["{$prefix}rewrite_titles"] ) ) )
				$options["{$prefix}rewrite_titles"] = 1;
			if ( ( isset( $options["{$prefix}enablecpost"] ) ) && ( $options["{$prefix}enablecpost"] === '' ) )
				$options["{$prefix}enablecpost"] = 0;
			if ( ( isset( $options["{$prefix}use_original_title"] ) ) && ( $options["{$prefix}use_original_title"] === '' ) )
				$options["{$prefix}use_original_title"] = 0;
		}
		return $options;
	}
	
	function display_extra_metaboxes( $add, $meta ) {
		echo "<div class='aioseop_metabox_wrapper' >";
		switch ( $meta['id'] ) {
			case "aioseop-about":
				?><div class="aioseop_metabox_text">
							<p><h2 style="display:inline;"><?php echo AIOSEOP_PLUGIN_NAME; ?></h2> by Michael Torbert of <a target="_blank" title="Semper Fi Web Design"
							href="http://semperfiwebdesign.com/">Semper Fi Web Design</a>.</p>
							<?php
							global $current_user;
							$user_id = $current_user->ID;
							$ignore = get_user_meta( $user_id, 'aioseop_ignore_notice' );
							if ( !empty( $ignore ) ) {
								$qa = Array();
								wp_parse_str( $_SERVER["QUERY_STRING"], $qa );
								$qa['aioseop_reset_notices'] = 1;
								$url = '?' . build_query( $qa );
								echo '<p><a href="' . $url . '">' . __( "Reset Dismissed Notices", 'all_in_one_seo_pack' ) . '</a></p>';
							}
							?>
							<p>
							<strong><a target="_blank" title="<?php _e('Pro Version', 'all_in_one_seo_pack' ); ?>"
							href="http://semperplugins.com/plugins/all-in-one-seo-pack-pro-version/?loc=side">
							<?php _e('UPGRADE TO PRO VERSION', 'all_in_one_seo_pack' ); ?></a></strong></p>
						</div>
				<?php
		    case "aioseop-donate":
		        ?>
				<div>
							<div class="aioseop_metabox_text">
								<p>If you like this plugin and find it useful, help keep this plugin free and actively developed by clicking the <a 				href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=mrtorbert%40gmail%2ecom&item_name=All%20In%20One%20SEO%20Pack&item_number=Support%20Open%20Source&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8" 
									target="_blank"><strong>donate</strong></a> button or send me a gift from my <a 
									href="https://www.amazon.com/wishlist/1NFQ133FNCOOA/ref=wl_web" target="_blank">
									<strong>Amazon wishlist</strong></a>.  Also, don't forget to follow me on <a 
									href="http://twitter.com/michaeltorbert/" target="_blank"><strong>Twitter</strong></a>.</p>
								</div>
								
							<div class="aioseop_metabox_feature">
								<a target="_blank" title="<?php _e( 'Donate', 'all_in_one_seo_pack' ); ?>"
	href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=mrtorbert%40gmail%2ecom&item_name=All%20In%20One%20SEO%20Pack&item_number=Support%20Open%20Source&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8">
					<img src="<?php echo AIOSEOP_PLUGIN_URL; ?>images/donate.jpg" alt="<?php _e('Donate with Paypal', 'all_in_one_seo_pack' ); ?>" />	</a>
					<a target="_blank" title="Amazon Wish List" href="https://www.amazon.com/wishlist/1NFQ133FNCOOA/ref=wl_web">
					<img src="<?php echo AIOSEOP_PLUGIN_URL; ?>images/amazon.jpg" alt="<?php _e('My Amazon Wish List', 'all_in_one_seo_pack' ); ?>" /> </a>
					<a target="_blank" title="<?php _e( 'Follow us on Facebook', 'all_in_one_seo_pack' ); ?>" href="http://www.facebook.com/pages/Semper-Fi-Web-Design/121878784498475"><span class="aioseop_follow_button aioseop_facebook_follow"></span></a>
					<a target="_blank" title="<?php _e( 'Follow us on Twitter', 'all_in_one_seo_pack' ); ?>" href="http://twitter.com/semperfidev/"><span class="aioseop_follow_button aioseop_twitter_follow"></span></a>
					</div>
				
				</div>
		        <?php
		        break;
			case "aioseop-list":
			?>
				<div class="aioseop_metabox_text">
						<form action="http://semperfiwebdesign.us1.list-manage.com/subscribe/post?u=794674d3d54fdd912f961ef14&amp;id=af0a96d3d9" 
						method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
						<h2><?php _e( 'Join our mailing list for tips, tricks, and WordPress secrets.', 'all_in_one_seo_pack' ); ?></h2>
						<p><i><?php _e( 'Sign up today and receive a free copy of the e-book 5 SEO Tips for WordPress ($39 value).', 'all_in_one_seo_pack' ); ?></i></p>
						<p><input type="text" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email Address">
							<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn"></p>
						</form>
				</div>
			<?php
				break;
		    case "aioseop-support":
		        ?><div class="aioseop_metabox_text">
				<p><div class="aioseop_icon aioseop_file_icon"></div><a target="_blank" href="http://semperplugins.com/documentation/"><?php _e( 'Read the All in One SEO Pack user guide', 'all_in_one_seo_pack' ); ?></a></p>
				<p><div class="aioseop_icon aioseop_support_icon"></div><a target="_blank" title="<?php _e( 'All in One SEO Pro Plugin Support Forum', 'all_in_one_seo_pack' ); ?>"
				href="http://semperplugins.com/support/"><?php _e( 'Access our Premium Support Forums', 'all_in_one_seo_pack' ); ?></a></p>
				<p><div class="aioseop_icon aioseop_cog_icon"></div><a target="_blank" title="<?php _e( 'All in One SEO Pro Plugin Changelog', 'all_in_one_seo_pack' ); ?>"
				href="http://semperfiwebdesign.com/blog/all-in-one-seo-pack/all-in-one-seo-pack-release-history/"><?php _e( 'View the Changelog', 'all_in_one_seo_pack' ); ?></a></p>
				<p><div class="aioseop_icon aioseop_youtube_icon"></div><a target="_blank" href="http://semperplugins.com/doc-type/video/"><?php _e( 'Watch video tutorials', 'all_in_one_seo_pack' ); ?></a></p>
				<p><div class="aioseop_icon aioseop_book_icon"></div><a target="_blank" href="http://semperplugins.com/documentation/quick-start-guide/"><?php _e( 'Getting started? Read the Beginners Guide', 'all_in_one_seo_pack' ); ?></a></p>
				</div>
		        <?php
		        break;
		}
		echo "</div>";
	}
	
	function get_queried_object() {
		static $p = null;
		global $wp_query, $post;
		if ( $p !== null ) return $p;
		if ( is_object( $post ) )
			$p = $post;
		else {
			if ( !$wp_query ) return null;
			$p = $wp_query->get_queried_object();			
		}
		return $p;
	}
	
	function is_page_included() {
		global $aioseop_options;
		if ( is_feed() ) return false;
		if ( aioseop_mrt_exclude_this_page() ) return false;
		$post = $this->get_queried_object();
		$post_type = '';
		if ( !empty( $post ) && !empty( $post->post_type ) )
			$post_type = $post->post_type;
		if ( empty( $aioseop_options['aiosp_enablecpost'] ) ) {
			$wp_post_types = get_post_types( Array( '_builtin' => true ) ); // don't display meta if SEO isn't enabled on custom post types -- pdb
			if( is_singular() && !in_array( $post_type, $wp_post_types ) && !is_front_page() ) return false;
		} elseif ( !empty( $aioseop_options['aiosp_cpostadvanced'] ) ) {
			$wp_post_types = $aioseop_options['aiosp_cpostactive'];
			if ( is_singular() && !in_array( $post_type, $wp_post_types ) && !is_front_page() ) return false;
			if ( is_post_type_archive() && !is_post_type_archive( $wp_post_types ) ) return false;
		}
		
		$this->meta_opts = $this->get_current_options( Array(), 'aiosp' );
		
		$aiosp_disable = $aiosp_disable_analytics = false;
		
		if  ( !empty( $this->meta_opts ) ) {
			if ( isset( $this->meta_opts['aiosp_disable'] ) ) 			$aiosp_disable			 = $this->meta_opts['aiosp_disable'];
			if ( isset( $this->meta_opts['aiosp_disable_analytics'] ) ) $aiosp_disable_analytics = $this->meta_opts['aiosp_disable_analytics'];
		}
		
		if ( $aiosp_disable ) {
			if ( !$aiosp_disable_analytics ) {
				if ( aioseop_option_isset( 'aiosp_google_analytics_id' ) ) {
					remove_action( 'aioseop_modules_wp_head', array( $this, 'aiosp_google_analytics' ) );
					add_action( 'wp_head', array( $this, 'aiosp_google_analytics' ) );
				}
			}
			return false;
		}
		
		if ( !empty( $this->meta_opts ) && $this->meta_opts['aiosp_disable'] == true ) return false;
		
		return true;
	}
	
	function template_redirect() {
		global $aioseop_options;

		$post = $this->get_queried_object();
		
		if ( !$this->is_page_included() ) return;
		if ( !empty( $aioseop_options['aiosp_rewrite_titles'] ) ) {
			$force_rewrites = 1;
			if ( isset( $aioseop_options['aiosp_force_rewrites'] ) )
				$force_rewrites = $aioseop_options['aiosp_force_rewrites'];
			if ( $force_rewrites )
				ob_start( array( $this, 'output_callback_for_title' ) );
			else
				add_filter( 'wp_title', array( $this, 'wp_title' ), 20 );
		}
	}
	
	function output_callback_for_title( $content ) {
		return $this->rewrite_title( $content );
	}

	function init() {
		if ( !defined( 'WP_PLUGIN_DIR' ) ) {
			load_plugin_textdomain( 'all_in_one_seo_pack', str_replace( ABSPATH, '', dirname( __FILE__ ) ) );
		} else {
			load_plugin_textdomain( 'all_in_one_seo_pack', false, AIOSEOP_PLUGIN_DIRNAME );
		}
	}
	
	function add_hooks() {
		global $aioseop_options;
		aioseop_update_settings_check();
		add_filter( 'user_contactmethods', 'aioseop_add_contactmethods' );
		if ( is_user_logged_in() && function_exists( 'is_admin_bar_showing' ) && is_admin_bar_showing() && current_user_can( 'manage_options' ) )
				add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 1000 );

		if ( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'admin_head', array( $this, 'add_page_icon' ) );
			add_action( 'admin_init', 'aioseop_addmycolumns', 1 );
			add_action( 'admin_init', 'aioseop_handle_ignore_notice' );
		} else {
			if ( $aioseop_options['aiosp_can'] == '1' || $aioseop_options['aiosp_can'] == 'on' )
			        remove_action( 'wp_head', 'rel_canonical' );
			////analytics
			if ( aioseop_option_isset( 'aiosp_google_analytics_id' ) )
				add_action( 'aioseop_modules_wp_head', array( $this, 'aiosp_google_analytics' ) );
			add_filter( 'wp_list_pages', 'aioseop_list_pages' );
			add_action( 'wp_head', array( $this, 'wp_head'), apply_filters( 'aioseop_wp_head_priority', 1 ) );
			add_action( 'template_redirect', array( $this, 'template_redirect' ), 0 );
			add_filter( 'wp_list_pages_excludes', 'aioseop_get_pages_start' );
			add_filter( 'get_pages', 'aioseop_get_pages' );	
		}
	}

	function is_static_front_page() {
		if ( isset( $this->is_front_page ) && $this->is_front_page !== null ) return $this->is_front_page;
		$post = $this->get_queried_object();
		$this->is_front_page = ( get_option( 'show_on_front' ) == 'page' && is_page() && $post->ID == get_option( 'page_on_front' ) );
		return $this->is_front_page;
	}
	
	function is_static_posts_page() {
		static $is_posts_page = null;
		if ( $is_posts_page !== null ) return $is_posts_page;
		$post = $this->get_queried_object();
		$is_posts_page = ( get_option( 'show_on_front' ) == 'page' && is_home() && $post->ID == get_option( 'page_for_posts' ) );
		return $is_posts_page;
	}
	
	function check_rewrite_handler() {
		global $aioseop_options;

		$force_rewrites = 1;
		if ( isset( $aioseop_options['aiosp_force_rewrites'] ) )
			$force_rewrites = $aioseop_options['aiosp_force_rewrites'];

		if ( !empty( $aioseop_options['aiosp_rewrite_titles'] ) && $force_rewrites ) {
			// make the title rewrite as short as possible
			if (function_exists( 'ob_list_handlers' ) ) {
				$active_handlers = ob_list_handlers();
			} else {
				$active_handlers = array();
			}
			if (sizeof($active_handlers) > 0 &&
				$this->strtolower( $active_handlers[sizeof( $active_handlers ) - 1] ) ==
				$this->strtolower( 'All_in_One_SEO_Pack::output_callback_for_title' ) ) {
				ob_end_flush();
			} else {
				$this->log( "another plugin interfering?" );
				// if we get here there *could* be trouble with another plugin :(
				$this->ob_start_detected = true;
				if ( function_exists( 'ob_list_handlers' ) ) {
					foreach ( ob_list_handlers() as $handler ) {
						$this->log( "detected output handler $handler" );
					}
				}
			}
		}
	}
	
	// handle prev / next links
	function get_prev_next_links( $post = null ) {
		$prev = $next = '';
		$page = $this->get_page_number();
		if ( is_home() || is_archive() || is_paged() ) {
			global $wp_query;
			$max_page = $wp_query->max_num_pages;
			if ( $page > 1 )
				$prev = get_previous_posts_page_link();
			if ( $page < $max_page ) {
				$paged = $GLOBALS['paged'];
				if ( !is_single() ) {
					if ( !$paged )
						$paged = 1;
					$nextpage = intval($paged) + 1;
					if ( !$max_page || $max_page >= $nextpage )
						$next = get_pagenum_link($nextpage);
				}
			}
		} else if ( is_page() || is_single() ) {
			$numpages = 1;
	        $multipage = 0;
	        $page = get_query_var('page');
	        if ( ! $page )
	                $page = 1;
	        if ( is_single() || is_page() || is_feed() )
	                $more = 1;
	        $content = $post->post_content;
	        if ( false !== strpos( $content, '<!--nextpage-->' ) ) {
	                if ( $page > 1 )
	                        $more = 1;
	                $content = str_replace( "\n<!--nextpage-->\n", '<!--nextpage-->', $content );
	                $content = str_replace( "\n<!--nextpage-->", '<!--nextpage-->', $content );
	                $content = str_replace( "<!--nextpage-->\n", '<!--nextpage-->', $content );
	                // Ignore nextpage at the beginning of the content.
	                if ( 0 === strpos( $content, '<!--nextpage-->' ) )
	                        $content = substr( $content, 15 );
	                $pages = explode('<!--nextpage-->', $content);
	                $numpages = count($pages);
	                if ( $numpages > 1 )
	                        $multipage = 1;
	        }
			if ( !empty( $page ) ) {
				if ( $page > 1 )
					$prev = _wp_link_page( $page - 1 );
				if ( $page + 1 <= $numpages )
					$next = _wp_link_page( $page + 1 );
			}
			if ( !empty( $prev ) ) {
				$prev = $this->substr( $prev, 9, -2 );
			}
			if ( !empty( $next ) ) {
				$next = $this->substr( $next, 9, -2 );
			}
		}
		return Array( 'prev' => $prev, 'next' => $next );
	}
	
	function get_google_authorship( $post ) {
		global $aioseop_options;
		$page = $this->get_page_number();
		// handle authorship
		$googleplus = $publisher = $author = '';

		if ( !empty( $post ) && isset( $post->post_author ) && empty( $aioseop_options['aiosp_google_disable_profile'] ) )
			$googleplus = get_the_author_meta( 'googleplus', $post->post_author );

		if ( empty( $googleplus ) && !empty( $aioseop_options['aiosp_google_publisher'] ) )
			$googleplus = $aioseop_options['aiosp_google_publisher'];

		if ( ( is_front_page() ) && ( $page < 2 ) ) {
			if ( !empty( $aioseop_options['aiosp_google_publisher'] ) )
				$publisher = $aioseop_options['aiosp_google_publisher'];

			if ( !empty( $aioseop_options["aiosp_google_author_advanced"] ) ) {
				if ( empty( $aioseop_options["aiosp_google_enable_publisher"] ) ) {
					$publisher = '';
				} elseif ( !empty( $aioseop_options["aiosp_google_specify_publisher"] ) ) {
					$publisher = $aioseop_options["aiosp_google_specify_publisher"];
				}
			}				
		}
		if ( is_singular() && ( !empty( $googleplus ) ) )
			$author = $googleplus;
		else if ( !empty( $aioseop_options['aiosp_google_publisher'] ) )
			$author = $aioseop_options['aiosp_google_publisher'];
			
		if ( !empty( $aioseop_options['aiosp_google_author_advanced'] ) && isset( $aioseop_options['aiosp_google_author_location'] ) ) {
			if ( is_front_page() && !in_array( 'front', $aioseop_options['aiosp_google_author_location'] ) ) {
				$author = '';
			} else {
				if ( in_array( 'all', $aioseop_options['aiosp_google_author_location'] ) ) {
					if ( is_singular() && !is_singular( $aioseop_options['aiosp_google_author_location'] ) )
						$author = '';
				} else {
					if ( !is_singular( $aioseop_options['aiosp_google_author_location'] ) )
						$author = '';
				}
			}
		}
		
		return Array( 'publisher' => $publisher, 'author' => $author );
	}
	
	function get_robots_meta() {
		global $aioseop_options;
		$opts = $this->meta_opts;
		$page = $this->get_page_number();
		$robots_meta = '';
				
		$aiosp_noindex = $aiosp_nofollow = $aiosp_noodp = $aiosp_noydir = '';
		$noindex = "index";
		$nofollow = "follow";
		if ( ( is_category() && !empty( $aioseop_options['aiosp_category_noindex'] ) ) || ( !is_category() && is_archive() && !is_tag() && !is_tax()
			&& ( ( is_date() && !empty( $aioseop_options['aiosp_archive_date_noindex'] ) ) || ( is_author() && !empty( $aioseop_options['aiosp_archive_author_noindex'] ) ) ) ) 
			|| ( is_tag() && !empty( $aioseop_options['aiosp_tags_noindex'] ) ) 
			|| ( is_search() && !empty( $aioseop_options['aiosp_search_noindex'] ) )
			|| ( is_404() && !empty( $aioseop_options['aiosp_404_noindex'] ) ) ) {
				$noindex = 'noindex';
		} elseif ( ( is_single() || is_page() || $this->is_static_posts_page() || is_attachment() || ( $page > 1 ) ) ) {
			$post_type = get_post_type();
			if ( !empty( $opts ) ) {
			    $aiosp_noindex = htmlspecialchars( stripslashes( $opts['aiosp_noindex'] ) );
			    $aiosp_nofollow = htmlspecialchars( stripslashes( $opts['aiosp_nofollow'] ) );
			    $aiosp_noodp = htmlspecialchars( stripslashes( $opts['aiosp_noodp'] ) );
			    $aiosp_noydir = htmlspecialchars( stripslashes( $opts['aiosp_noydir'] ) );					
			}
			if ( $aiosp_noindex || $aiosp_nofollow || $aiosp_noodp || $aiosp_noydir || !empty( $aioseop_options['aiosp_cpostnoindex'] ) 
				|| !empty( $aioseop_options['aiosp_cpostnofollow'] ) || !empty( $aioseop_options['aiosp_cpostnoodp'] ) || !empty( $aioseop_options['aiosp_cpostnoydir'] )
				|| !empty( $aioseop_options['aiosp_paginated_noindex'] ) || !empty( $aioseop_options['aiosp_paginated_nofollow'] ) ) {
				if ( ( $aiosp_noindex == 'on' ) || ( ( !empty( $aioseop_options['aiosp_paginated_noindex'] ) ) && ( ( $page > 1 ) ) ) ||
					 ( ( $aiosp_noindex == '' ) && ( !empty( $aioseop_options['aiosp_cpostnoindex'] ) ) && ( in_array( $post_type, $aioseop_options['aiosp_cpostnoindex'] ) ) ) )
					$noindex = "no" . $noindex;
				if ( ( $aiosp_nofollow == 'on' ) || ( ( !empty( $aioseop_options['aiosp_paginated_nofollow'] ) ) && ( ( $page > 1 ) ) ) ||
					 ( ( $aiosp_nofollow == '' ) && ( !empty( $aioseop_options['aiosp_cpostnofollow'] ) ) && ( in_array( $post_type, $aioseop_options['aiosp_cpostnofollow'] ) ) ) )
					$nofollow = "no" . $nofollow;
				if ( ( !empty( $aioseop_options['aiosp_cpostnoodp'] ) && ( in_array( $post_type, $aioseop_options['aiosp_cpostnoodp'] ) ) ) )
					$aiosp_noodp = true;
				if ( ( !empty( $aioseop_options['aiosp_cpostnoydir'] ) && ( in_array( $post_type, $aioseop_options['aiosp_cpostnoydir'] ) ) ) )
					$aiosp_noydir = true;
			}
		}
		if ( !empty( $aioseop_options['aiosp_noodp'] ) && $aioseop_options['aiosp_noodp'] )   $aiosp_noodp = true;
		if ( !empty( $aioseop_options['aiosp_noydir'] ) && $aioseop_options['aiosp_noydir'] ) $aiosp_noydir = true;
		if ( $aiosp_noodp ) $nofollow .= ',noodp';
		if ( $aiosp_noydir ) $nofollow .= ',noydir';
		$robots_meta = $noindex . ',' . $nofollow;
		if ( $robots_meta == 'index,follow' ) $robots_meta = '';
		return $robots_meta;
	}
	
	function get_main_description( $post = null ) {
		global $aioseop_options;
		$opts = $this->meta_opts;
		$description = '';
		if ( is_author()  && $this->show_page_description() ) {
			$description = $this->internationalize( get_the_author_meta( 'description' ) );
		} else if ( is_front_page() ) {
			$description = trim( stripslashes( $this->internationalize( $aioseop_options['aiosp_home_description'] ) ) );
		} else if ( function_exists( 'woocommerce_get_page_id' ) && is_post_type_archive( 'product' ) && ( $post_id = woocommerce_get_page_id( 'shop' ) ) && ( $post = get_post( $post_id ) ) ) {
			$description = $this->get_post_description( $post );
			$description = $this->apply_cf_fields( $description );
		} else if ( is_single() || is_page() || is_attachment() || is_home() || $this->is_static_posts_page() ) {
			$description = $this->get_aioseop_description( $post );
		} else if ( ( is_category() || is_tag() || is_tax() ) && $this->show_page_description() ) {
		//	if ( !empty( $opts ) ) $description = $opts['aiosp_description'];
			if ( empty( $description ) ) $description = term_description();
			$description = $this->internationalize( $description );
		}
		if ( empty( $aioseop_options['aiosp_dont_truncate_descriptions'] ) ) {
			$description = $this->trim_excerpt_without_filters( $description );				
		}
		return $description;
	}
	
	function trim_description( $description ) {
		$description = trim( wp_strip_all_tags( $description ) );
		$description = str_replace( '"', '&quot;', $description );
		$description = str_replace( "\r\n", ' ', $description );
		$description = str_replace( "\n", ' ', $description );
		return $description;
	}
	
	function apply_description_format( $description, $post = null ) {
		global $aioseop_options, $wp_query;
		$description_format = $aioseop_options['aiosp_description_format'];
		if ( !isset( $description_format ) || empty( $description_format ) ) {
			$description_format = "%description%";
		}
		$description = str_replace( '%description%', apply_filters( 'aioseop_description_override', $description ), $description_format );
		if ( strpos( $description, '%blog_title%'		) !== false ) $description = str_replace( '%blog_title%',		get_bloginfo( 'name' ), $description );
		if ( strpos( $description, '%blog_description%'	) !== false ) $description = str_replace( '%blog_description%',	get_bloginfo( 'description' ), $description );
		if ( strpos( $description, '%wp_title%'			) !== false ) $description = str_replace( '%wp_title%',			$this->get_original_title(), $description );
		if ( strpos( $description, '%post_title%'		) !== false ) $description = str_replace( '%post_title%',		$this->get_aioseop_title( $post ), $description );				
		if( $aioseop_options['aiosp_can'] && is_attachment() ) {
			$url = $this->aiosp_mrt_get_url( $wp_query );
			if ( $url ) {
				$matches = Array();
				preg_match_all( '/(\d+)/', $url, $matches );
				if ( is_array( $matches ) ){
					$uniqueDesc = join( '', $matches[0] );
				}
			}
			$description .= ' ' . $uniqueDesc;
		}
		return $description;
	}
	
	function get_main_keywords() {
		global $aioseop_options;
		global $aioseop_keywords;
		global $post;
		$opts = $this->meta_opts;
		if ( ( ( is_front_page() && $aioseop_options['aiosp_home_keywords'] && !$this->is_static_posts_page() ) || $this->is_static_front_page() ) ) {
			$keywords = trim( $this->internationalize( $aioseop_options['aiosp_home_keywords'] ) );
		} elseif ( empty( $aioseop_options['aiosp_dynamic_postspage_keywords'] ) && ($this->is_static_posts_page() || is_archive() || is_post_type_archive() ) ) {
				$keywords = stripslashes( $this->internationalize( $opts["aiosp_keywords"] ) ); // and if option = use page set keywords instead of keywords from recent posts
		} elseif ( ( $blog_page = $this->get_blog_page( $post ) )  && empty( $aioseop_options['aiosp_dynamic_postspage_keywords'] ) ) {
				$keywords = stripslashes( $this->internationalize( get_post_meta( $blog_page->ID, "_aioseop_keywords", true ) ) );
		} else {
			$keywords = $this->get_all_keywords();
		}
		return $keywords;
	}

	function wp_head() {
			if ( !$this->is_page_included() ) return;
			$opts = $this->meta_opts;
			global $wp_query, $aioseop_options, $posts;
			static $aioseop_dup_counter = 0;
			$aioseop_dup_counter++;
			if ( $aioseop_dup_counter > 1 ) {
			    echo "\n<!-- " . sprintf( __( "Debug Warning: All in One SEO Pack meta data was included again from %s filter. Called %s times!", 'all_in_one_seo_pack' ), current_filter(), $aioseop_dup_counter ) . " -->\n";
			    return;
			}
			if ( is_home() && !is_front_page() ) {
				$post = $this->get_blog_page();
			} else {
				$post = $this->get_queried_object();
			}
			$meta_string = null;
			$description = '';
			// logging - rewrite handler check for output buffering
			$this->check_rewrite_handler();
			echo "\n<!-- All in One SEO Pack $this->version by Michael Torbert of Semper Fi Web Design";
			if ( $this->ob_start_detected )
				echo "ob_start_detected ";
			echo "[$this->title_start,$this->title_end] ";
			echo "-->\n";
			$blog_page = $this->get_blog_page( $post );
			$save_posts = $posts;
			if ( function_exists( 'woocommerce_get_page_id' ) && is_post_type_archive( 'product' ) && ( $post_id = woocommerce_get_page_id( 'shop' ) ) && ( $post = get_post( $post_id ) ) ) {
				global $posts;
				$opts = $this->meta_opts = $this->get_current_options( Array(), 'aiosp', null, $post );
				$posts = Array();
				$posts[] = $post;
			}
			$posts = $save_posts;
			$description = apply_filters( 'aioseop_description', $this->get_main_description( $post ) );	// get the description
			// handle the description format
			if ( isset($description) && ( $this->strlen($description) > $this->minimum_description_length ) && !( is_front_page() && is_paged() ) ) {
				$description = $this->trim_description( $description );
				if ( !isset( $meta_string) ) $meta_string = '';
				// description format
				$description = apply_filters( 'aioseop_description_full', $this->apply_description_format( $description, $post ) );
				$desc_attr = '';
				if ( !empty( $aioseop_options['aiosp_schema_markup'] ) )
					$desc_attr = 'itemprop="description"';
				$desc_attr = apply_filters( 'aioseop_description_attributes', $desc_attr );
				$meta_string .= sprintf( "<meta name=\"description\" %s content=\"%s\" />\n", $desc_attr, $description );
			}
			// get the keywords
			$togglekeywords = 0;
			if ( isset( $aioseop_options['aiosp_togglekeywords'] ) )
				$togglekeywords = $aioseop_options['aiosp_togglekeywords'];
			if ( $togglekeywords == 0  && !( is_front_page() && is_paged() ) ) {
				$keywords = $this->get_main_keywords();
				$keywords = $this->apply_cf_fields( $keywords );
				$keywords = apply_filters( 'aioseop_keywords', $keywords );
				
				if ( isset( $keywords ) && !empty( $keywords ) ) {
					if ( isset( $meta_string ) ) $meta_string .= "\n";
					$keywords = wp_filter_nohtml_kses( str_replace( '"', '', $keywords ) );
					$key_attr = '';
					if ( !empty( $aioseop_options['aiosp_schema_markup'] ) )
						$key_attr = 'itemprop="keywords"';
					$key_attr = apply_filters( 'aioseop_keywords_attributes', $key_attr );
					$meta_string .= sprintf( "<meta name=\"keywords\" %s content=\"%s\" />\n", $key_attr, $keywords );
				}
			}
			// handle noindex, nofollow - robots meta
			$robots_meta = apply_filters( 'aioseop_robots_meta', $this->get_robots_meta() );
			if ( !empty( $robots_meta ) )
				$meta_string .= '<meta name="robots" content="' . esc_attr( $robots_meta ) . '" />' . "\n";
			// handle site verification
			if ( is_front_page() ) {
				foreach( Array( 'google' => 'google-site-verification', 'bing' => 'msvalidate.01', 'pinterest' => 'p:domain_verify' ) as $k => $v )
					if ( !empty( $aioseop_options["aiosp_{$k}_verify"] ) )
						$meta_string .= '<meta name="' . $v . '" content="' . trim( strip_tags( $aioseop_options["aiosp_{$k}_verify"] ) ) . '" />' . "\n";
				
				// sitelinks search
				if ( !empty( $aioseop_options["aiosp_google_sitelinks_search"] ) )
					$meta_string .= $this->sitelinks_search_box() . "\n";
			}
			// handle extra meta fields
			foreach( Array( 'page_meta', 'post_meta', 'home_meta', 'front_meta' ) as $meta ) {
				if ( !empty( $aioseop_options["aiosp_{$meta}_tags" ] ) )
					$$meta = html_entity_decode( stripslashes( $aioseop_options["aiosp_{$meta}_tags" ] ), ENT_QUOTES );
				else
					$$meta = '';
			}
			if ( is_page() && isset( $page_meta ) && !empty( $page_meta ) && ( !is_front_page() || empty( $front_meta ) ) ) {
				if ( isset( $meta_string ) ) $meta_string .= "\n";
				$meta_string .= $page_meta;
			}
			if ( is_single() && isset( $post_meta ) && !empty( $post_meta ) ) {
				if ( isset( $meta_string ) ) $meta_string .= "\n";
				$meta_string .= $post_meta;
			}
			// handle authorship
			$authorship = $this->get_google_authorship( $post );			
			$publisher = apply_filters( 'aioseop_google_publisher', $authorship["publisher"] );
			if ( !empty( $publisher ) )
				$meta_string = '<link rel="publisher" href="' . esc_url( $publisher ) . '" />' . "\n" . $meta_string;
			$author = apply_filters( 'aioseop_google_author', $authorship["author"] );
			if ( !empty( $author ) )
				$meta_string = '<link rel="author" href="' . esc_url( $author ) . '" />' . "\n" . $meta_string;

			if ( is_front_page() && !empty( $front_meta ) ) {
				if ( isset( $meta_string ) ) $meta_string .= "\n";
				$meta_string .= $front_meta;
			} else {
				if ( is_home() && !empty( $home_meta ) ) {
					if ( isset( $meta_string ) ) $meta_string .= "\n";
					$meta_string .= $home_meta;
				}
			}
			$prev_next = $this->get_prev_next_links( $post );
			$prev = apply_filters( 'aioseop_prev_link', $prev_next['prev'] );
			$next = apply_filters( 'aioseop_next_link', $prev_next['next'] );
			if ( !empty( $prev ) ) $meta_string .= "<link rel='prev' href='" . esc_url( $prev ) . "' />\n";
			if ( !empty( $next ) ) $meta_string .= "<link rel='next' href='" . esc_url( $next ) . "' />\n";
			if ( $meta_string != null ) echo "$meta_string\n";
			// handle canonical links
			$show_page = true;
			if ( !empty( $aioseop_options["aiosp_no_paged_canonical_links"] ) ) $show_page = false;
			
			if ( $aioseop_options['aiosp_can'] ) {
				$url = '';
				if ( !empty( $aioseop_options['aiosp_customize_canonical_links'] ) && !empty( $opts['aiosp_custom_link'] ) ) $url = $opts['aiosp_custom_link'];
				if ( empty( $url ) )
					$url = $this->aiosp_mrt_get_url( $wp_query, $show_page );
				$url = apply_filters( 'aioseop_canonical_url', $url );
				if ( !empty( $url ) )
					echo '<link rel="canonical" href="'. esc_url( $url ) . '" />'."\n";
			}
			do_action( 'aioseop_modules_wp_head' );
			echo "<!-- /all in one seo pack -->\n";
	}
	
	function override_options( $options, $location, $settings ) {
		if ( class_exists( 'DOMDocument' ) ) {
			$options['aiosp_google_connect'] = $settings['aiosp_google_connect']['default'];			
		}
		return $options;
	}

	function oauth_init() {
		if ( !is_user_logged_in() || !current_user_can( 'manage_options' ) ) return false;
		$this->token = "anonymous";
		$this->secret = "anonymous";
		$preload = $this->get_class_option();
		$manual_ua = '';
		if ( !empty( $_POST ) ) {
			if ( !empty( $_POST["{$this->prefix}google_connect"] ) ) {
				$manual_ua = 1;
			}
		} elseif ( !empty( $preload["{$this->prefix}google_connect"] ) ) {
			$manual_ua = 1;
		}
		if ( !empty( $manual_ua ) ) {
				foreach ( Array( "token", "secret", "access_token", "ga_token", "account_cache" ) as $v ) {
					if ( !empty( $preload["{$this->prefix}{$v}"]) ) {
						unset( $preload["{$this->prefix}{$v}"] );
						unset( $this->$v );
					}
				}
				$this->update_class_option( $preload );
				$this->update_options( );
	//		return;
		}
		foreach ( Array( "token", "secret", "access_token", "ga_token", "account_cache" ) as $v ) {
			if ( !empty( $preload["{$this->prefix}{$v}"]) ) {
				$this->$v = $preload["{$this->prefix}{$v}"];
			}
		}
		$callback_url = NULL;
		if ( !empty( $_REQUEST['oauth_verifier'] ) ) {
			$this->verifier = $_REQUEST['oauth_verifier'];
			if ( !empty( $_REQUEST['oauth_token'] ) ) {
				if ( isset( $this->token ) && $this->token == $_REQUEST['oauth_token'] ) {
					$this->access_token = $this->oauth_get_token( $this->verifier );
					if ( is_array( $this->access_token ) && !empty( $this->access_token['oauth_token'] ) ) {
						unset( $this->token );
						unset( $this->secret );
						$this->ga_token = $this->access_token['oauth_token'];
						foreach ( Array( "token", "secret", "access_token", "ga_token" ) as $v ) {
							if ( !empty( $this->$v) )  $preload["{$this->prefix}{$v}"] = $this->$v;
						}
						$this->update_class_option( $preload );
					}
				}
				wp_redirect( menu_page_url( plugin_basename( $this->file ), false ) );
				exit;
			}
		}
		if ( !empty( $this->ga_token ) ) {
			if ( !empty( $this->account_cache ) ) {
				$ua = $this->account_cache['ua'];
				$profiles = $this->account_cache['profiles'];
			} else {
				$this->token = $this->access_token['oauth_token'];
				$this->secret = $this->access_token['oauth_token_secret'];

				$data = $this->oauth_get_data('https://www.googleapis.com/analytics/v2.4/management/accounts/~all/webproperties/~all/profiles' );
				$http_code = wp_remote_retrieve_response_code( $data );
	            if( $http_code == 200 ) {
					$response = wp_remote_retrieve_body( $data );
					$xml = $this->xml_string_to_array( $response );
					$ua = Array();
					$profiles = Array();
					if ( !empty( $xml["entry"] ) ) {
						$rec = Array();
						$results = Array();
						if ( !empty( $xml["entry"][0] ) )
							$results = $xml["entry"];
						else
							$results[] = $xml["entry"];
						foreach( $results as $r ) {
							foreach( $r as $k => $v )
								switch( $k ) {
									case 'id':		$rec['id'] = $v; break;
									case 'title':	$rec['title'] = $v['@content']; break;
									case 'dxp:property':
													$attr = Array();
													foreach ( $v as $a => $f )
														if ( is_array($f) && !empty($f['@attributes'] ) )
															$rec[$f['@attributes']['name']] = $f['@attributes']['value'];
													break;
								}
							$ua[$rec['title']] = Array( $rec['ga:webPropertyId'] => $rec['ga:webPropertyId'] );
							$profiles[ $rec['ga:webPropertyId'] ] = $rec['ga:profileId'];
						}
					}
					$this->account_cache = Array();
					$this->account_cache['ua'] = $ua;
					$this->account_cache['profiles'] = $profiles;
					$preload["{$this->prefix}account_cache"] = $this->account_cache;
				} else {
					unset( $this->token );
					unset( $this->secret );
					unset( $this->ga_token );
					unset( $preload["{$this->prefix}ga_token"] ); // error condition here -- pdb
					$response = wp_remote_retrieve_body( $data );
					$xml = $this->xml_string_to_array( $response );
					if ( !empty( $xml ) && !empty( $xml["error"] ) ) {
						$error = 'Error: ';
						if ( !empty( $xml["error"]["internalReason"] ) ) {
							$error .= $xml["error"]["internalReason"];
						} else {
							foreach( $xml["error"] as $k => $v )
								$error .= "$k: $v\n";
						}
						$this->output_error( $error );
					}
				}
			}
		}
		if ( !empty( $this->ga_token ) ) {
			$this->default_options["google_analytics_id"]['type'] = 'select';
			$this->default_options["google_analytics_id"]['initial_options'] = $ua;
			$this->default_options["google_connect"]["type"] = 'html';
			$this->default_options["google_connect"]["nolabel"] = 1;
			$this->default_options["google_connect"]["save"] = true;
			$this->default_options["google_connect"]["name"] = __( 'Disconnect From Google Analytics', 'all_in_one_seo_pack' );
			$this->default_options["google_connect"]["default"] = "<input name='aiosp_google_connect' type=submit  class='button-primary' value='" . __( 'Remove Stored Credentials', 'all_in_one_seo_pack' ) . "'>";
			add_filter( $this->prefix . 'override_options', Array( $this, 'override_options' ), 10, 3 );
		} else {
			$this->default_options["google_connect"]["type"] = 'html';
			$this->default_options["google_connect"]["nolabel"] = 1;
			$this->default_options["google_connect"]["save"] = false;
			$url = $this->oauth_connect();
			$this->default_options["google_connect"]["default"] = "<a href='{$url}' class='button-primary'>" . __( 'Connect With Google Analytics', 'all_in_one_seo_pack' ) . "</a>";
			foreach ( Array( "token", "secret", "access_token", "ga_token", "account_cache" ) as $v ) {
				if ( !empty( $this->$v) )  $preload["{$this->prefix}{$v}"] = $this->$v;
			}
		}
		$this->update_class_option( $preload );
		$this->update_options( );
		// $url = $this->report_query();
		if ( !empty( $this->account_cache ) && !empty( $this->options["{$this->prefix}google_analytics_id"] ) && !empty( $this->account_cache["profiles"][ $this->options["{$this->prefix}google_analytics_id"] ] ) ) {
			$this->profile_id = $this->account_cache["profiles"][ $this->options["{$this->prefix}google_analytics_id"] ];
		}
	}

	function oauth_get_data( $oauth_url, $args = null ) {
		if ( !class_exists( 'OAuthConsumer' ) ) require_once( 'OAuth.php' );
		if ( $args === null ) $args = Array( 'scope' => 'https://www.googleapis.com/auth/analytics.readonly', 'xoauth_displayname' => AIOSEOP_PLUGIN_NAME . ' ' . __('Google Analytics', 'all_in_one_seo_pack' ) );
		$req_token = new OAuthConsumer( $this->token, $this->secret );
		$req = $this->oauth_get_creds( $oauth_url, $req_token, $args );
		return wp_remote_get( $req->to_url() );
	}

	function oauth_get_creds( $oauth_url, $req_token = NULL, $args = Array(), $callback = null ) {
		if ( !class_exists( 'OAuthConsumer' ) ) require_once( 'OAuth.php' );
		if ( !empty( $callback ) ) $args['oauth_callback'] = $callback;
		if ( empty( $this->sig_method ) ) $this->sig_method = new OAuthSignatureMethod_HMAC_SHA1();
		if ( empty( $this->consumer ) )   $this->consumer = new OAuthCOnsumer( 'anonymous', 'anonymous' );				
		$req_req = OAuthRequest::from_consumer_and_token( $this->consumer, $req_token, "GET", $oauth_url, $args );
		$req_req->sign_request( $this->sig_method, $this->consumer, $req_token );
		return $req_req;
	}

	function oauth_get_token( $oauth_verifier ) {
		if ( !class_exists( 'OAuthConsumer' ) ) require_once( 'OAuth.php' );
		$args = Array( 'scope' => 'https://www.google.com/analytics/feeds/', 'xoauth_displayname' => AIOSEOP_PLUGIN_NAME . ' ' . __('Google Analytics', 'all_in_one_seo_pack' ) );
		$args['oauth_verifier'] = $oauth_verifier;
		$oauth_access_token = "https://www.google.com/accounts/OAuthGetAccessToken";
		$reqData = $this->oauth_get_data( $oauth_access_token, $args );
		$reqOAuthData = OAuthUtil::parse_parameters( wp_remote_retrieve_body( $reqData ) );
		return $reqOAuthData;
	}

	function oauth_connect( $count = 0 ) {
		global $aiosp_activation;
		if ( !class_exists( 'OAuthConsumer' ) ) require_once( 'OAuth.php' );
		$url = '';
		$callback_url = NULL;
		$consumer_key = "anonymous"; 
		$consumer_secret = "anonymous"; 
		$oauth_request_token = "https://www.google.com/accounts/OAuthGetRequestToken"; 
		$oauth_authorize = "https://www.google.com/accounts/OAuthAuthorizeToken"; 
		$oauth_access_token = "https://www.google.com/accounts/OAuthGetAccessToken";
		if ( $aiosp_activation ) {
			$oauth_current = false;
		} else {			
			$oauth_current = get_transient( "aioseop_oauth_current" );
		}
		if ( !empty( $this->token ) && ( $this->token != 'anonymous' ) && $oauth_current ) {
			return $oauth_authorize . '?oauth_token=' . $this->token;			
		} else {
			set_transient( "aioseop_oauth_current", 1, 3600 );
			unset( $this->token );
			unset( $this->secret );
		}
		$args = array(
			'scope' => 'https://www.google.com/analytics/feeds/',
			'xoauth_displayname' => AIOSEOP_PLUGIN_NAME . ' ' . __('Google Analytics', 'all_in_one_seo_pack')
		);
		$req_req = $this->oauth_get_creds( $oauth_request_token, NULL, $args, admin_url( "admin.php?page=all-in-one-seo-pack/aioseop_class.php" ) );
		$reqData = wp_remote_get( $req_req->to_url() );
		$reqOAuthData = OAuthUtil::parse_parameters( wp_remote_retrieve_body( $reqData ) );
		if ( !empty( $reqOAuthData['oauth_token'] ) ) $this->token = $reqOAuthData['oauth_token'];
		if ( !empty( $reqOAuthData['oauth_token_secret'] ) ) $this->secret = $reqOAuthData['oauth_token_secret'];
		if ( !empty( $this->token ) && ( $this->token != 'anonymous' ) && ( $oauth_current ) ) {
			$url = $oauth_authorize . "?oauth_token={$this->token}";
		} else {
			if ( !$count ) {
				return $this->oauth_connect( 1 );
			}
		}		
		return $url;
	}

	function get_analytics_domain() {
		global $aioseop_options;
		if ( !empty( $aioseop_options['aiosp_ga_domain'] ) )
			return $this->sanitize_domain( $aioseop_options['aiosp_ga_domain'] );
		return '';
	}

	function universal_analytics() {
		global $aioseop_options;
		$analytics = '';
		if ( !empty( $aioseop_options['aiosp_ga_use_universal_analytics'] ) ) {
			$allow_linker = $cookie_domain = $domain = $addl_domains = $domain_list = '';
			if ( !empty( $aioseop_options['aiosp_ga_advanced_options'] ) )
				$cookie_domain = $this->get_analytics_domain();
			if ( !empty( $cookie_domain ) ) {
				$cookie_domain = esc_js( $cookie_domain );
				$cookie_domain = "'cookieDomain': '{$cookie_domain}'";
			}
			if ( empty( $cookie_domain ) ) {
				$domain = ", 'auto'";
			}
			if ( !empty( $aioseop_options['aiosp_ga_advanced_options'] ) && !empty( $aioseop_options['aiosp_ga_multi_domain'] ) ) {
				$allow_linker = "'allowLinker': true";
				if ( !empty( $aioseop_options['aiosp_ga_addl_domains'] ) ) {
					$addl_domains = trim( $aioseop_options['aiosp_ga_addl_domains'] );
					$addl_domains = preg_split('/[\s,]+/', $addl_domains);
					if ( !empty( $addl_domains ) ) {
						foreach( $addl_domains as $d ) {
							$d = $this->sanitize_domain( $d );
							if ( !empty( $d ) ) {
								if ( !empty( $domain_list ) )
									$domain_list .= ", ";
								$domain_list .= "'" . $d . "'";
							}
						}
					}
				}
			}
			$extra_options = '';
			if ( !empty( $aioseop_options['aiosp_ga_advanced_options'] ) && !empty( $aioseop_options['aiosp_ga_display_advertising'] ) ) {
				$extra_options .= "ga('require', 'displayfeatures');";
			}
			if ( !empty( $aioseop_options['aiosp_ga_advanced_options'] ) && !empty( $aioseop_options['aiosp_ga_enhanced_ecommerce'] ) ) {
				if ( !empty( $extra_options ) ) $extra_options .= "\n\t\t\t";
				$extra_options .= "ga('require', 'ec');";
			}
			if ( !empty( $domain_list ) ) {
				if ( !empty( $extra_options ) ) $extra_options .= "\n\t\t\t";
				$extra_options .= "ga('require', 'linker');\n\t\t\tga('linker:autoLink', [{$domain_list}] );";
			}
			if ( !empty( $aioseop_options['aiosp_ga_advanced_options'] ) && !empty( $aioseop_options['aiosp_ga_link_attribution'] ) ) {
				if ( !empty( $extra_options ) ) $extra_options .= "\n\t\t\t";
				$extra_options .= "ga('require', 'linkid', 'linkid.js');";
			}
			
			if ( !empty( $aioseop_options['aiosp_ga_advanced_options'] ) && !empty( $aioseop_options['aiosp_ga_anonymize_ip'] ) ) {
				if ( !empty( $extra_options ) ) $extra_options .= "\n\t\t\t";
				$extra_options .= "ga('set', 'anonymizeIp', true);";
			}
			$js_options = Array();
			foreach( Array( 'cookie_domain', 'allow_linker' ) as $opts ) {
				if ( !empty( $$opts ) ) $js_options[] = $$opts;
			}
			if ( !empty( $js_options ) ) {
				$js_options = join( ',', $js_options );
				$js_options = ', { ' . $js_options . ' } ';
			} else $js_options = '';		
			$analytics_id = esc_js( $aioseop_options["aiosp_google_analytics_id"] );
			$analytics =<<<EOF
			<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', '{$analytics_id}'{$domain}{$js_options});
			{$extra_options}
			ga('send', 'pageview');
			</script>

EOF;
		}
		return $analytics;
	}

function aiosp_google_analytics() {
	global $aioseop_options;
	$analytics = '';
	if ( !empty( $aioseop_options['aiosp_ga_advanced_options'] ) && !empty( $aioseop_options['aiosp_ga_exclude_users'] ) ) {
		if ( is_user_logged_in() ) {
			global $current_user;
			if ( empty( $current_user ) ) get_currentuserinfo();
			if ( !empty( $current_user ) ) {
				$intersect = array_intersect( $aioseop_options['aiosp_ga_exclude_users'], $current_user->roles );
				if ( !empty( $intersect ) ) return;			
			}
		}
	}
	if ( !empty( $aioseop_options['aiosp_google_analytics_id'] ) ) {
	ob_start();
	$analytics = $this->universal_analytics();
	echo $analytics;
	if ( empty( $analytics ) ) {
?>		<script type="text/javascript">
		  var _gaq = _gaq || [];
<?php if ( !empty( $aioseop_options['aiosp_ga_advanced_options'] ) && !empty( $aioseop_options['aiosp_ga_link_attribution'] ) ) {	
?>		var pluginUrl =
 		'//www.google-analytics.com/plugins/ga/inpage_linkid.js';
		_gaq.push(['_require', 'inpage_linkid', pluginUrl]);
<?php
}
?>		  _gaq.push(['_setAccount', '<?php
			echo $aioseop_options['aiosp_google_analytics_id'];
		  ?>']);
<?php if ( !empty( $aioseop_options['aiosp_ga_advanced_options'] ) && !empty( $aioseop_options['aiosp_ga_anonymize_ip'] ) ) {
?>		  _gaq.push(['_gat._anonymizeIp']);
<?php
}
?>
<?php if ( !empty( $aioseop_options['aiosp_ga_advanced_options'] ) && !empty( $aioseop_options['aiosp_ga_multi_domain'] ) ) {
?>		  _gaq.push(['_setAllowLinker', true]);
<?php
}
?>
<?php if ( !empty( $aioseop_options['aiosp_ga_advanced_options'] ) && !empty( $aioseop_options['aiosp_ga_domain'] ) ) {
		  $domain = $this->get_analytics_domain();
?>		  _gaq.push(['_setDomainName', '<?php echo $domain; ?>']);
<?php
}
?>		  _gaq.push(['_trackPageview']);
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
<?php
		if ( !empty( $aioseop_options['aiosp_ga_advanced_options'] ) && !empty( $aioseop_options['aiosp_ga_display_advertising'] ) ) {
?>			ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
<?php
		} else {
?>			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
<?php
		}
?>		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
<?php
	}
	if ( !empty( $aioseop_options['aiosp_ga_advanced_options'] ) && $aioseop_options['aiosp_ga_track_outbound_links'] ) { ?>
		<script type="text/javascript">
		function recordOutboundLink(link, category, action) {
		<?php if ( !empty( $aioseop_options['aiosp_ga_use_universal_analytics'] ) ) { ?>
			ga('send', 'event', category, action);
		<?php }
		 	  if ( empty( $aioseop_options['aiosp_ga_use_universal_analytics'] ) ) {	?>
			_gat._getTrackerByName()._trackEvent(category, action);
		<?php } ?>
			if ( link.target == '_blank' ) return true;
			setTimeout('document.location = "' + link.href + '"', 100);
			return false;
		}
			/* use regular Javascript for this */
			function getAttr(ele, attr) {
				var result = (ele.getAttribute && ele.getAttribute(attr)) || null;
				if( !result ) {
					var attrs = ele.attributes;
					var length = attrs.length;
					for(var i = 0; i < length; i++)
					if(attr[i].nodeName === attr) result = attr[i].nodeValue;
				}
				return result;
			}
			
			function aiosp_addLoadEvent(func) {
			  var oldonload = window.onload;
			  if (typeof window.onload != 'function') {
			    window.onload = func;
			  } else {
			    window.onload = function() {
			      if (oldonload) {
			        oldonload();
			      }
			      func();
			    }
			  }
			}
			
			function aiosp_addEvent(element, evnt, funct){
			  if (element.attachEvent)
			   return element.attachEvent('on'+evnt, funct);
			  else
			   return element.addEventListener(evnt, funct, false);
			}

			aiosp_addLoadEvent(function () {
				var links = document.getElementsByTagName('a');
				for (var x=0; x < links.length; x++) {
					if (typeof links[x] == 'undefined') continue;
					aiosp_addEvent( links[x], 'onclick', function () {
						var mydomain = new RegExp(document.domain, 'i');
						href = getAttr(this, 'href');
						if (href && href.toLowerCase().indexOf('http') === 0 && !mydomain.test(href)) {
							recordOutboundLink(this, 'Outbound Links', href);
						}
					});
				}
			});
		</script>
<?php
		}
	$analytics = ob_get_clean();
	}
	echo apply_filters( 'aiosp_google_analytics', $analytics );
}

	function sitelinks_search_box() {
		$home_url = get_home_url();
		$search_box=<<<EOF
<script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "WebSite",
          "url": "{$home_url}/",
          "potentialAction": {
            "@type": "SearchAction",
            "target": "{$home_url}/?s={search_term}",
            "query-input": "required name=search_term"
          }
        }
</script>
EOF;
		return apply_filters( 'aiosp_sitelinks_search_box', $search_box );
	}
	
// Thank you, Yoast de Valk, for much of this code.	

	function aiosp_mrt_get_url( $query, $show_page = true ) {
		if ( $query->is_404 || $query->is_search )
			return false;
		
		$link = '';
		$haspost = count( $query->posts ) > 0;

		if ( get_query_var( 'm' ) ) {
			$m = preg_replace( '/[^0-9]/', '', get_query_var( 'm' ) );
			switch ( $this->strlen( $m ) ) {
				case 4: $link = get_year_link( $m ); break;
        		case 6: $link = get_month_link( $this->substr( $m, 0, 4), $this->substr($m, 4, 2 ) ); break;
        		case 8: $link = get_day_link( $this->substr( $m, 0, 4 ), $this->substr( $m, 4, 2 ), $this->substr( $m, 6, 2 ) ); break;
       			default:
       			return false;
			}
		} elseif ( ( $query->is_single || $query->is_page ) && $haspost ) {
			$post = $query->posts[0];
			$link = get_permalink( $post->ID );
		} elseif ( $query->is_author && $haspost ) {
			$author = get_userdata( get_query_var( 'author' ) );
     		if ($author === false) return false;
			$link = get_author_posts_url( $author->ID, $author->user_nicename );
  		} elseif ( $query->is_category && $haspost ) {
    		$link = get_category_link( get_query_var( 'cat' ) );
		} elseif ( $query->is_tag && $haspost ) {
			$tag = get_term_by( 'slug', get_query_var( 'tag' ), 'post_tag' );
       		if ( !empty( $tag->term_id ) )
				$link = get_tag_link( $tag->term_id );
  		} elseif ( $query->is_day && $haspost ) {
  			$link = get_day_link( get_query_var( 'year' ),
	                              get_query_var( 'monthnum' ),
	                              get_query_var( 'day' ) );
	    } elseif ( $query->is_month && $haspost ) {
	        $link = get_month_link( get_query_var( 'year' ),
	                               get_query_var( 'monthnum' ) );
	    } elseif ( $query->is_year && $haspost ) {
	        $link = get_year_link( get_query_var( 'year' ) );
	    } elseif ( $query->is_home ) {
	        if ( (get_option( 'show_on_front' ) == 'page' ) &&
	            ( $pageid = get_option( 'page_for_posts' ) ) ) {
	            $link = get_permalink( $pageid );
	        } else {
				if ( function_exists( 'icl_get_home_url' ) ) {
					$link = icl_get_home_url();
				} else {
					$link = trailingslashit( home_url() );
				}
			}
		} elseif ( $query->is_tax && $haspost ) {
			$taxonomy = get_query_var( 'taxonomy' );
			$term = get_query_var( 'term' );
			if ( !empty( $term ) )
				$link = get_term_link( $term, $taxonomy );
        } elseif ( $query->is_archive && function_exists( 'get_post_type_archive_link' ) && ( $post_type = get_query_var( 'post_type' ) ) ) {
			if ( is_array( $post_type ) )
				$post_type = reset( $post_type );
			$link = get_post_type_archive_link( $post_type );		
	    } else {
	        return false;
	    }
		if ( empty( $link ) || !is_string( $link ) ) return false;
		if ( apply_filters( 'aioseop_canonical_url_pagination', $show_page ) )
			$link = $this->get_paged( $link );
		if ( !empty( $link ) ) {
			global $aioseop_options;
			if ( !empty( $aioseop_options['aiosp_can_set_protocol'] ) && ( $aioseop_options['aiosp_can_set_protocol'] != 'auto' ) ) {
				if ( $aioseop_options['aiosp_can_set_protocol'] == 'http' ) {
					$link = preg_replace("/^https:/i", "http:", $link );
				} elseif ( $aioseop_options['aiosp_can_set_protocol'] == 'https' ) {
					$link = preg_replace("/^http:/i", "https:", $link );
				}
			}
		}
		return $link;
	}
	
	function get_page_number() {
		$page = get_query_var( 'page' );
		if ( empty( $page ) )
			$page = get_query_var( 'paged' );
		return $page;
	}

	function get_paged( $link ) {
		global $wp_rewrite;
		$page = $this->get_page_number();
		$page_name = 'page';
		if ( !empty( $wp_rewrite ) && !empty( $wp_rewrite->pagination_base ) ) $page_name = $wp_rewrite->pagination_base;
        if ( !empty( $page ) && $page > 1 ) {
			if ( get_query_var( 'page' ) == $page )
				$link = trailingslashit( $link ) . "$page";
			else
				$link = trailingslashit( $link ) . trailingslashit( $page_name ) . $page;
			$link = user_trailingslashit( $link, 'paged' );
		}
		return $link;
	}

	function show_page_description() {
		global $aioseop_options;
		if ( !empty( $aioseop_options['aiosp_hide_paginated_descriptions'] ) ) {
			$page = $this->get_page_number();
			if ( !empty( $page ) && ( $page > 1 ) )
				return false;			
		}
		return true;
	}

	function get_post_description( $post ) {
		global $aioseop_options;

		if ( !$this->show_page_description() )
			return '';
		
	    $description = trim( stripslashes( $this->internationalize( get_post_meta( $post->ID, "_aioseop_description", true ) ) ) );
		if ( !$description ) {
			if ( empty( $aioseop_options["aiosp_skip_excerpt"] ) )
				$description = $this->trim_excerpt_without_filters_full_length( $this->internationalize( $post->post_excerpt ) );
			if ( !$description && $aioseop_options["aiosp_generate_descriptions"] ) {
				$content = $post->post_content;
				if ( !empty( $aioseop_options["aiosp_run_shortcodes"] ) ) $content = do_shortcode( $content );
				$content = wp_strip_all_tags( $content );
				$description = $this->trim_excerpt_without_filters( $this->internationalize( $content ) );
			}
		}
		
		// "internal whitespace trim"
		$description = preg_replace( "/\s\s+/u", " ", $description );
		return $description;
	}
	
	function get_blog_page( $p = null ) {
		static $blog_page = '';
		static $page_for_posts = '';
		if ( $p === null ) {
			global $post;
		} else {
			$post = $p;
		}
		if ( $blog_page === '' ) {
			if ( $page_for_posts === '' ) $page_for_posts = get_option( 'page_for_posts' );
			if ( $page_for_posts && is_home() && ( !is_object( $post ) || ( $page_for_posts != $post->ID ) ) )
				$blog_page = get_post( $page_for_posts );			
		}
		return $blog_page;
	}

	function get_aioseop_description( $post = null ) {
		global $aioseop_options;
		if ( $post === null )
			$post = $GLOBALS["post"];
		$blog_page = $this->get_blog_page();
		if ( $this->is_static_front_page() )
			$description = trim( stripslashes( $this->internationalize( $aioseop_options['aiosp_home_description'] ) ) );
		elseif ( !empty( $blog_page ) )
			$description = $this->get_post_description( $blog_page );
		if ( empty( $description ) && is_object( $post ) && !is_archive() && empty( $blog_page ) )
			$description = $this->get_post_description( $post );
		$description = $this->apply_cf_fields( $description );	
		return $description;
	}
	
	function replace_title( $content, $title ) {
		$title = trim( strip_tags( $title ) );
		$title_tag_start = "<title";
		$title_tag_end = "</title";
		$title = stripslashes( trim( $title ) );
		$start = $this->strpos( $content, $title_tag_start );
		$end = $this->strpos( $content, $title_tag_end );

		$this->title_start = $start;
		$this->title_end = $end;
		$this->orig_title = $title;
		
		return preg_replace( '/<title([^>]*?)\s*>([^<]*?)<\/title\s*>/is', '<title\\1>' . preg_replace('/(\$|\\\\)(?=\d)/', '\\\\\1', strip_tags( $title ) ) . '</title>', $content, 1 );
	}
	
	function internationalize( $in ) {
		if ( function_exists( 'langswitch_filter_langs_with_message' ) )
			$in = langswitch_filter_langs_with_message( $in );

		if ( function_exists( 'polyglot_filter' ) )
			$in = polyglot_filter( $in );

		if ( function_exists( 'qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage' ) )
			$in = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage( $in );

		return apply_filters( 'localization', $in );
	}

	/** @return The original title as delivered by WP (well, in most cases) */
	function get_original_title( $sep = '', $echo = false, $seplocation = '' ) {
		global $aioseop_options;
		if ( !empty( $aioseop_options['aiosp_use_original_title'] ) ) {
			$has_filter = has_filter( 'wp_title', Array( $this, 'wp_title' ) );
			if ( $has_filter !== false )
				remove_filter( 'wp_title', Array( $this, 'wp_title' ), $has_filter );
			$title = wp_title( $sep, $echo, $seplocation );
			if ( $has_filter !== false )
				add_filter( 'wp_title', Array( $this, 'wp_title' ), $has_filter );
			if ( $title && ( $title = trim( $title ) ) )
				return trim( $title );
		}
		
		// the_search_query() is not suitable, it cannot just return
		global $s;
		
		$title = null;
		
		if ( is_home() ) {
			$title = get_option( 'blogname' );
		} else if ( is_single() ) {
			$title = $this->internationalize( single_post_title( '', false ) );
		} else if ( is_search() && isset($s) && !empty($s) ) {
			$search = esc_attr( stripslashes($s) );
			if ( !empty( $aioseop_options['aiosp_cap_titles'] ) )
				$search = $this->capitalize( $search );
			$title = $search;
		} else if ( ( is_tax() || is_category() ) && !is_feed() ) {
			$category_name = $this->ucwords($this->internationalize( single_cat_title( '', false ) ) );
			$title = $category_name;
		} else if ( is_page() ) {
			$title = $this->internationalize( single_post_title( '', false ) );
		} else if ( is_tag() ) {
			global $utw;
			if ( $utw ) {
				$tags = $utw->GetCurrentTagSet();
				$tag = $tags[0]->tag;
		        $tag = str_replace('-', ' ', $tag);
			} else {
				// wordpress > 2.3
				$tag = $this->internationalize( single_term_title( '', false ) );
			}
			if ( $tag ) $title = $tag;
		} else if ( is_author() ) {
			$author = get_userdata( get_query_var( 'author' ) );
			if ( $author === false ) {
				global $wp_query;
				$author = $wp_query->get_queried_object();
			}
			if ($author !== false)
				$title = $author->display_name;
		} else if ( is_day() ) {
			$title = get_the_date();
		} else if ( is_month() ) {
			$title = get_the_date( 'F, Y' );
		} else if ( is_year() ) {
			$title = get_the_date( 'Y' );
		} else if ( is_archive() ) {
			$title = $this->internationalize( post_type_archive_title( '', false) );
		} else if ( is_404() ) {
		    $title_format = $aioseop_options['aiosp_404_title_format'];
		    $new_title = str_replace( '%blog_title%', $this->internationalize( get_bloginfo( 'name' ) ), $title_format );
		    if ( strpos( $new_title, '%blog_description%' ) !== false ) $new_title = str_replace( '%blog_description%', $this->internationalize( get_bloginfo( 'description' ) ), $new_title );
		    if ( strpos( $new_title, '%request_url%'	  ) !== false ) $new_title = str_replace( '%request_url%', $_SERVER['REQUEST_URI'], $new_title);
		    if ( strpos( $new_title, '%request_words%'	  ) !== false ) $new_title = str_replace( '%request_words%', $this->request_as_words( $_SERVER['REQUEST_URI'] ), $new_title );
			$title = $new_title;
		}
		return trim( $title );
	}
	
	function paged_title( $title ) {
		// the page number if paged
		global $paged;
		global $aioseop_options;
		// simple tagging support
		global $STagging;
		$page = get_query_var( 'page' );
		if ( $paged > $page ) $page = $paged;
		if ( is_paged() || ( isset($STagging) && $STagging->is_tag_view() && $paged ) || ( $page > 1 ) ) {
			$part = $this->internationalize( $aioseop_options['aiosp_paged_format'] );
			if ( isset( $part ) || !empty( $part ) ) {
				$part = " " . trim( $part );
				$part = str_replace( '%page%', $page, $part );
				$this->log( "paged_title() [$title] [$part]" );
				$title .= $part;
			}
		}
		return $title;
	}
	
	function get_tax_title_format( $tax = '' ) {
		global $aioseop_options;
		$title_format = '%category_title% | %blog_title%';
		if ( !empty( $aioseop_options['aiosp_category_title_format'] ) )
			$title_format = $aioseop_options['aiosp_category_title_format'];
		return $title_format;
	}
	
	function apply_tax_title_format( $category_name, $category_description, $tax = '' ) {
		if ( empty( $tax ) ) $tax = get_query_var( 'taxonomy' );
        $title_format = $this->get_tax_title_format( $tax );
        $title = str_replace( '%taxonomy_title%', $category_name, $title_format );
        if ( strpos( $title, '%taxonomy_description%' ) !== false ) $title = str_replace( '%taxonomy_description%', $category_description, $title );
        if ( strpos( $title, '%category_title%'		  ) !== false ) $title = str_replace( '%category_title%', $category_name, $title );
        if ( strpos( $title, '%category_description%' ) !== false ) $title = str_replace( '%category_description%', $category_description, $title );
        if ( strpos( $title, '%blog_title%'			  ) !== false ) $title = str_replace( '%blog_title%', $this->internationalize( get_bloginfo( 'name' ) ), $title );
        if ( strpos( $title, '%blog_description%'	  ) !== false ) $title = str_replace( '%blog_description%', $this->internationalize( get_bloginfo( 'description' ) ), $title );
		$title = trim( wp_strip_all_tags( $title ) );
		$title = str_replace( Array( '"', "\r\n", "\n" ), Array( '&quot;', ' ', ' ' ), $title );
        return $this->paged_title( $title );
	}
	
	function get_tax_name( $tax ) {
		$name = '';
		if ( empty( $name ) ) $name = single_term_title( '', false );
		if ( ( $tax == 'category' ) && ( !empty( $aioseop_options['aiosp_cap_cats'] ) ) )
				$name = $this->ucwords( $name );
		return $this->internationalize( $name );
	}
	
	function get_tax_desc( $tax ) {
		$desc = '';
		if ( empty( $desc ) ) $desc = term_description( '', $tax );
		return $this->internationalize( $desc );
	}
	
	function get_tax_title( $tax = '' ) {
		if ( empty( $tax ) )
			if ( is_category() )
				$tax = 'category';
			else
				$tax = get_query_var( 'taxonomy' );
		$name = $this->get_tax_name( $tax );
		$desc = $this->get_tax_desc( $tax );
		return $this->apply_tax_title_format( $name, $desc, $tax );
	}
	
	function get_post_title_format( $title_type = 'post' ) {
		global $aioseop_options;
		if ( ( $title_type != 'post' ) && ( $title_type != 'archive' ) ) return false;
		$title_format = "%{$title_type}_title% | %blog_title%";
		if ( isset( $aioseop_options["aiosp_{$title_type}_title_format"] ) )
			$title_format = $aioseop_options["aiosp_{$title_type}_title_format"];
		if( !empty( $aioseop_options['aiosp_enablecpost'] ) && !empty( $aioseop_options['aiosp_cpostadvanced'] ) && !empty( $aioseop_options['aiosp_cpostactive'] ) ) {
			$wp_post_types = $aioseop_options['aiosp_cpostactive'];
			if ( !empty( $aioseop_options["aiosp_cposttitles"] ) ) {
				if ( ( ( $title_type == 'archive' ) && is_post_type_archive( $wp_post_types ) && $prefix = "aiosp_{$title_type}_" ) ||
				     ( ( $title_type == 'post' ) && is_singular( $wp_post_types ) && $prefix = "aiosp_" ) ) {
						$post_type = get_post_type();
						if ( !empty( $aioseop_options["{$prefix}{$post_type}_title_format"] ) )
							$title_format = $aioseop_options["{$prefix}{$post_type}_title_format"];					
				}
			}
		}
		return $title_format;
	}
	
	function get_archive_title_format() {
		return $this->get_post_title_format( "archive" );
	}
	
	function apply_archive_title_format( $title, $category = '' ) {
		$title_format = $this->get_archive_title_format();
		$r_title = array( '%blog_title%', '%blog_description%', '%archive_title%' );
		$d_title = array( $this->internationalize( get_bloginfo('name') ), $this->internationalize( get_bloginfo( 'description' ) ), post_type_archive_title( '', false ) );
		$title = trim( str_replace( $r_title, $d_title, $title_format ) );
		return $title;
	}
	
	function apply_post_title_format( $title, $category = '', $p = null ) {
		if ( $p === null ) {
			global $post;			
		} else {
			$post = $p;
		}
		$title_format = $this->get_post_title_format();
		if ( !empty( $post ) )
			$authordata = get_userdata( $post->post_author );
		else
			$authordata = new WP_User();
		$r_title = array( '%blog_title%', '%blog_description%', '%post_title%', '%category%', '%category_title%', '%post_author_login%', '%post_author_nicename%', '%post_author_firstname%', '%post_author_lastname%' );
		$d_title = array( $this->internationalize( get_bloginfo('name') ), $this->internationalize( get_bloginfo( 'description' ) ), $title, $category, $category, $authordata->user_login, $authordata->user_nicename, $this->ucwords( $authordata->first_name ), $this->ucwords( $authordata->last_name ) );
		$title = trim( str_replace( $r_title, $d_title, $title_format ) );
		return $title;
	}
	
	function apply_page_title_format( $title, $p = null ) {
		global $aioseop_options;
		if ( $p === null ) {
			global $post;			
		} else {
			$post = $p;
		}
		$title_format = $aioseop_options['aiosp_page_title_format'];
		if ( !empty( $post ) )
			$authordata = get_userdata( $post->post_author );
		else
			$authordata = new WP_User();
        $new_title = str_replace( '%blog_title%', $this->internationalize( get_bloginfo( 'name' ) ), $title_format );
        if ( strpos( $new_title, '%blog_description%'	   ) !== false ) $new_title = str_replace( '%blog_description%', $this->internationalize( get_bloginfo( 'description' ) ), $new_title );
        if ( strpos( $new_title, '%page_title%'			   ) !== false ) $new_title = str_replace( '%page_title%', $title, $new_title );
        if ( strpos( $new_title, '%page_author_login%'	   ) !== false ) $new_title = str_replace( '%page_author_login%', $authordata->user_login, $new_title );
        if ( strpos( $new_title, '%page_author_nicename%'  ) !== false ) $new_title = str_replace( '%page_author_nicename%', $authordata->user_nicename, $new_title );
        if ( strpos( $new_title, '%page_author_firstname%' ) !== false ) $new_title = str_replace( '%page_author_firstname%', $this->ucwords($authordata->first_name ), $new_title );
        if ( strpos( $new_title, '%page_author_lastname%'  ) !== false ) $new_title = str_replace( '%page_author_lastname%', $this->ucwords($authordata->last_name ), $new_title );
		$title = trim( $new_title );
		return $title;
	}

	/*** Gets the title that will be used by AIOSEOP for title rewrites or returns false. ***/
	function get_aioseop_title( $post ) {
		global $aioseop_options;
		// the_search_query() is not suitable, it cannot just return
		global $s, $STagging;
		$opts = $this->meta_opts;
		if ( is_front_page() ) {
			$title = $this->internationalize( $aioseop_options['aiosp_home_title'] );
			if (empty( $title ) )
				$title = $this->internationalize( get_option( 'blogname' ) ) . ' | ' . $this->internationalize( get_bloginfo( 'description' ) );
			return $this->paged_title( $title );
		} else if ( is_attachment() ) {
			if ( $post === null ) return false;
			$title = get_post_meta( $post->ID, "_aioseop_title", true );
			if ( empty( $title ) ) $title = $post->post_title;
			if ( empty( $title ) ) $title = $this->get_original_title( '', false );
			if ( empty( $title ) ) $title = get_the_title( $post->post_parent );
			$title = apply_filters( 'aioseop_attachment_title', $this->internationalize( $this->apply_post_title_format( $title, '', $post ) ) );
			return $title;
		} else if ( is_page() || $this->is_static_posts_page() || ( is_home() && !$this->is_static_posts_page() ) ) {
			if ( $post === null ) return false;
			if ( ( $this->is_static_front_page() ) && ( $home_title = $this->internationalize( $aioseop_options['aiosp_home_title'] ) ) ) {
				//home title filter
				return apply_filters( 'aioseop_home_page_title', $home_title );
			} else {
				$page_for_posts = '';
				if ( is_home() )
					$page_for_posts = get_option( 'page_for_posts' );
				if ( $page_for_posts ) {
					$title = $this->internationalize( get_post_meta( $page_for_posts, "_aioseop_title", true ) );
					if ( !$title ) {
						$post_page = get_post( $page_for_posts );
						$title = $this->internationalize( $post_page->post_title );						
					}
				} else {
					$title = $this->internationalize( get_post_meta( $post->ID, "_aioseop_title", true ) );
					if ( !$title )
						$title = $this->internationalize( $post->post_title );
				}
				if ( !$title )
					$title = $this->internationalize( $this->get_original_title( '', false ) );

				$title = $this->apply_page_title_format( $title, $post );
                $title = $this->paged_title( $title );
				$title = apply_filters( 'aioseop_title_page', $title );
				if ( $this->is_static_posts_page() )
					$title = apply_filters( 'single_post_title', $title );
				return $title;
			}
		} else if ( function_exists( 'woocommerce_get_page_id' ) && is_post_type_archive( 'product' ) && ( $post_id = woocommerce_get_page_id( 'shop' ) ) && ( $post = get_post( $post_id ) ) ) {
			$title = $this->internationalize( get_post_meta( $post->ID, "_aioseop_title", true ) );
			if ( !$title ) $title = $this->internationalize( $post->post_title );
			if ( !$title ) $title = $this->internationalize( $this->get_original_title( '', false ) );
			$title = $this->apply_page_title_format( $title, $post );
            $title = $this->paged_title( $title );
			$title = apply_filters( 'aioseop_title_page', $title );
			return $title;
		} else if ( is_single() ) {
			// we're not in the loop :(
			if ( $post === null ) return false;
			$categories = get_the_category();
			$category = '';
			if ( count( $categories ) > 0 ) {
				$category = $categories[0]->cat_name;
			}
			$title = $this->internationalize( get_post_meta( $post->ID, "_aioseop_title", true ) );
			if ( !$title ) {
				$title = $this->internationalize( get_post_meta( $post->ID, "title_tag", true ) );
				if ( !$title ) $title = $this->internationalize($this->get_original_title( '', false ) );
			}
			if ( empty( $title ) ) $title = $post->post_title;
			if ( !empty( $title ) )
				$title = $this->apply_post_title_format( $title, $category, $post );
			$title = $this->paged_title( $title );
			return apply_filters( 'aioseop_title_single', $title );
		} else if ( is_search() && isset( $s ) && !empty( $s ) ) {
			$search = esc_attr( stripslashes( $s ) );
			if ( !empty( $aioseop_options['aiosp_cap_titles'] ) )
				$search = $this->capitalize( $search );
            $title_format = $aioseop_options['aiosp_search_title_format'];
            $title = str_replace( '%blog_title%', $this->internationalize( get_bloginfo( 'name' ) ), $title_format );
            if ( strpos( $title, '%blog_description%' ) !== false ) $title = str_replace( '%blog_description%', $this->internationalize( get_bloginfo( 'description' ) ), $title );
            if ( strpos( $title, '%search%'			  ) !== false ) $title = str_replace( '%search%', $search, $title );
			$title = $this->paged_title( $title );
			return $title;
		} else if ( is_tag() ) {
			global $utw;
			$tag = $tag_description = '';
			if ( $utw ) {
				$tags = $utw->GetCurrentTagSet();
				$tag = $tags[0]->tag;
	            $tag = str_replace('-', ' ', $tag);
			} else {
				if ( empty( $tag ) ) $tag = $this->get_original_title( '', false );
				if ( empty( $tag_description ) ) $tag_description = tag_description();
				$tag = $this->internationalize( $tag );
				$tag_description = $this->internationalize( $tag_description );
			}
			if ( $tag ) {
				if ( !empty( $aioseop_options['aiosp_cap_titles'] ) )
					$tag = $this->capitalize( $tag );
	            $title_format = $aioseop_options['aiosp_tag_title_format'];
	            $title = str_replace( '%blog_title%', $this->internationalize( get_bloginfo('name') ), $title_format );
	            if ( strpos( $title, '%blog_description%' ) !== false ) $title = str_replace( '%blog_description%', $this->internationalize( get_bloginfo( 'description') ), $title );
	            if ( strpos( $title, '%tag%'			  ) !== false ) $title = str_replace( '%tag%', $tag, $title );
		        if ( strpos( $title, '%tag_description%' ) !== false ) $title = str_replace( '%tag_description%', $tag_description, $title );
		        if ( strpos( $title, '%taxonomy_description%' ) !== false ) $title = str_replace( '%taxonomy_description%', $tag_description, $title );
				$title = trim( wp_strip_all_tags( $title ) );
				$title = str_replace( Array( '"', "\r\n", "\n" ), Array( '&quot;', ' ', ' ' ), $title );
	            $title = $this->paged_title( $title );
				return $title;
			}
		} else if ( ( is_tax() || is_category() ) && !is_feed() ) {
			return $this->get_tax_title();
		} else if ( isset( $STagging ) && $STagging->is_tag_view() ) { // simple tagging support
			$tag = $STagging->search_tag;
			if ( $tag ) {
				if ( !empty( $aioseop_options['aiosp_cap_titles'] ) )
					$tag = $this->capitalize($tag);
	            $title_format = $aioseop_options['aiosp_tag_title_format'];
	            $title = str_replace( '%blog_title%', $this->internationalize( get_bloginfo( 'name') ), $title_format);
	            if ( strpos( $title, '%blog_description%' ) !== false ) $title = str_replace( '%blog_description%', $this->internationalize( get_bloginfo( 'description') ), $title);
	            if ( strpos( $title, '%tag%'			  ) !== false ) $title = str_replace( '%tag%', $tag, $title );
	            $title = $this->paged_title( $title );
				return $title;
			}
		} else if ( is_archive() || is_post_type_archive() ) {
			if ( is_author() ) {
				$author = $this->internationalize( $this->get_original_title( '', false ) );
	            $title_format = $aioseop_options['aiosp_author_title_format'];
	            $new_title = str_replace( '%author%', $author, $title_format );
			} else if ( is_date() ) {
				global $wp_query;
				$date = $this->internationalize( $this->get_original_title( '', false ) );
	            $title_format = $aioseop_options['aiosp_date_title_format'];
	            $new_title = str_replace( '%date%', $date, $title_format );
				$day = get_query_var( 'day' );
				if ( empty( $day ) ) $day = '';
				$new_title = str_replace( '%day%', $day, $new_title );
				$monthnum = get_query_var( 'monthnum' );
				$year = get_query_var( 'year' );
				if ( empty( $monthnum ) || is_year() ) {
					$month = '';
					$monthnum = 0;
				}
				$month = date( "F", mktime( 0,0,0,(int)$monthnum,1,(int)$year ) );
				$new_title = str_replace( '%monthnum%', $monthnum, $new_title );
				if ( strpos( $new_title, '%month%' ) !== false ) $new_title = str_replace( '%month%', $month, $new_title );
	            if ( strpos( $new_title, '%year%' ) !== false ) $new_title = str_replace( '%year%', get_query_var( 'year' ), $new_title );
			} else if ( is_post_type_archive() ) {
				if ( empty( $title ) ) $title = $this->get_original_title( '', false );
				$new_title = apply_filters( 'aioseop_archive_title', $this->apply_archive_title_format( $title ) );
			} else return false;
			$new_title = str_replace( '%blog_title%', $this->internationalize( get_bloginfo( 'name' ) ), $new_title );
            if ( strpos( $new_title, '%blog_description%' ) !== false ) $new_title = str_replace( '%blog_description%', $this->internationalize( get_bloginfo( 'description' ) ), $new_title );
			$title = trim( $new_title );
            $title = $this->paged_title( $title );
			return $title;
		} else if ( is_404() ) {
            $title_format = $aioseop_options['aiosp_404_title_format'];
            $new_title = str_replace( '%blog_title%', $this->internationalize( get_bloginfo( 'name') ), $title_format );
            if ( strpos( $new_title, '%blog_description%' ) !== false ) $new_title = str_replace( '%blog_description%', $this->internationalize( get_bloginfo( 'description' ) ), $new_title );
            if ( strpos( $new_title, '%request_url%' ) !== false	  ) $new_title = str_replace( '%request_url%', $_SERVER['REQUEST_URI'], $new_title );
            if ( strpos( $new_title, '%request_words%' ) !== false	  ) $new_title = str_replace( '%request_words%', $this->request_as_words( $_SERVER['REQUEST_URI'] ), $new_title );
			if ( strpos( $new_title, '%404_title%' ) !== false		  ) $new_title = str_replace( '%404_title%', $this->internationalize( $this->get_original_title( '', false ) ), $new_title );
			return $new_title;
		}
		return false;
	}
	
	/*** Used to filter wp_title(), get our title. ***/
	function wp_title() {
		global $aioseop_options;
		$title = false;
		$post = $this->get_queried_object();
		if ( !empty( $aioseop_options['aiosp_rewrite_titles'] ) ) {
			$title = $this->get_aioseop_title( $post );
			$title = $this->apply_cf_fields( $title );
		}
		
		if ( $title === false )
			$title = $this->get_original_title();
		return apply_filters( 'aioseop_title', $title );
	}

	/*** Used for forcing title rewrites. ***/
	function rewrite_title($header) {
		global $wp_query;
		if (!$wp_query) {
			$header .= "<!-- no wp_query found! -->\n";
			return $header;	
		}
		$title = $this->wp_title();
		if ( !empty( $title ) )
			$header = $this->replace_title( $header, $title );
		return $header;
	}
	
	/**
	 * @return User-readable nice words for a given request.
	 */
	function request_as_words( $request ) {
		$request = htmlspecialchars( $request );
		$request = str_replace( '.html', ' ', $request );
		$request = str_replace( '.htm', ' ', $request );
		$request = str_replace( '.', ' ', $request );
		$request = str_replace( '/', ' ', $request );
		$request = str_replace( '-', ' ', $request );
		$request_a = explode( ' ', $request );
		$request_new = array();
		foreach ( $request_a as $token ) {
			$request_new[] = $this->ucwords( trim( $token ) );
		}
		$request = implode( ' ', $request_new );
		return $request;
	}
	
	function capitalize( $s ) {
		$s = trim( $s );
		$tokens = explode( ' ', $s );
		while ( list( $key, $val ) = each( $tokens ) ) {
			$tokens[ $key ] = trim( $tokens[ $key ] );
			$tokens[ $key ] = $this->strtoupper( $this->substr( $tokens[$key], 0, 1 ) ) . $this->substr( $tokens[$key], 1 );
		}
		$s = implode( ' ', $tokens );
		return $s;
	}
	
	function trim_excerpt_without_filters( $text, $max = 0 ) {
		$text = str_replace( ']]>', ']]&gt;', $text );
                $text = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $text );
		$text = wp_strip_all_tags( $text );
		if ( !$max ) $max = $this->maximum_description_length;
		$len = $this->strlen( $text );
		if ( $max < $len ) {
			if ( function_exists( 'mb_strrpos' ) ) {
				$pos = mb_strrpos( $text, ' ', -($len - $max) );
				if ( $pos === false ) $pos = $max;
				if ( $pos > $this->minimum_description_length ) {
					$max = $pos;
				} else {
					$max = $this->minimum_description_length;
				}
			} else {
				while( $text[$max] != ' ' && $max > $this->minimum_description_length ) {
					$max--;
				}				
			}
		}
		$text = $this->substr( $text, 0, $max );
		return trim( stripslashes( $text ) );
	}
	
	function trim_excerpt_without_filters_full_length( $text ) {
		$text = str_replace( ']]>', ']]&gt;', $text );
                $text = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $text );
		$text = wp_strip_all_tags( $text );
		return trim( stripslashes( $text ) );
	}
	
	function keyword_string_to_list( $keywords ) {
		$traverse = Array();
		$keywords_i = str_replace( '"', '', $keywords );
        if (isset( $keywords_i ) && !empty( $keywords_i ) ) {
        	$traverse = explode( ',', $keywords_i );
        }
		return $traverse;
	}
	
	function get_all_categories( $id = 0 ) {
		$keywords = Array();
		$categories = get_the_category( $id ); 
        foreach ( $categories as $category )
        	$keywords[] = $this->internationalize( $category->cat_name );
        return $keywords;
	}
	
	function get_all_tags( $id = 0 ) {
		$keywords = Array();
		$tags = get_the_tags( $id );
        if ( $tags && is_array( $tags) )
            foreach ( $tags as $tag )
            	$keywords[] = $this->internationalize( $tag->name );
		// Ultimate Tag Warrior integration
        global $utw;
        if ( $utw ) {
        	$tags = $utw->GetTagsForPost( $p );
        	if ( is_array( $tags ) )
            	foreach ( $tags as $tag ) {
					$tag = $tag->tag;
					$tag = str_replace( '_', ' ', $tag );
					$tag = str_replace( '-', ' ', $tag );
					$tag = stripslashes( $tag );
            		$keywords[] = $tag;
            	}
        }
		return $keywords;
	}
	
	/**
	 * @return comma-separated list of unique keywords
	 */
	function get_all_keywords() {
		global $posts;
		global $aioseop_options;
		if ( is_404() ) return null;
		// if we are on synthetic pages
		if ( !is_home() && !is_page() && !is_single() && !$this->is_static_front_page() && !$this->is_static_posts_page() && !is_archive() && !is_post_type_archive() )
			return null;
	    $keywords = array();
		$opts = $this->meta_opts;
		if ( !empty( $opts["aiosp_keywords"] ) ) {
			$traverse = $this->keyword_string_to_list( $opts["aiosp_keywords"] );
			if ( !empty( $traverse ) )
				foreach ( $traverse as $keyword ) $keywords[] = $keyword;
		}
		if ( empty( $posts ) ) {
			global $post;
			$post_arr = Array( $post );
		} else {
			$post_arr = $posts;
		}
	    if ( is_array( $post_arr ) ) {
			$postcount = count( $post_arr );
	        foreach ( $post_arr as $p ) {
	            if ( $p ) {
					$id = $p->ID;
					if ( $postcount == 1 || !empty( $aioseop_options['aiosp_dynamic_postspage_keywords'] ) ) {
		                // custom field keywords
		                $keywords_i = null;           
		                $keywords_i = stripslashes( $this->internationalize( get_post_meta( $id, "_aioseop_keywords", true ) ) );
						if ( is_attachment() ) {
							$id = $p->post_parent;
							if ( empty( $keywords_i ) )
								$keywords_i = stripslashes( $this->internationalize( get_post_meta( $id, "_aioseop_keywords", true ) ) );
						}
						$traverse = $this->keyword_string_to_list( $keywords_i );
						if ( !empty( $traverse ) )
							foreach ( $traverse as $keyword ) $keywords[] = $keyword;						
					}
					
					if ( !empty( $aioseop_options['aiosp_use_tags_as_keywords'] ) ) {
						$keywords = array_merge( $keywords, $this->get_all_tags( $id ) );
					}
	                // autometa
					$autometa = stripslashes( get_post_meta( $id, 'autometa', true ) );
	                if ( isset( $autometa ) && !empty( $autometa ) ) {
	                	$autometa_array = explode( ' ', $autometa );
	                	foreach ( $autometa_array as $e )
	                		$keywords[] = $e;
	                }
					
	            	if ( $aioseop_options['aiosp_use_categories'] && !is_page() ) {
						$keywords = array_merge( $keywords, $this->get_all_categories( $id ) );
	            	}
	            }
	        }
	    }
	    return $this->get_unique_keywords( $keywords );
	}
	
	function clean_keyword_list( $keywords ) {
		$small_keywords = array();
		if ( !is_array( $keywords ) ) $keywords = $this->keyword_string_to_list( $keywords );
		if ( !empty( $keywords ) )
			foreach ( $keywords as $word ) {
				$small_keywords[] = trim( $this->strtolower( $word ) );
			}
		return array_unique( $small_keywords );
	}
	
	function get_unique_keywords($keywords) {
		return implode( ',', $this->clean_keyword_list( $keywords ) );
	}
	
	function log( $message ) {
		if ( $this->do_log ) {
			@error_log( date( 'Y-m-d H:i:s' ) . " " . $message . "\n", 3, $this->log_file );
		}
	}

	function save_post_data( $id ) {
		$awmp_edit = $nonce = null;
		if ( empty( $_POST ) ) return false;
		if ( isset( $_POST[ 'aiosp_edit' ] ) )				$awmp_edit = $_POST['aiosp_edit'];
		if ( isset( $_POST[ 'nonce-aioseop-edit' ] ) )		$nonce     = $_POST['nonce-aioseop-edit'];

	    if ( isset($awmp_edit) && !empty($awmp_edit) && wp_verify_nonce($nonce, 'edit-aioseop-nonce') ) {
		
			$optlist = Array( 'keywords', 'description', 'title', 'custom_link', 'sitemap_exclude', 'disable', 'disable_analytics', 'noindex', 'nofollow', 'noodp', 'noydir', 'titleatr', 'menulabel' );
			if ( !( !empty( $this->options['aiosp_can'] ) ) && ( !empty( $this->options['aiosp_customize_canonical_links'] ) ) ) {
				unset( $optlist["custom_link"] );
			}
		    foreach ( $optlist as $f ) {
				$field = "aiosp_$f";
				if ( isset( $_POST[$field] ) ) $$field = $_POST[$field];
		    }
			
			$optlist = Array( 'keywords', 'description', 'title', 'custom_link', 'noindex', 'nofollow', 'noodp', 'noydir', 'titleatr', 'menulabel' );
			if ( !( !empty( $this->options['aiosp_can'] ) ) && ( !empty( $this->options['aiosp_customize_canonical_links'] ) ) ) {
				unset( $optlist["custom_link"] );
			}
			foreach ( $optlist as $f )
				delete_post_meta( $id, "_aioseop_{$f}" );
			
		    if ( $this->is_admin() ) {
		    	delete_post_meta($id, '_aioseop_sitemap_exclude' );
		    	delete_post_meta($id, '_aioseop_disable' );
		    	delete_post_meta($id, '_aioseop_disable_analytics' );
			}
		
			foreach ( $optlist as $f ) {
				$var = "aiosp_$f";
				$field = "_aioseop_$f";
				if ( isset( $$var ) && !empty( $$var ) )
				    add_post_meta( $id, $field, $$var );
		    }
		    if (isset( $aiosp_sitemap_exclude ) && !empty( $aiosp_sitemap_exclude ) && $this->is_admin() )
			    add_post_meta( $id, '_aioseop_sitemap_exclude', $aiosp_sitemap_exclude );
		    if (isset( $aiosp_disable ) && !empty( $aiosp_disable ) && $this->is_admin() ) {
			    add_post_meta( $id, '_aioseop_disable', $aiosp_disable );
			    if (isset( $aiosp_disable_analytics ) && !empty( $aiosp_disable_analytics ) )
				    add_post_meta( $id, '_aioseop_disable_analytics', $aiosp_disable_analytics );
			}
	    }
	}

	function display_tabbed_metabox( $post, $metabox ) {
		$tabs = $metabox['args'];
		echo '<div class="aioseop_tabs">';
		$header = $this->get_metabox_header( $tabs );
		echo $header;
		$active = "";
		foreach( $tabs as $m ) {
			echo '<div id="'.$m['id'].'" class="aioseop_tab"' . $active . '>';
			if ( !$active ) $active = ' style="display:none;"';
			$m['args'] = $m['callback_args'];
			$m['callback'][0]->{$m['callback'][1]}( $post, $m );
			echo '</div>';
		}
		echo '</div>';
	}
	
	function admin_bar_menu() {
		global $wp_admin_bar, $aioseop_admin_menu, $aioseop_options, $post;
		if ( !empty( $aioseop_options['aiosp_admin_bar'] ) ) {
			$menu_slug = plugin_basename( __FILE__ );
			
			$url = '';
            if ( function_exists( 'menu_page_url' ) )
                    $url = menu_page_url( $menu_slug, 0 );
            if ( empty( $url ) )
                    $url = esc_url( admin_url( 'admin.php?page=' . $menu_slug ) );
			
			$wp_admin_bar->add_menu( array( 'id' => AIOSEOP_PLUGIN_DIRNAME, 'title' => __( 'SEO', 'all_in_one_seo_pack' ), 'href' => $url ) );
			if ( current_user_can( 'update_plugins' ) )
				add_action( 'admin_bar_menu', array( $this, 'admin_bar_upgrade_menu' ), 1101 );
			$aioseop_admin_menu = 1;
			if ( !is_admin() && !empty( $post ) ) {
				$blog_page = $this->get_blog_page( $post );
				if ( !empty( $blog_page ) ) $post = $blog_page;
				$wp_admin_bar->add_menu( array( 'id' => 'aiosp_edit_' . $post->ID, 'parent' => AIOSEOP_PLUGIN_DIRNAME, 'title' => __( 'Edit SEO', 'all_in_one_seo_pack' ), 'href' => get_edit_post_link( $post->ID ) . '#aiosp' ) );				
			}
		}
	}
			
	function admin_bar_upgrade_menu() {
		global $wp_admin_bar;
		$wp_admin_bar->add_menu( array( 'parent' => AIOSEOP_PLUGIN_DIRNAME, 'title' => __( 'Upgrade To Pro', 'all_in_one_seo_pack' ), 'id' => 'aioseop-pro-upgrade', 'href' => 'http://semperplugins.com/plugins/all-in-one-seo-pack-pro-version/?loc=menu', 'meta' => Array( 'target' => '_blank' ) ) );
	}

	function menu_order() {
		return 5;
	}
	
	function admin_menu() {
		$file = plugin_basename( __FILE__ );
		$menu_name = __( 'All in One SEO', 'all_in_one_seo_pack' );

		$this->locations['aiosp']['default_options']['nonce-aioseop-edit']['default'] = wp_create_nonce('edit-aioseop-nonce');
		
		$custom_menu_order = false;
		global $aioseop_options;
		if ( !isset( $aioseop_options['custom_menu_order'] ) )
			$custom_menu_order = true;		

		$this->update_options( );
		
		$this->add_admin_pointers();
		if ( !empty( $this->pointers ) )
			foreach( $this->pointers as $k => $p )
				if ( !empty( $p["pointer_scope"] ) && ( $p["pointer_scope"] == 'global' ) )
					unset( $this->pointers[$k] );
		
		$donated = false;
		if ( ( isset( $_POST ) ) && ( isset( $_POST['module'] ) ) && ( isset( $_POST['nonce-aioseop'] ) ) && ( $_POST['module'] == 'All_in_One_SEO_Pack' ) && ( wp_verify_nonce( $_POST['nonce-aioseop'], 'aioseop-nonce' ) ) ) {
			if ( isset( $_POST["aiosp_donate"] ) )
				$donated = $_POST["aiosp_donate"];
			if ( isset($_POST["Submit"] ) ) {
				if ( isset( $_POST["aiosp_custom_menu_order"] ) )
					$custom_menu_order = $_POST["aiosp_custom_menu_order"];
				else
					$custom_menu_order = false;				
			} else if ( ( isset($_POST["Submit_Default"] ) ) || ( ( isset($_POST["Submit_All_Default"] ) ) ) ) {
				$custom_menu_order = true;				
			}
		} else {
			if ( isset( $this->options["aiosp_donate"] ) )
				$donated = $this->options["aiosp_donate"];
			if ( isset( $this->options["aiosp_custom_menu_order"] ) )
				$custom_menu_order = $this->options["aiosp_custom_menu_order"];
		}
		
		if ( $custom_menu_order ) {
			add_filter( 'custom_menu_order', '__return_true' );
			add_filter( 'menu_order', array( $this, 'set_menu_order' ) );
		}
		
		if ( $donated ) {
			// Thank you for your donation
			$this->pointers['aioseop_donate'] = Array( 'pointer_target' => '#aiosp_donate_wrapper',
														'pointer_text' => '<h3>' . __( 'Thank you!', 'all_in_one_seo_pack' ) 
														. '</h3><p>' . __( 'Thank you for your donation, it helps keep this plugin free and actively developed!', 'all_in_one_seo_pack' ) . '</p>'
												 );
		}
		
		if ( !empty( $this->pointers ) )
			foreach( $this->pointers as $k => $p )
				if ( !empty( $p["pointer_scope"] ) && ( $p["pointer_scope"] == 'global' ) )
					unset( $this->pointers[$k] );
		
		$this->filter_pointers();
		
		if ( !empty( $this->options['aiosp_enablecpost'] ) && $this->options['aiosp_enablecpost'] ) {
			if ( !empty( $this->options['aiosp_cpostadvanced'] ) ) {
				$this->locations['aiosp']['display'] = $this->options['aiosp_cpostactive'];
			} else {
				$this->locations['aiosp']['display'] = get_post_types( '', 'names' );
			}
		} else {
			$this->locations['aiosp']['display'] = Array( 'post', 'page' );
		}
		
		if ( $custom_menu_order )
			add_menu_page( $menu_name, $menu_name, 'manage_options', $file, Array( $this, 'display_settings_page' ) );
		else
			add_utility_page( $menu_name, $menu_name, 'manage_options', $file, Array( $this, 'display_settings_page' ) );
		
		add_meta_box('aioseop-list', __( "Join Our Mailing List", 'all_in_one_seo_pack' ), array( $this, 'display_extra_metaboxes'), 'aioseop_metaboxes', 'normal', 'core');
		add_meta_box('aioseop-about', "About <span style='float:right;'>Version <b>" . AIOSEOP_VERSION . "</b></span>", array( $this, 'display_extra_metaboxes'), 'aioseop_metaboxes', 'side', 'core');
		add_meta_box('aioseop-support', __( "Support", 'all_in_one_seo_pack' ) . " <span style='float:right;'>" . __( "Version", 'all_in_one_seo_pack' ) . " <b>" . AIOSEOP_VERSION . "</b></span>", array( $this, 'display_extra_metaboxes'), 'aioseop_metaboxes', 'side', 'core');
		
		add_action( 'aioseop_modules_add_menus', Array( $this, 'add_menu' ), 5 );
		do_action( 'aioseop_modules_add_menus', $file );

		$metaboxes = apply_filters( 'aioseop_add_post_metabox', Array() );

		if ( !empty( $metaboxes ) ) {
			if ( $this->tabbed_metaboxes ) {
				$tabs = Array();
				$tab_num = 0;
				foreach ( $metaboxes as $m ) {
					if ( !isset( $tabs[ $m['post_type'] ] ) ) $tabs[ $m['post_type'] ] = Array();
					$tabs[ $m['post_type'] ][] = $m;
				}
				
				if ( !empty( $tabs ) ) {
					foreach( $tabs as $p => $m ) {
						$tab_num = count( $m );
						$title = $m[0]['title'];
						if ( $title != $this->plugin_name ) $title = $this->plugin_name . ' - ' . $title;
						if ( $tab_num <= 1 ) {
							if ( !empty( $m[0]['callback_args']['help_link'] ) )
								$title .= "<a class='aioseop_help_text_link aioseop_meta_box_help' target='_blank' href='" . $m[0]['callback_args']['help_link'] . "'><span>" . __( 'Help', 'all_in_one_seo_pack' ) . "</span></a>";
							add_meta_box( $m[0]['id'], $title, $m[0]['callback'], $m[0]['post_type'], $m[0]['context'], $m[0]['priority'], $m[0]['callback_args'] );
						} elseif ( $tab_num > 1 ) {
							add_meta_box( $m[0]['id'] . '_tabbed', $title, Array( $this, 'display_tabbed_metabox' ), $m[0]['post_type'], $m[0]['context'], $m[0]['priority'], $m );
						}
					}
				}
			} else {
				foreach ( $metaboxes as $m ) {
					$title = $m['title'];
					if ( $title != $this->plugin_name ) $title = $this->plugin_name . ' - ' . $title;
					if ( !empty( $m['help_link'] ) )
						$title .= "<a class='aioseop_help_text_link aioseop_meta_box_help' target='_blank' href='" . $m['help_link'] . "'><span>" . __( 'Help', 'all_in_one_seo_pack' ) . "</span></a>";
					add_meta_box( $m['id'], $title, $m['callback'], $m['post_type'], $m['context'], $m['priority'], $m['callback_args'] );
				}
			}
		}
	}
	
	function get_metabox_header( $tabs ) {
		$header = '<ul class="aioseop_header_tabs hide">';
		$active = ' active';
		foreach( $tabs as $t ) {
			if ( $active )
				$title = __( 'Main Settings', 'all_in_one_seo_pack' );
			else
				$title = $t['title'];
			$header .= '<li><label class="aioseop_header_nav"><a class="aioseop_header_tab' . $active . '" href="#'. $t['id'] .'">'.$title.'</a></label></li>';
			$active = '';
		}
		$header .= '</ul>';
		return $header;
	}
	
	function set_menu_order( $menu_order ) {
		$order = array();
		$file = plugin_basename( __FILE__ );
		foreach ( $menu_order as $index => $item ) {
			if ( $item != $file ) $order[] = $item;
			if ( $index == 0 )    $order[] = $file;
		}
		return $order;
	}

	function display_settings_header() { ?>
		<?php
	}
	function display_settings_footer( ) {
	}

	function display_right_sidebar( ) { ?>
		
<?php
/* <label class="aioseop_generic_label"><?php _e('Click on option titles to get help!', 'all_in_one_seo_pack' ); ?></label> */
		global $wpdb;

		if( !get_option( 'aioseop_options' ) ) {
			$msg = "<div style='text-align:center;'><p><strong>Your database options need to be updated.</strong><em>(Back up your database before updating.)</em>
				<FORM action='' method='post' name='aioseop-migrate-options'>
					<input type='hidden' name='nonce-aioseop-migrate-options' value='" . wp_create_nonce( 'aioseop-migrate-nonce-options' ) . "' />
					<input type='submit' name='aioseop_migrate_options' class='button-primary' value='Update Database Options'>
		 		</FORM>
			</p></div>";
			aioseop_output_dismissable_notice( $msg, "", "error" );
		}
?>
		<div class="aioseop_top">
			<div class="aioseop_top_sidebar aioseop_options_wrapper">
				<?php do_meta_boxes( 'aioseop_metaboxes', 'normal', Array( 'test' ) ); ?>
			</div>
		</div>
		<style>
			#wpbody-content {
				min-width: 900px;
			}
		</style>
		<div class="aioseop_right_sidebar aioseop_options_wrapper">
		
		<div class="aioseop_sidebar">
			<?php
			do_meta_boxes( 'aioseop_metaboxes', 'side', Array( 'test' ) );		
			?>
			<script type="text/javascript">
				//<![CDATA[
				jQuery(document).ready( function($) {
					// close postboxes that should be closed
					$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
					// postboxes setup
					if ( typeof postboxes !== 'undefined' )
						postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
					// $('.meta-box-sortables').removeClass('meta-box-sortables');
				});
				//]]>
			</script>
		<div class="aioseop_advert aioseop_nopad">
			<a href="https://wp.wincher.com/v1/link" target="_blank"><img src="<?php echo AIOSEOP_PLUGIN_IMAGES_URL; ?>wincherbanner.png"></a>
		</div>
		<!-- Headway Themes-->
		<div class="aioseop_advert">
					<div>
					<h3>Drag and Drop WordPress Design</h3>
					<p><a href="http://semperfiwebdesign.com/headwayaio/" target="_blank">Headway Themes</a> allows you to easily create your own stunning website designs! Stop using premade themes start making your own design with Headway's easy to use Drag and Drop interface. All in One SEO Pack users have an exclusive discount by using coupon code <strong>SEMPERFI30</strong> at checkout.</p>
					</div>
				<a href="http://semperfiwebdesign.com/headwayaio/" target="_blank"><img src="<?php echo AIOSEOP_PLUGIN_IMAGES_URL; ?>headwaybanner.png"></a>
		</div>
		
	</div>
</div>	
<?php
	}
}
