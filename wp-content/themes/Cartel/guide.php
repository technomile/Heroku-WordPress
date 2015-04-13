<?php
function theme_guide(){
add_theme_page( 'Theme guide','Setup Guide','edit_themes', 'theme-documentation', 'w2f_theme_guide');
}
add_action('admin_menu', 'theme_guide');

function w2f_theme_guide(){
		echo '
		
<div id="welcome-panel" class="about-wrap">



	<div class="welcome-panel-content">
	
	<h1> '.wp_get_theme().' WordPress theme</h1>

	
		<p class="about-text"> '.wp_get_theme().' is an Ecommerce theme from Fabthemes.com. This theme is built for the Woocommerce plugin. Woocommerce is the most popular ecommerce solution based on WordPress.  </p>
		
		<hr>
		<div class="changelog ">
			<h3>Required plugins </h3>
			<p>The theme requires few plugins to work the way it is originally intended to. You will find a notification on the admin panel prompting you to install the required plugins. Please install and activate the plugins.  </p>
			<ul>
				<li><a href="http://wordpress.org/extend/plugins/options-framework/">Options framework</a></li>
				<li> <a href="http://wordpress.org/plugins/woocommerce/">Woocommerce</a> </li>
				<li> <a href="http://wordpress.org/plugins/testimonials-by-woothemes">Testimonials</a> </li>
				<li> <a href="http://wordpress.org/plugins/woocommerce-dropdown-cart/">Dropdown Cart</a> </li>
				<li> <a href="http://wordpress.org/plugins/wp-pagenavi/"> WP pagenavi </a> </li>
			</ul>

		</div>
		<hr>
		
		<div class="changelog">
		
		<h3>Theme options</h3>
			<p> Cartel theme comes with an options page. This enables you to configure the template\'s settings and pages.</p>  
			<img src="https://jinsona.files.wordpress.com/2014/06/options.png" alt="" /> <br><br>
			<b> 1. Logo</b>
			<p> Give you an option to upload a custom logo for your site</p>
			<b> 2. Header text </b>
			<p> Enter a custom text on the section above the logo. Ideal to place some info about your site </p>
			<b> 3. Footer text </b>
			<p> Enter a custom text on the section below the footer credits. Ideal to place some info about your site. </p>
			<b> 4. Breadcrumbs background </b>
			<p> Upload a background image for the breadcrumbs and title section.  </p>	
				
			<b> 5. Slide items </b>		
			<p> Set the number of slide items to be shown on the homepage jquery slider. </p>			
			
			<b> 6. Banner section background </b>
			<p> The homepage holds a section to feature 3 customisable banner items. You can upload a background for this section.  </p>			
			<b> 7. Banner image </b>
			<p> You have option to upload 3 different banner images. </p>			
		
			<b> 8. Banner link </b>
			<p> Use this option to provide link url to each banner image items. </p>		
		
			<b> 9. Blog section background </b>
			<p> The homepage holds a section below the products that shows the most recent 3 blog items. Use this option to upload a background image for this section. </p>		
			
			<b> 10. Testimonials </b>
			<p> The homepage holds a testimonial section just above the footer widgets. Use this option to set the number of testimonial items to display. </p>			
		
			<b> 11. Banner options </b>
			<p> Use this option to customise the sidebar ad banners </p>	

		</div>
		<hr />
		

		<div class="changelog ">
			<h3>Theme setup</h3>
			
			<p> Upload the theme to the themes directory of your WordPress installation and activate it. Also install and activate the required plugins listed above. We have included an xml database file with sample content to jumpstart your website setup. Use the import tool under the Tools menu to import the database. </p>
			

			
			<div class="feature-section">
			<h4> Setting up homepage </h4>
			<img src="https://jinsona.files.wordpress.com/2014/06/homepage.png" alt="" />
			<p> Cartel has a custom homepage template. It consists featured slider, banner ads, Product lists, blog items, testimonials etc. To set the homepage follow the steps given below </p>
					<ul>
						<li> Create a new page named "Home", if you do not already have it. </li>
						<li> Use the "Homepage" template for it under page attributes.</li>
						<li> Go to Admin panel > Settings > Reading and on Front page displays select static page option.</li>
						<li> Select the Page you created earlier with "Homepage" template for the Front page.</li>
						
					</ul>
			
			<p>Similarly use the "Blog" page for the posts page option.</p>
			
			</div>


			<div class="feature-section">
			<h4> jQuery slider </h4>
			<p> The cartel theme has a slider on the homepage. The following video shows how to create slide items for the slider. You will be able to set the number of slide items to be shown in the theme option page. </p>
			<p><iframe src="http://www.screenr.com/embed/ykAN" width="650" height="396" frameborder="0"></iframe></p>
			
			
			</div>
						
			
			<div class="feature-section">
			<h4> Features Widget </h4>
			<p> The cartel theme uses a custom widget are on the home page. You will find a Homepage widget area in the widget manger section. Drag and drop the cartel feature widget there. </p>
			<img src="https://jinsona.files.wordpress.com/2014/06/feature-widget.png" alt="" />
			
			</div>
			
			<div class="feature-section">
			<h4> Homepage Banners setup  </h4>
			<p> The homepage holds a section to display customisable banner ads. Please use the theme option page to configure the banner ads. </p>
			
			</div>			
			
			
			<div class="feature-section">
			<h4> Testimonial setting  </h4>
			<p> The homepage has a section for testimonials. This is a plugin powered feature. Once you have the Testimonial plugin activated you will be able to create the testimonials. Please check the video below to see how to create the testimonial items.</p>
			<p><iframe width="640" height="360" src="//www.youtube.com/embed/nznIgAtYvJc" frameborder="0" allowfullscreen></iframe></p>
			
			</div>			
			
			
			<div class="changelog">
			<h3> Woocommerce documentation</h3>
			<p> Woocommerce is the most popular eCommerce solution based on WordPress. The shop aspect of this theme is based on woocommerce plugin.  For documentation about configuring Woocommerce plugin please visit their <a href="http://docs.woothemes.com/documentation/plugins/woocommerce/getting-started/">official documentation website</a> </p>
			</div>
			
			
	
	
				
		<div class="changelog ">
			' . file_get_contents(dirname(__FILE__) . '/FT/license-html.php') . '
		</div>
	
				


	</div>
	</div>
		
		';
		

}
