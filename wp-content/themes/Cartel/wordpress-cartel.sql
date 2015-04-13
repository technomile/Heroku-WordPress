-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2015 at 09:25 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wordpress-cartel`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_commentmeta`
--

DROP TABLE IF EXISTS `wp_commentmeta`;
CREATE TABLE IF NOT EXISTS `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_comments`
--

DROP TABLE IF EXISTS `wp_comments`;
CREATE TABLE IF NOT EXISTS `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `wp_comments`
--

INSERT INTO `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(1, 1, 'Mr WordPress', '', 'https://wordpress.org/', '', '2015-04-13 17:26:13', '2015-04-13 17:26:13', 'Hi, this is a comment.\nTo delete a comment, just log in and view the post&#039;s comments. There you will have the option to edit or delete them.', 0, '1', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_links`
--

DROP TABLE IF EXISTS `wp_links`;
CREATE TABLE IF NOT EXISTS `wp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) NOT NULL DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` varchar(255) NOT NULL DEFAULT '',
  `link_visible` varchar(20) NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL DEFAULT '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_options`
--

DROP TABLE IF EXISTS `wp_options`;
CREATE TABLE IF NOT EXISTS `wp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=402 ;

--
-- Dumping data for table `wp_options`
--

INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'siteurl', 'http://localhost/WordPress/Cartel', 'yes'),
(2, 'home', 'http://localhost/WordPress/Cartel', 'yes'),
(3, 'blogname', 'MADISON ISLAND', 'yes'),
(4, 'blogdescription', 'ECOMMERCE', 'yes'),
(5, 'users_can_register', '1', 'yes'),
(6, 'admin_email', 'cartel@gmail.com', 'yes'),
(7, 'start_of_week', '1', 'yes'),
(8, 'use_balanceTags', '0', 'yes'),
(9, 'use_smilies', '1', 'yes'),
(10, 'require_name_email', '1', 'yes'),
(11, 'comments_notify', '1', 'yes'),
(12, 'posts_per_rss', '10', 'yes'),
(13, 'rss_use_excerpt', '0', 'yes'),
(14, 'mailserver_url', 'mail.example.com', 'yes'),
(15, 'mailserver_login', 'login@example.com', 'yes'),
(16, 'mailserver_pass', 'password', 'yes'),
(17, 'mailserver_port', '110', 'yes'),
(18, 'default_category', '1', 'yes'),
(19, 'default_comment_status', 'open', 'yes'),
(20, 'default_ping_status', 'open', 'yes'),
(21, 'default_pingback_flag', '1', 'yes'),
(22, 'posts_per_page', '10', 'yes'),
(23, 'date_format', 'F j, Y', 'yes'),
(24, 'time_format', 'g:i a', 'yes'),
(25, 'links_updated_date_format', 'F j, Y g:i a', 'yes'),
(26, 'comment_moderation', '0', 'yes'),
(27, 'moderation_notify', '1', 'yes'),
(28, 'permalink_structure', '/%postname%/', 'yes'),
(29, 'gzipcompression', '0', 'yes'),
(30, 'hack_file', '0', 'yes'),
(31, 'blog_charset', 'UTF-8', 'yes'),
(32, 'moderation_keys', '', 'no'),
(33, 'active_plugins', 'a:4:{i:0;s:52:"testimonials-by-woothemes/woothemes-testimonials.php";i:1;s:55:"woocommerce-dropdown-cart/woocommerce-dropdown-cart.php";i:2;s:27:"woocommerce/woocommerce.php";i:3;s:27:"wp-pagenavi/wp-pagenavi.php";}', 'yes'),
(34, 'category_base', '', 'yes'),
(35, 'ping_sites', 'http://rpc.pingomatic.com/', 'yes'),
(36, 'advanced_edit', '0', 'yes'),
(37, 'comment_max_links', '2', 'yes'),
(38, 'gmt_offset', '0', 'yes'),
(39, 'default_email_category', '1', 'yes'),
(40, 'recently_edited', '', 'no'),
(41, 'template', 'Cartel', 'yes'),
(42, 'stylesheet', 'Cartel', 'yes'),
(43, 'comment_whitelist', '1', 'yes'),
(44, 'blacklist_keys', '', 'no'),
(45, 'comment_registration', '0', 'yes'),
(46, 'html_type', 'text/html', 'yes'),
(47, 'use_trackback', '0', 'yes'),
(48, 'default_role', 'customer', 'yes'),
(49, 'db_version', '30133', 'yes'),
(50, 'uploads_use_yearmonth_folders', '1', 'yes'),
(51, 'upload_path', '', 'yes'),
(52, 'blog_public', '1', 'yes'),
(53, 'default_link_category', '2', 'yes'),
(54, 'show_on_front', 'page', 'yes'),
(55, 'tag_base', '', 'yes'),
(56, 'show_avatars', '1', 'yes'),
(57, 'avatar_rating', 'G', 'yes'),
(58, 'upload_url_path', '', 'yes'),
(59, 'thumbnail_size_w', '150', 'yes'),
(60, 'thumbnail_size_h', '150', 'yes'),
(61, 'thumbnail_crop', '1', 'yes'),
(62, 'medium_size_w', '300', 'yes'),
(63, 'medium_size_h', '300', 'yes'),
(64, 'avatar_default', 'mystery', 'yes'),
(65, 'large_size_w', '1024', 'yes'),
(66, 'large_size_h', '1024', 'yes'),
(67, 'image_default_link_type', 'file', 'yes'),
(68, 'image_default_size', '', 'yes'),
(69, 'image_default_align', '', 'yes'),
(70, 'close_comments_for_old_posts', '0', 'yes'),
(71, 'close_comments_days_old', '14', 'yes'),
(72, 'thread_comments', '1', 'yes'),
(73, 'thread_comments_depth', '5', 'yes'),
(74, 'page_comments', '0', 'yes'),
(75, 'comments_per_page', '50', 'yes'),
(76, 'default_comments_page', 'newest', 'yes'),
(77, 'comment_order', 'asc', 'yes'),
(78, 'sticky_posts', 'a:0:{}', 'yes'),
(79, 'widget_categories', 'a:2:{i:2;a:4:{s:5:"title";s:0:"";s:5:"count";i:0;s:12:"hierarchical";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}', 'yes'),
(80, 'widget_text', 'a:0:{}', 'yes'),
(81, 'widget_rss', 'a:0:{}', 'yes'),
(82, 'uninstall_plugins', 'a:1:{s:27:"wp-pagenavi/wp-pagenavi.php";s:14:"__return_false";}', 'no'),
(83, 'timezone_string', '', 'yes'),
(84, 'page_for_posts', '0', 'yes'),
(85, 'page_on_front', '10', 'yes'),
(86, 'default_post_format', '0', 'yes'),
(87, 'link_manager_enabled', '0', 'yes'),
(88, 'initial_db_version', '30133', 'yes'),
(89, 'wp_user_roles', 'a:7:{s:13:"administrator";a:2:{s:4:"name";s:13:"Administrator";s:12:"capabilities";a:132:{s:13:"switch_themes";b:1;s:11:"edit_themes";b:1;s:16:"activate_plugins";b:1;s:12:"edit_plugins";b:1;s:10:"edit_users";b:1;s:10:"edit_files";b:1;s:14:"manage_options";b:1;s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:6:"import";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:8:"level_10";b:1;s:7:"level_9";b:1;s:7:"level_8";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;s:12:"delete_users";b:1;s:12:"create_users";b:1;s:17:"unfiltered_upload";b:1;s:14:"edit_dashboard";b:1;s:14:"update_plugins";b:1;s:14:"delete_plugins";b:1;s:15:"install_plugins";b:1;s:13:"update_themes";b:1;s:14:"install_themes";b:1;s:11:"update_core";b:1;s:10:"list_users";b:1;s:12:"remove_users";b:1;s:9:"add_users";b:1;s:13:"promote_users";b:1;s:18:"edit_theme_options";b:1;s:13:"delete_themes";b:1;s:6:"export";b:1;s:18:"manage_woocommerce";b:1;s:24:"view_woocommerce_reports";b:1;s:12:"edit_product";b:1;s:12:"read_product";b:1;s:14:"delete_product";b:1;s:13:"edit_products";b:1;s:20:"edit_others_products";b:1;s:16:"publish_products";b:1;s:21:"read_private_products";b:1;s:15:"delete_products";b:1;s:23:"delete_private_products";b:1;s:25:"delete_published_products";b:1;s:22:"delete_others_products";b:1;s:21:"edit_private_products";b:1;s:23:"edit_published_products";b:1;s:20:"manage_product_terms";b:1;s:18:"edit_product_terms";b:1;s:20:"delete_product_terms";b:1;s:20:"assign_product_terms";b:1;s:15:"edit_shop_order";b:1;s:15:"read_shop_order";b:1;s:17:"delete_shop_order";b:1;s:16:"edit_shop_orders";b:1;s:23:"edit_others_shop_orders";b:1;s:19:"publish_shop_orders";b:1;s:24:"read_private_shop_orders";b:1;s:18:"delete_shop_orders";b:1;s:26:"delete_private_shop_orders";b:1;s:28:"delete_published_shop_orders";b:1;s:25:"delete_others_shop_orders";b:1;s:24:"edit_private_shop_orders";b:1;s:26:"edit_published_shop_orders";b:1;s:23:"manage_shop_order_terms";b:1;s:21:"edit_shop_order_terms";b:1;s:23:"delete_shop_order_terms";b:1;s:23:"assign_shop_order_terms";b:1;s:16:"edit_shop_coupon";b:1;s:16:"read_shop_coupon";b:1;s:18:"delete_shop_coupon";b:1;s:17:"edit_shop_coupons";b:1;s:24:"edit_others_shop_coupons";b:1;s:20:"publish_shop_coupons";b:1;s:25:"read_private_shop_coupons";b:1;s:19:"delete_shop_coupons";b:1;s:27:"delete_private_shop_coupons";b:1;s:29:"delete_published_shop_coupons";b:1;s:26:"delete_others_shop_coupons";b:1;s:25:"edit_private_shop_coupons";b:1;s:27:"edit_published_shop_coupons";b:1;s:24:"manage_shop_coupon_terms";b:1;s:22:"edit_shop_coupon_terms";b:1;s:24:"delete_shop_coupon_terms";b:1;s:24:"assign_shop_coupon_terms";b:1;s:17:"edit_shop_webhook";b:1;s:17:"read_shop_webhook";b:1;s:19:"delete_shop_webhook";b:1;s:18:"edit_shop_webhooks";b:1;s:25:"edit_others_shop_webhooks";b:1;s:21:"publish_shop_webhooks";b:1;s:26:"read_private_shop_webhooks";b:1;s:20:"delete_shop_webhooks";b:1;s:28:"delete_private_shop_webhooks";b:1;s:30:"delete_published_shop_webhooks";b:1;s:27:"delete_others_shop_webhooks";b:1;s:26:"edit_private_shop_webhooks";b:1;s:28:"edit_published_shop_webhooks";b:1;s:25:"manage_shop_webhook_terms";b:1;s:23:"edit_shop_webhook_terms";b:1;s:25:"delete_shop_webhook_terms";b:1;s:25:"assign_shop_webhook_terms";b:1;}}s:6:"editor";a:2:{s:4:"name";s:6:"Editor";s:12:"capabilities";a:34:{s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;}}s:6:"author";a:2:{s:4:"name";s:6:"Author";s:12:"capabilities";a:10:{s:12:"upload_files";b:1;s:10:"edit_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:4:"read";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;s:22:"delete_published_posts";b:1;}}s:11:"contributor";a:2:{s:4:"name";s:11:"Contributor";s:12:"capabilities";a:5:{s:10:"edit_posts";b:1;s:4:"read";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;}}s:10:"subscriber";a:2:{s:4:"name";s:10:"Subscriber";s:12:"capabilities";a:2:{s:4:"read";b:1;s:7:"level_0";b:1;}}s:8:"customer";a:2:{s:4:"name";s:8:"Customer";s:12:"capabilities";a:3:{s:4:"read";b:1;s:10:"edit_posts";b:0;s:12:"delete_posts";b:0;}}s:12:"shop_manager";a:2:{s:4:"name";s:12:"Shop Manager";s:12:"capabilities";a:110:{s:7:"level_9";b:1;s:7:"level_8";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:4:"read";b:1;s:18:"read_private_pages";b:1;s:18:"read_private_posts";b:1;s:10:"edit_users";b:1;s:10:"edit_posts";b:1;s:10:"edit_pages";b:1;s:20:"edit_published_posts";b:1;s:20:"edit_published_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"edit_private_posts";b:1;s:17:"edit_others_posts";b:1;s:17:"edit_others_pages";b:1;s:13:"publish_posts";b:1;s:13:"publish_pages";b:1;s:12:"delete_posts";b:1;s:12:"delete_pages";b:1;s:20:"delete_private_pages";b:1;s:20:"delete_private_posts";b:1;s:22:"delete_published_pages";b:1;s:22:"delete_published_posts";b:1;s:19:"delete_others_posts";b:1;s:19:"delete_others_pages";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:17:"moderate_comments";b:1;s:15:"unfiltered_html";b:1;s:12:"upload_files";b:1;s:6:"export";b:1;s:6:"import";b:1;s:10:"list_users";b:1;s:18:"manage_woocommerce";b:1;s:24:"view_woocommerce_reports";b:1;s:12:"edit_product";b:1;s:12:"read_product";b:1;s:14:"delete_product";b:1;s:13:"edit_products";b:1;s:20:"edit_others_products";b:1;s:16:"publish_products";b:1;s:21:"read_private_products";b:1;s:15:"delete_products";b:1;s:23:"delete_private_products";b:1;s:25:"delete_published_products";b:1;s:22:"delete_others_products";b:1;s:21:"edit_private_products";b:1;s:23:"edit_published_products";b:1;s:20:"manage_product_terms";b:1;s:18:"edit_product_terms";b:1;s:20:"delete_product_terms";b:1;s:20:"assign_product_terms";b:1;s:15:"edit_shop_order";b:1;s:15:"read_shop_order";b:1;s:17:"delete_shop_order";b:1;s:16:"edit_shop_orders";b:1;s:23:"edit_others_shop_orders";b:1;s:19:"publish_shop_orders";b:1;s:24:"read_private_shop_orders";b:1;s:18:"delete_shop_orders";b:1;s:26:"delete_private_shop_orders";b:1;s:28:"delete_published_shop_orders";b:1;s:25:"delete_others_shop_orders";b:1;s:24:"edit_private_shop_orders";b:1;s:26:"edit_published_shop_orders";b:1;s:23:"manage_shop_order_terms";b:1;s:21:"edit_shop_order_terms";b:1;s:23:"delete_shop_order_terms";b:1;s:23:"assign_shop_order_terms";b:1;s:16:"edit_shop_coupon";b:1;s:16:"read_shop_coupon";b:1;s:18:"delete_shop_coupon";b:1;s:17:"edit_shop_coupons";b:1;s:24:"edit_others_shop_coupons";b:1;s:20:"publish_shop_coupons";b:1;s:25:"read_private_shop_coupons";b:1;s:19:"delete_shop_coupons";b:1;s:27:"delete_private_shop_coupons";b:1;s:29:"delete_published_shop_coupons";b:1;s:26:"delete_others_shop_coupons";b:1;s:25:"edit_private_shop_coupons";b:1;s:27:"edit_published_shop_coupons";b:1;s:24:"manage_shop_coupon_terms";b:1;s:22:"edit_shop_coupon_terms";b:1;s:24:"delete_shop_coupon_terms";b:1;s:24:"assign_shop_coupon_terms";b:1;s:17:"edit_shop_webhook";b:1;s:17:"read_shop_webhook";b:1;s:19:"delete_shop_webhook";b:1;s:18:"edit_shop_webhooks";b:1;s:25:"edit_others_shop_webhooks";b:1;s:21:"publish_shop_webhooks";b:1;s:26:"read_private_shop_webhooks";b:1;s:20:"delete_shop_webhooks";b:1;s:28:"delete_private_shop_webhooks";b:1;s:30:"delete_published_shop_webhooks";b:1;s:27:"delete_others_shop_webhooks";b:1;s:26:"edit_private_shop_webhooks";b:1;s:28:"edit_published_shop_webhooks";b:1;s:25:"manage_shop_webhook_terms";b:1;s:23:"edit_shop_webhook_terms";b:1;s:25:"delete_shop_webhook_terms";b:1;s:25:"assign_shop_webhook_terms";b:1;}}}', 'yes'),
(90, 'widget_search', 'a:2:{i:2;a:1:{s:5:"title";s:0:"";}s:12:"_multiwidget";i:1;}', 'yes'),
(91, 'widget_recent-posts', 'a:3:{i:2;a:2:{s:5:"title";s:0:"";s:6:"number";i:5;}i:3;a:3:{s:5:"title";s:12:"Recent Posts";s:6:"number";i:5;s:9:"show_date";b:0;}s:12:"_multiwidget";i:1;}', 'yes'),
(92, 'widget_recent-comments', 'a:2:{i:2;a:2:{s:5:"title";s:0:"";s:6:"number";i:5;}s:12:"_multiwidget";i:1;}', 'yes'),
(93, 'widget_archives', 'a:2:{i:2;a:3:{s:5:"title";s:0:"";s:5:"count";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}', 'yes'),
(94, 'widget_meta', 'a:3:{i:2;a:1:{s:5:"title";s:0:"";}i:3;a:1:{s:5:"title";s:0:"";}s:12:"_multiwidget";i:1;}', 'yes'),
(95, 'sidebars_widgets', 'a:5:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:13:"footer-widget";a:3:{i:0;s:7:"pages-2";i:1;s:14:"recent-posts-3";i:2;s:6:"meta-3";}s:11:"home-widget";a:3:{i:0;s:15:"cartel_widget-2";i:1;s:15:"cartel_widget-3";i:2;s:15:"cartel_widget-4";}s:13:"array_version";i:3;}', 'yes'),
(96, 'cron', 'a:9:{i:1428953497;a:1:{s:32:"woocommerce_cancel_unpaid_orders";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:2:{s:8:"schedule";b:0;s:4:"args";a:0:{}}}}i:1428969600;a:1:{s:27:"woocommerce_scheduled_sales";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1428989230;a:3:{s:16:"wp_version_check";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:17:"wp_update_plugins";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:16:"wp_update_themes";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1428989469;a:1:{s:28:"woocommerce_cleanup_sessions";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1428995220;a:1:{s:20:"wp_maybe_auto_update";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1429032535;a:1:{s:19:"wp_scheduled_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1429032669;a:1:{s:30:"woocommerce_tracker_send_event";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1429033016;a:1:{s:30:"wp_scheduled_auto_draft_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}s:7:"version";i:2;}', 'yes'),
(98, '_site_transient_update_core', 'O:8:"stdClass":4:{s:7:"updates";a:1:{i:0;O:8:"stdClass":10:{s:8:"response";s:6:"latest";s:8:"download";s:59:"https://downloads.wordpress.org/release/wordpress-4.1.1.zip";s:6:"locale";s:5:"en_US";s:8:"packages";O:8:"stdClass":5:{s:4:"full";s:59:"https://downloads.wordpress.org/release/wordpress-4.1.1.zip";s:10:"no_content";s:70:"https://downloads.wordpress.org/release/wordpress-4.1.1-no-content.zip";s:11:"new_bundled";s:71:"https://downloads.wordpress.org/release/wordpress-4.1.1-new-bundled.zip";s:7:"partial";b:0;s:8:"rollback";b:0;}s:7:"current";s:5:"4.1.1";s:7:"version";s:5:"4.1.1";s:11:"php_version";s:5:"5.2.4";s:13:"mysql_version";s:3:"5.0";s:11:"new_bundled";s:3:"4.1";s:15:"partial_version";s:0:"";}}s:12:"last_checked";i:1428946162;s:15:"version_checked";s:5:"4.1.1";s:12:"translations";a:0:{}}', 'yes'),
(99, '_transient_random_seed', 'b31f05ee8c53066f934fccc8822f3317', 'yes'),
(101, '_site_transient_timeout_theme_roots', '1428947840', 'yes'),
(102, '_site_transient_theme_roots', 'a:4:{s:6:"Cartel";s:7:"/themes";s:13:"twentyfifteen";s:7:"/themes";s:14:"twentyfourteen";s:7:"/themes";s:14:"twentythirteen";s:7:"/themes";}', 'yes'),
(103, '_site_transient_update_themes', 'O:8:"stdClass":4:{s:12:"last_checked";i:1428946165;s:7:"checked";a:4:{s:6:"Cartel";s:3:"1.1";s:13:"twentyfifteen";s:3:"1.0";s:14:"twentyfourteen";s:3:"1.3";s:14:"twentythirteen";s:3:"1.4";}s:8:"response";a:0:{}s:12:"translations";a:0:{}}', 'yes'),
(104, 'can_compress_scripts', '1', 'yes'),
(105, '_transient_timeout_plugin_slugs', '1429032738', 'no'),
(106, '_transient_plugin_slugs', 'a:6:{i:0;s:19:"akismet/akismet.php";i:1;s:9:"hello.php";i:2;s:52:"testimonials-by-woothemes/woothemes-testimonials.php";i:3;s:27:"woocommerce/woocommerce.php";i:4;s:55:"woocommerce-dropdown-cart/woocommerce-dropdown-cart.php";i:5;s:27:"wp-pagenavi/wp-pagenavi.php";}', 'no'),
(107, '_transient_timeout_dash_4077549d03da2e451c8b5f002294ff51', '1428989267', 'no'),
(108, '_transient_dash_4077549d03da2e451c8b5f002294ff51', '<div class="rss-widget"><p><strong>RSS Error</strong>: WP HTTP Error: Failed to connect to wordpress.org port 80: Timed out</p></div><div class="rss-widget"><p><strong>RSS Error</strong>: WP HTTP Error: Could not resolve host: planet.wordpress.org</p></div><div class="rss-widget"><ul></ul></div>', 'no'),
(109, 'theme_mods_twentyfifteen', 'a:1:{s:16:"sidebars_widgets";a:2:{s:4:"time";i:1428946071;s:4:"data";a:2:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}}}}', 'yes'),
(110, 'current_theme', 'Cartel', 'yes'),
(111, 'theme_mods_Cartel', 'a:2:{i:0;b:0;s:18:"nav_menu_locations";a:1:{s:7:"primary";i:6;}}', 'yes'),
(112, 'theme_switched', '', 'yes'),
(113, 'shop_catalog_image_size', 'a:3:{s:5:"width";s:3:"320";s:6:"height";s:3:"400";s:4:"crop";i:1;}', 'yes'),
(114, 'shop_single_image_size', 'a:3:{s:5:"width";s:3:"500";s:6:"height";s:3:"999";s:4:"crop";i:0;}', 'yes'),
(115, 'shop_thumbnail_image_size', 'a:3:{s:5:"width";s:3:"120";s:6:"height";s:3:"120";s:4:"crop";i:0;}', 'yes'),
(116, 'ft_op', 'a:1:{s:2:"id";s:9:"ft_cartel";}', 'yes'),
(117, 'external_theme_updates-Cartel', 'O:8:"stdClass":3:{s:9:"lastCheck";i:1428946163;s:14:"checkedVersion";s:3:"1.1";s:6:"update";N;}', 'yes'),
(120, 'recently_activated', 'a:0:{}', 'yes'),
(122, '_site_transient_update_plugins', 'O:8:"stdClass":5:{s:12:"last_checked";i:1428946248;s:7:"checked";a:6:{s:19:"akismet/akismet.php";s:5:"3.1.1";s:9:"hello.php";s:3:"1.6";s:52:"testimonials-by-woothemes/woothemes-testimonials.php";s:5:"1.5.3";s:27:"woocommerce/woocommerce.php";s:5:"2.3.7";s:55:"woocommerce-dropdown-cart/woocommerce-dropdown-cart.php";s:5:"1.3.1";s:27:"wp-pagenavi/wp-pagenavi.php";s:4:"2.87";}s:8:"response";a:0:{}s:12:"translations";a:0:{}s:9:"no_update";a:6:{s:19:"akismet/akismet.php";O:8:"stdClass":6:{s:2:"id";s:2:"15";s:4:"slug";s:7:"akismet";s:6:"plugin";s:19:"akismet/akismet.php";s:11:"new_version";s:5:"3.1.1";s:3:"url";s:38:"https://wordpress.org/plugins/akismet/";s:7:"package";s:56:"https://downloads.wordpress.org/plugin/akismet.3.1.1.zip";}s:9:"hello.php";O:8:"stdClass":6:{s:2:"id";s:4:"3564";s:4:"slug";s:11:"hello-dolly";s:6:"plugin";s:9:"hello.php";s:11:"new_version";s:3:"1.6";s:3:"url";s:42:"https://wordpress.org/plugins/hello-dolly/";s:7:"package";s:58:"https://downloads.wordpress.org/plugin/hello-dolly.1.6.zip";}s:52:"testimonials-by-woothemes/woothemes-testimonials.php";O:8:"stdClass":6:{s:2:"id";s:5:"35636";s:4:"slug";s:25:"testimonials-by-woothemes";s:6:"plugin";s:52:"testimonials-by-woothemes/woothemes-testimonials.php";s:11:"new_version";s:5:"1.5.3";s:3:"url";s:56:"https://wordpress.org/plugins/testimonials-by-woothemes/";s:7:"package";s:74:"https://downloads.wordpress.org/plugin/testimonials-by-woothemes.1.5.3.zip";}s:27:"woocommerce/woocommerce.php";O:8:"stdClass":6:{s:2:"id";s:5:"25331";s:4:"slug";s:11:"woocommerce";s:6:"plugin";s:27:"woocommerce/woocommerce.php";s:11:"new_version";s:5:"2.3.7";s:3:"url";s:42:"https://wordpress.org/plugins/woocommerce/";s:7:"package";s:60:"https://downloads.wordpress.org/plugin/woocommerce.2.3.7.zip";}s:55:"woocommerce-dropdown-cart/woocommerce-dropdown-cart.php";O:8:"stdClass":6:{s:2:"id";s:5:"36977";s:4:"slug";s:25:"woocommerce-dropdown-cart";s:6:"plugin";s:55:"woocommerce-dropdown-cart/woocommerce-dropdown-cart.php";s:11:"new_version";s:5:"1.3.1";s:3:"url";s:56:"https://wordpress.org/plugins/woocommerce-dropdown-cart/";s:7:"package";s:74:"https://downloads.wordpress.org/plugin/woocommerce-dropdown-cart.1.3.1.zip";}s:27:"wp-pagenavi/wp-pagenavi.php";O:8:"stdClass":6:{s:2:"id";s:3:"363";s:4:"slug";s:11:"wp-pagenavi";s:6:"plugin";s:27:"wp-pagenavi/wp-pagenavi.php";s:11:"new_version";s:4:"2.87";s:3:"url";s:42:"https://wordpress.org/plugins/wp-pagenavi/";s:7:"package";s:59:"https://downloads.wordpress.org/plugin/wp-pagenavi.2.87.zip";}}}', 'yes'),
(123, 'woothemes-testimonials-version', '1.5.3', 'yes'),
(124, 'woocommerce_default_country', 'US:NY', 'yes'),
(125, 'woocommerce_allowed_countries', 'all', 'yes'),
(126, 'woocommerce_specific_allowed_countries', 'a:0:{}', 'yes'),
(127, 'woocommerce_default_customer_address', 'geolocation', 'yes'),
(128, 'woocommerce_demo_store', 'no', 'yes'),
(129, 'woocommerce_demo_store_notice', 'This is a demo store for testing purposes — no orders shall be fulfilled.', 'no'),
(130, 'woocommerce_api_enabled', 'yes', 'yes'),
(131, 'woocommerce_currency', 'USD', 'yes'),
(132, 'woocommerce_currency_pos', 'left', 'yes'),
(133, 'woocommerce_price_thousand_sep', ',', 'yes'),
(134, 'woocommerce_price_decimal_sep', '.', 'yes'),
(135, 'woocommerce_price_num_decimals', '2', 'yes'),
(136, 'woocommerce_weight_unit', 'kg', 'yes'),
(137, 'woocommerce_dimension_unit', 'cm', 'yes'),
(138, 'woocommerce_enable_review_rating', 'yes', 'no'),
(139, 'woocommerce_review_rating_required', 'yes', 'no'),
(140, 'woocommerce_review_rating_verification_label', 'yes', 'no'),
(141, 'woocommerce_review_rating_verification_required', 'no', 'no'),
(142, 'woocommerce_shop_page_id', '4', 'yes'),
(143, 'woocommerce_shop_page_display', '', 'yes'),
(144, 'woocommerce_category_archive_display', '', 'yes'),
(145, 'woocommerce_default_catalog_orderby', 'menu_order', 'yes'),
(146, 'woocommerce_cart_redirect_after_add', 'no', 'yes'),
(147, 'woocommerce_enable_ajax_add_to_cart', 'yes', 'yes'),
(148, 'woocommerce_enable_lightbox', 'yes', 'yes'),
(149, 'woocommerce_manage_stock', 'yes', 'yes'),
(150, 'woocommerce_hold_stock_minutes', '60', 'no'),
(151, 'woocommerce_notify_low_stock', 'yes', 'no'),
(152, 'woocommerce_notify_no_stock', 'yes', 'no'),
(153, 'woocommerce_stock_email_recipient', 'cartel@gmail.com', 'no'),
(154, 'woocommerce_notify_low_stock_amount', '2', 'no'),
(155, 'woocommerce_notify_no_stock_amount', '0', 'no'),
(156, 'woocommerce_hide_out_of_stock_items', 'no', 'yes'),
(157, 'woocommerce_stock_format', '', 'yes'),
(158, 'woocommerce_file_download_method', 'force', 'no'),
(159, 'woocommerce_downloads_require_login', 'no', 'no'),
(160, 'woocommerce_downloads_grant_access_after_payment', 'yes', 'no'),
(161, 'woocommerce_calc_taxes', 'no', 'yes'),
(162, 'woocommerce_prices_include_tax', 'no', 'yes'),
(163, 'woocommerce_tax_based_on', 'shipping', 'yes'),
(164, 'woocommerce_shipping_tax_class', 'title', 'yes'),
(165, 'woocommerce_tax_round_at_subtotal', 'no', 'yes'),
(166, 'woocommerce_tax_classes', 'Reduced Rate\r\nZero Rate', 'yes'),
(167, 'woocommerce_tax_display_shop', 'excl', 'yes'),
(168, 'woocommerce_tax_display_cart', 'excl', 'no'),
(169, 'woocommerce_price_display_suffix', '', 'yes'),
(170, 'woocommerce_tax_total_display', 'itemized', 'no'),
(171, 'woocommerce_enable_coupons', 'yes', 'no'),
(172, 'woocommerce_enable_guest_checkout', 'yes', 'no'),
(173, 'woocommerce_force_ssl_checkout', 'no', 'yes'),
(174, 'woocommerce_unforce_ssl_checkout', 'no', 'yes'),
(175, 'woocommerce_cart_page_id', '5', 'yes'),
(176, 'woocommerce_checkout_page_id', '6', 'yes'),
(177, 'woocommerce_terms_page_id', '', 'no'),
(178, 'woocommerce_checkout_pay_endpoint', 'order-pay', 'yes'),
(179, 'woocommerce_checkout_order_received_endpoint', 'order-received', 'yes'),
(180, 'woocommerce_myaccount_add_payment_method_endpoint', 'add-payment-method', 'yes'),
(181, 'woocommerce_calc_shipping', 'yes', 'yes'),
(182, 'woocommerce_enable_shipping_calc', 'yes', 'no'),
(183, 'woocommerce_shipping_cost_requires_address', 'no', 'no'),
(184, 'woocommerce_shipping_method_format', '', 'no'),
(185, 'woocommerce_ship_to_destination', 'billing', 'no'),
(186, 'woocommerce_ship_to_countries', '', 'yes'),
(187, 'woocommerce_specific_ship_to_countries', '', 'yes'),
(188, 'woocommerce_myaccount_page_id', '7', 'yes'),
(189, 'woocommerce_myaccount_view_order_endpoint', 'view-order', 'yes'),
(190, 'woocommerce_myaccount_edit_account_endpoint', 'edit-account', 'yes'),
(191, 'woocommerce_myaccount_edit_address_endpoint', 'edit-address', 'yes'),
(192, 'woocommerce_myaccount_lost_password_endpoint', 'lost-password', 'yes'),
(193, 'woocommerce_logout_endpoint', 'customer-logout', 'yes'),
(194, 'woocommerce_enable_signup_and_login_from_checkout', 'yes', 'no'),
(195, 'woocommerce_enable_myaccount_registration', 'no', 'no'),
(196, 'woocommerce_enable_checkout_login_reminder', 'yes', 'no'),
(197, 'woocommerce_registration_generate_username', 'yes', 'no'),
(198, 'woocommerce_registration_generate_password', 'no', 'no'),
(199, 'woocommerce_email_from_name', 'Cartel', 'no'),
(200, 'woocommerce_email_from_address', 'cartel@gmail.com', 'no'),
(201, 'woocommerce_email_header_image', '', 'no'),
(202, 'woocommerce_email_footer_text', 'Cartel - Powered by WooCommerce', 'no'),
(203, 'woocommerce_email_base_color', '#557da1', 'no'),
(204, 'woocommerce_email_background_color', '#f5f5f5', 'no'),
(205, 'woocommerce_email_body_background_color', '#fdfdfd', 'no'),
(206, 'woocommerce_email_text_color', '#505050', 'no'),
(208, 'woocommerce_db_version', '2.3.7', 'yes'),
(209, 'woocommerce_version', '2.3.7', 'yes'),
(210, 'woocommerce_admin_notices', 'a:1:{i:2;s:14:"template_files";}', 'yes'),
(213, 'woocommerce_language_pack_version', 'a:2:{i:0;s:5:"2.3.7";i:1;s:5:"en_US";}', 'yes'),
(215, '_transient_woocommerce_webhook_ids', 'a:0:{}', 'yes'),
(216, '_transient_wc_attribute_taxonomies', 'a:0:{}', 'yes'),
(218, 'woocommerce_meta_box_errors', 'a:0:{}', 'yes'),
(219, 'woocommerce_allow_tracking', 'yes', 'yes'),
(220, 'woocommerce_tracker_last_send', '1428946322', 'yes'),
(221, 'pagenavi_options', 'a:15:{s:10:"pages_text";s:36:"Page %CURRENT_PAGE% of %TOTAL_PAGES%";s:12:"current_text";s:13:"%PAGE_NUMBER%";s:9:"page_text";s:13:"%PAGE_NUMBER%";s:10:"first_text";s:13:"&laquo; First";s:9:"last_text";s:12:"Last &raquo;";s:9:"prev_text";s:7:"&laquo;";s:9:"next_text";s:7:"&raquo;";s:12:"dotleft_text";s:3:"...";s:13:"dotright_text";s:3:"...";s:9:"num_pages";i:5;s:23:"num_larger_page_numbers";i:3;s:28:"larger_page_numbers_multiple";i:10;s:11:"always_show";b:0;s:16:"use_pagenavi_css";b:1;s:5:"style";i:1;}', 'yes'),
(222, '_transient_timeout_geoip_::1', '1429551148', 'no'),
(223, '_transient_geoip_::1', '', 'no'),
(224, '_transient_timeout_external_ip_address_::1', '1429551149', 'no'),
(225, '_transient_external_ip_address_::1', '117.198.82.131', 'no'),
(226, '_transient_timeout_geoip_117.198.82.131', '1429551150', 'no'),
(227, '_transient_geoip_117.198.82.131', 'IN', 'no'),
(230, 'ffref', '374029', 'yes'),
(231, 'fflink', 'Website by Wordpress', 'yes'),
(234, '_transient_product_query-transient-version', '1428952349', 'yes'),
(237, '_site_transient_timeout_browser_8573ab448203183ab7511e8ef5367263', '1429551407', 'yes'),
(238, '_site_transient_browser_8573ab448203183ab7511e8ef5367263', 'a:9:{s:8:"platform";s:7:"Windows";s:4:"name";s:7:"Firefox";s:7:"version";s:4:"37.0";s:10:"update_url";s:23:"http://www.firefox.com/";s:7:"img_src";s:50:"http://s.wordpress.org/images/browsers/firefox.png";s:11:"img_src_ssl";s:49:"https://wordpress.org/images/browsers/firefox.png";s:15:"current_version";s:2:"16";s:7:"upgrade";b:0;s:8:"insecure";b:0;}', 'yes'),
(243, '_transient_timeout_wc_admin_report', '1429033008', 'no'),
(244, '_transient_wc_admin_report', 'a:1:{s:32:"db19cc44194d251ffb1cd28b27cee2b2";a:0:{}}', 'no'),
(252, 'widget_cartel_widget', 'a:4:{i:2;a:3:{s:5:"title";s:13:"Free shipping";s:4:"icon";s:13:"fa-envelope-o";s:4:"text";s:168:"Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptuat vero eos et ";}i:3;a:3:{s:5:"title";s:13:"30 day refund";s:4:"icon";s:20:"fa-arrow-circle-o-up";s:4:"text";s:190:"At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing ";}i:4;a:3:{s:5:"title";s:22:"International delivery";s:4:"icon";s:8:"fa-heart";s:4:"text";s:176:"Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in ";}s:12:"_multiwidget";i:1;}', 'yes'),
(253, '_site_transient_timeout_available_translations', '1428957655', 'yes'),
(254, '_site_transient_available_translations', 'a:53:{s:2:"ar";a:8:{s:8:"language";s:2:"ar";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-04-01 13:21:43";s:12:"english_name";s:6:"Arabic";s:11:"native_name";s:14:"العربية";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.1.1/ar.zip";s:3:"iso";a:2:{i:1;s:2:"ar";i:2;s:3:"ara";}s:7:"strings";a:1:{s:8:"continue";s:16:"المتابعة";}}s:2:"az";a:8:{s:8:"language";s:2:"az";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:15:41";s:12:"english_name";s:11:"Azerbaijani";s:11:"native_name";s:16:"Azərbaycan dili";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.1.1/az.zip";s:3:"iso";a:2:{i:1;s:2:"az";i:2;s:3:"aze";}s:7:"strings";a:1:{s:8:"continue";s:5:"Davam";}}s:5:"bg_BG";a:8:{s:8:"language";s:5:"bg_BG";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:19:26";s:12:"english_name";s:9:"Bulgarian";s:11:"native_name";s:18:"Български";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/bg_BG.zip";s:3:"iso";a:2:{i:1;s:2:"bg";i:2;s:3:"bul";}s:7:"strings";a:1:{s:8:"continue";s:22:"Продължение";}}s:5:"bs_BA";a:8:{s:8:"language";s:5:"bs_BA";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:22:49";s:12:"english_name";s:7:"Bosnian";s:11:"native_name";s:8:"Bosanski";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/bs_BA.zip";s:3:"iso";a:2:{i:1;s:2:"bs";i:2;s:3:"bos";}s:7:"strings";a:1:{s:8:"continue";s:7:"Nastavi";}}s:2:"ca";a:8:{s:8:"language";s:2:"ca";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:24:48";s:12:"english_name";s:7:"Catalan";s:11:"native_name";s:7:"Català";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.1.1/ca.zip";s:3:"iso";a:2:{i:1;s:2:"ca";i:2;s:3:"cat";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continua";}}s:2:"cy";a:8:{s:8:"language";s:2:"cy";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:30:22";s:12:"english_name";s:5:"Welsh";s:11:"native_name";s:7:"Cymraeg";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.1.1/cy.zip";s:3:"iso";a:2:{i:1;s:2:"cy";i:2;s:3:"cym";}s:7:"strings";a:1:{s:8:"continue";s:6:"Parhau";}}s:5:"da_DK";a:8:{s:8:"language";s:5:"da_DK";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:32:23";s:12:"english_name";s:6:"Danish";s:11:"native_name";s:5:"Dansk";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/da_DK.zip";s:3:"iso";a:2:{i:1;s:2:"da";i:2;s:3:"dan";}s:7:"strings";a:1:{s:8:"continue";s:12:"Forts&#230;t";}}s:5:"de_DE";a:8:{s:8:"language";s:5:"de_DE";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:34:24";s:12:"english_name";s:6:"German";s:11:"native_name";s:7:"Deutsch";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/de_DE.zip";s:3:"iso";a:1:{i:1;s:2:"de";}s:7:"strings";a:1:{s:8:"continue";s:10:"Fortfahren";}}s:5:"de_CH";a:8:{s:8:"language";s:5:"de_CH";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:38:25";s:12:"english_name";s:20:"German (Switzerland)";s:11:"native_name";s:17:"Deutsch (Schweiz)";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/de_CH.zip";s:3:"iso";a:1:{i:1;s:2:"de";}s:7:"strings";a:1:{s:8:"continue";s:10:"Fortfahren";}}s:2:"el";a:8:{s:8:"language";s:2:"el";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:40:46";s:12:"english_name";s:5:"Greek";s:11:"native_name";s:16:"Ελληνικά";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.1.1/el.zip";s:3:"iso";a:2:{i:1;s:2:"el";i:2;s:3:"ell";}s:7:"strings";a:1:{s:8:"continue";s:16:"Συνέχεια";}}s:5:"en_CA";a:8:{s:8:"language";s:5:"en_CA";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:44:26";s:12:"english_name";s:16:"English (Canada)";s:11:"native_name";s:16:"English (Canada)";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/en_CA.zip";s:3:"iso";a:3:{i:1;s:2:"en";i:2;s:3:"eng";i:3;s:3:"eng";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continue";}}s:5:"en_GB";a:8:{s:8:"language";s:5:"en_GB";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:46:15";s:12:"english_name";s:12:"English (UK)";s:11:"native_name";s:12:"English (UK)";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/en_GB.zip";s:3:"iso";a:3:{i:1;s:2:"en";i:2;s:3:"eng";i:3;s:3:"eng";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continue";}}s:5:"en_AU";a:8:{s:8:"language";s:5:"en_AU";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:42:35";s:12:"english_name";s:19:"English (Australia)";s:11:"native_name";s:19:"English (Australia)";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/en_AU.zip";s:3:"iso";a:3:{i:1;s:2:"en";i:2;s:3:"eng";i:3;s:3:"eng";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continue";}}s:2:"eo";a:8:{s:8:"language";s:2:"eo";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:48:12";s:12:"english_name";s:9:"Esperanto";s:11:"native_name";s:9:"Esperanto";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.1.1/eo.zip";s:3:"iso";a:2:{i:1;s:2:"eo";i:2;s:3:"epo";}s:7:"strings";a:1:{s:8:"continue";s:8:"Daŭrigi";}}s:5:"es_MX";a:8:{s:8:"language";s:5:"es_MX";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:54:32";s:12:"english_name";s:16:"Spanish (Mexico)";s:11:"native_name";s:19:"Español de México";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/es_MX.zip";s:3:"iso";a:2:{i:1;s:2:"es";i:2;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"es_PE";a:8:{s:8:"language";s:5:"es_PE";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:56:31";s:12:"english_name";s:14:"Spanish (Peru)";s:11:"native_name";s:17:"Español de Perú";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/es_PE.zip";s:3:"iso";a:2:{i:1;s:2:"es";i:2;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"es_ES";a:8:{s:8:"language";s:5:"es_ES";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 14:50:12";s:12:"english_name";s:15:"Spanish (Spain)";s:11:"native_name";s:8:"Español";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/es_ES.zip";s:3:"iso";a:1:{i:1;s:2:"es";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"es_CL";a:8:{s:8:"language";s:5:"es_CL";s:7:"version";s:3:"4.0";s:7:"updated";s:19:"2014-09-04 19:47:01";s:12:"english_name";s:15:"Spanish (Chile)";s:11:"native_name";s:17:"Español de Chile";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/4.0/es_CL.zip";s:3:"iso";a:2:{i:1;s:2:"es";i:2;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:2:"eu";a:8:{s:8:"language";s:2:"eu";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-27 08:55:29";s:12:"english_name";s:6:"Basque";s:11:"native_name";s:7:"Euskara";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.1.1/eu.zip";s:3:"iso";a:2:{i:1;s:2:"eu";i:2;s:3:"eus";}s:7:"strings";a:1:{s:8:"continue";s:8:"Jarraitu";}}s:5:"fa_IR";a:8:{s:8:"language";s:5:"fa_IR";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 15:03:17";s:12:"english_name";s:7:"Persian";s:11:"native_name";s:10:"فارسی";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/fa_IR.zip";s:3:"iso";a:2:{i:1;s:2:"fa";i:2;s:3:"fas";}s:7:"strings";a:1:{s:8:"continue";s:10:"ادامه";}}s:2:"fi";a:8:{s:8:"language";s:2:"fi";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-18 08:12:21";s:12:"english_name";s:7:"Finnish";s:11:"native_name";s:5:"Suomi";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.1.1/fi.zip";s:3:"iso";a:2:{i:1;s:2:"fi";i:2;s:3:"fin";}s:7:"strings";a:1:{s:8:"continue";s:5:"Jatka";}}s:5:"fr_FR";a:8:{s:8:"language";s:5:"fr_FR";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 15:08:29";s:12:"english_name";s:15:"French (France)";s:11:"native_name";s:9:"Français";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/fr_FR.zip";s:3:"iso";a:1:{i:1;s:2:"fr";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuer";}}s:2:"gd";a:8:{s:8:"language";s:2:"gd";s:7:"version";s:3:"4.0";s:7:"updated";s:19:"2014-09-05 17:37:43";s:12:"english_name";s:15:"Scottish Gaelic";s:11:"native_name";s:9:"Gàidhlig";s:7:"package";s:59:"https://downloads.wordpress.org/translation/core/4.0/gd.zip";s:3:"iso";a:3:{i:1;s:2:"gd";i:2;s:3:"gla";i:3;s:3:"gla";}s:7:"strings";a:1:{s:8:"continue";s:15:"Lean air adhart";}}s:5:"gl_ES";a:8:{s:8:"language";s:5:"gl_ES";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 15:14:57";s:12:"english_name";s:8:"Galician";s:11:"native_name";s:6:"Galego";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/gl_ES.zip";s:3:"iso";a:2:{i:1;s:2:"gl";i:2;s:3:"glg";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:3:"haz";a:8:{s:8:"language";s:3:"haz";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 15:20:27";s:12:"english_name";s:8:"Hazaragi";s:11:"native_name";s:15:"هزاره گی";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/4.1.1/haz.zip";s:3:"iso";a:2:{i:1;s:3:"haz";i:2;s:3:"haz";}s:7:"strings";a:1:{s:8:"continue";s:10:"ادامه";}}s:5:"he_IL";a:8:{s:8:"language";s:5:"he_IL";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-04-08 22:28:26";s:12:"english_name";s:6:"Hebrew";s:11:"native_name";s:16:"עִבְרִית";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/he_IL.zip";s:3:"iso";a:1:{i:1;s:2:"he";}s:7:"strings";a:1:{s:8:"continue";s:12:"להמשיך";}}s:2:"hr";a:8:{s:8:"language";s:2:"hr";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 15:25:25";s:12:"english_name";s:8:"Croatian";s:11:"native_name";s:8:"Hrvatski";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.1.1/hr.zip";s:3:"iso";a:2:{i:1;s:2:"hr";i:2;s:3:"hrv";}s:7:"strings";a:1:{s:8:"continue";s:7:"Nastavi";}}s:5:"hu_HU";a:8:{s:8:"language";s:5:"hu_HU";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 15:27:28";s:12:"english_name";s:9:"Hungarian";s:11:"native_name";s:6:"Magyar";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/hu_HU.zip";s:3:"iso";a:2:{i:1;s:2:"hu";i:2;s:3:"hun";}s:7:"strings";a:1:{s:8:"continue";s:7:"Tovább";}}s:5:"id_ID";a:8:{s:8:"language";s:5:"id_ID";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 15:29:34";s:12:"english_name";s:10:"Indonesian";s:11:"native_name";s:16:"Bahasa Indonesia";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/id_ID.zip";s:3:"iso";a:2:{i:1;s:2:"id";i:2;s:3:"ind";}s:7:"strings";a:1:{s:8:"continue";s:9:"Lanjutkan";}}s:5:"is_IS";a:8:{s:8:"language";s:5:"is_IS";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-15 22:23:37";s:12:"english_name";s:9:"Icelandic";s:11:"native_name";s:9:"Íslenska";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/is_IS.zip";s:3:"iso";a:2:{i:1;s:2:"is";i:2;s:3:"isl";}s:7:"strings";a:1:{s:8:"continue";s:6:"Áfram";}}s:5:"it_IT";a:8:{s:8:"language";s:5:"it_IT";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 15:33:39";s:12:"english_name";s:7:"Italian";s:11:"native_name";s:8:"Italiano";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/it_IT.zip";s:3:"iso";a:2:{i:1;s:2:"it";i:2;s:3:"ita";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continua";}}s:2:"ja";a:8:{s:8:"language";s:2:"ja";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 15:35:42";s:12:"english_name";s:8:"Japanese";s:11:"native_name";s:9:"日本語";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.1.1/ja.zip";s:3:"iso";a:1:{i:1;s:2:"ja";}s:7:"strings";a:1:{s:8:"continue";s:9:"続ける";}}s:5:"ko_KR";a:8:{s:8:"language";s:5:"ko_KR";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 15:43:18";s:12:"english_name";s:6:"Korean";s:11:"native_name";s:9:"한국어";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/ko_KR.zip";s:3:"iso";a:2:{i:1;s:2:"ko";i:2;s:3:"kor";}s:7:"strings";a:1:{s:8:"continue";s:6:"계속";}}s:5:"lt_LT";a:8:{s:8:"language";s:5:"lt_LT";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 15:47:56";s:12:"english_name";s:10:"Lithuanian";s:11:"native_name";s:15:"Lietuvių kalba";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/lt_LT.zip";s:3:"iso";a:2:{i:1;s:2:"lt";i:2;s:3:"lit";}s:7:"strings";a:1:{s:8:"continue";s:6:"Tęsti";}}s:5:"my_MM";a:8:{s:8:"language";s:5:"my_MM";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 15:57:42";s:12:"english_name";s:7:"Burmese";s:11:"native_name";s:15:"ဗမာစာ";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/my_MM.zip";s:3:"iso";a:2:{i:1;s:2:"my";i:2;s:3:"mya";}s:7:"strings";a:1:{s:8:"continue";s:54:"ဆက်လက်လုပ်ေဆာင်ပါ။";}}s:5:"nb_NO";a:8:{s:8:"language";s:5:"nb_NO";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 15:59:41";s:12:"english_name";s:19:"Norwegian (Bokmål)";s:11:"native_name";s:13:"Norsk bokmål";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/nb_NO.zip";s:3:"iso";a:2:{i:1;s:2:"nb";i:2;s:3:"nob";}s:7:"strings";a:1:{s:8:"continue";s:8:"Fortsett";}}s:5:"nl_NL";a:8:{s:8:"language";s:5:"nl_NL";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 16:02:30";s:12:"english_name";s:5:"Dutch";s:11:"native_name";s:10:"Nederlands";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/nl_NL.zip";s:3:"iso";a:2:{i:1;s:2:"nl";i:2;s:3:"nld";}s:7:"strings";a:1:{s:8:"continue";s:8:"Doorgaan";}}s:5:"pl_PL";a:8:{s:8:"language";s:5:"pl_PL";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 16:07:08";s:12:"english_name";s:6:"Polish";s:11:"native_name";s:6:"Polski";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/pl_PL.zip";s:3:"iso";a:2:{i:1;s:2:"pl";i:2;s:3:"pol";}s:7:"strings";a:1:{s:8:"continue";s:9:"Kontynuuj";}}s:2:"ps";a:8:{s:8:"language";s:2:"ps";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-29 22:19:48";s:12:"english_name";s:6:"Pashto";s:11:"native_name";s:8:"پښتو";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.1.1/ps.zip";s:3:"iso";a:1:{i:1;s:2:"ps";}s:7:"strings";a:1:{s:8:"continue";s:8:"دوام";}}s:5:"pt_PT";a:8:{s:8:"language";s:5:"pt_PT";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 16:11:07";s:12:"english_name";s:21:"Portuguese (Portugal)";s:11:"native_name";s:10:"Português";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/pt_PT.zip";s:3:"iso";a:1:{i:1;s:2:"pt";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"pt_BR";a:8:{s:8:"language";s:5:"pt_BR";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 16:14:41";s:12:"english_name";s:19:"Portuguese (Brazil)";s:11:"native_name";s:20:"Português do Brasil";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/pt_BR.zip";s:3:"iso";a:2:{i:1;s:2:"pt";i:2;s:3:"por";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"ro_RO";a:8:{s:8:"language";s:5:"ro_RO";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-27 14:48:56";s:12:"english_name";s:8:"Romanian";s:11:"native_name";s:8:"Română";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/ro_RO.zip";s:3:"iso";a:2:{i:1;s:2:"ro";i:2;s:3:"ron";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuă";}}s:5:"ru_RU";a:8:{s:8:"language";s:5:"ru_RU";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 16:19:48";s:12:"english_name";s:7:"Russian";s:11:"native_name";s:14:"Русский";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/ru_RU.zip";s:3:"iso";a:2:{i:1;s:2:"ru";i:2;s:3:"rus";}s:7:"strings";a:1:{s:8:"continue";s:20:"Продолжить";}}s:5:"sk_SK";a:8:{s:8:"language";s:5:"sk_SK";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 16:23:44";s:12:"english_name";s:6:"Slovak";s:11:"native_name";s:11:"Slovenčina";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/sk_SK.zip";s:3:"iso";a:2:{i:1;s:2:"sk";i:2;s:3:"slk";}s:7:"strings";a:1:{s:8:"continue";s:12:"Pokračovať";}}s:5:"sl_SI";a:8:{s:8:"language";s:5:"sl_SI";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 16:25:46";s:12:"english_name";s:9:"Slovenian";s:11:"native_name";s:13:"Slovenščina";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/sl_SI.zip";s:3:"iso";a:2:{i:1;s:2:"sl";i:2;s:3:"slv";}s:7:"strings";a:1:{s:8:"continue";s:10:"Nadaljujte";}}s:5:"sr_RS";a:8:{s:8:"language";s:5:"sr_RS";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 16:30:35";s:12:"english_name";s:7:"Serbian";s:11:"native_name";s:23:"Српски језик";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/sr_RS.zip";s:3:"iso";a:2:{i:1;s:2:"sr";i:2;s:3:"srp";}s:7:"strings";a:1:{s:8:"continue";s:14:"Настави";}}s:5:"sv_SE";a:8:{s:8:"language";s:5:"sv_SE";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 16:33:33";s:12:"english_name";s:7:"Swedish";s:11:"native_name";s:7:"Svenska";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/sv_SE.zip";s:3:"iso";a:2:{i:1;s:2:"sv";i:2;s:3:"swe";}s:7:"strings";a:1:{s:8:"continue";s:9:"Fortsätt";}}s:2:"th";a:8:{s:8:"language";s:2:"th";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-27 00:00:51";s:12:"english_name";s:4:"Thai";s:11:"native_name";s:9:"ไทย";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.1.1/th.zip";s:3:"iso";a:2:{i:1;s:2:"th";i:2;s:3:"tha";}s:7:"strings";a:1:{s:8:"continue";s:15:"ต่อไป";}}s:5:"tr_TR";a:8:{s:8:"language";s:5:"tr_TR";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 16:43:10";s:12:"english_name";s:7:"Turkish";s:11:"native_name";s:8:"Türkçe";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/tr_TR.zip";s:3:"iso";a:2:{i:1;s:2:"tr";i:2;s:3:"tur";}s:7:"strings";a:1:{s:8:"continue";s:5:"Devam";}}s:5:"ug_CN";a:8:{s:8:"language";s:5:"ug_CN";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 16:45:38";s:12:"english_name";s:6:"Uighur";s:11:"native_name";s:9:"Uyƣurqə";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/ug_CN.zip";s:3:"iso";a:2:{i:1;s:2:"ug";i:2;s:3:"uig";}s:7:"strings";a:1:{s:8:"continue";s:26:"داۋاملاشتۇرۇش";}}s:2:"uk";a:8:{s:8:"language";s:2:"uk";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-04-10 12:55:55";s:12:"english_name";s:9:"Ukrainian";s:11:"native_name";s:20:"Українська";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.1.1/uk.zip";s:3:"iso";a:2:{i:1;s:2:"uk";i:2;s:3:"ukr";}s:7:"strings";a:1:{s:8:"continue";s:20:"Продовжити";}}s:5:"zh_TW";a:8:{s:8:"language";s:5:"zh_TW";s:7:"version";s:5:"4.1.1";s:7:"updated";s:19:"2015-03-26 16:55:15";s:12:"english_name";s:16:"Chinese (Taiwan)";s:11:"native_name";s:12:"繁體中文";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.1.1/zh_TW.zip";s:3:"iso";a:2:{i:1;s:2:"zh";i:2;s:3:"zho";}s:7:"strings";a:1:{s:8:"continue";s:6:"繼續";}}s:5:"zh_CN";a:8:{s:8:"language";s:5:"zh_CN";s:7:"version";s:3:"4.1";s:7:"updated";s:19:"2014-12-26 02:21:02";s:12:"english_name";s:15:"Chinese (China)";s:11:"native_name";s:12:"简体中文";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/4.1/zh_CN.zip";s:3:"iso";a:2:{i:1;s:2:"zh";i:2;s:3:"zho";}s:7:"strings";a:1:{s:8:"continue";s:6:"继续";}}}', 'yes');
INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(259, 'ft_cartel', 'a:29:{s:11:"header_text";s:14:"MADISON ISLAND";s:11:"footer_text";s:14:"MADISON ISLAND";s:18:"subhead_background";s:0:"";s:12:"slide_number";s:1:"3";s:17:"banner_background";s:81:"http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/wallpaper-724473.jpg";s:13:"banner_image1";s:76:"http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/BN3-720x400.jpg";s:12:"banner_link1";s:0:"";s:13:"banner_image2";s:77:"http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/BAN2-720x400.jpg";s:12:"banner_link2";s:0:"";s:13:"banner_image3";s:77:"http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/BAN1-720x400.jpg";s:12:"banner_link3";s:0:"";s:15:"blog_background";s:82:"http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/wallpaper-2067766.jpg";s:13:"testim_number";s:1:"3";s:17:"fabthemes_banner1";s:96:"http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/homepage-three-column-promo-01B.png";s:14:"fabthemes_alt1";s:12:"SUMMER SALES";s:14:"fabthemes_url1";s:96:"http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/homepage-three-column-promo-01B.png";s:14:"fabthemes_lab1";s:12:"SUMMER SALES";s:17:"fabthemes_banner2";s:96:"http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/homepage-three-column-promo-01B.png";s:14:"fabthemes_alt2";s:16:"MEN''S COLLECTION";s:14:"fabthemes_url2";s:96:"http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/homepage-three-column-promo-01B.png";s:14:"fabthemes_lab2";s:16:"MEN''S COLLECTION";s:17:"fabthemes_banner3";s:96:"http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/homepage-three-column-promo-01B.png";s:14:"fabthemes_alt3";s:12:"NEW ARRIVALS";s:14:"fabthemes_url3";s:96:"http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/homepage-three-column-promo-01B.png";s:14:"fabthemes_lab3";s:12:"NEW ARRIVALS";s:17:"fabthemes_banner4";s:0:"";s:14:"fabthemes_alt4";s:0:"";s:14:"fabthemes_url4";s:0:"";s:14:"fabthemes_lab4";s:0:"";}', 'yes'),
(275, 'widget_pages', 'a:2:{i:2;a:3:{s:5:"title";s:12:"About Cartel";s:6:"sortby";s:2:"ID";s:7:"exclude";s:12:"2,4,7,10,6,5";}s:12:"_multiwidget";i:1;}', 'yes'),
(289, 'category_children', 'a:0:{}', 'yes'),
(291, 'woocommerce_permalinks', 'a:4:{s:13:"category_base";s:0:"";s:8:"tag_base";s:0:"";s:14:"attribute_base";s:0:"";s:12:"product_base";s:0:"";}', 'yes'),
(297, 'nav_menu_options', 'a:2:{i:0;b:0;s:8:"auto_add";a:0:{}}', 'yes'),
(301, '_transient_woocommerce_cache_excluded_uris', 'a:6:{i:0;s:3:"p=5";i:1;s:5:"/cart";i:2;s:3:"p=6";i:3;s:9:"/checkout";i:4;s:3:"p=7";i:5;s:11:"/my-account";}', 'yes'),
(303, '_transient_product-transient-version', '1428952349', 'yes'),
(307, '_transient_timeout_wc_rating_count_431428950024', '1431542047', 'no'),
(308, '_transient_wc_rating_count_431428950024', '0', 'no'),
(309, '_transient_timeout_wc_average_rating_431428950024', '1431542047', 'no'),
(310, '_transient_wc_average_rating_431428950024', '', 'no'),
(312, 'product_shipping_class_children', 'a:0:{}', 'yes'),
(313, '_transient_timeout_wc_review_count_431428950024', '1431542060', 'no'),
(314, '_transient_wc_review_count_431428950024', '0', 'no'),
(315, 'product_cat_children', 'a:0:{}', 'yes'),
(317, '_transient_timeout_wc_rating_count_431428950202', '1431542205', 'no'),
(318, '_transient_wc_rating_count_431428950202', '0', 'no'),
(319, '_transient_timeout_wc_review_count_431428950202', '1431542206', 'no'),
(320, '_transient_wc_review_count_431428950202', '0', 'no'),
(321, '_transient_timeout_wc_average_rating_431428950202', '1431542206', 'no'),
(322, '_transient_wc_average_rating_431428950202', '', 'no'),
(323, '_transient_timeout_wc_max_related_431428950202', '1431542206', 'no'),
(324, '_transient_wc_max_related_431428950202', '0', 'no'),
(328, '_transient_timeout_wc_rating_count_461428950751', '1431542755', 'no'),
(329, '_transient_wc_rating_count_461428950751', '0', 'no'),
(330, '_transient_timeout_wc_average_rating_461428950751', '1431542755', 'no'),
(331, '_transient_wc_average_rating_461428950751', '', 'no'),
(332, '_transient_timeout_wc_rating_count_431428950751', '1431542755', 'no'),
(333, '_transient_wc_rating_count_431428950751', '0', 'no'),
(334, '_transient_timeout_wc_average_rating_431428950751', '1431542755', 'no'),
(335, '_transient_wc_average_rating_431428950751', '', 'no'),
(337, '_transient_timeout_wc_rating_count_461428950780', '1431542783', 'no'),
(338, '_transient_wc_rating_count_461428950780', '0', 'no'),
(339, '_transient_timeout_wc_average_rating_461428950780', '1431542783', 'no'),
(340, '_transient_wc_average_rating_461428950780', '', 'no'),
(341, '_transient_timeout_wc_rating_count_431428950780', '1431542783', 'no'),
(342, '_transient_wc_rating_count_431428950780', '0', 'no'),
(343, '_transient_timeout_wc_average_rating_431428950780', '1431542783', 'no'),
(344, '_transient_wc_average_rating_431428950780', '', 'no'),
(345, 'rewrite_rules', 'a:210:{s:22:"^wc-api/v([1-2]{1})/?$";s:51:"index.php?wc-api-version=$matches[1]&wc-api-route=/";s:24:"^wc-api/v([1-2]{1})(.*)?";s:61:"index.php?wc-api-version=$matches[1]&wc-api-route=$matches[2]";s:7:"shop/?$";s:27:"index.php?post_type=product";s:37:"shop/feed/(feed|rdf|rss|rss2|atom)/?$";s:44:"index.php?post_type=product&feed=$matches[1]";s:32:"shop/(feed|rdf|rss|rss2|atom)/?$";s:44:"index.php?post_type=product&feed=$matches[1]";s:24:"shop/page/([0-9]{1,})/?$";s:45:"index.php?post_type=product&paged=$matches[1]";s:15:"testimonials/?$";s:31:"index.php?post_type=testimonial";s:45:"testimonials/feed/(feed|rdf|rss|rss2|atom)/?$";s:48:"index.php?post_type=testimonial&feed=$matches[1]";s:40:"testimonials/(feed|rdf|rss|rss2|atom)/?$";s:48:"index.php?post_type=testimonial&feed=$matches[1]";s:32:"testimonials/page/([0-9]{1,})/?$";s:49:"index.php?post_type=testimonial&paged=$matches[1]";s:47:"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:42:"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:35:"category/(.+?)/page/?([0-9]{1,})/?$";s:53:"index.php?category_name=$matches[1]&paged=$matches[2]";s:32:"category/(.+?)/wc-api(/(.*))?/?$";s:54:"index.php?category_name=$matches[1]&wc-api=$matches[3]";s:17:"category/(.+?)/?$";s:35:"index.php?category_name=$matches[1]";s:44:"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:39:"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:32:"tag/([^/]+)/page/?([0-9]{1,})/?$";s:43:"index.php?tag=$matches[1]&paged=$matches[2]";s:29:"tag/([^/]+)/wc-api(/(.*))?/?$";s:44:"index.php?tag=$matches[1]&wc-api=$matches[3]";s:14:"tag/([^/]+)/?$";s:25:"index.php?tag=$matches[1]";s:45:"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:40:"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:33:"type/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?post_format=$matches[1]&paged=$matches[2]";s:15:"type/([^/]+)/?$";s:33:"index.php?post_format=$matches[1]";s:33:"slide/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:43:"slide/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:63:"slide/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:58:"slide/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:58:"slide/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:26:"slide/([^/]+)/trackback/?$";s:32:"index.php?slide=$matches[1]&tb=1";s:34:"slide/([^/]+)/page/?([0-9]{1,})/?$";s:45:"index.php?slide=$matches[1]&paged=$matches[2]";s:41:"slide/([^/]+)/comment-page-([0-9]{1,})/?$";s:45:"index.php?slide=$matches[1]&cpage=$matches[2]";s:31:"slide/([^/]+)/wc-api(/(.*))?/?$";s:46:"index.php?slide=$matches[1]&wc-api=$matches[3]";s:37:"slide/[^/]+/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:48:"slide/[^/]+/attachment/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:26:"slide/([^/]+)(/[0-9]+)?/?$";s:44:"index.php?slide=$matches[1]&page=$matches[2]";s:22:"slide/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:32:"slide/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:52:"slide/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:47:"slide/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:47:"slide/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:55:"product-category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?product_cat=$matches[1]&feed=$matches[2]";s:50:"product-category/(.+?)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?product_cat=$matches[1]&feed=$matches[2]";s:43:"product-category/(.+?)/page/?([0-9]{1,})/?$";s:51:"index.php?product_cat=$matches[1]&paged=$matches[2]";s:25:"product-category/(.+?)/?$";s:33:"index.php?product_cat=$matches[1]";s:52:"product-tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?product_tag=$matches[1]&feed=$matches[2]";s:47:"product-tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?product_tag=$matches[1]&feed=$matches[2]";s:40:"product-tag/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?product_tag=$matches[1]&paged=$matches[2]";s:22:"product-tag/([^/]+)/?$";s:33:"index.php?product_tag=$matches[1]";s:35:"product/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:45:"product/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:65:"product/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:60:"product/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:60:"product/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:28:"product/([^/]+)/trackback/?$";s:34:"index.php?product=$matches[1]&tb=1";s:48:"product/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:46:"index.php?product=$matches[1]&feed=$matches[2]";s:43:"product/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:46:"index.php?product=$matches[1]&feed=$matches[2]";s:36:"product/([^/]+)/page/?([0-9]{1,})/?$";s:47:"index.php?product=$matches[1]&paged=$matches[2]";s:43:"product/([^/]+)/comment-page-([0-9]{1,})/?$";s:47:"index.php?product=$matches[1]&cpage=$matches[2]";s:33:"product/([^/]+)/wc-api(/(.*))?/?$";s:48:"index.php?product=$matches[1]&wc-api=$matches[3]";s:39:"product/[^/]+/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:50:"product/[^/]+/attachment/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:28:"product/([^/]+)(/[0-9]+)?/?$";s:46:"index.php?product=$matches[1]&page=$matches[2]";s:24:"product/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:34:"product/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:54:"product/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:49:"product/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:49:"product/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:45:"product_variation/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:55:"product_variation/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:75:"product_variation/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:70:"product_variation/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:70:"product_variation/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:38:"product_variation/([^/]+)/trackback/?$";s:44:"index.php?product_variation=$matches[1]&tb=1";s:46:"product_variation/([^/]+)/page/?([0-9]{1,})/?$";s:57:"index.php?product_variation=$matches[1]&paged=$matches[2]";s:53:"product_variation/([^/]+)/comment-page-([0-9]{1,})/?$";s:57:"index.php?product_variation=$matches[1]&cpage=$matches[2]";s:43:"product_variation/([^/]+)/wc-api(/(.*))?/?$";s:58:"index.php?product_variation=$matches[1]&wc-api=$matches[3]";s:49:"product_variation/[^/]+/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:60:"product_variation/[^/]+/attachment/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:38:"product_variation/([^/]+)(/[0-9]+)?/?$";s:56:"index.php?product_variation=$matches[1]&page=$matches[2]";s:34:"product_variation/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:44:"product_variation/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:64:"product_variation/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:59:"product_variation/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:59:"product_variation/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:45:"shop_order_refund/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:55:"shop_order_refund/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:75:"shop_order_refund/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:70:"shop_order_refund/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:70:"shop_order_refund/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:38:"shop_order_refund/([^/]+)/trackback/?$";s:44:"index.php?shop_order_refund=$matches[1]&tb=1";s:46:"shop_order_refund/([^/]+)/page/?([0-9]{1,})/?$";s:57:"index.php?shop_order_refund=$matches[1]&paged=$matches[2]";s:53:"shop_order_refund/([^/]+)/comment-page-([0-9]{1,})/?$";s:57:"index.php?shop_order_refund=$matches[1]&cpage=$matches[2]";s:43:"shop_order_refund/([^/]+)/wc-api(/(.*))?/?$";s:58:"index.php?shop_order_refund=$matches[1]&wc-api=$matches[3]";s:49:"shop_order_refund/[^/]+/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:60:"shop_order_refund/[^/]+/attachment/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:38:"shop_order_refund/([^/]+)(/[0-9]+)?/?$";s:56:"index.php?shop_order_refund=$matches[1]&page=$matches[2]";s:34:"shop_order_refund/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:44:"shop_order_refund/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:64:"shop_order_refund/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:59:"shop_order_refund/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:59:"shop_order_refund/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:39:"testimonial/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:49:"testimonial/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:69:"testimonial/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:64:"testimonial/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:64:"testimonial/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:32:"testimonial/([^/]+)/trackback/?$";s:38:"index.php?testimonial=$matches[1]&tb=1";s:52:"testimonial/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?testimonial=$matches[1]&feed=$matches[2]";s:47:"testimonial/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?testimonial=$matches[1]&feed=$matches[2]";s:40:"testimonial/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?testimonial=$matches[1]&paged=$matches[2]";s:47:"testimonial/([^/]+)/comment-page-([0-9]{1,})/?$";s:51:"index.php?testimonial=$matches[1]&cpage=$matches[2]";s:37:"testimonial/([^/]+)/wc-api(/(.*))?/?$";s:52:"index.php?testimonial=$matches[1]&wc-api=$matches[3]";s:43:"testimonial/[^/]+/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:54:"testimonial/[^/]+/attachment/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:32:"testimonial/([^/]+)(/[0-9]+)?/?$";s:50:"index.php?testimonial=$matches[1]&page=$matches[2]";s:28:"testimonial/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:38:"testimonial/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:58:"testimonial/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:53:"testimonial/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:53:"testimonial/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:53:"testimonials/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:59:"index.php?testimonial-category=$matches[1]&feed=$matches[2]";s:48:"testimonials/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:59:"index.php?testimonial-category=$matches[1]&feed=$matches[2]";s:41:"testimonials/([^/]+)/page/?([0-9]{1,})/?$";s:60:"index.php?testimonial-category=$matches[1]&paged=$matches[2]";s:23:"testimonials/([^/]+)/?$";s:42:"index.php?testimonial-category=$matches[1]";s:48:".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$";s:18:"index.php?feed=old";s:20:".*wp-app\\.php(/.*)?$";s:19:"index.php?error=403";s:18:".*wp-register.php$";s:23:"index.php?register=true";s:32:"feed/(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:27:"(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:20:"page/?([0-9]{1,})/?$";s:28:"index.php?&paged=$matches[1]";s:27:"comment-page-([0-9]{1,})/?$";s:39:"index.php?&page_id=10&cpage=$matches[1]";s:17:"wc-api(/(.*))?/?$";s:29:"index.php?&wc-api=$matches[2]";s:20:"order-pay(/(.*))?/?$";s:32:"index.php?&order-pay=$matches[2]";s:25:"order-received(/(.*))?/?$";s:37:"index.php?&order-received=$matches[2]";s:21:"view-order(/(.*))?/?$";s:33:"index.php?&view-order=$matches[2]";s:23:"edit-account(/(.*))?/?$";s:35:"index.php?&edit-account=$matches[2]";s:23:"edit-address(/(.*))?/?$";s:35:"index.php?&edit-address=$matches[2]";s:24:"lost-password(/(.*))?/?$";s:36:"index.php?&lost-password=$matches[2]";s:26:"customer-logout(/(.*))?/?$";s:38:"index.php?&customer-logout=$matches[2]";s:29:"add-payment-method(/(.*))?/?$";s:41:"index.php?&add-payment-method=$matches[2]";s:41:"comments/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:36:"comments/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:26:"comments/wc-api(/(.*))?/?$";s:29:"index.php?&wc-api=$matches[2]";s:44:"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:39:"search/(.+)/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:32:"search/(.+)/page/?([0-9]{1,})/?$";s:41:"index.php?s=$matches[1]&paged=$matches[2]";s:29:"search/(.+)/wc-api(/(.*))?/?$";s:42:"index.php?s=$matches[1]&wc-api=$matches[3]";s:14:"search/(.+)/?$";s:23:"index.php?s=$matches[1]";s:47:"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:42:"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:35:"author/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?author_name=$matches[1]&paged=$matches[2]";s:32:"author/([^/]+)/wc-api(/(.*))?/?$";s:52:"index.php?author_name=$matches[1]&wc-api=$matches[3]";s:17:"author/([^/]+)/?$";s:33:"index.php?author_name=$matches[1]";s:69:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:64:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:57:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:81:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]";s:54:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/wc-api(/(.*))?/?$";s:82:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&wc-api=$matches[5]";s:39:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$";s:63:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]";s:56:"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:51:"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:44:"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:65:"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]";s:41:"([0-9]{4})/([0-9]{1,2})/wc-api(/(.*))?/?$";s:66:"index.php?year=$matches[1]&monthnum=$matches[2]&wc-api=$matches[4]";s:26:"([0-9]{4})/([0-9]{1,2})/?$";s:47:"index.php?year=$matches[1]&monthnum=$matches[2]";s:43:"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:38:"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:31:"([0-9]{4})/page/?([0-9]{1,})/?$";s:44:"index.php?year=$matches[1]&paged=$matches[2]";s:28:"([0-9]{4})/wc-api(/(.*))?/?$";s:45:"index.php?year=$matches[1]&wc-api=$matches[3]";s:13:"([0-9]{4})/?$";s:26:"index.php?year=$matches[1]";s:27:".?.+?/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:37:".?.+?/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:57:".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:20:"(.?.+?)/trackback/?$";s:35:"index.php?pagename=$matches[1]&tb=1";s:40:"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:35:"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:28:"(.?.+?)/page/?([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&paged=$matches[2]";s:35:"(.?.+?)/comment-page-([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&cpage=$matches[2]";s:25:"(.?.+?)/wc-api(/(.*))?/?$";s:49:"index.php?pagename=$matches[1]&wc-api=$matches[3]";s:28:"(.?.+?)/order-pay(/(.*))?/?$";s:52:"index.php?pagename=$matches[1]&order-pay=$matches[3]";s:33:"(.?.+?)/order-received(/(.*))?/?$";s:57:"index.php?pagename=$matches[1]&order-received=$matches[3]";s:29:"(.?.+?)/view-order(/(.*))?/?$";s:53:"index.php?pagename=$matches[1]&view-order=$matches[3]";s:31:"(.?.+?)/edit-account(/(.*))?/?$";s:55:"index.php?pagename=$matches[1]&edit-account=$matches[3]";s:31:"(.?.+?)/edit-address(/(.*))?/?$";s:55:"index.php?pagename=$matches[1]&edit-address=$matches[3]";s:32:"(.?.+?)/lost-password(/(.*))?/?$";s:56:"index.php?pagename=$matches[1]&lost-password=$matches[3]";s:34:"(.?.+?)/customer-logout(/(.*))?/?$";s:58:"index.php?pagename=$matches[1]&customer-logout=$matches[3]";s:37:"(.?.+?)/add-payment-method(/(.*))?/?$";s:61:"index.php?pagename=$matches[1]&add-payment-method=$matches[3]";s:31:".?.+?/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:42:".?.+?/attachment/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:20:"(.?.+?)(/[0-9]+)?/?$";s:47:"index.php?pagename=$matches[1]&page=$matches[2]";s:27:"[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:37:"[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:57:"[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:"[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:"[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:20:"([^/]+)/trackback/?$";s:31:"index.php?name=$matches[1]&tb=1";s:40:"([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?name=$matches[1]&feed=$matches[2]";s:35:"([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?name=$matches[1]&feed=$matches[2]";s:28:"([^/]+)/page/?([0-9]{1,})/?$";s:44:"index.php?name=$matches[1]&paged=$matches[2]";s:35:"([^/]+)/comment-page-([0-9]{1,})/?$";s:44:"index.php?name=$matches[1]&cpage=$matches[2]";s:25:"([^/]+)/wc-api(/(.*))?/?$";s:45:"index.php?name=$matches[1]&wc-api=$matches[3]";s:31:"[^/]+/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:42:"[^/]+/attachment/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:20:"([^/]+)(/[0-9]+)?/?$";s:43:"index.php?name=$matches[1]&page=$matches[2]";s:16:"[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:26:"[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:46:"[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:41:"[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:41:"[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";}', 'yes'),
(355, 'WPLANG', '', 'yes'),
(378, '_transient_timeout_wc_review_count_461428950780', '1431543994', 'no'),
(379, '_transient_wc_review_count_461428950780', '0', 'no'),
(380, '_transient_timeout_wc_max_related_461428950780', '1431543995', 'no'),
(381, '_transient_wc_max_related_461428950780', '1', 'no'),
(382, '_transient_is_multi_author', '0', 'yes'),
(383, '_transient_timeout_wc_rating_count_461428952349', '1431544383', 'no'),
(384, '_transient_wc_rating_count_461428952349', '0', 'no'),
(385, '_transient_timeout_wc_average_rating_461428952349', '1431544383', 'no'),
(386, '_transient_wc_average_rating_461428952349', '', 'no'),
(387, '_transient_timeout_wc_rating_count_431428952349', '1431544384', 'no'),
(388, '_transient_wc_rating_count_431428952349', '0', 'no'),
(389, '_transient_timeout_wc_average_rating_431428952349', '1431544384', 'no'),
(390, '_transient_wc_average_rating_431428952349', '', 'no'),
(391, '_transient_timeout_wc_review_count_461428952349', '1431544411', 'no'),
(392, '_transient_wc_review_count_461428952349', '0', 'no'),
(393, '_transient_timeout_wc_max_related_461428952349', '1431544412', 'no'),
(394, '_transient_wc_max_related_461428952349', '1', 'no'),
(395, '_transient_timeout_wc_low_stock_count', '1431544609', 'no'),
(396, '_transient_wc_low_stock_count', '0', 'no'),
(397, '_transient_timeout_wc_outofstock_count', '1431544609', 'no'),
(398, '_transient_wc_outofstock_count', '0', 'no'),
(401, '_transient_cartel_categories', '1', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `wp_postmeta`
--

DROP TABLE IF EXISTS `wp_postmeta`;
CREATE TABLE IF NOT EXISTS `wp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=229 ;

--
-- Dumping data for table `wp_postmeta`
--

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 2, '_wp_page_template', 'default'),
(2, 8, '_edit_last', '1'),
(3, 8, '_edit_lock', '1428951340:1'),
(4, 9, '_wp_attached_file', '2015/04/wallpaper-1685134-1280x500.jpg'),
(5, 9, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:1280;s:6:"height";i:500;s:4:"file";s:38:"2015/04/wallpaper-1685134-1280x500.jpg";s:5:"sizes";a:6:{s:9:"thumbnail";a:4:{s:4:"file";s:38:"wallpaper-1685134-1280x500-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:38:"wallpaper-1685134-1280x500-300x117.jpg";s:5:"width";i:300;s:6:"height";i:117;s:9:"mime-type";s:10:"image/jpeg";}s:5:"large";a:4:{s:4:"file";s:39:"wallpaper-1685134-1280x500-1024x400.jpg";s:5:"width";i:1024;s:6:"height";i:400;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:37:"wallpaper-1685134-1280x500-120x47.jpg";s:5:"width";i:120;s:6:"height";i:47;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:38:"wallpaper-1685134-1280x500-320x400.jpg";s:5:"width";i:320;s:6:"height";i:400;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:38:"wallpaper-1685134-1280x500-500x195.jpg";s:5:"width";i:500;s:6:"height";i:195;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(7, 8, '_slide_link', 'http://localhost/WordPress/Cartel/'),
(8, 10, '_edit_last', '1'),
(9, 10, '_wp_page_template', 'homepage.php'),
(10, 10, '_edit_lock', '1428946856:1'),
(11, 12, '_wp_attached_file', '2015/04/BAN1-720x400.jpg'),
(12, 12, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:720;s:6:"height";i:400;s:4:"file";s:24:"2015/04/BAN1-720x400.jpg";s:5:"sizes";a:5:{s:9:"thumbnail";a:4:{s:4:"file";s:24:"BAN1-720x400-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:24:"BAN1-720x400-300x167.jpg";s:5:"width";i:300;s:6:"height";i:167;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:23:"BAN1-720x400-120x67.jpg";s:5:"width";i:120;s:6:"height";i:67;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:24:"BAN1-720x400-320x400.jpg";s:5:"width";i:320;s:6:"height";i:400;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:24:"BAN1-720x400-500x278.jpg";s:5:"width";i:500;s:6:"height";i:278;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(13, 13, '_wp_attached_file', '2015/04/BAN2-720x400.jpg'),
(14, 13, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:720;s:6:"height";i:400;s:4:"file";s:24:"2015/04/BAN2-720x400.jpg";s:5:"sizes";a:5:{s:9:"thumbnail";a:4:{s:4:"file";s:24:"BAN2-720x400-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:24:"BAN2-720x400-300x167.jpg";s:5:"width";i:300;s:6:"height";i:167;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:23:"BAN2-720x400-120x67.jpg";s:5:"width";i:120;s:6:"height";i:67;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:24:"BAN2-720x400-320x400.jpg";s:5:"width";i:320;s:6:"height";i:400;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:24:"BAN2-720x400-500x278.jpg";s:5:"width";i:500;s:6:"height";i:278;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(15, 14, '_wp_attached_file', '2015/04/BN3-720x400.jpg'),
(16, 14, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:720;s:6:"height";i:400;s:4:"file";s:23:"2015/04/BN3-720x400.jpg";s:5:"sizes";a:5:{s:9:"thumbnail";a:4:{s:4:"file";s:23:"BN3-720x400-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:23:"BN3-720x400-300x167.jpg";s:5:"width";i:300;s:6:"height";i:167;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:22:"BN3-720x400-120x67.jpg";s:5:"width";i:120;s:6:"height";i:67;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:23:"BN3-720x400-320x400.jpg";s:5:"width";i:320;s:6:"height";i:400;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:23:"BN3-720x400-500x278.jpg";s:5:"width";i:500;s:6:"height";i:278;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(17, 15, '_edit_last', '1'),
(18, 15, '_edit_lock', '1428947982:1'),
(19, 15, '_byline', 'Owner of Eshop'),
(20, 15, '_url', 'http://www.eshop.com'),
(21, 16, '_wp_attached_file', '2015/04/s7-120x120.jpg'),
(22, 16, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:120;s:6:"height";i:120;s:4:"file";s:22:"2015/04/s7-120x120.jpg";s:5:"sizes";a:1:{s:14:"shop_thumbnail";a:4:{s:4:"file";s:22:"s7-120x120-120x120.jpg";s:5:"width";i:120;s:6:"height";i:120;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(23, 15, '_thumbnail_id', '16'),
(24, 1, '_edit_lock', '1428948398:1'),
(25, 19, '_wp_attached_file', '2015/04/vladstudio_dreamserviceproviders_1024x768-910x480.jpg'),
(26, 19, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:910;s:6:"height";i:480;s:4:"file";s:61:"2015/04/vladstudio_dreamserviceproviders_1024x768-910x480.jpg";s:5:"sizes";a:5:{s:9:"thumbnail";a:4:{s:4:"file";s:61:"vladstudio_dreamserviceproviders_1024x768-910x480-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:61:"vladstudio_dreamserviceproviders_1024x768-910x480-300x158.jpg";s:5:"width";i:300;s:6:"height";i:158;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:60:"vladstudio_dreamserviceproviders_1024x768-910x480-120x63.jpg";s:5:"width";i:120;s:6:"height";i:63;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:61:"vladstudio_dreamserviceproviders_1024x768-910x480-320x400.jpg";s:5:"width";i:320;s:6:"height";i:400;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:61:"vladstudio_dreamserviceproviders_1024x768-910x480-500x264.jpg";s:5:"width";i:500;s:6:"height";i:264;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(27, 20, '_wp_attached_file', '2015/04/wallpaper-1797392-910x480.jpg'),
(28, 20, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:910;s:6:"height";i:480;s:4:"file";s:37:"2015/04/wallpaper-1797392-910x480.jpg";s:5:"sizes";a:5:{s:9:"thumbnail";a:4:{s:4:"file";s:37:"wallpaper-1797392-910x480-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:37:"wallpaper-1797392-910x480-300x158.jpg";s:5:"width";i:300;s:6:"height";i:158;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:36:"wallpaper-1797392-910x480-120x63.jpg";s:5:"width";i:120;s:6:"height";i:63;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:37:"wallpaper-1797392-910x480-320x400.jpg";s:5:"width";i:320;s:6:"height";i:400;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:37:"wallpaper-1797392-910x480-500x264.jpg";s:5:"width";i:500;s:6:"height";i:264;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(29, 21, '_wp_attached_file', '2015/04/wallpaper-2795700-910x480.jpg'),
(30, 21, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:910;s:6:"height";i:480;s:4:"file";s:37:"2015/04/wallpaper-2795700-910x480.jpg";s:5:"sizes";a:5:{s:9:"thumbnail";a:4:{s:4:"file";s:37:"wallpaper-2795700-910x480-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:37:"wallpaper-2795700-910x480-300x158.jpg";s:5:"width";i:300;s:6:"height";i:158;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:36:"wallpaper-2795700-910x480-120x63.jpg";s:5:"width";i:120;s:6:"height";i:63;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:37:"wallpaper-2795700-910x480-320x400.jpg";s:5:"width";i:320;s:6:"height";i:400;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:37:"wallpaper-2795700-910x480-500x264.jpg";s:5:"width";i:500;s:6:"height";i:264;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(31, 1, '_thumbnail_id', '21'),
(32, 1, '_edit_last', '1'),
(35, 23, '_edit_last', '1'),
(36, 23, '_edit_lock', '1428948336:1'),
(37, 23, '_thumbnail_id', '20'),
(40, 25, '_edit_last', '1'),
(41, 25, '_edit_lock', '1428948304:1'),
(42, 25, '_thumbnail_id', '19'),
(51, 30, '_edit_last', '1'),
(52, 30, '_edit_lock', '1428950743:1'),
(53, 30, '_wp_page_template', 'default'),
(54, 32, '_wp_attached_file', '2015/04/wallpaper-724473.jpg'),
(55, 32, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:1680;s:6:"height";i:1050;s:4:"file";s:28:"2015/04/wallpaper-724473.jpg";s:5:"sizes";a:6:{s:9:"thumbnail";a:4:{s:4:"file";s:28:"wallpaper-724473-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:28:"wallpaper-724473-300x188.jpg";s:5:"width";i:300;s:6:"height";i:188;s:9:"mime-type";s:10:"image/jpeg";}s:5:"large";a:4:{s:4:"file";s:29:"wallpaper-724473-1024x640.jpg";s:5:"width";i:1024;s:6:"height";i:640;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:27:"wallpaper-724473-120x75.jpg";s:5:"width";i:120;s:6:"height";i:75;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:28:"wallpaper-724473-320x400.jpg";s:5:"width";i:320;s:6:"height";i:400;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:28:"wallpaper-724473-500x313.jpg";s:5:"width";i:500;s:6:"height";i:313;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(56, 33, '_wp_attached_file', '2015/04/wallpaper-2067766.jpg'),
(57, 33, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:2560;s:6:"height";i:1600;s:4:"file";s:29:"2015/04/wallpaper-2067766.jpg";s:5:"sizes";a:6:{s:9:"thumbnail";a:4:{s:4:"file";s:29:"wallpaper-2067766-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:29:"wallpaper-2067766-300x188.jpg";s:5:"width";i:300;s:6:"height";i:188;s:9:"mime-type";s:10:"image/jpeg";}s:5:"large";a:4:{s:4:"file";s:30:"wallpaper-2067766-1024x640.jpg";s:5:"width";i:1024;s:6:"height";i:640;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:28:"wallpaper-2067766-120x75.jpg";s:5:"width";i:120;s:6:"height";i:75;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:29:"wallpaper-2067766-320x400.jpg";s:5:"width";i:320;s:6:"height";i:400;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:29:"wallpaper-2067766-500x313.jpg";s:5:"width";i:500;s:6:"height";i:313;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(58, 34, '_menu_item_type', 'post_type'),
(59, 34, '_menu_item_menu_item_parent', '0'),
(60, 34, '_menu_item_object_id', '10'),
(61, 34, '_menu_item_object', 'page'),
(62, 34, '_menu_item_target', ''),
(63, 34, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
(64, 34, '_menu_item_xfn', ''),
(65, 34, '_menu_item_url', ''),
(67, 35, '_menu_item_type', 'post_type'),
(68, 35, '_menu_item_menu_item_parent', '0'),
(69, 35, '_menu_item_object_id', '30'),
(70, 35, '_menu_item_object', 'page'),
(71, 35, '_menu_item_target', ''),
(72, 35, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
(73, 35, '_menu_item_xfn', ''),
(74, 35, '_menu_item_url', ''),
(75, 35, '_menu_item_orphaned', '1428949733'),
(76, 36, '_menu_item_type', 'post_type'),
(77, 36, '_menu_item_menu_item_parent', '0'),
(78, 36, '_menu_item_object_id', '5'),
(79, 36, '_menu_item_object', 'page'),
(80, 36, '_menu_item_target', ''),
(81, 36, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
(82, 36, '_menu_item_xfn', ''),
(83, 36, '_menu_item_url', ''),
(85, 37, '_menu_item_type', 'post_type'),
(86, 37, '_menu_item_menu_item_parent', '0'),
(87, 37, '_menu_item_object_id', '6'),
(88, 37, '_menu_item_object', 'page'),
(89, 37, '_menu_item_target', ''),
(90, 37, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
(91, 37, '_menu_item_xfn', ''),
(92, 37, '_menu_item_url', ''),
(94, 38, '_menu_item_type', 'post_type'),
(95, 38, '_menu_item_menu_item_parent', '0'),
(96, 38, '_menu_item_object_id', '10'),
(97, 38, '_menu_item_object', 'page'),
(98, 38, '_menu_item_target', ''),
(99, 38, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
(100, 38, '_menu_item_xfn', ''),
(101, 38, '_menu_item_url', ''),
(102, 38, '_menu_item_orphaned', '1428949734'),
(103, 39, '_menu_item_type', 'post_type'),
(104, 39, '_menu_item_menu_item_parent', '0'),
(105, 39, '_menu_item_object_id', '7'),
(106, 39, '_menu_item_object', 'page'),
(107, 39, '_menu_item_target', ''),
(108, 39, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
(109, 39, '_menu_item_xfn', ''),
(110, 39, '_menu_item_url', ''),
(112, 40, '_menu_item_type', 'post_type'),
(113, 40, '_menu_item_menu_item_parent', '0'),
(114, 40, '_menu_item_object_id', '2'),
(115, 40, '_menu_item_object', 'page'),
(116, 40, '_menu_item_target', ''),
(117, 40, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
(118, 40, '_menu_item_xfn', ''),
(119, 40, '_menu_item_url', ''),
(120, 40, '_menu_item_orphaned', '1428949735'),
(121, 41, '_menu_item_type', 'post_type'),
(122, 41, '_menu_item_menu_item_parent', '0'),
(123, 41, '_menu_item_object_id', '4'),
(124, 41, '_menu_item_object', 'page'),
(125, 41, '_menu_item_target', ''),
(126, 41, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
(127, 41, '_menu_item_xfn', ''),
(128, 41, '_menu_item_url', ''),
(130, 42, '_menu_item_type', 'taxonomy'),
(131, 42, '_menu_item_menu_item_parent', '0'),
(132, 42, '_menu_item_object_id', '1'),
(133, 42, '_menu_item_object', 'category'),
(134, 42, '_menu_item_target', ''),
(135, 42, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
(136, 42, '_menu_item_xfn', ''),
(137, 42, '_menu_item_url', ''),
(139, 43, '_edit_last', '1'),
(140, 43, '_edit_lock', '1428952225:1'),
(141, 44, '_wp_attached_file', '2015/04/poster_2_up-500x500.jpg'),
(142, 44, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:500;s:6:"height";i:500;s:4:"file";s:31:"2015/04/poster_2_up-500x500.jpg";s:5:"sizes";a:5:{s:9:"thumbnail";a:4:{s:4:"file";s:31:"poster_2_up-500x500-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:31:"poster_2_up-500x500-300x300.jpg";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:31:"poster_2_up-500x500-120x120.jpg";s:5:"width";i:120;s:6:"height";i:120;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:31:"poster_2_up-500x500-320x400.jpg";s:5:"width";i:320;s:6:"height";i:400;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:31:"poster_2_up-500x500-500x500.jpg";s:5:"width";i:500;s:6:"height";i:500;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(143, 43, '_thumbnail_id', '44'),
(144, 43, '_visibility', 'visible'),
(145, 43, '_stock_status', 'instock'),
(146, 43, 'total_sales', '0'),
(147, 43, '_downloadable', 'no'),
(148, 43, '_virtual', 'no'),
(149, 43, '_regular_price', '15'),
(150, 43, '_sale_price', '12'),
(151, 43, '_purchase_note', ''),
(152, 43, '_featured', 'no'),
(153, 43, '_weight', ''),
(154, 43, '_length', ''),
(155, 43, '_width', ''),
(156, 43, '_height', ''),
(157, 43, '_sku', 'Flying Ninja'),
(158, 43, '_product_attributes', 'a:0:{}'),
(159, 43, '_sale_price_dates_from', ''),
(160, 43, '_sale_price_dates_to', ''),
(161, 43, '_price', '12'),
(162, 43, '_sold_individually', ''),
(163, 43, '_manage_stock', 'no'),
(164, 43, '_backorders', 'no'),
(165, 43, '_stock', ''),
(166, 43, '_upsell_ids', 'a:0:{}'),
(167, 43, '_crosssell_ids', 'a:0:{}'),
(168, 43, '_product_image_gallery', ''),
(169, 46, '_edit_last', '1'),
(170, 46, '_edit_lock', '1428952436:1'),
(171, 47, '_wp_attached_file', '2015/04/poster_1_up-500x500.jpg'),
(172, 47, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:500;s:6:"height";i:500;s:4:"file";s:31:"2015/04/poster_1_up-500x500.jpg";s:5:"sizes";a:5:{s:9:"thumbnail";a:4:{s:4:"file";s:31:"poster_1_up-500x500-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:31:"poster_1_up-500x500-300x300.jpg";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:31:"poster_1_up-500x500-120x120.jpg";s:5:"width";i:120;s:6:"height";i:120;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:31:"poster_1_up-500x500-320x400.jpg";s:5:"width";i:320;s:6:"height";i:400;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:31:"poster_1_up-500x500-500x500.jpg";s:5:"width";i:500;s:6:"height";i:500;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(174, 46, '_visibility', 'visible'),
(175, 46, '_stock_status', 'instock'),
(176, 46, 'total_sales', '0'),
(177, 46, '_downloadable', 'no'),
(178, 46, '_virtual', 'no'),
(179, 46, '_regular_price', '210'),
(180, 46, '_sale_price', ''),
(181, 46, '_purchase_note', ''),
(182, 46, '_featured', 'no'),
(183, 46, '_weight', ''),
(184, 46, '_length', ''),
(185, 46, '_width', ''),
(186, 46, '_height', ''),
(187, 46, '_sku', 'wbk012'),
(188, 46, '_product_attributes', 'a:0:{}'),
(189, 46, '_sale_price_dates_from', ''),
(190, 46, '_sale_price_dates_to', ''),
(191, 46, '_price', '210'),
(192, 46, '_sold_individually', ''),
(193, 46, '_manage_stock', 'yes'),
(194, 46, '_backorders', 'yes'),
(195, 46, '_stock', '10.000000'),
(196, 46, '_upsell_ids', 'a:0:{}'),
(197, 46, '_crosssell_ids', 'a:0:{}'),
(198, 46, '_product_image_gallery', ''),
(199, 49, '_wp_attached_file', '2015/04/slide-1.jpg'),
(200, 49, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:1767;s:6:"height";i:887;s:4:"file";s:19:"2015/04/slide-1.jpg";s:5:"sizes";a:6:{s:9:"thumbnail";a:4:{s:4:"file";s:19:"slide-1-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:19:"slide-1-300x151.jpg";s:5:"width";i:300;s:6:"height";i:151;s:9:"mime-type";s:10:"image/jpeg";}s:5:"large";a:4:{s:4:"file";s:20:"slide-1-1024x514.jpg";s:5:"width";i:1024;s:6:"height";i:514;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:18:"slide-1-120x60.jpg";s:5:"width";i:120;s:6:"height";i:60;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:19:"slide-1-320x400.jpg";s:5:"width";i:320;s:6:"height";i:400;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:19:"slide-1-500x251.jpg";s:5:"width";i:500;s:6:"height";i:251;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(201, 8, '_thumbnail_id', '49'),
(202, 52, '_wp_attached_file', '2015/04/slide-2.jpg'),
(203, 52, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:1767;s:6:"height";i:887;s:4:"file";s:19:"2015/04/slide-2.jpg";s:5:"sizes";a:6:{s:9:"thumbnail";a:4:{s:4:"file";s:19:"slide-2-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:19:"slide-2-300x151.jpg";s:5:"width";i:300;s:6:"height";i:151;s:9:"mime-type";s:10:"image/jpeg";}s:5:"large";a:4:{s:4:"file";s:20:"slide-2-1024x514.jpg";s:5:"width";i:1024;s:6:"height";i:514;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:18:"slide-2-120x60.jpg";s:5:"width";i:120;s:6:"height";i:60;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:19:"slide-2-320x400.jpg";s:5:"width";i:320;s:6:"height";i:400;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:19:"slide-2-500x251.jpg";s:5:"width";i:500;s:6:"height";i:251;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(204, 53, '_wp_attached_file', '2015/04/slide-3.jpg'),
(205, 53, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:1767;s:6:"height";i:887;s:4:"file";s:19:"2015/04/slide-3.jpg";s:5:"sizes";a:6:{s:9:"thumbnail";a:4:{s:4:"file";s:19:"slide-3-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:19:"slide-3-300x151.jpg";s:5:"width";i:300;s:6:"height";i:151;s:9:"mime-type";s:10:"image/jpeg";}s:5:"large";a:4:{s:4:"file";s:20:"slide-3-1024x514.jpg";s:5:"width";i:1024;s:6:"height";i:514;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:18:"slide-3-120x60.jpg";s:5:"width";i:120;s:6:"height";i:60;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:19:"slide-3-320x400.jpg";s:5:"width";i:320;s:6:"height";i:400;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:19:"slide-3-500x251.jpg";s:5:"width";i:500;s:6:"height";i:251;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(206, 51, '_thumbnail_id', '52'),
(207, 51, '_edit_last', '1'),
(208, 51, '_slide_link', ''),
(209, 51, '_edit_lock', '1428951352:1'),
(210, 54, '_thumbnail_id', '53'),
(211, 54, '_edit_last', '1'),
(212, 54, '_slide_link', ''),
(213, 54, '_edit_lock', '1428951360:1'),
(214, 55, '_wp_attached_file', '2015/04/homepage-three-column-promo-01B.png'),
(215, 55, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:569;s:6:"height";i:150;s:4:"file";s:43:"2015/04/homepage-three-column-promo-01B.png";s:5:"sizes";a:5:{s:9:"thumbnail";a:4:{s:4:"file";s:43:"homepage-three-column-promo-01B-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:42:"homepage-three-column-promo-01B-300x79.png";s:5:"width";i:300;s:6:"height";i:79;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:42:"homepage-three-column-promo-01B-120x32.png";s:5:"width";i:120;s:6:"height";i:32;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:43:"homepage-three-column-promo-01B-320x150.png";s:5:"width";i:320;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:11:"shop_single";a:4:{s:4:"file";s:43:"homepage-three-column-promo-01B-500x132.png";s:5:"width";i:500;s:6:"height";i:132;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(216, 56, '_wp_attached_file', '2015/04/homepage-three-column-promo-02.png'),
(217, 56, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:569;s:6:"height";i:150;s:4:"file";s:42:"2015/04/homepage-three-column-promo-02.png";s:5:"sizes";a:5:{s:9:"thumbnail";a:4:{s:4:"file";s:42:"homepage-three-column-promo-02-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:41:"homepage-three-column-promo-02-300x79.png";s:5:"width";i:300;s:6:"height";i:79;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:41:"homepage-three-column-promo-02-120x32.png";s:5:"width";i:120;s:6:"height";i:32;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:42:"homepage-three-column-promo-02-320x150.png";s:5:"width";i:320;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:11:"shop_single";a:4:{s:4:"file";s:42:"homepage-three-column-promo-02-500x132.png";s:5:"width";i:500;s:6:"height";i:132;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(218, 57, '_wp_attached_file', '2015/04/homepage-three-column-promo-03.png'),
(219, 57, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:569;s:6:"height";i:150;s:4:"file";s:42:"2015/04/homepage-three-column-promo-03.png";s:5:"sizes";a:5:{s:9:"thumbnail";a:4:{s:4:"file";s:42:"homepage-three-column-promo-03-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:41:"homepage-three-column-promo-03-300x79.png";s:5:"width";i:300;s:6:"height";i:79;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:41:"homepage-three-column-promo-03-120x32.png";s:5:"width";i:120;s:6:"height";i:32;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:42:"homepage-three-column-promo-03-320x150.png";s:5:"width";i:320;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:11:"shop_single";a:4:{s:4:"file";s:42:"homepage-three-column-promo-03-500x132.png";s:5:"width";i:500;s:6:"height";i:132;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(220, 59, '_edit_last', '1'),
(221, 59, '_edit_lock', '1428952044:1'),
(222, 60, '_edit_last', '1'),
(223, 60, '_edit_lock', '1428952050:1'),
(224, 61, '_edit_last', '1'),
(225, 61, '_edit_lock', '1428952056:1'),
(226, 63, '_wp_attached_file', '2015/04/wbk012t.jpg'),
(227, 63, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:260;s:6:"height";i:260;s:4:"file";s:19:"2015/04/wbk012t.jpg";s:5:"sizes";a:2:{s:9:"thumbnail";a:4:{s:4:"file";s:19:"wbk012t-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:19:"wbk012t-120x120.jpg";s:5:"width";i:120;s:6:"height";i:120;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:11:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";s:11:"orientation";i:0;}}'),
(228, 46, '_thumbnail_id', '63');

-- --------------------------------------------------------

--
-- Table structure for table `wp_posts`
--

DROP TABLE IF EXISTS `wp_posts`;
CREATE TABLE IF NOT EXISTS `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(20) NOT NULL DEFAULT '',
  `post_name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `wp_posts`
--

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(1, 1, '2015-04-13 17:26:13', '2015-04-13 17:26:13', 'Consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus.', 'Hello world!', 'Consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.', 'publish', 'open', 'open', '', 'hello-world', '', '', '2015-04-13 18:08:11', '2015-04-13 18:08:11', '', 0, 'http://localhost/WordPress/Cartel/?p=1', 0, 'post', '', 1),
(2, 1, '2015-04-13 17:26:13', '2015-04-13 17:26:13', 'This is an example page. It''s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:\n\n<blockquote>Hi there! I''m a bike messenger by day, aspiring actor by night, and this is my blog. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin'' caught in the rain.)</blockquote>\n\n...or something like this:\n\n<blockquote>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</blockquote>\n\nAs a new WordPress user, you should go to <a href="http://localhost/WordPress/Cartel/wp-admin/">your dashboard</a> to delete this page and create new pages for your content. Have fun!', 'Sample Page', '', 'publish', 'open', 'open', '', 'sample-page', '', '', '2015-04-13 17:26:13', '2015-04-13 17:26:13', '', 0, 'http://localhost/WordPress/Cartel/?page_id=2', 0, 'page', '', 0),
(3, 1, '2015-04-13 17:27:31', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'open', 'open', '', '', '', '', '2015-04-13 17:27:31', '0000-00-00 00:00:00', '', 0, 'http://localhost/WordPress/Cartel/?p=3', 0, 'post', '', 0),
(4, 1, '2015-04-13 17:31:46', '2015-04-13 17:31:46', '', 'Shop', '', 'publish', 'closed', 'open', '', 'shop', '', '', '2015-04-13 17:31:46', '2015-04-13 17:31:46', '', 0, 'http://localhost/WordPress/Cartel/?page_id=4', 0, 'page', '', 0),
(5, 1, '2015-04-13 17:31:46', '2015-04-13 17:31:46', '[woocommerce_cart]', 'Cart', '', 'publish', 'closed', 'open', '', 'cart', '', '', '2015-04-13 17:31:46', '2015-04-13 17:31:46', '', 0, 'http://localhost/WordPress/Cartel/?page_id=5', 0, 'page', '', 0),
(6, 1, '2015-04-13 17:31:47', '2015-04-13 17:31:47', '[woocommerce_checkout]', 'Checkout', '', 'publish', 'closed', 'open', '', 'checkout', '', '', '2015-04-13 17:31:47', '2015-04-13 17:31:47', '', 0, 'http://localhost/WordPress/Cartel/?page_id=6', 0, 'page', '', 0),
(7, 1, '2015-04-13 17:31:47', '2015-04-13 17:31:47', '[woocommerce_my_account]', 'My Account', '', 'publish', 'closed', 'open', '', 'my-account', '', '', '2015-04-13 17:31:47', '2015-04-13 17:31:47', '', 0, 'http://localhost/WordPress/Cartel/?page_id=7', 0, 'page', '', 0),
(8, 1, '2015-04-13 00:03:05', '2015-04-13 00:03:05', '', 'AN EYE FOR DETAIL', '', 'publish', 'closed', 'closed', '', 'stet-clita-kasd-gubergren', '', '', '2015-04-13 18:55:40', '2015-04-13 18:55:40', '', 0, 'http://localhost/WordPress/Cartel/?post_type=slide&#038;p=8', 0, 'slide', '', 0),
(9, 1, '2015-04-13 17:37:55', '2015-04-13 17:37:55', '', 'wallpaper-1685134-1280x500', '', 'inherit', 'open', 'open', '', 'wallpaper-1685134-1280x500', '', '', '2015-04-13 17:37:55', '2015-04-13 17:37:55', '', 8, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/wallpaper-1685134-1280x500.jpg', 0, 'attachment', 'image/jpeg', 0),
(10, 1, '2015-04-13 17:42:46', '2015-04-13 17:42:46', '', 'Home', '', 'publish', 'open', 'open', '', 'home', '', '', '2015-04-13 17:42:46', '2015-04-13 17:42:46', '', 0, 'http://localhost/WordPress/Cartel/?page_id=10', 0, 'page', '', 0),
(11, 1, '2015-04-13 17:42:46', '2015-04-13 17:42:46', '', 'Home', '', 'inherit', 'open', 'open', '', '10-revision-v1', '', '', '2015-04-13 17:42:46', '2015-04-13 17:42:46', '', 10, 'http://localhost/WordPress/Cartel/?p=11', 0, 'revision', '', 0),
(12, 1, '2015-04-13 17:53:11', '2015-04-13 17:53:11', '', 'BAN1-720x400', '', 'inherit', 'open', 'open', '', 'ban1-720x400', '', '', '2015-04-13 17:53:11', '2015-04-13 17:53:11', '', 0, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/BAN1-720x400.jpg', 0, 'attachment', 'image/jpeg', 0),
(13, 1, '2015-04-13 17:53:13', '2015-04-13 17:53:13', '', 'BAN2-720x400', '', 'inherit', 'open', 'open', '', 'ban2-720x400', '', '', '2015-04-13 17:53:13', '2015-04-13 17:53:13', '', 0, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/BAN2-720x400.jpg', 0, 'attachment', 'image/jpeg', 0),
(14, 1, '2015-04-13 17:53:14', '2015-04-13 17:53:14', '', 'BN3-720x400', '', 'inherit', 'open', 'open', '', 'bn3-720x400', '', '', '2015-04-13 17:53:14', '2015-04-13 17:53:14', '', 0, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/BN3-720x400.jpg', 0, 'attachment', 'image/jpeg', 0),
(15, 1, '2015-04-13 17:58:35', '2015-04-13 17:58:35', 'Consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea', 'Martin Bonet', '', 'publish', 'closed', 'closed', '', 'martin-bonet', '', '', '2015-04-13 18:01:11', '2015-04-13 18:01:11', '', 0, 'http://localhost/WordPress/Cartel/?post_type=testimonial&#038;p=15', 0, 'testimonial', '', 0),
(16, 1, '2015-04-13 18:01:04', '2015-04-13 18:01:04', '', 's7-120x120', '', 'inherit', 'open', 'open', '', 's7-120x120', '', '', '2015-04-13 18:01:04', '2015-04-13 18:01:04', '', 15, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/s7-120x120.jpg', 0, 'attachment', 'image/jpeg', 0),
(17, 1, '2015-04-13 18:02:12', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'open', 'open', '', '', '', '', '2015-04-13 18:02:12', '0000-00-00 00:00:00', '', 0, 'http://localhost/WordPress/Cartel/?p=17', 0, 'post', '', 0),
(18, 1, '2015-04-13 18:03:20', '2015-04-13 18:03:20', 'Consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus.', 'Hello world!', '', 'inherit', 'open', 'open', '', '1-autosave-v1', '', '', '2015-04-13 18:03:20', '2015-04-13 18:03:20', '', 1, 'http://localhost/WordPress/Cartel/?p=18', 0, 'revision', '', 0),
(19, 1, '2015-04-13 18:03:54', '2015-04-13 18:03:54', '', 'vladstudio_dreamserviceproviders_1024x768-910x480', '', 'inherit', 'open', 'open', '', 'vladstudio_dreamserviceproviders_1024x768-910x480', '', '', '2015-04-13 18:03:54', '2015-04-13 18:03:54', '', 1, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/vladstudio_dreamserviceproviders_1024x768-910x480.jpg', 0, 'attachment', 'image/jpeg', 0),
(20, 1, '2015-04-13 18:03:56', '2015-04-13 18:03:56', '', 'wallpaper-1797392-910x480', '', 'inherit', 'open', 'open', '', 'wallpaper-1797392-910x480', '', '', '2015-04-13 18:03:56', '2015-04-13 18:03:56', '', 1, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/wallpaper-1797392-910x480.jpg', 0, 'attachment', 'image/jpeg', 0),
(21, 1, '2015-04-13 18:03:57', '2015-04-13 18:03:57', '', 'wallpaper-2795700-910x480', '', 'inherit', 'open', 'open', '', 'wallpaper-2795700-910x480', '', '', '2015-04-13 18:03:57', '2015-04-13 18:03:57', '', 1, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/wallpaper-2795700-910x480.jpg', 0, 'attachment', 'image/jpeg', 0),
(22, 1, '2015-04-13 18:04:05', '2015-04-13 18:04:05', 'Consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus.', 'Hello world!', '', 'inherit', 'open', 'open', '', '1-revision-v1', '', '', '2015-04-13 18:04:05', '2015-04-13 18:04:05', '', 1, 'http://localhost/WordPress/Cartel/?p=22', 0, 'revision', '', 0),
(23, 1, '2015-04-13 18:05:32', '2015-04-13 18:05:32', 'Donec iaculis, orci a vehicula semper, nunc velit auctor nibh, vitae condimentum odio nibh vitae sapien. Donec malesuada pellentesque mattis. Praesent varius, lectus vel tempus tincidunt, felis turpis lobortis turpis, eget porttitor turpis urna eget ipsum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla eu nibh ac leo fringilla tincidunt. Sed adipiscing nisl sed leo accumsan a dapibus nibh gravida! Nullam gravida lectus rhoncus erat luctus ultrices! Maecenas porta tempus consequat. Curabitur sed risus sed metus cursus rhoncus sit amet et diam. Quisque mi lacus, adipiscing id pharetra et, ullamcorper ut augue. In hac habitasse platea dictumst. Vivamus placerat; tortor vel ultricies adipiscing, urna urna tristique tortor, sit amet rutrum lorem lacus eget odio. Etiam cursus lorem sit amet lorem feugiat venenatis. Morbi at velit mi, in rhoncus velit!', 'Maecenas porta tempus consequat', 'Donec iaculis, orci a vehicula semper, nunc velit auctor nibh, vitae condimentum odio nibh vitae sapien. Donec malesuada pellentesque', 'publish', 'open', 'open', '', 'maecenas-porta-tempus-consequat', '', '', '2015-04-13 18:07:46', '2015-04-13 18:07:46', '', 0, 'http://localhost/WordPress/Cartel/?p=23', 0, 'post', '', 0),
(24, 1, '2015-04-13 18:05:32', '2015-04-13 18:05:32', 'Donec iaculis, orci a vehicula semper, nunc velit auctor nibh, vitae condimentum odio nibh vitae sapien. Donec malesuada pellentesque mattis. Praesent varius, lectus vel tempus tincidunt, felis turpis lobortis turpis, eget porttitor turpis urna eget ipsum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla eu nibh ac leo fringilla tincidunt. Sed adipiscing nisl sed leo accumsan a dapibus nibh gravida! Nullam gravida lectus rhoncus erat luctus ultrices! Maecenas porta tempus consequat. Curabitur sed risus sed metus cursus rhoncus sit amet et diam. Quisque mi lacus, adipiscing id pharetra et, ullamcorper ut augue. In hac habitasse platea dictumst. Vivamus placerat; tortor vel ultricies adipiscing, urna urna tristique tortor, sit amet rutrum lorem lacus eget odio. Etiam cursus lorem sit amet lorem feugiat venenatis. Morbi at velit mi, in rhoncus velit!', 'Maecenas porta tempus consequat', '', 'inherit', 'open', 'open', '', '23-revision-v1', '', '', '2015-04-13 18:05:32', '2015-04-13 18:05:32', '', 23, 'http://localhost/WordPress/Cartel/?p=24', 0, 'revision', '', 0),
(25, 1, '2015-04-13 18:06:17', '2015-04-13 18:06:17', 'Nunc ornare dui at metus mattis pulvinar. Nullam tincidunt justo nec libero malesuada eget dapibus lorem facilisis. Nam eu metus auctor augue ornare faucibus. Fusce egestas dui eu est mattis aliquam ornare ipsum malesuada. Morbi pretium quam quis lacus eleifend ultricies. Donec fermentum, massa ut molestie gravida, ipsum metus pretium eros, sodales condimentum dui risus at lectus. Suspendisse potenti. Fusce congue est nec ante eleifend dictum. Praesent in felis at mauris venenatis mattis? Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\r\nNullam mi quam, elementum posuere mattis at, porttitor id lacus. Nulla facilisi. Aenean sed arcu ante, eu iaculis tellus. Nullam ut ultrices justo. Integer dui massa, sagittis eget facilisis eget, vehicula ac tortor. Phasellus pulvinar feugiat metus quis pharetra? Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce et neque mauris. Sed euismod; nibh at varius elementum, erat ipsum venenatis sapien, eget pellentesque velit purus vel augue. Nunc mi augue, sagittis ut rutrum et, tempor non elit. Vestibulum laoreet est in sapien fringilla nec blandit augue consequat. Vivamus mattis auctor ante, ac tristique mi feugiat eget. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer pretium lacus et ante condimentum nec dapibus mi cursus. Etiam elit nulla, mollis eget porta a, tincidunt ac orci. Vestibulum in nisi quis enim cursus facilisis. Etiam sodales pulvinar diam, nec posuere enim sagittis ut? In hac habitasse platea dictumst. Nulla facilisi. Cras quis nulla turpis!', 'Forbin pretium quam quis lacus', 'Nunc ornare dui at metus mattis pulvinar. Nullam tincidunt justo nec libero malesuada eget dapibus lorem facilisis. ', 'publish', 'open', 'open', '', 'forbin-pretium-quam-quis-lacus', '', '', '2015-04-13 18:07:09', '2015-04-13 18:07:09', '', 0, 'http://localhost/WordPress/Cartel/?p=25', 0, 'post', '', 0),
(26, 1, '2015-04-13 18:06:17', '2015-04-13 18:06:17', 'Nunc ornare dui at metus mattis pulvinar. Nullam tincidunt justo nec libero malesuada eget dapibus lorem facilisis. Nam eu metus auctor augue ornare faucibus. Fusce egestas dui eu est mattis aliquam ornare ipsum malesuada. Morbi pretium quam quis lacus eleifend ultricies. Donec fermentum, massa ut molestie gravida, ipsum metus pretium eros, sodales condimentum dui risus at lectus. Suspendisse potenti. Fusce congue est nec ante eleifend dictum. Praesent in felis at mauris venenatis mattis? Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\r\nNullam mi quam, elementum posuere mattis at, porttitor id lacus. Nulla facilisi. Aenean sed arcu ante, eu iaculis tellus. Nullam ut ultrices justo. Integer dui massa, sagittis eget facilisis eget, vehicula ac tortor. Phasellus pulvinar feugiat metus quis pharetra? Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce et neque mauris. Sed euismod; nibh at varius elementum, erat ipsum venenatis sapien, eget pellentesque velit purus vel augue. Nunc mi augue, sagittis ut rutrum et, tempor non elit. Vestibulum laoreet est in sapien fringilla nec blandit augue consequat. Vivamus mattis auctor ante, ac tristique mi feugiat eget. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer pretium lacus et ante condimentum nec dapibus mi cursus. Etiam elit nulla, mollis eget porta a, tincidunt ac orci. Vestibulum in nisi quis enim cursus facilisis. Etiam sodales pulvinar diam, nec posuere enim sagittis ut? In hac habitasse platea dictumst. Nulla facilisi. Cras quis nulla turpis!', 'Forbin pretium quam quis lacus', '', 'inherit', 'open', 'open', '', '25-revision-v1', '', '', '2015-04-13 18:06:17', '2015-04-13 18:06:17', '', 25, 'http://localhost/WordPress/Cartel/?p=26', 0, 'revision', '', 0),
(27, 1, '2015-04-13 18:07:09', '2015-04-13 18:07:09', 'Nunc ornare dui at metus mattis pulvinar. Nullam tincidunt justo nec libero malesuada eget dapibus lorem facilisis. Nam eu metus auctor augue ornare faucibus. Fusce egestas dui eu est mattis aliquam ornare ipsum malesuada. Morbi pretium quam quis lacus eleifend ultricies. Donec fermentum, massa ut molestie gravida, ipsum metus pretium eros, sodales condimentum dui risus at lectus. Suspendisse potenti. Fusce congue est nec ante eleifend dictum. Praesent in felis at mauris venenatis mattis? Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\r\nNullam mi quam, elementum posuere mattis at, porttitor id lacus. Nulla facilisi. Aenean sed arcu ante, eu iaculis tellus. Nullam ut ultrices justo. Integer dui massa, sagittis eget facilisis eget, vehicula ac tortor. Phasellus pulvinar feugiat metus quis pharetra? Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce et neque mauris. Sed euismod; nibh at varius elementum, erat ipsum venenatis sapien, eget pellentesque velit purus vel augue. Nunc mi augue, sagittis ut rutrum et, tempor non elit. Vestibulum laoreet est in sapien fringilla nec blandit augue consequat. Vivamus mattis auctor ante, ac tristique mi feugiat eget. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer pretium lacus et ante condimentum nec dapibus mi cursus. Etiam elit nulla, mollis eget porta a, tincidunt ac orci. Vestibulum in nisi quis enim cursus facilisis. Etiam sodales pulvinar diam, nec posuere enim sagittis ut? In hac habitasse platea dictumst. Nulla facilisi. Cras quis nulla turpis!', 'Forbin pretium quam quis lacus', 'Nunc ornare dui at metus mattis pulvinar. Nullam tincidunt justo nec libero malesuada eget dapibus lorem facilisis. ', 'inherit', 'open', 'open', '', '25-revision-v1', '', '', '2015-04-13 18:07:09', '2015-04-13 18:07:09', '', 25, 'http://localhost/WordPress/Cartel/?p=27', 0, 'revision', '', 0),
(28, 1, '2015-04-13 18:07:46', '2015-04-13 18:07:46', 'Donec iaculis, orci a vehicula semper, nunc velit auctor nibh, vitae condimentum odio nibh vitae sapien. Donec malesuada pellentesque mattis. Praesent varius, lectus vel tempus tincidunt, felis turpis lobortis turpis, eget porttitor turpis urna eget ipsum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla eu nibh ac leo fringilla tincidunt. Sed adipiscing nisl sed leo accumsan a dapibus nibh gravida! Nullam gravida lectus rhoncus erat luctus ultrices! Maecenas porta tempus consequat. Curabitur sed risus sed metus cursus rhoncus sit amet et diam. Quisque mi lacus, adipiscing id pharetra et, ullamcorper ut augue. In hac habitasse platea dictumst. Vivamus placerat; tortor vel ultricies adipiscing, urna urna tristique tortor, sit amet rutrum lorem lacus eget odio. Etiam cursus lorem sit amet lorem feugiat venenatis. Morbi at velit mi, in rhoncus velit!', 'Maecenas porta tempus consequat', 'Donec iaculis, orci a vehicula semper, nunc velit auctor nibh, vitae condimentum odio nibh vitae sapien. Donec malesuada pellentesque', 'inherit', 'open', 'open', '', '23-revision-v1', '', '', '2015-04-13 18:07:46', '2015-04-13 18:07:46', '', 23, 'http://localhost/WordPress/Cartel/?p=28', 0, 'revision', '', 0),
(29, 1, '2015-04-13 18:08:11', '2015-04-13 18:08:11', 'Consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus.', 'Hello world!', 'Consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.', 'inherit', 'open', 'open', '', '1-revision-v1', '', '', '2015-04-13 18:08:11', '2015-04-13 18:08:11', '', 1, 'http://localhost/WordPress/Cartel/?p=29', 0, 'revision', '', 0),
(30, 1, '2015-04-13 18:09:33', '2015-04-13 18:09:33', 'Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna nonummy nibh euismod tincidunt ut laoreet dolore magna', 'About Cartel', '', 'publish', 'open', 'open', '', 'about-cartel', '', '', '2015-04-13 18:09:33', '2015-04-13 18:09:33', '', 0, 'http://localhost/WordPress/Cartel/?page_id=30', 0, 'page', '', 0),
(31, 1, '2015-04-13 18:09:33', '2015-04-13 18:09:33', 'Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna nonummy nibh euismod tincidunt ut laoreet dolore magna', 'About Cartel', '', 'inherit', 'open', 'open', '', '30-revision-v1', '', '', '2015-04-13 18:09:33', '2015-04-13 18:09:33', '', 30, 'http://localhost/WordPress/Cartel/?p=31', 0, 'revision', '', 0),
(32, 1, '2015-04-13 18:20:00', '2015-04-13 18:20:00', '', 'wallpaper-724473', '', 'inherit', 'open', 'open', '', 'wallpaper-724473', '', '', '2015-04-13 18:20:00', '2015-04-13 18:20:00', '', 0, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/wallpaper-724473.jpg', 0, 'attachment', 'image/jpeg', 0),
(33, 1, '2015-04-13 18:21:19', '2015-04-13 18:21:19', '', 'wallpaper-2067766', '', 'inherit', 'open', 'open', '', 'wallpaper-2067766', '', '', '2015-04-13 18:21:19', '2015-04-13 18:21:19', '', 0, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/wallpaper-2067766.jpg', 0, 'attachment', 'image/jpeg', 0),
(34, 1, '2015-04-13 18:29:27', '2015-04-13 18:29:27', ' ', '', '', 'publish', 'open', 'open', '', '34', '', '', '2015-04-13 18:29:40', '2015-04-13 18:29:40', '', 0, 'http://localhost/WordPress/Cartel/?p=34', 1, 'nav_menu_item', '', 0),
(35, 1, '2015-04-13 18:28:53', '0000-00-00 00:00:00', ' ', '', '', 'draft', 'open', 'open', '', '', '', '', '2015-04-13 18:28:53', '0000-00-00 00:00:00', '', 0, 'http://localhost/WordPress/Cartel/?p=35', 1, 'nav_menu_item', '', 0),
(36, 1, '2015-04-13 18:29:27', '2015-04-13 18:29:27', ' ', '', '', 'publish', 'open', 'open', '', '36', '', '', '2015-04-13 18:29:41', '2015-04-13 18:29:41', '', 0, 'http://localhost/WordPress/Cartel/?p=36', 3, 'nav_menu_item', '', 0),
(37, 1, '2015-04-13 18:29:27', '2015-04-13 18:29:27', ' ', '', '', 'publish', 'open', 'open', '', '37', '', '', '2015-04-13 18:29:41', '2015-04-13 18:29:41', '', 0, 'http://localhost/WordPress/Cartel/?p=37', 4, 'nav_menu_item', '', 0),
(38, 1, '2015-04-13 18:28:54', '0000-00-00 00:00:00', ' ', '', '', 'draft', 'open', 'open', '', '', '', '', '2015-04-13 18:28:54', '0000-00-00 00:00:00', '', 0, 'http://localhost/WordPress/Cartel/?p=38', 1, 'nav_menu_item', '', 0),
(39, 1, '2015-04-13 18:29:28', '2015-04-13 18:29:28', ' ', '', '', 'publish', 'open', 'open', '', '39', '', '', '2015-04-13 18:29:41', '2015-04-13 18:29:41', '', 0, 'http://localhost/WordPress/Cartel/?p=39', 5, 'nav_menu_item', '', 0),
(40, 1, '2015-04-13 18:28:55', '0000-00-00 00:00:00', ' ', '', '', 'draft', 'open', 'open', '', '', '', '', '2015-04-13 18:28:55', '0000-00-00 00:00:00', '', 0, 'http://localhost/WordPress/Cartel/?p=40', 1, 'nav_menu_item', '', 0),
(41, 1, '2015-04-13 18:29:28', '2015-04-13 18:29:28', ' ', '', '', 'publish', 'open', 'open', '', '41', '', '', '2015-04-13 18:29:41', '2015-04-13 18:29:41', '', 0, 'http://localhost/WordPress/Cartel/?p=41', 6, 'nav_menu_item', '', 0),
(42, 1, '2015-04-13 18:29:27', '2015-04-13 18:29:27', ' ', '', '', 'publish', 'open', 'open', '', '42', '', '', '2015-04-13 18:29:41', '2015-04-13 18:29:41', '', 0, 'http://localhost/WordPress/Cartel/?p=42', 2, 'nav_menu_item', '', 0),
(43, 1, '2015-04-13 18:33:43', '2015-04-13 18:33:43', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', 'Flying Ninja', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', 'publish', 'open', 'closed', '', 'flying-ninja', '', '', '2015-04-13 18:36:41', '2015-04-13 18:36:41', '', 0, 'http://localhost/WordPress/Cartel/?post_type=product&#038;p=43', 0, 'product', '', 0),
(44, 1, '2015-04-13 18:33:23', '2015-04-13 18:33:23', '', 'poster_2_up-500x500', '', 'inherit', 'open', 'open', '', 'poster_2_up-500x500', '', '', '2015-04-13 18:33:23', '2015-04-13 18:33:23', '', 43, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/poster_2_up-500x500.jpg', 0, 'attachment', 'image/jpeg', 0),
(45, 1, '2015-04-13 18:36:13', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'open', 'open', '', '', '', '', '2015-04-13 18:36:13', '0000-00-00 00:00:00', '', 0, 'http://localhost/WordPress/Cartel/?post_type=product&p=45', 0, 'product', '', 0),
(46, 1, '2015-04-13 18:45:50', '2015-04-13 18:45:50', 'The demure Elizabeth Knit features a semi sheer open weave and a forgiving silhouette. A nude camisole underneath keeps a stylish but conservative look.', 'Elizabeth Knit Top', 'The demure Elizabeth Knit features a semi sheer open weave and a forgiving silhouette. A nude camisole underneath keeps a stylish but conservative look.', 'publish', 'open', 'closed', '', 'ship-your-idea', '', '', '2015-04-13 19:12:29', '2015-04-13 19:12:29', '', 0, 'http://localhost/WordPress/Cartel/?post_type=product&#038;p=46', 0, 'product', '', 0),
(47, 1, '2015-04-13 18:45:45', '2015-04-13 18:45:45', '', 'poster_1_up-500x500', '', 'inherit', 'open', 'open', '', 'poster_1_up-500x500', '', '', '2015-04-13 18:45:45', '2015-04-13 18:45:45', '', 46, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/poster_1_up-500x500.jpg', 0, 'attachment', 'image/jpeg', 0),
(48, 1, '2015-04-13 18:47:17', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'open', 'open', '', '', '', '', '2015-04-13 18:47:17', '0000-00-00 00:00:00', '', 0, 'http://localhost/WordPress/Cartel/?post_type=product&p=48', 0, 'product', '', 0),
(49, 1, '2015-04-13 18:52:20', '2015-04-13 18:52:20', '', 'slide-1', '', 'inherit', 'open', 'open', '', 'slide-1', '', '', '2015-04-13 18:52:20', '2015-04-13 18:52:20', '', 8, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/slide-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(50, 1, '2015-04-13 18:53:28', '2015-04-13 18:53:28', '', 'An EYE F', '', 'inherit', 'open', 'open', '', '8-autosave-v1', '', '', '2015-04-13 18:53:28', '2015-04-13 18:53:28', '', 8, 'http://localhost/WordPress/Cartel/8-autosave-v1/', 0, 'revision', '', 0),
(51, 1, '2015-04-13 00:02:16', '2015-04-13 00:02:16', '', 'STYLE SOLUTIONS', '', 'publish', 'closed', 'closed', '', 'style-solutions', '', '', '2015-04-13 18:55:52', '2015-04-13 18:55:52', '', 0, 'http://localhost/WordPress/Cartel/?post_type=slide&#038;p=51', 0, 'slide', '', 0),
(52, 1, '2015-04-13 18:53:59', '2015-04-13 18:53:59', '', 'slide-2', '', 'inherit', 'open', 'open', '', 'slide-2', '', '', '2015-04-13 18:53:59', '2015-04-13 18:53:59', '', 51, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/slide-2.jpg', 0, 'attachment', 'image/jpeg', 0),
(53, 1, '2015-04-13 18:54:01', '2015-04-13 18:54:01', '', 'slide-3', '', 'inherit', 'open', 'open', '', 'slide-3', '', '', '2015-04-13 18:54:01', '2015-04-13 18:54:01', '', 51, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/slide-3.jpg', 0, 'attachment', 'image/jpeg', 0),
(54, 1, '2015-04-13 00:01:36', '2015-04-13 00:01:36', '', 'WING MAN', '', 'publish', 'closed', 'closed', '', 'wing-man', '', '', '2015-04-13 18:56:00', '2015-04-13 18:56:00', '', 0, 'http://localhost/WordPress/Cartel/?post_type=slide&#038;p=54', 0, 'slide', '', 0),
(55, 1, '2015-04-13 18:58:07', '2015-04-13 18:58:07', '', 'homepage-three-column-promo-01B', '', 'inherit', 'open', 'open', '', 'homepage-three-column-promo-01b', '', '', '2015-04-13 18:58:07', '2015-04-13 18:58:07', '', 0, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/homepage-three-column-promo-01B.png', 0, 'attachment', 'image/png', 0),
(56, 1, '2015-04-13 18:58:15', '2015-04-13 18:58:15', '', 'homepage-three-column-promo-02', '', 'inherit', 'open', 'open', '', 'homepage-three-column-promo-02', '', '', '2015-04-13 18:58:15', '2015-04-13 18:58:15', '', 0, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/homepage-three-column-promo-02.png', 0, 'attachment', 'image/png', 0),
(57, 1, '2015-04-13 18:58:16', '2015-04-13 18:58:16', '', 'homepage-three-column-promo-03', '', 'inherit', 'open', 'open', '', 'homepage-three-column-promo-03', '', '', '2015-04-13 18:58:16', '2015-04-13 18:58:16', '', 0, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/homepage-three-column-promo-03.png', 0, 'attachment', 'image/png', 0),
(58, 1, '2015-04-13 19:08:44', '2015-04-13 19:08:44', 'The demure Elizabeth Knit features a semi sheer open weave and a forgiving silhouette. A nude camisole underneath keeps a stylish but conservative look.', 'Elizabeth Knit Top', '<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>\n', 'inherit', 'open', 'open', '', '46-autosave-v1', '', '', '2015-04-13 19:08:44', '2015-04-13 19:08:44', '', 46, 'http://localhost/WordPress/Cartel/46-autosave-v1/', 0, 'revision', '', 0),
(59, 1, '2015-04-13 19:07:24', '0000-00-00 00:00:00', '', 'Lafayette Convertible Dress', '', 'draft', 'open', 'closed', '', '', '', '', '2015-04-13 19:07:24', '2015-04-13 19:07:24', '', 0, 'http://localhost/WordPress/Cartel/?post_type=product&#038;p=59', 0, 'product', '', 0),
(60, 1, '2015-04-13 19:07:30', '0000-00-00 00:00:00', '', 'Tori Tank', '', 'draft', 'open', 'closed', '', '', '', '', '2015-04-13 19:07:30', '2015-04-13 19:07:30', '', 0, 'http://localhost/WordPress/Cartel/?post_type=product&#038;p=60', 0, 'product', '', 0),
(61, 1, '2015-04-13 19:07:36', '0000-00-00 00:00:00', '', 'Linen Blazer', '', 'draft', 'open', 'closed', '', '', '', '', '2015-04-13 19:07:36', '2015-04-13 19:07:36', '', 0, 'http://localhost/WordPress/Cartel/?post_type=product&#038;p=61', 0, 'product', '', 0),
(62, 1, '2015-04-13 19:07:47', '2015-04-13 19:07:47', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', 'Chelsea Tee', '<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>\n', 'inherit', 'open', 'open', '', '43-autosave-v1', '', '', '2015-04-13 19:07:47', '2015-04-13 19:07:47', '', 43, 'http://localhost/WordPress/Cartel/43-autosave-v1/', 0, 'revision', '', 0),
(63, 1, '2015-04-13 19:12:23', '2015-04-13 19:12:23', '', 'wbk012t', '', 'inherit', 'open', 'open', '', 'wbk012t', '', '', '2015-04-13 19:12:23', '2015-04-13 19:12:23', '', 46, 'http://localhost/WordPress/Cartel/wp-content/uploads/2015/04/wbk012t.jpg', 0, 'attachment', 'image/jpeg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_terms`
--

DROP TABLE IF EXISTS `wp_terms`;
CREATE TABLE IF NOT EXISTS `wp_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `wp_terms`
--

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Blog', 'blog', 0),
(2, 'simple', 'simple', 0),
(3, 'grouped', 'grouped', 0),
(4, 'variable', 'variable', 0),
(5, 'external', 'external', 0),
(6, 'Menu 1', 'menu-1', 0),
(7, 'Posters', 'posters', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_relationships`
--

DROP TABLE IF EXISTS `wp_term_relationships`;
CREATE TABLE IF NOT EXISTS `wp_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_term_relationships`
--

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 1, 0),
(23, 1, 0),
(25, 1, 0),
(34, 6, 0),
(36, 6, 0),
(37, 6, 0),
(39, 6, 0),
(41, 6, 0),
(42, 6, 0),
(43, 2, 0),
(43, 7, 0),
(46, 2, 0),
(46, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_taxonomy`
--

DROP TABLE IF EXISTS `wp_term_taxonomy`;
CREATE TABLE IF NOT EXISTS `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `wp_term_taxonomy`
--

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 3),
(2, 2, 'product_type', '', 0, 2),
(3, 3, 'product_type', '', 0, 0),
(4, 4, 'product_type', '', 0, 0),
(5, 5, 'product_type', '', 0, 0),
(6, 6, 'nav_menu', '', 0, 6),
(7, 7, 'product_cat', '', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `wp_usermeta`
--

DROP TABLE IF EXISTS `wp_usermeta`;
CREATE TABLE IF NOT EXISTS `wp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `wp_usermeta`
--

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'nickname', 'admin'),
(2, 1, 'first_name', ''),
(3, 1, 'last_name', ''),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'comment_shortcuts', 'false'),
(7, 1, 'admin_color', 'fresh'),
(8, 1, 'use_ssl', '0'),
(9, 1, 'show_admin_bar_front', 'true'),
(10, 1, 'wp_capabilities', 'a:1:{s:13:"administrator";b:1;}'),
(11, 1, 'wp_user_level', '10'),
(12, 1, 'dismissed_wp_pointers', 'wp360_locks,wp390_widgets,wp410_dfw'),
(13, 1, 'show_welcome_panel', '1'),
(15, 1, 'wp_dashboard_quick_press_last_post_id', '3'),
(16, 1, '_woocommerce_persistent_cart', 'a:1:{s:4:"cart";a:0:{}}'),
(18, 1, 'wp_user-settings', 'libraryContent=browse'),
(19, 1, 'wp_user-settings-time', '1428946741'),
(20, 1, 'closedpostboxes_post', 'a:0:{}'),
(21, 1, 'metaboxhidden_post', 'a:6:{i:0;s:13:"trackbacksdiv";i:1;s:10:"postcustom";i:2;s:16:"commentstatusdiv";i:3;s:11:"commentsdiv";i:4;s:7:"slugdiv";i:5;s:9:"authordiv";}'),
(22, 1, 'managenav-menuscolumnshidden', 'a:4:{i:0;s:11:"link-target";i:1;s:11:"css-classes";i:2;s:3:"xfn";i:3;s:11:"description";}'),
(23, 1, 'metaboxhidden_nav-menus', 'a:7:{i:0;s:30:"woocommerce_endpoints_nav_link";i:1;s:8:"add-post";i:2;s:11:"add-product";i:3;s:15:"add-testimonial";i:4;s:12:"add-post_tag";i:5;s:15:"add-product_cat";i:6;s:15:"add-product_tag";}'),
(24, 1, 'closedpostboxes_product', 'a:1:{i:0;s:10:"postcustom";}'),
(25, 1, 'metaboxhidden_product', 'a:1:{i:0;s:7:"slugdiv";}');

-- --------------------------------------------------------

--
-- Table structure for table `wp_users`
--

DROP TABLE IF EXISTS `wp_users`;
CREATE TABLE IF NOT EXISTS `wp_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `wp_users`
--

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'admin', '$P$BTQ9q3BzQF7v3IlDX91pFuXo4KNgu.1', 'admin', 'cartel@gmail.com', '', '2015-04-13 17:26:12', '', 0, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_attribute_taxonomies`
--

DROP TABLE IF EXISTS `wp_woocommerce_attribute_taxonomies`;
CREATE TABLE IF NOT EXISTS `wp_woocommerce_attribute_taxonomies` (
  `attribute_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(200) NOT NULL,
  `attribute_label` longtext,
  `attribute_type` varchar(200) NOT NULL,
  `attribute_orderby` varchar(200) NOT NULL,
  `attribute_public` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`attribute_id`),
  KEY `attribute_name` (`attribute_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_downloadable_product_permissions`
--

DROP TABLE IF EXISTS `wp_woocommerce_downloadable_product_permissions`;
CREATE TABLE IF NOT EXISTS `wp_woocommerce_downloadable_product_permissions` (
  `permission_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `download_id` varchar(32) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL DEFAULT '0',
  `order_key` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `downloads_remaining` varchar(9) DEFAULT NULL,
  `access_granted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access_expires` datetime DEFAULT NULL,
  `download_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`permission_id`),
  KEY `download_order_key_product` (`product_id`,`order_id`,`order_key`,`download_id`),
  KEY `download_order_product` (`download_id`,`order_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_order_itemmeta`
--

DROP TABLE IF EXISTS `wp_woocommerce_order_itemmeta`;
CREATE TABLE IF NOT EXISTS `wp_woocommerce_order_itemmeta` (
  `meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_item_id` bigint(20) NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `order_item_id` (`order_item_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_order_items`
--

DROP TABLE IF EXISTS `wp_woocommerce_order_items`;
CREATE TABLE IF NOT EXISTS `wp_woocommerce_order_items` (
  `order_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_item_name` longtext NOT NULL,
  `order_item_type` varchar(200) NOT NULL DEFAULT '',
  `order_id` bigint(20) NOT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_tax_rates`
--

DROP TABLE IF EXISTS `wp_woocommerce_tax_rates`;
CREATE TABLE IF NOT EXISTS `wp_woocommerce_tax_rates` (
  `tax_rate_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tax_rate_country` varchar(200) NOT NULL DEFAULT '',
  `tax_rate_state` varchar(200) NOT NULL DEFAULT '',
  `tax_rate` varchar(200) NOT NULL DEFAULT '',
  `tax_rate_name` varchar(200) NOT NULL DEFAULT '',
  `tax_rate_priority` bigint(20) NOT NULL,
  `tax_rate_compound` int(1) NOT NULL DEFAULT '0',
  `tax_rate_shipping` int(1) NOT NULL DEFAULT '1',
  `tax_rate_order` bigint(20) NOT NULL,
  `tax_rate_class` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`tax_rate_id`),
  KEY `tax_rate_country` (`tax_rate_country`),
  KEY `tax_rate_state` (`tax_rate_state`),
  KEY `tax_rate_class` (`tax_rate_class`),
  KEY `tax_rate_priority` (`tax_rate_priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_tax_rate_locations`
--

DROP TABLE IF EXISTS `wp_woocommerce_tax_rate_locations`;
CREATE TABLE IF NOT EXISTS `wp_woocommerce_tax_rate_locations` (
  `location_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `location_code` varchar(255) NOT NULL,
  `tax_rate_id` bigint(20) NOT NULL,
  `location_type` varchar(40) NOT NULL,
  PRIMARY KEY (`location_id`),
  KEY `tax_rate_id` (`tax_rate_id`),
  KEY `location_type` (`location_type`),
  KEY `location_type_code` (`location_type`,`location_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_termmeta`
--

DROP TABLE IF EXISTS `wp_woocommerce_termmeta`;
CREATE TABLE IF NOT EXISTS `wp_woocommerce_termmeta` (
  `meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `woocommerce_term_id` bigint(20) NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `woocommerce_term_id` (`woocommerce_term_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `wp_woocommerce_termmeta`
--

INSERT INTO `wp_woocommerce_termmeta` (`meta_id`, `woocommerce_term_id`, `meta_key`, `meta_value`) VALUES
(1, 7, 'order', '0'),
(2, 7, 'display_type', ''),
(3, 7, 'thumbnail_id', '0'),
(4, 7, 'product_count_product_cat', '2');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
