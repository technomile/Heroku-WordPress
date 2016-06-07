<?php
/*
Plugin Name: Woocommerce Dropdown Cart
Plugin URI: https://wordpress.org/plugins/woocommerce-dropdown-cart/
Description: A widget plugin for WooCommerce to display the cart at top of page
Author: Phuc Pham
Version: 2.1.1
Author URI: http://www.clientsa2z.com
*/

class WooCommerce_Widget_DropdownCart extends WP_Widget {

    var $default_values = array(
        'title' => '',
        'hide_if_empty' => 0,
        'show_on_checkout' => 0,
        'popup_align' => 'left'
    );

    function __construct() {

        /* Widget settings. */
        $widget_options = array(
            'classname' => 'widget_shopping_mini_cart dropdown-cart',
            'description' => __( "Display the cart content", 'woocommerce-ddc' )
        );

        /* Create the widget. */
        parent::__construct( 'widget_shopping_mini_cart', __( 'WooCommerce Dropdown Cart', 'woocommerce-ddc' ), $widget_options );
    }


    function widget( $args, $instance ) {

        $instance = wp_parse_args($instance, $this->default_values);

        if(empty($instance['show_on_checkout']) && (is_cart() || is_checkout())){
            return;
        }

        $woocommerce = WC();

        $before_widget = $after_widget = $before_title = $after_title = '';
        extract( $args, EXTR_OVERWRITE );


        $hide_if_empty = empty( $instance['hide_if_empty'] )  ? 0 : 1;
        $popup_align = $instance['popup_align'] == 'left'?'left':'right';

        echo $before_widget;

        $title = apply_filters('widget_title', $instance['title']);
        if ( $title )
            echo $before_title . $title . $after_title;

        $cart_contents_count = $woocommerce->cart->get_cart_contents_count();

        $item_text = __('item', 'woocommerce-ddc');
        $items_text = __('items', 'woocommerce-ddc');

        ?>
        <div class="widget_shopping_mini_cart_content" id="<?php echo $this->id ?>-content">
            <?php if ( !$hide_if_empty || $cart_contents_count > 0 ) : ?>
                <div class="dropdown-cart-button <?php echo $hide_if_empty ? 'hide_dropdown_cart_widget_if_empty' : '' ?>" style="<?php echo $hide_if_empty && sizeof( $woocommerce->cart->get_cart() ) == 0 ? "display:none;":"" ?>">
                    <a href="#" class="dropdown-total"><?php echo $cart_contents_count.' '._n($item_text, $items_text, $cart_contents_count) ?> - <?php echo $woocommerce->cart->get_cart_subtotal(); ?></a>
                    <div class="dropdown dropdown-<?php echo $popup_align ?>">
                        <?php woocommerce_mini_cart(); ?>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php else: ?>
                <script type="text/javascript">
                    jQuery(function($){
                        $('#<?php echo $this->id ?>').hide();
                    });
                </script>
            <?php endif; ?>
        </div>
        <?php
        echo $after_widget;

    }


    /**
     * update function.
     *
     * @see WP_Widget->update
     * @access public
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    function update( $new_instance, $old_instance ) {
        $instance['title'] = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['hide_if_empty'] = empty( $new_instance['hide_if_empty'] ) ? 0 : 1;
        $instance['show_on_checkout'] = empty( $new_instance['show_on_checkout'] ) ? 0 : 1;
        $instance['popup_align'] = $new_instance['popup_align'];
        return $instance;
    }


    /**
     * form function.
     *
     * @see WP_Widget->form
     * @access public
     * @param array $instance
     * @return void
     */
    function form( $instance ) {

        $instance = wp_parse_args($instance, $this->default_values);

        $hide_if_empty = empty( $instance['hide_if_empty'] ) ? 0 : 1;
        $show_on_checkout = empty( $instance['show_on_checkout'] ) ? 0 : 1;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'woocommerce-ddc') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>

        <p><input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id('hide_if_empty') ); ?>" name="<?php echo esc_attr( $this->get_field_name('hide_if_empty') ); ?>"<?php checked( $hide_if_empty ); ?> />
            <label for="<?php echo $this->get_field_id('hide_if_empty'); ?>"><?php _e( 'Hide if cart is empty', 'woocommerce-ddc' ); ?></label></p>

        <p><input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_on_checkout') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_on_checkout') ); ?>"<?php checked( $show_on_checkout ); ?> />
            <label for="<?php echo $this->get_field_id('show_on_checkout'); ?>"><?php _e( 'Show this widget on cart/checkout pages', 'woocommerce-ddc' ); ?></label></p>
        <p>
            <label for="<?php echo $this->get_field_id('popup_align') ?>"><?php _e('Popup align:', 'woocommerce-ddc') ?></label>
            <select name="<?php echo $this->get_field_name('popup_align') ?>" id="<?php echo $this->get_field_id('popup_align') ?>" class="widefat">
                <option value="left" <?php selected('left', $instance['popup_align']) ?>><?php _e('Left', 'woocommerce-ddc') ?></option>
                <option value="right" <?php selected('right', $instance['popup_align']) ?>><?php _e('Right', 'woocommerce-ddc') ?></option>
            </select>
        </p>
    <?php
    }



}

function register_WooCommerce_Widget_DropdownCart() {
    if(class_exists('Woocommerce')) {
        register_widget('WooCommerce_Widget_DropdownCart');
    }
}

add_action( 'widgets_init', 'register_WooCommerce_Widget_DropdownCart' );

function register_script_WooCommerce_Widget_DropdownCart() {
    if(class_exists('Woocommerce')) {
        if( !is_admin() ){
            wp_enqueue_script('jquery');

            $suffix = !WP_DEBUG ? '.min' : '';

            wp_enqueue_script('jquery-dropdown-cart', plugins_url('woocommerce-dropdown-cart/js/main'.$suffix.'.js'), array('jquery'));
            wp_enqueue_style('jquery-dropdown-cart', plugins_url('woocommerce-dropdown-cart/css/style'.$suffix.'.css'));



        }
    }
}
add_action( 'wp_enqueue_scripts', 'register_script_WooCommerce_Widget_DropdownCart' );

add_action( 'plugins_loaded', 'woocommerce_ddc_load_textdomain' );
function woocommerce_ddc_load_textdomain(){
    $domain = "woocommerce-ddc";

    $locale = apply_filters('plugin_locale', get_locale(), $domain);
    load_textdomain($domain, WP_LANG_DIR.'/'.$domain.'-'.$locale.'.mo');
    load_plugin_textdomain( $domain, false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}