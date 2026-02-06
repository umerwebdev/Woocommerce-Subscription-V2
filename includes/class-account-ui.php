<?php
defined( 'ABSPATH' ) || exit;

class WPAegis_Account_UI {

    public function __construct() {
        add_action(
            'woocommerce_order_details_after_order_table',
            array( $this, 'show_expiry_on_order' )
        );

        add_filter(
            'woocommerce_my_account_my_orders_columns',
            array( $this, 'add_expiry_column' )
        );

        add_action(
            'woocommerce_my_account_my_orders_column_subscription_expiry',
            array( $this, 'render_expiry_column' )
        );
    }

    private function has_subscription( $order ) {
        foreach ( $order->get_items() as $item ) {
            $product_id = $item->get_product_id();

            if (
                'yes' === get_post_meta( $product_id, '_wpaegis_is_subscription', true ) ||
                'yes' === get_post_meta( $product_id, '_is_subscription_product', true ) // backward compatibility
            ) {
                return true;
            }
        }
        return false;
    }


    private function get_expiry( $order_id ) {
        return get_post_meta( $order_id, '_wpaegis_subscription_expiry', true )
            ?: get_post_meta( $order_id, '_subscription_expiry', true );
    }

    public function show_expiry_on_order( $order ) {
        if ( ! $this->has_subscription( $order ) ) {
            return;
        }

        $expiry = $this->get_expiry( $order->get_id() );

        if ( $expiry ) {
            echo '<p><strong>' .
                esc_html__( 'Subscription Expiry Date:', 'wpaegis-subscriptions' ) .
                '</strong> ' . esc_html( $expiry ) . '</p>';
        }
    }

    public function add_expiry_column( $columns ) {
        $columns['subscription_expiry'] = esc_html__( 'Expiry Date', 'wpaegis-subscriptions' );
        return $columns;
    }

    public function render_expiry_column( $order ) {
        if ( ! $this->has_subscription( $order ) ) {
            echo '-';
            return;
        }

        $expiry = $this->get_expiry( $order->get_id() );
        echo $expiry ? esc_html( $expiry ) : '-';
    }
}
