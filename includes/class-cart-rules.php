<?php
defined( 'ABSPATH' ) || exit;

class WPAegis_Cart_Rules {

    public function __construct() {
        add_filter(
            'woocommerce_add_to_cart_validation',
            array( $this, 'validate_cart' ),
            10,
            3
        );
    }

    public function validate_cart( $passed, $product_id ) {
        if ( 'yes' !== get_post_meta( $product_id, '_wpaegis_is_subscription', true ) ) {
            return $passed;
        }

        foreach ( WC()->cart->get_cart() as $key => $item ) {
            if ( 'yes' === get_post_meta( $item['product_id'], '_wpaegis_is_subscription', true ) ) {
                WC()->cart->remove_cart_item( $key );
            }
        }

        return true;
    }
}
