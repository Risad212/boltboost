<?php

    require_once BB_DIR_PATH . 'includes/PostType.php';
    require_once BB_DIR_PATH . 'includes/Database.php';
    require_once BB_DIR_PATH . 'includes/Plugin.php';
    require_once BB_DIR_PATH . 'includes/Environment.php';

    /**
     * ========================
     *     store post types for render in othere files 
     * ========================
     */
    $get_details    = Post_Type::get_all_details();

    // assign the all value in variable for view
    $post_types_count = isset($get_details['registered']) ? count($get_details['registered']) : 0;

    $total_post       = $get_details['total_posts']        ?? null;
    $post_meta_total  = $get_details['post_meta_total']    ?? null;
    $revisions        = $get_details['revisions']          ?? null;


    // PAGE information
    if (isset($get_details['registered']['page'])) {
        $pages            = $get_details['registered']['page']['count']           ?? null;
        $page_percentage  = $get_details['registered']['page']['percentage']      ?? null;
        $pages_meta       = $get_details['registered']['page']['meta']            ?? null;
        $page_meta_pg     = $get_details['registered']['page']['meta_percentage'] ?? null;
    } else {
        $pages = $page_percentage = $pages_meta = $page_meta_pg = 0;
    }


    // POST information
    if (isset($get_details['registered']['post'])) {
        $posts            = $get_details['registered']['post']['count']           ?? null;
        $post_percentage  = $get_details['registered']['post']['percentage']      ?? null;
        $posts_meta       = $get_details['registered']['post']['meta']            ?? null;
        $post_meta_pg     = $get_details['registered']['post']['meta_percentage'] ?? null;
    } else {
        $posts = $post_percentage = $posts_meta = $post_meta_pg = 0;
    }


    // WP Navigation information
    if (isset($get_details['registered']['wp_navigation'])) {
        $navigation            = $get_details['registered']['wp_navigation']['count']           ?? null;
        $navigation_percentage = $get_details['registered']['wp_navigation']['percentage']      ?? null;
        $navigation_meta       = $get_details['registered']['wp_navigation']['meta']            ?? null;
        $navigation_meta_pg    = $get_details['registered']['wp_navigation']['meta_percentage'] ?? null;
    } else {
        $navigation = $navigation_percentage = $navigation_meta = $navigation_meta_pg = 0;
    }


    // Elementor Library information
    if (isset($get_details['registered']['elementor_library'])) {
        $E_Library            = $get_details['registered']['elementor_library']['count']           ?? null;
        $E_Library_percentage = $get_details['registered']['elementor_library']['percentage']      ?? null;
        $E_Library_meta       = $get_details['registered']['elementor_library']['meta']            ?? null;
        $E_Library_meta_pg    = $get_details['registered']['elementor_library']['meta_percentage'] ?? null;
    } else {
        $E_Library = $E_Library_percentage = $E_Library_meta = $E_Library_meta_pg = 0;
    }

   
    /**
     * ===============================
     *     store database for render in othere files 
     * ================================
     */
   $get_db_details  = Database::get_all(); 
  
   $db_size         = $get_db_details[ 'db_size'] ?? null;
   $db_total_tables = $get_db_details['total_table'] ?? null;
   $db_option       = $get_db_details['options']['total_options'] ?? null;
   $db_transist     = $get_db_details['options']['total_transient'] ?? null;
   $db_tables       = $get_db_details['tables'] ?? null;
   $core_tables     = [ 'wp_options', 'wp_comments', 'wp_posts', 'wp_users', 
                        'wp_commentmeta', 'wp_postmeta', 'wp_term_taxonomy', 
                        'wp_termmeta', 'wp_terms', 'wp_usermeta' ];

    $db_core_tables = array_filter($db_tables, function($table) use ($core_tables) {
        return in_array($table['table_name'], $core_tables);
    });

    usort($db_core_tables, function($a, $b) {
        return ($b['data_size'] + $b['index_size']) <=> ($a['data_size'] + $a['index_size']);
    });

   
     /**
     * ===============================
     *     store plugin for render in othere files 
     * ================================
     */

     $get_plugin_details = Plugin::get_all();

     $total_plugin     = $get_plugin_details[ 'counts' ][ 'total' ] ?? null;
     $activate_plugin  = $get_plugin_details[ 'counts' ][ 'active_count' ] ?? null;
     $inactive_plugin  = $get_plugin_details[ 'counts' ][ 'inactive' ] ?? null;
     $abandoned_plugin = $get_plugin_details[ 'counts' ][ 'abandoned' ] ?? null;
     
     $all_plugin_info  = $get_plugin_details[ 'plugins' ] ?? null;

    

     /**
     * ===============================
     *     store Envirement snapshot data for render in othere files 
     * ================================
     */

     $get_env_details = Environment::get_all();


     $php_version          = $get_env_details[ 'php' ][ 'version' ] ?? null;
     $php_sapi             = $get_env_details[ 'php' ][ 'sapi' ] ?? null;
     $php_user             = $get_env_details[ 'php' ][ 'user' ] ?? null;
     $max_execution_time   = $get_env_details[ 'php' ][ 'ini_values' ][ 'max_execution_time' ] ?? null;
     $memory_limit         = $get_env_details[ 'php' ][ 'ini_values' ][ 'memory_limit' ] ?? null;
     $upload_max_filesize  = $get_env_details[ 'php' ][ 'ini_values' ][ 'upload_max_filesize' ] ?? null;
     $post_max_size        = $get_env_details[ 'php' ][ 'ini_values' ][ 'post_max_size' ] ?? null;
     $display_errors       = $get_env_details[ 'php' ][ 'ini_values' ][ 'display_errors' ] ?? null;
     $log_errors           = $get_env_details[ 'php' ][ 'ini_values' ][ 'log_errors' ] ?? null;
     $php_extensions       = $get_env_details[ 'php' ][ 'extensions' ] ?? null;
     $php_error_reporting  = $get_env_details[ 'php' ][ 'error_reporting' ] ?? null;
    
     /*----- Server -----*/
     $server_software      = $get_env_details[ 'server' ][ 'software' ];
     $server_address       = $get_env_details[ 'server' ][ 'address' ];
     $server_os            = $get_env_details[ 'server' ][ 'os' ];
     $server_host          = $get_env_details[ 'server' ][ 'host' ];
     $server_arch          = $get_env_details[ 'server' ][ 'arch' ];

     /*----- WordPress -----*/
     $wp_version           = $get_env_details['wordpress']['version'] ?? '';
     $wp_constants         = $get_env_details['wordpress']['constants'] ?? [];
     $environment_type     = $get_env_details['wordpress']['environment_type'] ?? '';
     $development_mode     = $get_env_details['wordpress']['development_mode'] ?? '';

     $wp_debug             = $get_env_details[ 'wordpress' ][ 'constants' ][ 'WP_DEBUG' ] ?? null;
     $wp_debug_display     = $get_env_details[ 'wordpress' ][ 'constants' ][ 'WP_DEBUG_DISPLAY' ] ?? null;
     $wp_debug_log         = $get_env_details[ 'wordpress' ][ 'constants' ][ 'WP_DEBUG_LOG' ] ?? null;
     $script_debug         = $get_env_details[ 'wordpress' ][ 'constants' ][ 'SCRIPT_DEBUG' ] ?? null;
     $wp_cache             = $get_env_details[ 'wordpress' ][ 'constants' ][ 'WP_CACHE' ] ?? null;
     $concatenate_scripts  = $get_env_details[ 'wordpress' ][ 'constants' ][ 'CONCATENATE_SCRIPTS' ] ?? null;
     $compress_scripts     = $get_env_details[ 'wordpress' ][ 'constants' ][ 'COMPRESS_SCRIPTS' ] ?? null;
     $compress_css         = $get_env_details[ 'wordpress' ][ 'constants' ][ 'COMPRESS_CSS' ] ?? null;
     $environment_type     = $get_env_details[ 'wordpress' ][ 'environment_type' ] ?? null;
     $development_mode     = $get_env_details[ 'wordpress' ][ 'development_mode' ] ?? null;
   
    /*----- Database -----*/
     $database_name        = $get_env_details[ 'database' ][ 'database_name' ];
     $database_user        = $get_env_details[ 'database' ][ 'database_user' ];
     $database_host        = $get_env_details[ 'database' ][ 'database_host' ];
     $server_version       = $get_env_details[ 'database' ][ 'server_version' ];

  
