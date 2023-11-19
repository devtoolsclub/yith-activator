<?php
function yith_custom_disable_update_check() {
    if (class_exists('YITH_Plugin_Upgrade')) {
        $yith_upgrade_instance = YITH_Plugin_Upgrade::instance();
        remove_filter('pre_set_site_transient_update_plugins', array($yith_upgrade_instance, 'check_update'));
    }
}