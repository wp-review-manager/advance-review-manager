<?php
declare(strict_types=1);

namespace WPReviewManager\Classes;

use WPReviewManager\Database\DBMigrator;

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
        $statuses = get_option( 'wprm_statuses', []);
        if( !isset($statuses['installed_time']) ){
            $statuses['installed_time'] = strtotime("now") ;
            update_option('wprm_statuses', $statuses, false);
        }
    }
}