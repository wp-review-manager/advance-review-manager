<?php
declare(strict_types=1);

namespace ADReviewManager\Classes;

use ADReviewManager\Database\DBMigrator;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Ajax Handler Class
 * @since 1.0.0
 */
class ActivationHandler
{
    public static function handle($network_wide = false)
    {
        DBMigrator::run($network_wide);

        // will call the function later
        // $this->setPluginInstallTime();
    }

    public function setPluginInstallTime()
    {
        $statuses = get_option( 'wp_statuses', []);
        if( !isset($statuses['installed_time']) ){
            $statuses['installed_time'] = strtotime("now") ;
            update_option('adrm_statuses', $statuses, false);
        }
    }
}