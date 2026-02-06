<?php
defined( 'ABSPATH' ) || exit;

class WPAegis_Admin_Product_Fields {

    public function __construct() {
        add_action(
            'woocommerce_product_options_general_product_data',
            array( $this, 'add_fields' )
        );

        add_action(
            'woocommerce_process_product_meta',
            array( $this, 'save_fields' )
        );
    }    

    public function add_fields() {
        echo '<div class="options_group">';

        woocommerce_wp_checkbox(
            array(
                'id'    => '_wpaegis_is_subscription',
                'label' => __( 'Subscription Product', 'wpaegis-subscriptions' ),
            )
        );

        woocommerce_wp_select(
            array(
                'id'      => '_wpaegis_subscription_duration',
                'label'   => __( 'Subscription Duration', 'wpaegis-subscriptions' ),
                'options' => array(
                    ''        => __( 'Select Duration', 'wpaegis-subscriptions' ),
                    '1_month' => __( '1 Month', 'wpaegis-subscriptions' ),
                    '1_year'  => __( '1 Year', 'wpaegis-subscriptions' ),
                ),
            )
        );

        wp_nonce_field( 'wpaegis_save_subscription', 'wpaegis_nonce' );
        echo '</div>';
    }

    public function save_fields( $post_id ) {
        if (
            ! isset( $_POST['wpaegis_nonce'] ) ||
            ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wpaegis_nonce'] ) ), 'wpaegis_save_subscription' )
        ) {
            return;
        }

        update_post_meta(
            $post_id,
            '_wpaegis_is_subscription',
            isset( $_POST['_wpaegis_is_subscription'] ) ? 'yes' : 'no'
        );

        if ( isset( $_POST['_wpaegis_subscription_duration'] ) ) {
            update_post_meta(
                $post_id,
                '_wpaegis_subscription_duration',
                sanitize_text_field( wp_unslash( $_POST['_wpaegis_subscription_duration'] ) )
            );
        }
    }
}
