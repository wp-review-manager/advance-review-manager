<?php
namespace WPReviewManager\Database;

class SampleTableMigration {

    public function createTable() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'wprm_sample_table';
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $table_name (
            id INT(11) NOT NULL AUTO_INCREMENT,
            column1 VARCHAR(255) NOT NULL,
            column2 TEXT,
            created_at DATETIME NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    private function runSQL($sql, $tableName)
    {
        global $wpdb;
        if ($wpdb->get_var("SHOW TABLES LIKE '$tableName'") != $tableName) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

}
