<?php

namespace ADReviewManager\Database;

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


class DBMigrator
{
    const ADRMDBV = ADRM_DB_VERSION;

    public static function run($network_wide = false)
    {
        global $wpdb;

        if ($network_wide) {
            // Retrieve all site IDs from this network (WordPress >= 4.6 provides easy to use functions for that).
            if (function_exists('get_sites') && function_exists('get_current_network_id')) {
                $site_ids = get_sites(array('fields' => 'ids', 'network_id' => get_current_network_id()));
            } else {
                $query = $wpdb->prepare("SELECT blog_id FROM $wpdb->blogs WHERE site_id = %d", $wpdb->siteid);
                $site_ids = $wpdb->get_col($query);
            }
            // Install the plugin for all these sites.
            foreach ($site_ids as $site_id) {
                switch_to_blog($site_id);
                self::migrate();
                restore_current_blog();
            }
        } else {
            self::migrate();
        }
    }

    public static function migrate()
    {
        \ADReviewManager\Database\Migrations\ReviewTable::migrate();
        \ADReviewManager\Database\Migrations\Rating::migrate();
        \ADReviewManager\Database\Migrations\ReviewComment::migrate();
        \ADReviewManager\Database\Migrations\ReviewMedia::migrate();
        \ADReviewManager\Database\Migrations\CustomFeedback::migrate();
        // we are good. It's a new installation
        if (get_option('ADRM_DB_VERSION') < self::ADRMDBV) {
            self::maybeUpgradeDB();
        } else {
            // we are good. It's a new installation
            update_option('ADRM_DB_VERSION', self::ADRMDBV, false);
        }
    }

    public static function maybeUpgradeDB()
    {
        if (get_option('ADRM_DB_VERSION') < self::ADRMDBV) {
            // We need to upgrade the database
            self::forceUpgradeDB();
        }
    }

    // If needed in future
    public static function forceUpgradeDB()
    {
        // We are upgrading the DB forcedly
        // upgrade and migrate new tables
        update_option('ADRM_DB_VERSION', self::ADRMDBV, false);
    }
}
