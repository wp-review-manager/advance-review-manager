<?php
namespace ADReviewManager\Database\Migrations;

class ReviewMedia {

    public static function migrate($forced = false)
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'adrm_review_media';

        $sql = "CREATE TABLE $table_name (
            id int(20) NOT NULL AUTO_INCREMENT,
            review_id int(20) NOT NULL,
            media_url text,
            media_type varchar(255),
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