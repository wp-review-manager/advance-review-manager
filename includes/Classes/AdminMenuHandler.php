<?php

namespace WPReviewManager\Classes;
use WPReviewManager\Classes\Helper;

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
                'User Guide',
                'manage_options',
                'admin.php?page=wp-review-manager.php#/usage-guide',
            );
            $submenu['wp-review-manager.php']['support-&-debug'] = array(
                'Support & Debug',
                'manage_options',
                'admin.php?page=wp-review-manager.php#/support-&-debug',
            );
        });
        add_action('admin_init', function () {

            $disablePages = [
                'wp-review-manager.php',
            ];
        
            if (isset($_GET['page']) && in_array($_GET['page'], $disablePages)) {
                remove_all_actions('admin_notices');
        
                wp_enqueue_style(
                    'wprm_admin_app',
                    WPRM_URL . 'assets/css/wp-review-manager-admin.css',
                    array(),
                    WPRM_VERSION
                );
            }
        }, 20);
    }

    public function renderAdminPage()
    {

        Vite::enqueueScript('WPRM-script-boot', 'admin/js/start.js', array('jquery'), WPRM_VERSION, true);
        Vite::enqueueStyle('WPRM-global-styling', 'scss/element.css', array(), WPRM_VERSION);

        $WPRM = apply_filters('WPRM/admin_app_vars', array(
            //'image_upload_url' => admin_url('admin-ajax.php?action=wpf_global_settings_handler&route=wpf_upload_image'),
            'assets_url' => WPRM_URL . 'assets/',
            'ajaxurl' => admin_url('admin-ajax.php')
        ));

        $this->renderGlobalSettings();

        wp_localize_script('WPRM-script-boot', 'WPRMAdmin', $WPRM);
        ob_start();
        ?>
        <div class="WPRM-admin-page" id="WPRM_app">
            <div class="main-menu text-white-200 bg-wheat-600">
                <div class="WPRM-logo">
                    <?php echo Helper::LogoSvg() ?>
                </div>
                <div class="WPRM-menu-item">
                    <router-link to="/">
                        Review Forms
                    </router-link> 
                    <router-link to="/settings" >
                        Settings 
                    </router-link>
                    <router-link to="/usage-guide" >
                        Usage Guide 
                    </router-link>
                    <router-link to="/support-&-debug" >
                        Support And Debug
                    </router-link>
                </div>
            </div>
            <hr/>
            <router-view></router-view>
        </div>;
        <?php
        $form_body = ob_get_clean();
        echo $form_body;
    }

    public function renderGlobalSettings()
    {
        if (function_exists('wp_enqueue_editor')) {
            add_filter('user_can_richedit', '__return_true');
            wp_enqueue_editor();
            wp_enqueue_media();
        }
    }

}