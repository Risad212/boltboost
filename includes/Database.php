<?php

class Database{
   
    public static $table_store = null;

    public static function get_table_stats() {
        global $wpdb;

        if ( null !== self::$table_store ) {
			return self::$table_store;
		}
        
        $raw_table = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT
					TABLE_NAME AS table_name,
					ENGINE,
					TABLE_ROWS AS row_count,
					DATA_LENGTH AS data_size,
					INDEX_LENGTH AS index_size,
					(DATA_LENGTH + INDEX_LENGTH) AS total_size
				FROM information_schema.TABLES
				WHERE TABLE_SCHEMA = %s",
				DB_NAME
			),
			ARRAY_A
		);

       self::$table_store = array_map( function ( $table ) {
			// Format sizes for human readability
		   	$table['data_size_formatted']  = size_format( $table['data_size'], 2 );
			$table['index_size_formatted'] = size_format( $table['index_size'], 2 );
			$table['total_size_formatted'] = size_format( $table['total_size'], 2 );

			return $table;

       }, $raw_table);

	   return self::$table_store;
    }

	// get total db size
	public static function get_total_db_size() {

		$tables = self::get_table_stats();

		$total = array_reduce( $tables, fn( $carry, $t ) => $carry + (int) $t['total_size'], 0 );

		$total_table = array_reduce( $tables, fn( $carray, $item) => $carray + $item['total_size'], 0); 

		return size_format( $total, 2 );
	}


	// get option count
	public static function get_option_counts(){
		global $wpdb;

		$total_options            = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->options}" );
		$total_autoloaded_options = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->options} WHERE autoload = 'yes' " );
		$total_transient          = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->options} WHERE option_name LIKE '\_transient\_%' " );
		$total_expired_transient  = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->options} WHERE option_name LIKE '\_transient\_%' AND option_value < UNIX_TIMESTAMP() " );
        $total_autoloaded_size    = $wpdb->get_var( "SELECT SUM(LENGTH(option_value)) FROM {$wpdb->options} WHERE autoload = 'yes' " );

		
		return [
			'total_options'            => $total_options,
			'total_transient'          => $total_transient,
			'total_expired_transients' => $total_expired_transients,
			'total_autoloaded_options' => $total_autoloaded_options,
			'total_autoloaded_size'    => $total_autoloaded_size,
		];
	   
	}

	// get largest table 
	public static function get_lergest_table( $limit = 10 ) {
      
		$tables = self::get_table_stats();

		usort( $tables, function ( $a, $b ) {
           return $b['total_size'] <=> $a['total_size'];
		});

		return array_slice( $tables, 0, $limit );
	}

	// get empty talbe
	public static function get_empty_table(){
	  $tables = self::get_table_stats();

	  return array_values( array_filter( $tables, fn( $table ) => $table['row_count'] === 0 ) );

	}
 }

