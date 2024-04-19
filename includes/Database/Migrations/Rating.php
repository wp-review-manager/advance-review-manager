<?php
namespace ADReviewManager\Database\Migrations;

class Rating {

    public static function migrate($forced = false)
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'adrm_reviews';

        $sql = "CREATE TABLE $table_name (
            id int(20) NOT NULL AUTO_INCREMENT,
            review_id int(20) NOT NULL,
            rating int(20) NOT NULL,
            created_at timestamp NULL,
            updated_at timestamp NULL,
            PRIMARY  KEY  (id)
        ) $charset_collate;";

        if ($forced) {
            return MigrateHelper::runForceSQL($sql, $table_name);
        }

        return MigrateHelper::runSQL($sql, $table_name);
    }

}
