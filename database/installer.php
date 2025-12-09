<?php


class Installer {
   
    public function run(){
      $this->create_table();
    }

    public function create_table(){
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $table_name = $wpdb->prefix."boltboost_option";

        $schema = "CREATE TABLE IF NOT EXISTS $table_name (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            option_key varchar(255) NOT NULL,
            context varchar(255) NOT NULL,
            data longtext NULL,
            expire datetime NULL,
            created datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY option_key (option_key),
            KEY context (context)
    ) $charset_collate;";

    if( !function_exists( 'dbDelta ') ){
         require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    }
     dbDelta( $schema );

    }
}
