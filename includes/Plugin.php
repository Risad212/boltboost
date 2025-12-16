<?php


class Plugin {
  
    protected static $cached_plugins_data = null;

	protected static $active_plugins = null;
	protected static $update_plugins = null;
	protected static $all_plugins    = null;

	// get plugins data
    public static function get_plugins_data(){

        if ( null !== self::$cached_plugins_data ) {
			return self::$cached_plugins_data;
		}
        
        if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		if ( ! function_exists( 'get_plugin_updates' ) ) {
			require_once ABSPATH . 'wp-admin/includes/update.php';
		}

        $all_plugins  = get_plugins();
		
		$plugins_data = [];
		
		foreach( $all_plugins as $plugin_file => $plugin_data ){
		   $plugins_data[] = self::get_basic_plugin_data( $plugin_file, $plugin_data );
		}

		self::$cached_plugins_data = $plugins_data;

		return $plugins_data;
    }

	// get basic plugin data
    public static function get_basic_plugin_data( $plugin_file, $plugin_data ) {

    self::ensure_wp_plugin();

    $slug       = dirname( $plugin_file );
    $version    = $plugin_data['Version'] ?? 'Unknown';
    $option_key = "plugin_data_{$slug}_v{$version}";
    $option_name = "boltboost_plugin_cache_{$option_key}";

    $cached = get_transient( $option_name );
    if ( false !== $cached ) {
        $cached['is_active'] = in_array( $plugin_file, self::$active_plugins );
        return $cached;
    }

    $wp_org_info  = self::fetch_wp_org_info( $slug );
    $is_wp_repo   = ! empty( $wp_org_info ) && ! is_wp_error( $wp_org_info );
    $last_updated = $is_wp_repo ? ( $wp_org_info->last_updated ?? null ) : null;
    $is_abandoned = $last_updated ? self::is_abandonedis_abandoned( $last_updated ) : null;

    $data = [
        'name'          => $plugin_data['Name'] ?? '',
        'slug'          => $slug,
        'plugin_file'   => $plugin_file,
        'needs_upgrade' => isset( self::$plugin_updates[$plugin_file] ),
        'is_wp_repo'    => $is_wp_repo,
        'is_active'     => in_array( $plugin_file, self::$active_plugins ),
        'last_updated'  => $last_updated,
        'is_abandoned'  => $is_abandoned,
        'version'       => $version,
        'author'        => $plugin_data['Author'] ?? '',
    ];

    set_transient( $option_name, $data, HOUR_IN_SECONDS );

    return $data;

    }

	// fetch plugin info from org
	public static function fetch_wp_org_info( $slug ){
       if ( ! function_exists( 'plugins_api' ) ){
            require_once ABSPATH. 'wp-admin/includes/plugin-install.php';
	   }

	   try{
		  $info = plugins_api('plugin_information', [
			 'slug' => $slug,
			 'fields' => ['las_updated' => true]
		  ] );
	   }
	   catch ( \Throwable $error){
			error_log( printf( 'plugins_api failed for %s: %s', $slug, $error->getMessage() ) );
			$info = null;
	   }

	   return is_wp_error( $info ) ? null : $info;
	}

	public static function ensure_wp_plugin( ){
		if ( ! function_exists( 'get_plugins' ) ){
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		if ( ! function_exists( 'get_plugins_updates' ) ){
			require_once ABSPATH . 'wp-admin/includes/update.php';
		}

		self::$active_plugins = get_option( 'active_plugins', [] );
		self::$update_plugins = get_plugin_updates();
		self::$all_plugins    = get_plugins();
	} 

	public static function is_abandonedis_abandoned( $last_update ) {
      $timestamp = strtotime( $last_update );

	  return $timestamp && ( time() - $timestamp ) > YEAR_IN_SECONDS;
	}

	public static function get_counts ( ){
		$data         = self::get_plugins_data();
		$total        = count( $data );
		$active_count = count( get_option( 'active_plugins', [] ) );
		$inactive     = $total - $active_count;
		$abandoned    = count( array_filter( $data, fn( $p ) => $p['is_abandoned'] ) );
		
		return compact( 'total', 'active_count', 'inactive', 'abandoned' );
	}

	public static function get_suggestions( ) {
		$plugins     = self::get_plugins_data();
		$count       = self::get_counts();
		$suggestions = [];  

		$abandoned_plugin = array_filter( $plugins, function ( $plugin ){
           return $plugin['is_abandoned'] === true;
		} );

		$plugins_needing_update = array_filter( $plugins, function ( $plugin ){
           return $plugin['needs_upgrade'] === true;
		} );

		$total_plugins    = $counts['total'] ?? count( $plugins );
		$active_plugins   = $counts['active'] ?? 0;
		$inactive_plugins = $total_plugins - $active_plugins;

		if ( ! empty( $plugins_needing_update ) ){
		   $suggestions[] = sprintf( "%d plugin(s) need updates. Keeping plugins updated improves performance and security.", 
		                    count( $plugins_needing_update ));
		}

		if ( ! empty( $abandoned_plugin ) ){
		   $suggestions[] = sprintf( "%d plugin(s) appear abandoned (not updated in 1+ year). Consider replacing or removing them.", 
		                    count( $abandoned_plugin ));
		}

		if ( $total_plugins > 30 ) {
			$suggestions[] = "You have over 30 plugins installed. Consider trimming unused ones to reduce overhead.";
		}

		if ( $inactive_plugins > 5 ) {
			$suggestions[] = sprintf(
				"You have %d inactive plugin(s). Inactive plugins still load in admin — consider removing them.",
				$inactive_plugins
			);
		}

		if ( empty( $suggestions ) ) {
			$suggestions[] = "All good! Your plugin setup looks clean and up-to-date.";
		}

	    return $suggestions;
	}


	public static function get_all() {
		return [
			'plugins'     => self::get_plugins_data(),
			'counts'      => self::get_counts(),
			'suggestions' => self::get_suggestions(),
		];
	}

}
