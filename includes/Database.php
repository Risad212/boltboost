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
			'total_expired_transient' => $total_expired_transient,
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

	// get engine summuray
	public static function get_engine_summary() {
       $tables = self::get_table_stats();

	   $summary = [];

	   foreach( $tables as $table ){
		 $engine = $table['ENGINE'] ?? 'UNKNOWN';
		 $summary[$engine] = isset( $summary[$engine] ) ? $summary[$engine] + 1 : 1; 
	   }

	   return $summary;
	}

	// get index effeiancy 
	public static function get_index_efficiency() {
      $tables = self::get_table_stats();
      
	  $stats = [];

	  foreach( $tables as $table ){
		$index = $table['index_size'];
		$data  = $table['data_size'];

		$efficiency = $data ? round( ( $index / $data ) * 100, 2) : 0 ;

		$stats[] = [
			'table'       => $table['table_name'],
			'data_size'   => $data,
			'data_index'  => $index,
			'index_ratio' => $efficiency
		];
	  }

	  usort( $stats, fn( $a, $b ) => $b['index_ratio'] <=> $a['index_ratio'] );

	  return array_slice( $stats, 0, 5 );

	}

	// get havvy load 
	public static function get_heavy_autoloaded_options( $limit = 10 ) {
         global $wpdb;

		 return $wpdb->get_results( 
			"SELECT option_name, LENGTH( option_value ) AS size 
			 FROM {$wpdb->options} 
			 WHERE autoload = 'yes' 
			 ORDER BY size DESC 
			 LIMIT $limit", 
			 ARRAY_A
		  );
	}

   // get all information in one array
   public static function get_all() {

      $table_stats   = self::get_table_stats();
	  $empty_table   = self::get_empty_table();
	  $larget_tables = self::get_lergest_table();

	  return [
		'tables'            => $table_stats,
		'total_table'       => count( $table_stats ),
		'empty_table'       => $empty_table,
		'total_empty_table' => count( $empty_table ),
		'larget_tables'     => $larget_tables,
		'options'           => self::get_option_counts(),
		'engine_summary'    => self::get_engine_summary(),
		'db_size'           => self::get_total_db_size(),
		'index_efficiency'  => self::get_index_efficiency(),
		'heavy_autoloaded'  => self::get_heavy_autoloaded_options(),
	  ];

   }

 }

