<?php
declare(strict_types=1);

namespace ADReviewManager\Controllers;

use ADReviewManager\Modules\Debug\Debug;
use ADReviewManager\Services\SanitizationService;
use ADReviewManager\Services\ArrayHelper as Arr;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('ADReviewManager\Services\ArrayHelper', true)) {
    require ADRM_DIR . 'includes/services/ArrayHelper.php';
}

if (!class_exists('ADReviewManager\Services\SanitizationService', true)) {
    require ADRM_DIR . 'includes/services/SanitizationService.php';
}

class GlobalSettingsController
{
    public function getGlobalSettings()
    {
        $settings = get_option('adrm_global_settings');
        wp_send_json_success($settings);
    }

    public function updateGlobalSettings()
    {

        if (! isset( $_REQUEST['nonce'] ) || !wp_verify_nonce(sanitize_text_field( wp_unslash($_REQUEST['nonce'])), 'advance-review-manager-nonce')) {
            wp_send_json_error(
                [
                    'message' => "Nonce verification failed."
                ],
            423);
        } else {
            $request = $_REQUEST;
            $settings = SanitizationService::sanitize_array_values(Arr::get($request, 'settings', []));
            update_option('adrm_global_settings', $settings);
            wp_send_json_success();
        }
    }

    public function generateDebug($type)
    {
        $response =  Debug::getDebugInfos($type);

        wp_send_json_success($response);
    }
}