<?php
defined( 'ABSPATH' ) || exit;

class WPAegis_Order_Handler {

    public function __construct() {
        add_action( 'woocommerce_thankyou', array( $this, 'handle_order' ) );
        add_action( 'check_subscription_expiry_event', array( $this, 'handle_expiry' ) );
        add_action( 'send_subscription_reminder_event', array( $this, 'handle_reminder' ) );
    }

    public function handle_order( $order_id ) {
        $order = wc_get_order( $order_id );
        if ( ! $order ) {
            return;
        }

        foreach ( $order->get_items() as $item ) {
            $product = $item->get_product();
            if ( ! $product ) {
                continue;
            }

            if ( 'yes' !== get_post_meta( $product->get_id(), '_wpaegis_is_subscription', true ) ) {
                continue;
            }

            $duration = get_post_meta( $product->get_id(), '_wpaegis_subscription_duration', true );

            $expiry = ( '1_month' === $duration )
                ? strtotime( '+1 month', current_time( 'timestamp' ) )
                : strtotime( '+1 year', current_time( 'timestamp' ) );

            update_post_meta( $order_id, '_wpaegis_subscription_expiry', gmdate( 'Y-m-d', $expiry ) );

            if ( ! wp_next_scheduled( 'send_subscription_reminder_event', array( $order_id ) ) ) {
                wp_schedule_single_event( $expiry - WEEK_IN_SECONDS, 'send_subscription_reminder_event', array( $order_id ) );
            }

            if ( ! wp_next_scheduled( 'check_subscription_expiry_event', array( $order_id ) ) ) {
                wp_schedule_single_event( $expiry, 'check_subscription_expiry_event', array( $order_id ) );
            }
        }
    }

    public function handle_expiry( $order_id ) {
        update_post_meta( $order_id, '_wpaegis_subscription_status', 'expired' );
        WPAegis_Email_Handler::send( $order_id, 'expired' );
    }

    public function handle_reminder( $order_id ) {
        WPAegis_Email_Handler::send( $order_id, 'reminder' );
    }
}
