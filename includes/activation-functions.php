<?php
function yith_disable_license_activation_redirect() {
    if (class_exists('YITH_Plugin_Licence_Onboarding')) {
        remove_action('admin_init', array('YITH_Plugin_Licence_Onboarding', 'handle_redirect'), 5);
    }
}

function yith_override_onboarding_queue() {
    set_transient('yith_plugin_licence_onboarding_queue', array(), 1);
}