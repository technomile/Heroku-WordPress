=== Quick Page/Post Redirect Plugin ===
Contributors: Don Fischer
Donate link: http://www.fischercreativemedia.com/donations/
Tags: redirect, 301, 302, meta, post, plugin, page, forward, re-direct, nofollow, menu links, posts, pages, admin, 404, custom post types, nav menu, import, export, restore
Requires at least: 3.1
Tested up to: 3.9
Stable tag: trunk

Redirect Pages/Posts to another page/post or external URL. Has edit box as well as global options. Specify the redirect Location and type. For PHP5+

== Description ==
Version 5.0.6.
This plugin adds adds an option box to the edit section where you can specify the redirect location and type of redirect that you want, temporary, permanent, or meta. See below for additional features added. 

= Features: = 
* Works with new WordPress menus
* Works with new WordPress Custom Post Types (set option on settings page)
* Disabled in 5.0.3: [jQuery integration for more enhanced re-writes (set option on settings page)].
* You can set a redirect page or menu link to open in a new window (will not work on permalinks)
* You can add a *rel="nofollow"* attribute to the page or menu link of the redirect (will not work on permalinks)
* You can completely re-write the URL for the redirect so it takes the place of the default page URL (rewrite the href link)
* You can redirect without needing to create a Page or Post. This is very useful for sites that were converted to WordPress and have old links that create 404 errors (see FAQs for more information). This option does not allow for open in a new window or nofollow functions.
* Redirect Location can be to another WordPress page/post or any other website with an external URL. 
* Redirect can use a full URL path, the post or page ID, permalink or page-name (not available for Quick Redirects method).
* Option Screen to set global overrides like turning off all redirects at once, setting a global destination link, make all redirect open in a new window, etc.
* View a summary of all redirected pages/posts or custom post types and Quick Redirects that are currently set up.
* Plugin Clean up functions for those who decide they may want to remove all plugin data.
* Import/Export of redirects for backup, or to bulk add redirects.
* Built-in FAQs/Help that can be updated daily with relevant questions.

This plugin is not compatible with WordPress versions less than 3.1. Requires PHP 5+.

*PLEASE NOTE:* A new page or post needs to be Published in order for Page/Post redirect to happen. It WILL work on a DRAFT Status Post/Page ONLY, and I mean ONLY, if the Post/Page has FIRST been Published and the re-saved as a Draft. This does not apply to Quick Redirects.

= TROUBLESHOOTING: =
* To include custom post types, check the setting on the main plugin option page.
* If you check the box for "Show Redirect URL below" on the edit page, please note that you MUST use the full URL in the Redirect URL box. If you do not, you may experience some odd links and 404 pages, as this option changes the Permalink for the page/post to the EXACT URL you enter in that field. (i.e., if you enter '2' in the field, it will redirect to 'http://2' which is not the same as 'http://yoursite.com/?p=2').
* If your browser tells you that your are in an infinite loop, check to make sure you do not have pages redirecting to another page that redirects back to the initial page. That WILL cause an infinite loop.
* If you are using the Quick Redirects method to do your redirects, be sure that your Request URL starts with a / and is relative to the root (i.e., http://mysite.com/test/ would have /test/ in the request field).
* Links in page/post content and Permalinks will not open in a new window or add the rel=nofollow. That is because the theme template actually sets up the links by calling "the_permalink()" function so adding these elements is not consistently possible. You can however, have the attempt to use a jQuery replace to try to fix the issue - to do this enable the jQuery option in the settings.
* If your page or post is not redirecting, this is most likely because something else like the theme functions file or another plugin is outputting the header BEFORE the plugin can perform the redirect. This can be tested by turning off all plugins except the Quick Page/Post Redirect Plugin and testing if the redirect works. 9 out of 10 times, a plugin or bad code is the culprit.
* We have tested the plugin in dozens of themes and alongside a whole lot more plugins. In our experience, (with exception to a few bugs from time to time) most of the time another plugin is the problem. If you do notice a problem, please let us know at plugins@fischercreativemedia.com - along with the WP version, theme you are using and plugins you have installed - and we will try to troubleshoot the problem. 
* Check the FAQs/Help located in the Plugin menu for more up to date issues and fixes.

== Installation ==

= If you downloaded this plugin: =
1. Upload `quick_page_post_redirect` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Once Activated, you can add a redirect by entering the correct information in the `Quick Page/Post Redirect` box in the edit section of a page or post
1. You can create a redirect with the 'Quick Redirects' option located in the Admin Settings menu.

= If you install this plugin through WordPress 2.8+ plugin search interface: =
1. Click Install `Quick Page/Post Redirect Plugin`
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Once Activated, you can add a redirect by entering the correct information in the `Quick Page/Post Redirect` box in the edit section of a page or post
1. You can create a redirect with the 'Quick Redirects' option located in the Admin Settings menu.

== Frequently Asked Questions ==
** SEE A LIST OF MORE UP TO DATE FAQS IN THE PLUGIN MENU ITSELF ** 

= With 3.0s new menu structure, isn't your plugin now obsolete? =
Yes, and No. Mostly No.
Here is why - with WordPress 3.0, comes the new menu structure, but only a handful of themes actually have the menu structure already integrated into theme. This means that there are tons of themes out there that still need to use the the old way until they can update their theme template pages and functions to turn on the menu capability.
Additionally, the Quick Redirects option still allows you to create redirects for any url on your site, so that is very much not obsolete (until WP makes something to do that as well). And as a final note, the plugin is still compatible with WP's new menu functionality using the standard page/post creations - only custom menu items will be out of the plugin's realm of redirects - and you could set the URL in the new WP menu anyway, so that would be covered.

= I still can't get the OPEN IN NEW WINDOW option to work... why? =
Some themes put custom links in the menu, like RSS and other similar items. Many times (an this is usually the main reason why), they do not use the WP hook to add the menu item to the list - they literally just put it there. Unless the theme uses the internal WordPress hooks to call the menu, redirects, open in a new window and rel=nofollow features just will not work.
ADDITIONALLY - Links in page/post content and Permalinks will not open in a new window or add the rel=nofollow. That is because the theme template actually sets up the links by calling "the_permalink()" function so add these elements is not consistently possible so it has been excluded from the functionality. The links will still redirect just fine but without that feature.

= Do I need to have a Page or Post Created to redirect? =
There is a Quick Redirects feature that allows you to create a redirect for any URL on your site. This is VERY helpful when you move an old site to WordPress and have old links that need to go some place new. For example, 
If you had a link on a site that went to http://yoursite.com/aboutme.html you can now redirect that to http://yoursite.com/about/ without needing to edit the htaccess file. You simply add the old URL (/aboutme.html) and tell it you want to go to the new one (/about/). Simple as that.

The functionality is located in the REDIRECT MENU under Quick Redirects. The old URL goes in the Request field and the to new URL goes in the Destination field. Simple and Quick!

= Can I add 'rel="nofollow" attribute to the redirect link? =
YES, you can add a ' rel="nofollow" ' attribute for the redirect link. Simply check the "add rel=nofollow" box when setting up the redirect on the page/post edit page. Note - this option is only available for the Quick Redirects method when the 'use with jQuery' functionality is enabled in the settings.

= Can I make the redirect open in a new window? =
YES, you can make the redirect link open in a new window. Simply check the "Open in a new window" box when setting up the redirect on the page/post edit page. Note - this option is only available for the Quick Redirects method when the 'use with jQuery' functionality is enabled in the settings.

= I want to just have the link for the redirecting page/post show the new redirect link in the link, not the old one, can I do that? =
YES, you can hide the original page link and have it replaced with the redirect link. Any place the theme calls either "wp_page_links", "post_links" or "page_links" functions, the plugin can replace the original link with the new one. Simply check the "Show Redirect URL" box when setting up the redirect on the page/post edit page. Note - this option is not available for the Quick Redirects method. 

= I have Business Cards/Postcards/Ads that say my website is http://something.com/my-name/ or http://something.com/my-product/, can I set that up with this? =
YES! Just set up a redirect (see above) and set the Request field to /my-name/ or /my-product/ and the Destination field to the place you want it to go. The destination doesn't even need to be on the same site - it can go anywhere you want it to go!

= Why is my Page/Post not redirecting? =
FIRST - make sure it is active. Then, check to make sure the global option to turn off all redirects is not checked.
If your page or post is still not redirecting, then it is most likely because something else like the theme functions file or another plugin is outputting the header BEFORE the plugin can perform the redirect. This can be tested by turning off all plugins except the Quick Page/Post Redirect Plugin and testing if the redirect works. 9 out of 10 times, a plugin or bad code is the culprit - or the redirect is just simply turned off. 

We have tested the plugin in dozens of themes and a whole lot more plugins. In our experience, (with exception to a few bugs) most of the time another plugin is the problem. If you do notice a problem, please let us know at plugins@fischercreativemedia.com - along with the WP version, theme you are using and plugins you have installed - and we will try to troubleshoot the problem. 

= Does the Page/Post need to be Published to redirect? =
YES... and NO... The redirect will always work on a Published Post/Page. For it to work correctly on a Post/Page in DRAFT status, you need to fist publish the page, then re-save it as a draft. If you don't follow that step, you will get a 404 error. 

= Can I do a permanent 301 Redirect? =
Yes. You can perform a 301 Permanent Redirect. Additionally, you can select a 302 Temporary or a 307 Temporary redirect or a Meta redirect. 

= What the heck is a 301 or 302 redirect anyway? =
Good question! The number corresponds with the header code that is returned to the browser when the page is first accessed. A good page, meaning something was found, returns a 200 status code and that tells the browser to go ahead and keep loading the content for the page. If nothing is found a 404 error is returned (and we have ALL seen these - usually it is a bad link or a page was moved). There are many other types of codes, but those ore the most common. 

The 300+ range of codes in the header, tells the browser (and search engine spider) that the original page has moved to a new location - this can be just a new file name a new folder or a completely different site.

A 301 code means that you want to tell the browser (or Google, bing, etc.) that your new page has permanently moved to a new location. This is great for search engines because it lets them know that there was a page there once, but now go to the new place to get it - and they update there old link to is so future visitors will not have to go through the same process.

A 302 or 307 code tell the browser that the file was there but TEMPORARILY it can be found at a new location. This will tell the search engines to KEEP the old link in place because SOME day it will be back at the same old link. There is only a slight difference between a 302 and a 307 status. Truth is, 302 is more widely used, so unless you know why you need a 307, stick with a 302.

= So, which one do I use? =
Easiest way to decide is this: If you want the page to permanently change to a new spot, use 301. If you are editing the page or post and only want it to be down for a few hours, minutes, days or weeks and plan on putting it back with the same link as before, then us 302. If you want to hide the responses code from the spiders, use the `no code` option, and if you are having trouble with the redirects, use a `meta` redirect. The meta redirect actually starts to load the page as a 200 good status, then redirects using a meta redirect tag. 

Still not sure? Try 302 for now - at least until you have a little time to read up on the subject.

= Should I use a full URL with http:// or https:// ? =
Yes, you can, but you do not always need to. If you are redirecting to an external URL, then yes. If you are just redirecting to another page or post on your site, then no, it is not needed. When in doubt, use the entire URL.

= That's all the FAQs you have? =
NO it isn't! Check the plugin FAQs/Help page for a more up to date list of Frequently Asked Questions. The plugin now has a live feed of FAQs that can be updated regularly. If you have something you thin we should add, please let us know.


== Screenshots ==

1. New FAQs/Help Page. This is updated off an RSS feed so it can be updated regularly with fixs and common questions.
2. Setting Page. Includes new Import and Export features.
3. More detailed view of Import/Export Feature.
4. Plugin Clean Up feature. You can delete ALL plugin data!
5. Quick Redirects setup page.
5. Summary of redirects plugin page.

== Changelog ==
= 5.0.6 =
* Fix to some users getting Warning messages for parse_url function.
* Added nonce field checking for Quick Redirects form to help eliminate the possibility of form takeover on submission of quick redirect saves.

= 5.0.5 =
* Fix to security flaw for logged in admin users.
* Fix to extra spaces that broke some callback functions in the redirect class in 5.0.4.

= 5.0.4 =
* Minor bug cleanup
* Security fixes: fixed possible cross-scripting vulnerability in saving of data to options.
* Changed the hook call level for the redirects hook on normal redirects so it will not interfere with some other plugins.


= 5.0.3 =
* Minor bug cleanup update - (no new features added)
* Bug fixes: Javascript ghost js file call fixed. Actions hooks not applying issue fixed. Querystring redirect issue addressed. Unset index errors addressed. Some Network/MU problems fixed.
* Modified Import and Export scripts to export a more editable export file. Import can be either old encoded version or new readable PIPE version.
* Typos and minor layout issues addressed.

= 5.0.2 =
* Bug fixes and jQuery now set to off until issues are resolved.
* Set Case Sensetive to on by default - Some people having issues with infinite loops.

= 5.0.1 =
* Fix to jQuery conflict issue.

= 5.0 =
* Added jQuery version check to ensure no problmes with themes forcing older versions of jQuery
* Added a few warning /info messages to Quick Redirects page.
* Redirect summary was updated to display Quick Redirects as well as individual redirects. Now it is easier to see at a glance what redirects you have set up.
* Rewrite of Quick Redirects functions to allow selecting Open in New Window (NW) and rel=nofollow (NF) as long as 'use jQuery' is selected. 
* Added "use jQuery" option on settings page - on by default after upgrade
* Added jQuery redirect replace, target="_blank", and rel="nofollow" to increase success for additional options (mainly Quick redirects).
* Changed out WP_PLUGIN_URL for plugins_url() to help resolve errors in redirects for SSL/https
* Changed the way custom post types are handled.These are now on by default for new users - or users who have not specifically set to off.
* The ability to turn off the Plugin Meta Box for any post type was added (admin permissions required).
* Import and Export features were added to allow for backup of existing Quick Redirects, Restoring a backup or adding bulk redirects.
* Plugin clean-up features were added to completely remove either Page/Post meta data (for regular redirects), Quick Redirects, or both.
* Several filter and action hooks were added to help users better integrate the plugin into their theme, should they need additional functionality.
* New FAQs/Help page with items provided by an RSS feed, so we can easily update FAQs when common questions/issues arise.
* Query String data is now preserved for Quick Redirects (thanks to Jon Wilson for the contribution).
* Case insensitivity option was added for Quick Redirects (thanks to Brian DiChiara for the contribution).

= 4.2.2 =
* Fix some embarrasing spelling errors.(07/14/2011)
* Fix Quick Redirects links from inside the redirect edit box and plugin page - they would give a "not authorized" warning because the page location changed in version 4.0 (07/14/11)

= 4.2.1 =
* Fix to trailing slash non-redirect for quick redirects.(06/28/2011)
* Note - this was not a public version fix, but a dev testing version - this fix is publicly included in 4.2.2.

= 4.2 =
* Fix to menus pages always opening in New Window even when not selected.(05/08/2011)
* Fix Categories/Archives automatically redirecting to the first post with redirect set if any post on the page had a redirect set.(05/08/2011)
* Fix Homepage redirecting to first post with redirect set if using posts as home and any post had a redirect.(05/08/2011)
* Fix misrepresentation of new window global setting on options page. Should read that "all redirects WILL open in a new window" not "will NOT open in a new window". (05/08/2011)
* Update description to note that the plugin requires PHP 5+ because some of the class calls will not work in php4 (plugin will not activate). (05/08/2011)

= 4.1 =
* Fix Minor spelling issues and code typos.(05/05/2011)

= 4.0 =
* Rewrite of all functions for better optimization.(05/01/2011)
* Added consolidated DB call at class setup to reduce DB calls to one call per page load.(05/01/2011)
* Moved entire plugin into a class for easier updates.(05/01/2011)
* Added new Options page with Global Overrides.(05/02/2011)
* Integrated Custom Post Types functionality.(05/02/2011)
* Created a Summary Page for a quick glace of set up redirects.(05/04/2011)
* Moved Quick Redirects menu from settings to a new Redirects Menu.(05/03/2011)
* Added additional checks and validations when adding Quick Redirects.(05/03/2011)
* Added a way to delete Quick Redirects easier.(03/01/2011)

= 3.2.3 =
* Fix New Window and No Follow attributes in themes with older menu calls. (12/29/10)
= 3.2.2 =
* Fix meta tag redirect method. Was broken because of new method of checking redirects with less query calls. (12/16/10)
* Fix php code errors - still had some debugging code live that will cause some users to have problems.(12/16/10)
= 3.2.1 =
* limited test release - testing for some of 3.2.2 release fixes. (12/14/10)
= 3.2 =
* remove functions ppr_linktotarget, ppr_linktonorel, ppr_redirectto and ppr_linktometa.(12/10/2010) 
* re-write functions to consolidate queries. (12/10/2010) 
* added new filters for New menu structure to filter wp_nav_menu menus as well as old wp_page_menus functions. (12/10/2010) 
* cleaned up new window and nofollow code to work more consistently. (12/10/2010) 
= 3.1 =
* Re-issue of 2.1 for immediate fix of issue with the 3.0 version.(6/21/2010)
= 3.0 =
* Enhance filter function in main class to reduce Database calls. (06/20/2010)
= 2.1 =
* Fix Bug - Open in New Window would not work unless Show Link URL was also selected. (3/12/2010)
* Fix Bug - Add rel=nofollow would not work if Open in a New Window was not selected. (3/13/2010)
* Fix Bug - Show Link, Add nofollow and Open in New Window would still work when redirect not active. (3/13/2010)
* Added new preg_match_all and preg_replace calls to add target and nofollow links - more effecient and accuarte - noticed some cases where old funtion would add the items if a redirect link had the same URL. (3/13/2010) 
= 2.0 =
* Cosmetic code cleanup. (2/28/2010)
* Remove warning and error messages created in 1.9 (2/28/2010)
= 1.9 =
* Added 'Open in New Window' Feature. (2/20/2010)
* Added 'rel="nofollow"' attribute option for links that will redirect. (2/20/2010)
* Added 'rewrite url/permalink' option to hide the regular link and replace it with the new re-write link anywhere the link is displayed on the site. (2/20/2010)
* Hid the Custom Field Meta Data that the plugin uses - this is just to clean up the custom fields box. (2/20/2010)
= 1.8 =
* Added a new Quick 301 Redirects Page to allow adding of additional redirects that do not have Pages or Posts created for them. Based on Scott Nelle's Simple 301 Redirects plugin.(12/28/2009)
= 1.7 =
* fix to correct meta redirect - moved "exit" command to "addtoheader_theme" function. Also fixed the problem with some pages not redirecting. Made the plugin WordPress MU compatible. (9/8/2009)
= 1.6.1 =
* Small fix to correct the same problem as 1.6 for Category and Archive pages (9/1/2009) 
= 1.6 =
* Fixed wrongful redirect when the first blog post on home page (main blog page) has a redirect set up - this was redirecting the entire page incorrectly. This was only an issue with the first post on a page. (9/1/2009)
= 1.5 =
* Major re-Write of the plugin core function to hook WP at a later time to take advantage of the POST function - no sense re-creating the wheel. 
* Removed the 'no code' redirect, as it turns out, many browsers will not redirect properly without a code - sorry guys.
* Can have page/post as draft and still redirect - but ONLY after the post/page has first been published and then re-saved as draft (this will hopefully be a fix for a later version). (8/31/2009)
= 1.4 =
* Add exit script command after header redirect function - needed on some servers and browsers. (8/19/2009)
= 1.3 = 
* Add Meta Re-fresh option (7/26/2009)
= 1.2 = 
* Add easy Post/Page Edit Box (7/25/2009)
= 1.1 = 
* Fix redirect for off site links (7/7/2009)
= 1.0 = 
* Initial Plugin creation (7/1/2009)

== Upgrade Notice ==
= 5.0.6 =
* Fix Warning Message from parse_url function for some users. 
* Added Nonce to form to prevent possible maliscious form takeover on saving Quick Redirects. 
