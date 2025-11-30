<?php

    require_once BB_DIR_PATH . 'includes/PostType.php';

    /**
     * ========================
     *     store post types for render in othere files 
     * ========================
     */
    $get_details    = Post_Type::get_all_details();

    // assign the all value in variable for view
    $post_types_count = isset($get_details['registered']) ? count($get_details['registered']) : 0;

    $total_post       = $get_details['total_posts']        ?? 0;
    $post_meta_total  = $get_details['post_meta_total']    ?? 0;
    $revisions        = $get_details['revisions']          ?? 0;


    // PAGE information
    if (isset($get_details['registered']['page'])) {
        $pages            = $get_details['registered']['page']['count']           ?? 0;
        $page_percentage  = $get_details['registered']['page']['percentage']      ?? 0;
        $pages_meta       = $get_details['registered']['page']['meta']            ?? 0;
        $page_meta_pg     = $get_details['registered']['page']['meta_percentage'] ?? 0;
    } else {
        $pages = $page_percentage = $pages_meta = $page_meta_pg = 0;
    }


    // POST information
    if (isset($get_details['registered']['post'])) {
        $posts            = $get_details['registered']['post']['count']           ?? 0;
        $post_percentage  = $get_details['registered']['post']['percentage']      ?? 0;
        $posts_meta       = $get_details['registered']['post']['meta']            ?? 0;
        $post_meta_pg     = $get_details['registered']['post']['meta_percentage'] ?? 0;
    } else {
        $posts = $post_percentage = $posts_meta = $post_meta_pg = 0;
    }


    // WP Navigation information
    if (isset($get_details['registered']['wp_navigation'])) {
        $navigation            = $get_details['registered']['wp_navigation']['count']           ?? 0;
        $navigation_percentage = $get_details['registered']['wp_navigation']['percentage']      ?? 0;
        $navigation_meta       = $get_details['registered']['wp_navigation']['meta']            ?? 0;
        $navigation_meta_pg    = $get_details['registered']['wp_navigation']['meta_percentage'] ?? 0;
    } else {
        $navigation = $navigation_percentage = $navigation_meta = $navigation_meta_pg = 0;
    }


    // Elementor Library information
    if (isset($get_details['registered']['elementor_library'])) {
        $E_Library            = $get_details['registered']['elementor_library']['count']           ?? 0;
        $E_Library_percentage = $get_details['registered']['elementor_library']['percentage']      ?? 0;
        $E_Library_meta       = $get_details['registered']['elementor_library']['meta']            ?? 0;
        $E_Library_meta_pg    = $get_details['registered']['elementor_library']['meta_percentage'] ?? 0;
    } else {
        $E_Library = $E_Library_percentage = $E_Library_meta = $E_Library_meta_pg = 0;
    }


