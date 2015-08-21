<?php
/**
 * Plugin Name: Testimonials
 * Plugin URI: http://woothemes.com/
 * Description: Hi, I'm your testimonials management plugin for WordPress. Show off what your customers or website users are saying about your business and how great they say you are, using our shortcode, widget or template tag.
 * Author: WooThemes
 * Version: 1.5.4
 * Author URI: http://woothemes.com/
 *
 * @package WordPress
 * @subpackage Woothemes_Testimonials
 * @author Matty
 * @since 1.0.0
 */

require_once( 'classes/class-woothemes-testimonials.php' );
require_once( 'classes/class-woothemes-testimonials-taxonomy.php' );
require_once( 'woothemes-testimonials-template.php' );
require_once( 'classes/class-woothemes-widget-testimonials.php' );
global $woothemes_testimonials;
$woothemes_testimonials = new Woothemes_Testimonials( __FILE__ );
$woothemes_testimonials->version = '1.5.4';
