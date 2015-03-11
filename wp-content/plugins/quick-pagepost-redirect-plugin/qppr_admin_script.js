(function($){
	$(document).ready(function() {
		$('span.qppr_meta_help').css('display','none');
		$('span.qppr_meta_help_wrap').live('hover',function(e){
			var $curdisp = $(this).find('span.qppr_meta_help').css('display');
			if($curdisp == 'none'){
				$(this).find('span.qppr_meta_help').css('display','inline');
			}else{
				$(this).find('span.qppr_meta_help').css('display','none');
			}
			e.preventDefault();
		});
	});
})(jQuery)
