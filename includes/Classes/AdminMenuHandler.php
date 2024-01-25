<?php

namespace WPReviewManager\Classes;

class AdminMenuHandler{

    public function renderMenu() {
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

}