jQuery(document).ready(function () {

	// Установка реального цвета с учётом прозрачности
	function setIColor(fake_i, color, opacity) {
			var id = fake_i.attr("id");
			var name = id.substring(5);
			jQuery('#' + name).val(color);
			jQuery('#' + name + '_opacity').val(opacity);
	}

	function setColorPicker() {
		jQuery("input.color-picker").css({"height": "auto", "padding-top": "7px", "padding-right": "7px", "padding-bottom": "7px"});

		jQuery("input.color-picker").minicolors({
			'control': "wheel",
			'defaultValue': "#FFFFFF",
			'changeDelay': 25,
			'inline': false,
			'position': "bottom left",
			'letterCase': "lowercase",
			'theme': "bootstrap",
			'opacity': true,
			'change': function(hex, opacity) {
					var color = hex;
					if (opacity != 1)
							color = jQuery(this).minicolors('rgbaString');

					setIColor(jQuery(this), color, opacity);
			},
			'hide': function() {
					var opacity =  jQuery(this).minicolors('opacity');
					var color =  jQuery(this).val();
					if (opacity != 1)
							color = jQuery(this).minicolors('rgbaString');

					setIColor(jQuery(this), color, opacity);
			}
		});
		jQuery(".minicolors").css({"width": "100%"});
		jQuery(".minicolors-swatch").css({"top": "4px"});
	}

	// + Выставляем opacity
	// + Запоняем скрытые поля из знач по умолчанию
	jQuery("input[type=hidden]").each(function() {
		var id = jQuery(this).attr('id');

		// Запоняем скрытые поля из знач по умолчанию
		if (typeof(id) != 'undefined' && id.substring(10) != 'opacity' && jQuery("#fake_" + id.substring(0, 9)).length > 0) {
				if (jQuery(this).val() == '')
						jQuery(this).val( jQuery("#fake_" + id.substring(0, 9)).val() );
		}

		if (typeof(id) == 'undefined' || id.substring(10) != 'opacity' || jQuery("#fake_" + id.substring(0, 9)).length <= 0)
				return;

		jQuery("#fake_" + id.substring(0, 9)).attr('data-opacity', jQuery(this).val());
	});

	setColorPicker();
});