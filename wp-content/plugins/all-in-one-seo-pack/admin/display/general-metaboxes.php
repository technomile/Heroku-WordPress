<?php

/**
 * @package All-in-One-SEO-Pack
 */

class aiosp_metaboxes {
	
	function __construct() {
		//construct

	}
	

	
	
	
	
	
	static function display_extra_metaboxes( $add, $meta ) {
		echo "<div class='aioseop_metabox_wrapper' >";
		switch ( $meta['id'] ) {
			case "aioseop-about":
				?><div class="aioseop_metabox_text">
							<p><h2 style="display:inline;"><?php echo AIOSEOP_PLUGIN_NAME; ?></h2><?php sprintf( __( "by %s of %s.", 'all-in-one-seo-pack' ), 'Michael Torbert', '<a target="_blank" title="Semper Fi Web Design"
							href="http://semperfiwebdesign.com/">Semper Fi Web Design</a>' ); ?>.</p>
							<?php
							global $current_user;
							$user_id = $current_user->ID;
							$ignore = get_user_meta( $user_id, 'aioseop_ignore_notice' );
							if ( !empty( $ignore ) ) {
								$qa = Array();
								wp_parse_str( $_SERVER["QUERY_STRING"], $qa );
								$qa['aioseop_reset_notices'] = 1;
								$url = '?' . build_query( $qa );
								echo '<p><a href="' . $url . '">' . __( "Reset Dismissed Notices", 'all-in-one-seo-pack' ) . '</a></p>';
							}
							if ( !AIOSEOPPRO ) {
							?>
							<p>
							<strong><?php echo aiosp_common::get_upgrade_hyperlink( 'side', __('Pro Version', 'all-in-one-seo-pack'), __('UPGRADE TO PRO VERSION', 'all-in-one-seo-pack'), '_blank' );  ?></strong></p>
							<?php } ?>
						</div>
				<?php
		    case "aioseop-donate":
		        ?>
				<div>

				<?php if ( !AIOSEOPPRO ) { ?>
					<div class="aioseop_metabox_text">
						<p>If you like this plugin and find it useful, help keep this plugin free and actively developed by clicking the <a 				href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=mrtorbert%40gmail%2ecom&item_name=All%20In%20One%20SEO%20Pack&item_number=Support%20Open%20Source&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8"
							target="_blank"><strong>donate</strong></a> button or send me a gift from my <a
							href="https://www.amazon.com/wishlist/1NFQ133FNCOOA/ref=wl_web" target="_blank">
							<strong>Amazon wishlist</strong></a>.  Also, don't forget to follow me on <a
							href="http://twitter.com/michaeltorbert/" target="_blank"><strong>Twitter</strong></a>.
						</p>
					</div>
				<?php } ?>

					<div class="aioseop_metabox_feature">

				<?php if ( !AIOSEOPPRO ) { ?>
								<a target="_blank" title="<?php _e( 'Donate', 'all-in-one-seo-pack' ); ?>"
	href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=mrtorbert%40gmail%2ecom&item_name=All%20In%20One%20SEO%20Pack&item_number=Support%20Open%20Source&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8">
					<img src="<?php echo AIOSEOP_PLUGIN_URL; ?>images/donate.jpg" alt="<?php _e('Donate with Paypal', 'all-in-one-seo-pack' ); ?>" />	</a>
					<a target="_blank" title="Amazon Wish List" href="https://www.amazon.com/wishlist/1NFQ133FNCOOA/ref=wl_web">
					<img src="<?php echo AIOSEOP_PLUGIN_URL; ?>images/amazon.jpg" alt="<?php _e('My Amazon Wish List', 'all-in-one-seo-pack' ); ?>" /> </a>
				<?php } ?>

					<a target="_blank" title="<?php _e( 'Follow us on Facebook', 'all-in-one-seo-pack' ); ?>" href="http://www.facebook.com/pages/Semper-Fi-Web-Design/121878784498475"><span class="aioseop_follow_button aioseop_facebook_follow"></span></a>
					<a target="_blank" title="<?php _e( 'Follow us on Twitter', 'all-in-one-seo-pack' ); ?>" href="http://twitter.com/semperfidev/"><span class="aioseop_follow_button aioseop_twitter_follow"></span></a>
					</div><?php if(get_locale() != 'en_US'){ ?>
					<div><strong>
					<a target="_blank" title="translate" href="https://translate.wordpress.org/projects/wp-plugins/all-in-one-seo-pack">
					<?php _e( 'We need your help translating All in One SEO Pack into your language! Click Here to help make the translation complete and fix any errors.' , 'all-in-one-seo-pack' );  ?>
					</a></strong>
					</div>
					<?php } ?>
				</div>
		        <?php
		        break;
			case "aioseop-list":
			?>
				<div class="aioseop_metabox_text">
						<form action="http://semperfiwebdesign.us1.list-manage.com/subscribe/post?u=794674d3d54fdd912f961ef14&amp;id=af0a96d3d9"
						method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
						<h2><?php _e( 'Join our mailing list for tips, tricks, and WordPress secrets.', 'all-in-one-seo-pack' ); ?></h2>
						<p><i><?php _e( 'Sign up today and receive a free copy of the e-book 5 SEO Tips for WordPress ($39 value).', 'all-in-one-seo-pack' ); ?></i></p>
						<p><input type="text" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email Address">
							<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn"></p>
						</form>
				</div>
			<?php
				break;
		    case "aioseop-support":
		        ?><div class="aioseop_metabox_text">
				<p><div class="aioseop_icon aioseop_file_icon"></div><a target="_blank" href="http://semperplugins.com/documentation/"><?php _e( 'Read the All in One SEO Pack user guide', 'all-in-one-seo-pack' ); ?></a></p>
				<p><div class="aioseop_icon aioseop_support_icon"></div><a target="_blank" title="<?php _e( 'All in One SEO Pro Plugin Support Forum', 'all-in-one-seo-pack' ); ?>"
				href="http://semperplugins.com/support/"><?php _e( 'Access our Premium Support Forums', 'all-in-one-seo-pack' ); ?></a></p>
				<p><div class="aioseop_icon aioseop_cog_icon"></div><a target="_blank" title="<?php _e( 'All in One SEO Pro Plugin Changelog', 'all-in-one-seo-pack' ); ?>"
				href="<?php if ( AIOSEOPPRO ) { echo 'http://semperplugins.com/documentation/all-in-one-seo-pack-pro-changelog/'; } else { echo 'http://semperfiwebdesign.com/blog/all-in-one-seo-pack/all-in-one-seo-pack-release-history/'; } ?>"><?php _e( 'View the Changelog', 'all-in-one-seo-pack' ); ?></a></p>
				<p><div class="aioseop_icon aioseop_youtube_icon"></div><a target="_blank" href="http://semperplugins.com/doc-type/video/"><?php _e( 'Watch video tutorials', 'all-in-one-seo-pack' ); ?></a></p>
				<p><div class="aioseop_icon aioseop_book_icon"></div><a target="_blank" href="http://semperplugins.com/documentation/quick-start-guide/"><?php _e( 'Getting started? Read the Beginners Guide', 'all-in-one-seo-pack' ); ?></a></p>
				</div>
		        <?php
		        break;
		}
		echo "</div>";
	}
	
	
	
	
	
	
	
	
	
}