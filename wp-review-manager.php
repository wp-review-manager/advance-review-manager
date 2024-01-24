<?php

/**
 * Plugin Name: WP review manager
 * Plugin URI: http://wp-review-manager.com/
 * Description: WP review manager is a plugin for wordpress that allows you to manage reviews for your website.
 * Author: #
 * Author URI: #
 * Version: 1.0.5
 */
define('WPM_URL', plugin_dir_url(__FILE__));
define('WPM_DIR', plugin_dir_path(__FILE__));

define('WPM_VERSION', '1.0.5');

class WPPluginWithVueTailwind {
    public function boot()
    {
        $this->loadClasses();
        $this->registerShortCodes();
        $this->ActivatePlugin();
        $this->renderMenu();
    }

    public function loadClasses()
    {
        require WPM_DIR . 'includes/autoload.php';
    }

    public function renderMenu()
    {
        add_action('admin_menu', function () {
            if (!current_user_can('manage_options')) {
                return;
            }
            global $submenu;
            add_menu_page(
                'WP-review-manager',
                'WP Review Manager',
                'manage_options',
                'wp-review-manager.php',
                array($this, 'renderAdminPage'),
                'dashicons-editor-code',
                25
            );
            $submenu['wp-review-manager.php']['dashboard'] = array(
                'Dashboard',
                'manage_options',
                'admin.php?page=wp-review-manager.php#/',
            );
            $submenu['wp-review-manager.php']['contact'] = array(
                'Contact',
                'manage_options',
                'admin.php?page=wp-review-manager.php#/contact',
            );
        });
    }

    public function renderAdminPage()
    {
        wp_enqueue_script('WPRM-script-boot', WPM_URL . 'assets/admin/js/start.js', array('jquery'), WPM_VERSION, false);
        wp_enqueue_style('WPRM-global-styling', WPM_URL . 'assets/css/element.css', array(), WPM_VERSION);

        $WPRM = apply_filters('WPRM/admin_app_vars', array(
            //'image_upload_url' => admin_url('admin-ajax.php?action=wpf_global_settings_handler&route=wpf_upload_image'),
            'assets_url' => WPM_URL . 'assets/',
            'ajaxurl' => admin_url('admin-ajax.php')
        ));

        wp_localize_script('WPRM-script-boot', 'WPRMAdmin', $WPRM);

        echo '<div class="WPRM-admin-page" id="WPRM_app">
            <div class="main-menu text-white-200 bg-wheat-600 p-4">
                <router-link to="/">
                    Home
                </router-link> |
                <router-link to="/contact" >
                    Contact
                </router-link>
            </div>
            <hr/>
            <router-view></router-view>
        </div>';
    }

    public function registerShortCodes()
    {
        // your shortcode here
    }

    public function ActivatePlugin()
    {
        //activation deactivation hook
        register_activation_hook(__FILE__, function ($newWorkWide) {
            require_once(WPM_DIR . 'includes/Classes/Activator.php');
            $activator = new \WPPluginWithVueTailwind\Classes\Activator();
            $activator->migrateDatabases($newWorkWide);
        });
    }
}

(new WPPluginWithVueTailwind())->boot();



