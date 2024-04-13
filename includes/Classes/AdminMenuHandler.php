<?php
declare(strict_types=1);

namespace ADReviewManager\Classes;
use ADReviewManager\Classes\Helper;
use ADReviewManager\Hooks\Actions;

class AdminMenuHandler{

    public function renderMenu() {
        add_action('admin_menu', function () {
            if (!current_user_can('manage_options')) {
                return;
            }
            global $submenu;
            add_menu_page(
                'Advance-review-manager',
                'Advance Review Manager',
                'manage_options',
                'advance-review-manager.php',
                array($this, 'renderAdminPage'),
                'dashicons-editor-code',
                25
            );
            $submenu['advance-review-manager.php']['review-forms'] = array(
                'Review Forms',
                'manage_options',
                'admin.php?page=advance-review-manager.php#/',
            );
            $submenu['advance-review-manager.php']['settings'] = array(
                'Settings',
                'manage_options',
                'admin.php?page=advance-review-manager.php#/settings',
            );
            $submenu['advance-review-manager.php']['user-guide'] = array(
                'User Guide',
                'manage_options',
                'admin.php?page=advance-review-manager.php#/user-guide',
            );
            $submenu['advance-review-manager.php']['support-&-debug'] = array(
                'Support & Debug',
                'manage_options',
                'admin.php?page=advance-review-manager.php#/support-&-debug',
            );
        });
        add_action('admin_init', function () {

            $disablePages = [
                'advance-review-manager.php',
            ];
        
            if (isset($_GET['page']) && in_array($_GET['page'], $disablePages)) {
                remove_all_actions('admin_notices');
        
                // wp_enqueue_style(
                //     'adrm_admin_app',
                //     ADRM_URL . 'assets/css/advance-review-manager-admin.css',
                //     array(),
                //     ADRM_VERSION
                // );
            }
        }, 20);
    }

    public function renderAdminPage()
    {

        Vite::enqueueScript('ADRM-script-boot', 'admin/start.js', array('jquery'), ADRM_VERSION, true);
        Vite::enqueueStyle('ADRM-global-styling', 'scss/admin/app.scss', array(), ADRM_VERSION);
        $ADRM = apply_filters('ADRM/admin_app_vars', array(
            //'image_upload_url' => admin_url('admin-ajax.php?action=wpf_global_settings_handler&route=wpf_upload_image'),
            'assets_url' => ADRM_URL . 'assets/',
            'ajax_url' => admin_url('admin-ajax.php'),
            'adrm_nonce' => wp_create_nonce('advance-review-manager-nonce'),
        ));

        $this->renderGlobalSettings();

        wp_localize_script('ADRM-script-boot', 'ADRMAdmin', $ADRM);
        ob_start();
        ?>
        <div class="adrm-admin-page" id="ADRM_app">
            <div class="main-menu text-white-200 bg-wheat-600">
                <div class="adrm-logo">
                    <?php echo Helper::LogoSvg() ?>
                </div>
                <div class="adrm-menu-item">
                    <router-link to="/">
                        Review Forms
                    </router-link> 
                    <router-link to="/settings" >
                        Settings 
                    </router-link>
                    <router-link to="/user-guide" >
                        User Guide 
                    </router-link>
                    <router-link to="/support-&-debug" >
                        Support And Debug
                    </router-link>
                </div>
            </div>
            <hr/>
            <router-view></router-view>
        </div>
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