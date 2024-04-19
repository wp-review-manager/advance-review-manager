<?php
namespace ADReviewManager\Database\Migrations;

class CustomFeedback {

    public static function migrate($forced = false)
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'adrm_custom_feedbacks';

        $sql = "CREATE TABLE $table_name (
            id int(20) NOT NULL AUTO_INCREMENT,
            review_title varchar(255),
            name varchar(255),
            reviewer_title varchar(255) not null,
            review_text text not null,
            meta longtext,
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
