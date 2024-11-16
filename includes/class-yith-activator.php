<?php

if ( ! class_exists( 'YITH_Activator' ) ) {
    class YITH_Activator {

        public function __construct() {
            add_action('init', array($this, 'load_yith_plugins'));
        }

        /**
         * Load YITH plugins that are installed and activate their licenses.
         */
        public function load_yith_plugins() {
            $installed_yith_plugins = $this->get_installed_yith_plugins();
            error_log('Installed YITH plugins: ' . print_r($installed_yith_plugins, true)); // Debug installed plugins
            foreach ($installed_yith_plugins as $plugin_slug => $defined_slug) {
                $this->load_yith_license($plugin_slug, $defined_slug);
            }
        }

        /**
         * Retrieve all installed YITH plugins dynamically and extract defined slugs.
         *
         * @return array Associative array with plugin slugs as keys and defined slugs as values.
         */
        private function get_installed_yith_plugins() {
            $all_plugins = get_plugins();
            $yith_plugins = [];

            foreach ($all_plugins as $plugin_path => $plugin_data) {
                $plugin_slug = explode('/', $plugin_path)[0];
                error_log("Checking plugin: $plugin_path | Slug: $plugin_slug");

                if (
                    stripos($plugin_data['Author'], 'YITH') !== false ||
                    stripos($plugin_data['TextDomain'], 'yith') !== false ||
                    stripos($plugin_data['Name'], 'YITH') !== false
                ) {
                    // Attempt to load the plugin's main file to retrieve its defined slug.
                    $main_file_path = WP_PLUGIN_DIR . '/' . $plugin_path;
                    $defined_slug = $this->extract_defined_slug($main_file_path);

                    if ($defined_slug) {
                        $yith_plugins[$plugin_slug] = $defined_slug;
                        error_log("YITH plugin detected: $plugin_slug | Defined Slug: $defined_slug");
                    } else {
                        $yith_plugins[$plugin_slug] = $plugin_slug; // Fallback to detected slug.
                        error_log("YITH plugin detected without defined slug: $plugin_slug");
                    }
                }
            }

            return $yith_plugins;
        }

        /**
         * Extract the defined slug from the plugin's main file.
         *
         * @param string $file_path Path to the plugin's main file.
         * @return string|null The defined slug if found, or null.
         */
        private function extract_defined_slug($file_path) {
            if (!file_exists($file_path)) {
                return null;
            }

            $file_contents = file_get_contents($file_path);
            if (preg_match("/define\(\s*['\"]YITH_[A-Z_]+_SLUG['\"]\s*,\s*['\"]([^'\"]+)['\"]\s*\)/", $file_contents, $matches)) {
                return $matches[1]; // Return the defined slug.
            }

            return null;
        }

        /**
         * Load license data for a specific YITH plugin.
         *
         * @param string $plugin_slug The detected plugin slug.
         * @param string $defined_slug The defined slug from the plugin's main file.
         */
        private function load_yith_license($plugin_slug, $defined_slug) {
            if (!$this->is_plugin_active($plugin_slug)) {
                error_log("Plugin not active: $plugin_slug");
                return;
            }

            // Use the defined slug for license options.
            $license_slug = $defined_slug ?: $plugin_slug;

            $license_options = get_option('yit_products_licence_activation', []);
            error_log("Current license options: " . print_r($license_options, true));

            if (!isset($license_options[$license_slug])) {
                $license_options[$license_slug] = $this->default_license_data();
                error_log("License added for plugin: $license_slug");
            } else {
                error_log("License already exists for plugin: $license_slug");
            }

            update_option('yit_products_licence_activation', $license_options);
            update_option('yit_plugin_licence_activation', $license_options);
            update_option('yit_theme_licence_activation', $license_options);

            $updated_license_options = get_option('yit_products_licence_activation', []);
            error_log("Updated license options: " . print_r($updated_license_options, true));
        }

        /**
         * Check if a specific plugin is active.
         *
         * @param string $plugin_slug The slug of the plugin to check.
         * @return bool True if the plugin is active, false otherwise.
         */
        private function is_plugin_active($plugin_slug) {
            $active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
            foreach ($active_plugins as $plugin_path) {
                if (strpos($plugin_path, $plugin_slug) !== false) {
                    error_log("Plugin is active: $plugin_slug");
                    return true;
                }
            }
            error_log("Plugin is NOT active: $plugin_slug");
            return false;
        }

        /**
         * Default license data for YITH plugins.
         *
         * @return array Default license data structure.
         */
        private function default_license_data() {
            return [
                'activated' => true,
                'email' => 'members@devtools.club',
                'licence_key' => '****-****-****-****',
                'activation_limit' => '999',
                'activation_remaining' => '998',
                'is_membership' => 'true',
                'marketplace' => 'yith',
                'licence_expires' => strtotime('+5 years'),
            ];
        }
    }
}
