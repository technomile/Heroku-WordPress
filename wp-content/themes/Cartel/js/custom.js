jQuery(document).ready(function() {

	jQuery('.flexslider').flexslider({
		controlNav: false
	});
	
	/* Custom select */

	jQuery('.selectpicker').selectpicker();
	

	jQuery( ".search-button" ).click(function() {
	  jQuery( ".search-box" ).slideToggle( "slow", function() {
	    // Animation complete.
	  });
	});
	
	jQuery( ".testimonials-list" ).jshowoff({
		autoPlay:false,
		effect : 'fade',
		controls:false,
	});
	

	selectnav('cartel', {
		label: 'Select your menu item ',
		nested: true,
		indent: '-'
		});	
	
});
