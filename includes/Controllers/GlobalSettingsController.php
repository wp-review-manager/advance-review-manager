<?php
declare(strict_types=1);

namespace ADReviewManager\Controllers;

use ADReviewManager\Modules\Debug\Debug;
use ADReviewManager\Services\ArrayHelper as Arr;

class GlobalSettingsController
{
    public function getGlobalSettings()
    {
        $settings = get_option('adrm_global_settings');
        wp_send_json_success($settings);
    }

    public function updateGlobalSettings()
    {
        $nonce = $_REQUEST['nonce'] ?? $_REQUEST['nonce'] ?? '';

        if (!wp_verify_nonce($nonce, 'advance-review-manager-nonce')) {
            wp_send_json_error(
                [
                    'message' => "Nonce verification failed."
                ],
            423);
        } else {
            $settings = Arr::get($_REQUEST, 'settings', []);
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