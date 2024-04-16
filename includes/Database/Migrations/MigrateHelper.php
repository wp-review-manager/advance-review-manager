<?php
namespace ADReviewManager\Database\Migrations;

class MigrateHelper
{
    public static function runForceSQL($sql, $tableName)
    {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        return true;
    }

    public static function runSQL($sql, $tableName)
    {
        global $wpdb;
        if ($wpdb->prepare("SHOW TABLES LIKE %s", $tableName) != $tableName) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
            return true;
        }
        return false;
    }
}
