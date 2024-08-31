<?php
declare(strict_types=1);

namespace ADReviewManager\Classes;
use ADReviewManager\Classes\Helper;
use ADReviewManager\Hooks\Actions;
use PHPUnit\TextUI\Help;

if (!defined('ABSPATH')) {
    exit;
}

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
                $this->getMenuIcon(),
                4
            );
            $submenu['advance-review-manager.php']['review-forms'] = array(
                'Review Forms',
                'manage_options',
                'admin.php?page=advance-review-manager.php#/',
            );
            // $submenu['advance-review-manager.php']['settings'] = array(
            //     'Settings',
            //     'manage_options',
            //     'admin.php?page=advance-review-manager.php#/settings',
            // );
            // $submenu['advance-review-manager.php']['user-guide'] = array(
            //     'User Guide',
            //     'manage_options',
            //     'admin.php?page=advance-review-manager.php#/support-&-debug',
            // );
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
            'user_id' => get_current_user_id() ? get_current_user_id() : null,
        ));

        $this->renderGlobalSettings();

        wp_localize_script('ADRM-script-boot', 'ADRMAdmin', $ADRM);
        ob_start();
        ?>
        <div class="adrm-admin-page" id="ADRM_app">
            <div class="main-menu text-white-200 bg-wheat-600">
                <div class="adrm-logo">
                   <a href="admin.php?page=advance-review-manager.php#/"> <?php echo wp_kses(Helper::LogoSvg(), Helper::allowedHTMLTags()) ?> </a>
                </div>
                <div class="adrm-menu-item">
                    <router-link to="/">
                        Review Templates
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
        echo wp_kses($form_body, Helper::allowedHTMLTags());
    }

   

    public function renderGlobalSettings()
    {
        if (function_exists('wp_enqueue_editor')) {
            add_filter('user_can_richedit', '__return_true');
            wp_enqueue_editor();
            wp_enqueue_media();
        }
    }

    protected function getMenuIcon()
    {
        $svg = '<?xml version="1.0" encoding="utf-8"?>
        <!-- Generator: Adobe Illustrator 24.2.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
        <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
        width="720.000000pt" height="720.000000pt" viewBox="0 0 720.000000 720.000000"
        preserveAspectRatio="xMidYMid meet">

            <g transform="translate(0.000000,720.000000) scale(0.100000,-0.100000)"
            fill="#096A2E" stroke="none">
            <path d="M3654 6381 c-45 -21 -71 -52 -127 -156 -88 -164 -175 -354 -267 -580
            -32 -79 -73 -152 -90 -163 -24 -15 -104 -32 -310 -67 -206 -35 -481 -90 -565
            -112 -77 -21 -133 -56 -141 -89 -4 -14 -4 -47 -2 -74 7 -71 50 -123 342 -418
            138 -139 259 -270 270 -290 22 -42 18 -76 -34 -347 -26 -137 -39 -211 -69
            -423 -23 -156 -4 -240 63 -282 41 -25 114 -26 164 -3 53 24 285 152 365 202
            37 22 70 41 72 41 3 0 24 12 48 27 23 15 51 33 62 39 168 94 245 134 257 134
            9 0 52 -20 97 -45 45 -25 84 -45 86 -45 3 0 22 -11 43 -23 20 -13 71 -42 112
            -64 135 -72 264 -145 317 -179 141 -90 257 -123 318 -90 53 29 75 80 75 177 0
            111 -33 332 -89 594 -12 55 -25 137 -28 182 -5 75 -4 85 20 125 14 24 132 146
            261 271 291 282 352 358 350 436 -2 68 -51 115 -144 139 -44 11 -302 63 -405
            82 -27 5 -86 16 -130 25 -44 9 -118 22 -165 30 -120 19 -172 34 -194 53 -17
            15 -47 74 -92 182 -23 52 -30 69 -63 143 -17 38 -31 71 -31 74 0 14 -182 376
            -213 426 -25 39 -48 61 -73 72 -45 18 -40 19 -90 -4z"/>
            <path d="M1360 2806 c0 -2128 -4 -1995 55 -2071 29 -39 102 -75 151 -75 65 0
            113 22 198 90 46 37 103 81 127 99 109 78 157 114 315 237 93 72 241 185 329
            251 88 67 205 157 260 201 l99 80 1171 5 c1276 6 1210 3 1355 64 292 123 475
            335 563 653 20 73 20 100 24 1243 2 661 0 1167 -5 1167 -5 0 -67 -62 -138
            -137 -71 -76 -159 -167 -197 -203 l-67 -65 0 -895 c0 -862 -4 -1000 -31 -1060
            -34 -76 -47 -100 -87 -153 -66 -88 -156 -147 -274 -181 -50 -14 -177 -16
            -1245 -16 l-1188 0 -250 -188 c-137 -103 -309 -232 -382 -287 -187 -142 -316
            -233 -347 -245 l-26 -10 0 1517 1 1516 -129 131 c-70 72 -160 166 -199 209
            -39 42 -74 77 -77 77 -3 0 -6 -879 -6 -1954z"/>
            <path d="M3632 3074 c-193 -42 -298 -248 -212 -418 61 -119 154 -176 290 -176
            43 0 81 4 85 9 3 5 18 12 34 16 36 8 121 96 150 155 31 65 29 174 -4 243 -46
            95 -107 144 -214 171 -34 9 -63 16 -64 15 -1 -1 -30 -7 -65 -15z"/>
            </g>
        </svg>
    ';

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

}