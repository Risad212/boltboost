<?php
 require_once BB_DIR_PATH . 'includes/PostType.php';

  $get_post_types = new Post_Type();
  $get_details    = $get_post_types->get_all_details();
  
  // assign the all value in varable for view
  $post_types_count       =  count($get_details['registered']);
  $total_post             =  $get_details['total_posts'];
  $post_meta_total        =  $get_details['post_meta_total'];
  $revisions              =  $get_details['revisions'];
        
  // pages infromation
  $pages                  =  $get_details['registered']['page']['count'];
  $page_percentage        =  $get_details['registered']['page']['percentage'];
  $pages_meta             =  $get_details['registered']['page']['meta'];
  $page_meta_pg           =  $get_details['registered']['page']['meta_percentage'];

  // Post infromation
  $posts                  =  $get_details['registered']['post']['count'];
  $post_percentage        =  $get_details['registered']['post']['percentage'];
  $posts_meta             =  $get_details['registered']['post']['meta'];
  $post_meta_pg           =  $get_details['registered']['page']['meta_percentage'];

  // Wp Navigatio infromation
  $navigation             =  $get_details['registered']['wp_navigation']['count'];
  $navigation_percentage  =  $get_details['registered']['wp_navigation']['percentage'];
  $navigation_meta        =  $get_details['registered']['wp_navigation']['meta'];
  $navigation_meta_pg     =  $get_details['registered']['wp_navigation']['meta_percentage'];

  // Elementor Library infromation
  $E_Library             =  $get_details['registered']['elementor_library']['count'];
  $E_Library_percentage  =  $get_details['registered']['elementor_library']['percentage'];
  $E_Library_meta        =  $get_details['registered']['elementor_library']['meta'];
  $E_Library_meta_pg     =  $get_details['registered']['elementor_library']['meta_percentage'];
