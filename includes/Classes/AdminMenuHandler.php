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
            $submenu['wp-review-manager.php']['review-forms'] = array(
                'Review Forms',
                'manage_options',
                'admin.php?page=wp-review-manager.php#/',
            );
            $submenu['wp-review-manager.php']['settings'] = array(
                'Settings',
                'manage_options',
                'admin.php?page=wp-review-manager.php#/settings',
            );
            $submenu['wp-review-manager.php']['usage-guide'] = array(
                'Usage Guide',
                'manage_options',
                'admin.php?page=wp-review-manager.php#/usage-guide',
            );
            $submenu['wp-review-manager.php']['support-&-debug'] = array(
                'Support & Debug',
                'manage_options',
                'admin.php?page=wp-review-manager.php#/support-&-debug',
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
                    Review Forms
                </router-link> |
                <router-link to="/settings" >
                    Settings | 
                </router-link>
                <router-link to="/usage-guide" >
                    Usage Guide | 
                </router-link>
                <router-link to="/support-&-debug" >
                    Support And Debug
                </router-link>
            </div>
            <hr/>
            <router-view></router-view>
        </div>';
    }

}