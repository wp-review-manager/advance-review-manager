<?php
namespace ADReviewManager\Modules\Debug;
use ADReviewManager\Services\ArrayHelper as Arr;

if (!defined('ABSPATH')) {
    exit;
}

class Debug
{
    public static function getDebugInfos($type)
    {
        global $wpdb;

        if ($type === 'wp') {
            return self::getWPInfos();
        } elseif ($type === 'server') {
            return self::getServerInfos();
        } elseif ($type === 'others') {
            $others = array(
                'plugins'   => self::getPlugins(),
                'themes' => self::getTheme()
            );
            return $others;
        } else {
            return self::myInfo();
        }
    }

    private static function myInfo()
    {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
        global $wp_version;

        $free_path = ADRM_DIR . 'advance-review-manager.php';
        $allActives = get_option('active_plugins', array());

        $has_pro = defined('ADRMHASPRO');

        $currentVersion = '';

        if ($has_pro) {
            $currentVersion = defined('ADRM_VERSION') ? ADRM_VERSION : 'NO';
        } else {
            $plugin_free = get_plugin_data($free_path);
            $currentVersion = Arr::get($plugin_free, 'Version');
        }

        $api = plugins_api(
            'plugin_information',
            array(
                'slug'   => 'advance-review-manager',
                'fields' => array(
                    'version' => true
                ),
            )
        );
        $liveVersion = $api->version;
        $liveTestedWp = $api->tested;
        $livePhpRequire = $api->requires_php;

        if (version_compare($currentVersion, $liveVersion, '<')) {
            $plugin_version = array(
                'result' =>  $currentVersion .($has_pro? "-Pro" : '-Free'). ' (old, issue)',
                'label'=> 'Plugin Version',
                'status' => 'warn'
            );
        } else {
            $plugin_version = array(
                'result' =>  $currentVersion  .($has_pro? "-Pro" : '-Free'). ' (latest)',
                'label'=> 'Plugin Version',
                'status' => 'ok'
            );
        }

        if (version_compare(PHP_VERSION, $livePhpRequire, '<')) {
            $php_version = array(
                'result' =>  PHP_VERSION . ' (old, issue)',
                'label'=> 'PHP Version',
                'status' => 'warn'
            );
        } else {
            $php_version = array(
                'result' =>  PHP_VERSION . ' (Supported)',
                'label'=> 'PHP Version',
                'status' => 'ok'
            );
        }

        if (version_compare($wp_version, $api->requires, '<')) {
            $wpVersion = array(
                'result' =>  $wp_version . ' (too old, issue)',
                'label'=> 'WP Version',
                'status' => 'warn'
            );
        } else {
            $wpVersion = array(
                'result' =>  $wp_version . ' (Supported)',
                'label'=> 'WP Version',
                'status' => 'ok'
            );
        }

        $recapchaSettings = get_option('adrm_recaptcha_settings', array());
        $recapchaVersion = Arr::get($recapchaSettings, 'recaptcha_version', false);

        $myPlugin = array(
            "version"=> $plugin_version,
            "php_version" => $php_version,
            'wp_version' => $wpVersion,
            "dir_url" => array(
                "label" => "Dir URL",
                "result" => ADRM_URL
            ),
            "permissions" => array(
                "label" => "Permissions",
                "result" => get_option('_adrm_form_permission', 'admin only')
            ),
            // "integration" => array(
            //     "label" => "Integration Module",
            //     "result" => get_option('adrm_integration_status', false) ? 'Enabled' : 'Disable'
            // ),
            // "global_recapcha" => array(
            //     "label" => "Recapcha",
            //     "result" => $recapchaVersion === 'none' ? 'Disable' : $recapchaVersion
            // )
        );

        $hasPro = defined('ADRMHASPRO');
        $proInfo = array();
        if ($hasPro) {
            $licenceStatus = get_option('_adrm_pro_license_status', false);
            $proInfo = array (
                "has_pro" => array(
                    "label" => "Pro version",
                    "result" => ADRM_VERSION
                ),
                "licence" => array(
                    "label" => "Licence",
                    "result"=> $licenceStatus,
                    "status" => $licenceStatus ? 'ok' : 'warn'
                )
            );
        };

        return $myPluginInfos = array_merge($myPlugin, $proInfo);
    }

    public static function getTheme()
    {
        $theme = wp_get_theme();
        return array(
            'name' => array(
                'label' => __('Theme Name', 'advance-review-manager'),
                'result' => $theme->Name
            ),
            'version' => array(
                'label' => __('Theme Version', 'advance-review-manager'),
                'result' => $theme->version
            ),
            'author' => array(
                'label' => __('Author', 'advance-review-manager'),
                'result' => $theme->author,
            ),
            'URI' => array(
                'label' => __('Theme URI', 'advance-review-manager'),
                'result' => $theme->ThemeURI ? $theme->ThemeURI : '-'
            )
        );
    }


    public static function getPlugins()
    {
        $actives = (array) get_option('active_plugins', array());
        if (is_multisite()) {
            $actives = array_merge($actives, get_site_option('active_sitewide_plugins', array()));
        }
        $plugins = [];
        foreach ($actives as $plugin) {
            $arr = explode("/", $plugin, 2);
            $plugins[] = $arr[0];
        }
        return array(
            'all' => $plugins,
            'total' => count($plugins)
        );
    }

    public static function getServerInfos()
    {
        global $wpdb;
        $remoteGet = self::getRequestTest();
        $executionLimit = ini_get('max_execution_time');
        $memoryLimit = ini_get('memory_limit');
        $uploadedFileSIze = ini_get('upload_max_filesize');
        $inputsLimit = ini_get('max_input_vars');
        $maximumPostSize = ini_get('post_max_size');
        $curlVersion = self::getCurl();
        $host = self::getHost();
        $mysql = '';

        global $wpdb;
        $mysql = $wpdb->db_version();

        $mysqlStatus = version_compare($mysql, '5.4', '>');

        $serverInfos = array(
            'host' => array(
                'label' => __('Web Server', 'advance-review-manager'),
                'result' => $host,
            ),
            'php_version' => array(
                'label' => __('PHP Version', 'advance-review-manager'),
                'result' => PHP_VERSION,
            ),
            'server_timezone' => array(
                'label' => __('Server Timezone', 'advance-review-manager'),
                'result' => date_default_timezone_get(),
            ),
            'mysql_version' => array(
                'label' => __('MySQL Version', 'advance-review-manager'),
                'result' =>  $mysqlStatus ? $mysql . '(Ok)': $mysql . ('old, issue'),
                'status' => $mysqlStatus ? 'ok' : 'warn'
            ),
            'display_errors' => array(
                'label' => __('Display Errors', 'advance-review-manager'),
                'result' => (ini_get('display_errors')) ? __('Yes', 'advance-review-manager') . ' (' . ini_get('display_errors') . ')(issue)' : 'No Display Errors',
                'status' => ini_get('display_errors') ? 'warn' : 'ok'
            ),
            'memoryLimit' => array(
                'label' => __('Server Memory Limit (PHP)', 'advance-review-manager'),
                'result' => $memoryLimit ? $memoryLimit : '-',
            ),
            'upload_max_filesize' => array(
                'label' => __('Upload Max Filesize', 'advance-review-manager'),
                'result' => $uploadedFileSIze ? $uploadedFileSIze : '-',
            ),
            'mbstring' => array(
                'label' => 'mbstring (' . __('MultiByte String', 'advance-review-manager') . ') ' . __('Enabled', 'advance-review-manager'),
                'result' => extension_loaded('mbstring') ? __('Yes', 'advance-review-manager') : __('Not Enabled (issue)', 'advance-review-manager'),
                'status' => extension_loaded('mbstring') ? 'ok' : 'warn'
            ),
            'fsockopen' => array(
                'label' => 'fsockopen',
                'result' => function_exists('fsockopen') ? __('Yes', 'advance-review-manager') : __('Not', 'advance-review-manager'),
            ),
            'soap' => array(
                'label' => 'SOAP',
                'result' => class_exists('SoapClient') ? __('Yes', 'advance-review-manager') : __('No', 'advance-review-manager'),
            ),
            'post_max_size' => array(
                'label' => __('Post Max Size', 'advance-review-manager'),
                'result' => $maximumPostSize ? $maximumPostSize : '-',
            ),
            'max_execution_time' => array(
                'label' => __('Max Execution Time', 'advance-review-manager'),
                'result' => $executionLimit ? $executionLimit : '-',
            ),
            'max_input_vars' => array(
                'label' => __('Max Input Vars', 'advance-review-manager'),
                'result' => $inputsLimit ? $inputsLimit : '-',
            ),
            'wp_remote_get' =>$remoteGet,
            'curl_init' => array(
                'label' => __('cURL Enabled', 'advance-review-manager'),
                'result' => function_exists('curl_init') ? __('Yes', 'advance-review-manager') : __('Not Enabled (issue)', 'advance-review-manager'),
                'status' => function_exists('curl_init') ? 'ok' : 'warn'
            ),
            'curl_version' => array(
                'label' => __('cURL Version', 'advance-review-manager'),
                'result' => $curlVersion,
            )
        );

        return $serverInfos;
    }

    private static function getWPInfos()
    {
        global $wp_version;

        $wpInfos = array(
            'site_name' => array(
                'label' => __('Site Name', 'advance-review-manager'),
                'result' => get_bloginfo('name')
            ),
            'home_url' => array(
                'label' => __('Site Homepage', 'advance-review-manager'),
                'result' => home_url()
            ),
            'site_url' => array(
                'label' => __('Site Url', 'advance-review-manager'),
                'result' => site_url()
            ),
            'wp_version' => array(
                'label' => __('WP Version', 'advance-review-manager'),
                'result' => $wp_version
            ),
            'wp_debug' => array(
                'label' => __('WP Debug', 'advance-review-manager'),
                'result' => defined('WP_DEBUG') ? (WP_DEBUG ? 'yes' : WP_DEBUG) : 'Not defined'
            ),
            'wp_debug_log' => array(
                'label' => __('WP Debug log', 'advance-review-manager'),
                'result' => defined('WP_DEBUG_LOG') ? (WP_DEBUG_LOG ? 'yes' : WP_DEBUG_LOG) : 'Not defined'
            ),
            'locale' => array(
                'label' => __('Locale', 'advance-review-manager'),
                'result' => get_locale()
            ),
            'multisite' => array(
                'label' => __('Multisite', 'advance-review-manager'),
                'result' => is_multisite() ? 'Yes' : 'No'
            ),
            'memory_limit' => array(
                'label' => __('WP Memory Limit', 'advance-review-manager'),
                'result' => size_format(self::makeNum(WP_MEMORY_LIMIT))
            )
        );
        return $wpInfos;
    }

    private static function getHost()
    {
        $host = sanitize_text_field($_SERVER['SERVER_SOFTWARE']);
        if (defined('WPE_APIKEY')) {
            $host .= ' (WP Engine)';
        } elseif (defined('PAGELYBIN')) {
            $host .= ' (Pagely)';
        }
        return $host;
    }
    private static function makeNum($size)
    {
        $pos   = substr($size, -1);
        $formatted = substr($size, 0, -1);
        switch (strtoupper($pos)) {
            case 'P':
                $formatted *= 1024;
                // no break
            case 'T':
                $formatted *= 1024;
                // no break
            case 'G':
                $formatted *= 1024;
                // no break
            case 'M':
                $formatted *= 1024;
                // no break
            case 'K':
                $formatted *= 1024;
        }
        return $formatted;
    }

    private static function getRequestTest()
    {
        $response = wp_safe_remote_get(get_home_url('/?p=1'));
        $remoteGet = '';
        if (!is_wp_error($response) && $response['response']['code'] >= 200 && $response['response']['code'] < 300) {
            $remoteGet = 'Yes';
        } else {
            $remoteGet = 'No';
            if (is_wp_error($response)) {
                $error = ' (' . $response->get_error_message() . ')';
                $remoteGet .= $error;
            } else {
                $error = ' (' . $response['response']['code'] . ')';
                $remoteGet .= $error;
            }
        }
        return array(
                'label' => __('WP Remote GET', 'advance-review-manager'),
                'result' => is_wp_error($response) ? $remoteGet . '(issue)' : $remoteGet,
                'status' => is_wp_error($response) ? 'warn' : 'ok'
        );
    }

    private static function getCurl()
    {
        $curlVersion = "Curl method doesn't exist";
        if (function_exists('curl_version')) {
            $curlVersion = curl_version();
            $curlVersion = Arr::get($curlVersion, 'version') . ', ' . Arr::get($curlVersion, 'ssl_version');
        }
        return $curlVersion;
    }
}
