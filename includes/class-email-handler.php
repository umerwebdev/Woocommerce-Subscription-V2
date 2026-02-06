<?php
    defined( 'ABSPATH' ) || exit;

    class WPAegis_Email_Handler {

        public static function send( $order_id, $type ) {
            $order = wc_get_order( $order_id );
            if ( ! $order ) {
                return;
            }

            $mailer = WC()->mailer();
            $expiry = get_post_meta( $order_id, '_wpaegis_subscription_expiry', true );

            $subject = ( 'reminder' === $type )
                ? __( 'Subscription Expiry Reminder', 'wpaegis-subscriptions' )
                : __( 'Subscription Expired', 'wpaegis-subscriptions' );

            $message  = esc_html__( 'Hello', 'wpaegis-subscriptions' ) . ' ';
            $message .= esc_html( $order->get_billing_first_name() );
            $message .= '<br><br>';
            $message .= esc_html__( 'Expiry Date:', 'wpaegis-subscriptions' ) . ' ';
            $message .= esc_html( $expiry );

            $mailer->send(
                $order->get_billing_email(),
                $subject,
                $mailer->wrap_message( $subject, $message )
            );
        }
    }
