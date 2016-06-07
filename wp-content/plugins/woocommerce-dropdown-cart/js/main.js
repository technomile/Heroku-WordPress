jQuery(function($){
    $('body').on('click', '.dropdown-cart-button .dropdown-total', function($e){
        var $button = $(this).parent();
        var $popup = $('.dropdown', $button);

        if(!$popup.is(':visible')){

            $popup.removeClass('drop-left')
                .removeClass('drop-bottom');

            // get width/height
            $popup.show();
            var $width = $popup.width();
            var $height = $popup.height();
            var $button_offset = $button.get(0).getBoundingClientRect();
            $popup.hide();

            var $left = $button_offset.right - $width;
            var $right = $(window).width() - ($button_offset.left + $width);
            var $top = $button_offset.bottom - $height;
            var $bottom = $(window).height() - ($button_offset.bottom + $height);

            if($left < 10 && $right > 0){
                $popup.addClass('drop-left');
            }

            if($bottom < 10 && $top > 0){
                $popup.addClass('drop-bottom');
            }

            $popup.slideDown();
        }else{
            $popup.slideUp();
        }


        return false;
    });

    $('body').on('click', '.dropdown-cart-button', function($e){
        $e.stopPropagation();
    });

    $(document).on('click', function(){
        $('.dropdown-cart-button .dropdown').hide();
    });

    $('body').bind('adding_to_cart', function(){
        $('.widget_shopping_mini_cart').show();
    });

    $('body').bind('added_to_cart', function(){
        $('.widget_shopping_mini_cart').addClass('loading');
        var this_page = window.location.toString();
        this_page = this_page.replace( 'add-to-cart', 'added-to-cart' );
        if(this_page.indexOf('?') >= 0){
            this_page += '&t=' + new Date().getTime();
        }else{
            this_page += '?t=' + new Date().getTime();
        }

        $('.widget_shopping_mini_cart').each(function($i, $item){
            $('.widget_shopping_mini_cart_content', $item).load( this_page + ' #' + $item.id + '-content', function(){
                $($item).removeClass('loading');
            });
        });

    });
});
