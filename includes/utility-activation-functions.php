<?php
function yith_disable_license_activation_redirect() {
    if (class_exists('YITH_Plugin_Licence_Onboarding')) {
        remove_action('admin_init', ['YITH_Plugin_Licence_Onboarding', 'handle_redirect'], 5);
    }
}

function yith_override_onboarding_queue() {
	set_transient('yith_plugin_licence_onboarding_queue', [], 1);
}


function yith_custom_disable_update_check() {
    if (class_exists('YITH_Plugin_Upgrade')) {
        $yith_upgrade_instance = YITH_Plugin_Upgrade::instance();
        remove_filter('pre_set_site_transient_update_plugins', array($yith_upgrade_instance, 'check_update'));
    }
}

function block_li_check_urls($preempt, $parsed_args, $url) {
    $blocked_urls = [
        'https://licence.yithemes.com/api/check',
        'https://casper.yithemes.com/wc-api/software-api/'
    ];

    if (in_array($url, $blocked_urls, true)) {
        return [
            'headers' => [],
            'body' => json_encode([
                'timestamp' => time(),
                'error' => false,
                'code' => 200,
                'activated' => true
            ]),
            'response' => [
                'code' => 200,
                'message' => 'OK'
            ],
            'cookies' => []
        ];
    }
    
    return $preempt;
}