<?php
function yith_disable_license_activation_redirect() {
    if (class_exists('YITH_Plugin_Licence_Onboarding')) {
        remove_action('admin_init', array('YITH_Plugin_Licence_Onboarding', 'handle_redirect'), 5);
    }
}

function yith_override_onboarding_queue() {
    set_transient('yith_plugin_licence_onboarding_queue', array(), 1);
}

function remove_yith_license_banner() {
    // Remove actions that enqueue banner scripts and styles
    remove_action('admin_notices', array('YITH\PluginUpgrade\Admin\Banner', 'register_scripts'), 5);
    remove_action('yith_plugin_fw_panel_enqueue_scripts', array('YITH\PluginUpgrade\Admin\Banner', 'maybe_enqueue_and_render_licence_banner'));
}