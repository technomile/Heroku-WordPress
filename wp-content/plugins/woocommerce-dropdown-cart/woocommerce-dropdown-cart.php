<?php
/*
Plugin Name: WooCommerce Dropdown Cart
Plugin URI: https://www.facebook.com/svincoll4
Description: A widget plugin for WooCommerce to display the cart at top of page
Author: svincoll4
Version: 1.3.1
Author URI: https://www.facebook.com/svincoll4
*/

class WooCommerce_Widget_DropdownCart extends WP_Widget {

    var $woo_widget_cssclass;
    var $woo_widget_description;
    var $woo_widget_idbase;
    var $woo_widget_name;

    /**
     * constructor
     *
     * @access public
     * @return void
     */
    function WooCommerce_Widget_DropdownCart() {

        /* Widget variable settings. */
        $this->woo_widget_cssclass 		= 'widget_shopping_mini_cart dropdown-cart';
        $this->woo_widget_description 	= __( "Display the user's Cart in the sidebar.", 'woocommerce' );
        $this->woo_widget_idbase 		= 'woocommerce_widget_minicart';
        $this->woo_widget_name 			= __( 'WooCommerce Dropdown Cart', 'woocommerce' );

        /* Widget settings. */
        $widget_ops = array( 'classname' => $this->woo_widget_cssclass, 'description' => $this->woo_widget_description );

        /* Create the widget. */
        $this->WP_Widget( 'widget_shopping_mini_cart', $this->woo_widget_name, $widget_ops );
    }


    /**
     * widget function.
     *
     * @see WP_Widget
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    function widget( $args, $instance ) {
        global $woocommerce;

        extract( $args );

        if ( is_cart() || is_checkout() ) return;

        $title = apply_filters('widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $hide_if_empty = empty( $instance['hide_if_empty'] )  ? 0 : 1;

        echo $before_widget;

        if ( $title )
            echo $before_title . $title . $after_title;

        global $woocommerce;
        ?>
        <div class="widget_shopping_mini_cart_content">
            <?php if ( !$hide_if_empty || sizeof( $woocommerce->cart->get_cart() ) > 0 ) : ?>
                <div class="dropdown-cart-button <?php echo $hide_if_empty ? 'hide_dropdown_cart_widget_if_empty' : '' ?>" style="<?php echo $hide_if_empty && sizeof( $woocommerce->cart->get_cart() ) == 0 ? "display:none;":"" ?>">
                    <a href="#" class="dropdown-total"><?php echo sizeof( $woocommerce->cart->get_cart()) ?> <?php _e('items(s)', 'woocommerce-ddc') ?> - <?php echo $woocommerce->cart->get_cart_subtotal(); ?></a>
                    <div class="dropdown">
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
        $hide_if_empty = empty( $instance['hide_if_empty'] ) ? 0 : 1;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'woocommerce') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>

        <p><input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id('hide_if_empty') ); ?>" name="<?php echo esc_attr( $this->get_field_name('hide_if_empty') ); ?>"<?php checked( $hide_if_empty ); ?> />
            <label for="<?php echo $this->get_field_id('hide_if_empty'); ?>"><?php _e( 'Hide if cart is empty', 'woocommerce' ); ?></label></p>
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
            wp_enqueue_script('jquery-dropdown-cart', plugins_url('woocommerce-dropdown-cart/js/main.js'), array('jquery'));
            wp_enqueue_style('jquery-dropdown-cart', plugins_url('woocommerce-dropdown-cart/css/style.css'));
        }
    }
}
add_action( 'wp_enqueue_scripts', 'register_script_WooCommerce_Widget_DropdownCart' );
