<?php
if ( ! class_exists( 'YITH_Activator' ) ) {
    class YITH_Activator {
        private $yith_plugins = [
            'yith-woocommerce-stripe',
            'yith-woocommerce-recently-viewed-products',
            'yith-woocommerce-tab-manager',
	    'yith-woocommerce-stripe',
	    'yith-easy-order-page-for-woocommerce',
            'yith-woocommerce-recently-viewed-products',
            'yith-woocommerce-tab-manager',
            'yith-woocommerce-name-your-price',
            'yith-active-campaign-for-woocommerce',
            'yith-woocommerce-zoom-magnifier',
            'yith-woocommerce-added-to-cart-popup',
            'yith-google-product-feed-for-woocommerce',
            'yith-woocommerce-questions-and-answers',
            'yith-stripe-connect-for-woocommerce',
            'yith-woocommerce-wishlist',
            'yith-geoip-language-redirect-for-woocommerce',
            'yith-woocommerce-minimum-maximum-quantity',
            'yith-woocommerce-customize-myaccount-page',
            'yith-woocommerce-product-bundles',
            'yith-woocommerce-sequential-order-number',
            'yith-woocommerce-delivery-date',
            'yith-woocommerce-eu-energy-label',
            'yith-infinite-scrolling',
            'yith-live-chat',
            'yith-woocommerce-affiliates',
            'yith-woocommerce-anti-fraud',
            'yith-product-description-in-loop-for-woocommerce',
            'yith-woocommerce-advanced-product-options',
            'yith-woocommerce-waiting-list',
            'yith-woocommerce-cart-messages',
            'yith-donations-for-woocommerce',
            'yith-woocommerce-email-templates',
            'yith-woocommerce-quick-export',
            'yith-product-size-charts-for-woocommerce',
            'yith-woocommerce-customer-history',
            'yith-faq-plugin-for-wordpress',
            'yith-woocommerce-authorizenet-payment-gateway',
            'yith-woocommerce-bulk-product-editing',
            'yith-woocommerce-featured-video',
            'yith-woocommerce-request-a-quote',
            'yith-woocommerce-deposits-and-down-payments',
            'yith-woocommerce-pre-order',
            'yith-woocommerce-brands-add-on',
            'yith-desktop-notifications-for-woocommerce',
            'yith-woocommerce-checkout-manager',
            'yith-woocommerce-role-based-prices',
            'yith-point-of-sale-for-woocommerce',
            'yith-woocommerce-best-sellers',
            'yith-deals-for-woocommerce',
            'yith-easy-login-register-popup-for-woocommerce',
            'yith-woocommerce-share-for-discounts',
            'yith-woocommerce-ajax-search',
            'yith-woocommerce-terms-conditions-popup',
            'yith-woocommerce-catalog-mode',
            'yith-automatic-role-changer-for-woocommerce',
            'yith-paypal-payouts-for-woocommerce',
            'yith-product-shipping-for-woocommerce',
            'yith-woocommerce-subscription',
            'yith-woocommerce-auctions',
            'yith-woocommerce-booking',
            'yith-woocommerce-advanced-reviews',
            'yith-woocommerce-mailchimp',
            'yith-store-locator-for-wordpress',
            'yith-woocommerce-barcodes',
            'yith-woocommerce-color-label-variations',
            'yith-dynamic-pricing-per-payment-method-for-woocommerce',
            'yith-woocommerce-gift-cards',
            'yith-frontend-manager-for-woocommerce',
            'yith-woocommerce-account-funds',
            'yith-woocommerce-points-and-rewards',
            'yith-woocommerce-one-click-checkout',
            'yith-payment-method-restrictions-for-woocommerce',
            'yith-woocommerce-recover-abandoned-cart',
            'yith-woocommerce-quick-checkout-for-digital-goods',
            'yith-woocommerce-dynamic-pricing-and-discounts',
            'yith-event-tickets-for-woocommerce',
            'yith-woocommerce-sms-notifications',
            'yith-woocommerce-surveys',
            'yith-custom-thank-you-page-for-woocommerce',
            'yith-woocommerce-pdf-invoice',
            'yith-woocommerce-product-vendors',
            'yith-woocommerce-ajax-navigation',
            'yith-quick-order-forms-for-woocommerce',
            'yith-advanced-refund-system-for-woocommerce',
            'yith-woocommerce-review-reminder',
            'yith-woocommerce-eu-vat',
            'yith-woocommerce-additional-uploads',
            'yith-paypal-braintree-for-woocommerce',
            'yith-woocommerce-category-accordion',
            'yith-woocommerce-product-countdown',
            'yith-woocommerce-popup',
            'yith-woocommerce-pending-order-survey',
            'yith-woocommerce-coupon-email-system',
            'yith-woocommerce-watermark',
            'yith-wordpress-title-bar-effects',
            'yith-woocommerce-custom-order-status',
            'yith-multiple-shipping-addresses-for-woocommerce',
            'yith-woocommerce-product-slider-carousel',
            'yith-composite-products-for-woocommerce',
            'yith-paypal-adaptive-payments-for-woocommerce',
            'yith-best-price-guaranteed-for-woocommerce',
            'yith-woocommerce-save-for-later',
            'yith-amazon-s3-storage',
            'yith-woocommerce-review-for-discounts',
            'yith-wordpress-test-environment',
            'yith-woocommerce-membership',
            'yith-woocommerce-social-login',
            'yith-woocommerce-frequently-bought-together',
            'yith-cost-of-goods-for-woocommerce',
            'yith-woocommerce-quick-view',
            'yith-woocommerce-compare',
            'yith-woocommerce-multi-step-checkout',
            'yith-woocommerce-badges-management',
            'yith-woocommerce-order-tracking',
            // ... Add all the other YITH plugins you want to activate
        ];

        public function __construct() {
            add_action('init', array($this, 'load_yith_plugins'));
        }

        public function load_yith_plugins() {
            foreach ($this->yith_plugins as $plugin_slug) {
                $this->load_yith_license($plugin_slug);
            }
        }

        private function load_yith_license($plugin_slug) {
            if (!$this->is_plugin_active($plugin_slug)) {
                return;
            }

            $license_options = get_option('yit_products_licence_activation', array());
            if (!isset($license_options[$plugin_slug])) {
                $license_options[$plugin_slug] = $this->default_license_data();
            }

            update_option('yit_products_licence_activation', $license_options);
        }

        private function is_plugin_active($plugin_slug) {
            $active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
            foreach ($active_plugins as $plugin_path) {
                if (strpos($plugin_path, $plugin_slug) !== false) {
                    return true;
                }
            }
            return false;
        }

        private function default_license_data() {
            return [
                'activated' => true,
                'email' => 'members@devtools.club',
                'licence_key' => '****-****-****-****',
                'activation_limit' => '999',
                'activation_remaining' => '998',
                'is_membership' => 'true',
                'marketplace' => 'yith',
                'licence_expires' => strtotime('+5 years')
            ];
        }
    }
}
