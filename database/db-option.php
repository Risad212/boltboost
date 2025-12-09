<?php

class DB_Option{
   
    public static function insert_option( $option_key, $context, $data ){
         global $wpdb;

         $table_name = $wpdb->prefix. "boltboost_option";

         return $wpdb->insert( $table_name, [
            'option_key' => $option_key,
            'context' => $context,
            'data' => is_array($data) ? json_encode($data) : $data,
            'expire' => null,
            'created' => current_time( 'mysql' )
         ]);
    }


    public static function get_option( $option_key, $context ){
       global $wpdb;

        // SELECT one row
        $row = $wpdb->get_row( $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}boltboost_option WHERE option_key = %s AND context = %s LIMIT 1",
            $option_key,
            $context
        ), ARRAY_A );

        return $row;
    }
}
