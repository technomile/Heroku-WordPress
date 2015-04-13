jQuery(function($){
    jQuery('.widget_shopping_mini_cart').on('click', '.dropdown-total', function(){
        $(this).next().slideToggle();

        return false;
    });

    $('body').bind('adding_to_cart', function(){
        $('.widget_shopping_mini_cart').show();
    });

    $('body').bind('added_to_cart', function(){
        $('.widget_shopping_mini_cart').addClass('loading');
        var this_page = window.location.toString();
        this_page = this_page.replace( 'add-to-cart', 'added-to-cart' );

        $('.widget_shopping_mini_cart_content').load( this_page + ' .dropdown-cart-button', function() {
            $('.widget_shopping_mini_cart').removeClass('loading');
        });
    });
});
