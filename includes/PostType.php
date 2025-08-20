<?php

class Post_Type {

   // Cache properties to store results once queried
    public static $total_meta_count     = null;
    public static $total_revisions      = null;
    public static $post_types           = null;
    public static $total_post           = null;
    public static $orphan_post          = null;
    public static $post_meta_by_type    = null;
    public static $percentage           = null;

    /**
    * total post;
    * 
    * @access public
    */
    public static function get_posts_count() {
    if ( null !== self::$total_post ) {
      return self::$total_post;
    }

      global $wpdb;
      self::$total_post = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type NOT IN ('revision', 'nav_menu_item')" );

      return self::$total_post;
    }

    /**
    * Get Post tyes;
    * 
    * @access public
    */
      public static function get_type_counts() {
      if ( null !== self::$post_types ) {
        return self::$post_types;
      }

      global $wpdb;
      $results = $wpdb->get_results( "
              SELECT post_type, COUNT(*) as count
              FROM {$wpdb->posts}
              WHERE post_type NOT IN ('revision', 'nav_menu_item')
              GROUP BY post_type
          ", ARRAY_A );

      $output = [];
      foreach ( $results as $row ) {
        $output[$row['post_type']] = (int) $row['count'];
      }

      // Add orphaned posts
      $registered   = get_post_types();
      $orphan_count = 0;

      foreach ( $output as $post_type => $count ) {
        if ( ! in_array( $post_type, $registered, true ) ) {
          $orphan_count += $count;
          unset( $output[$post_type] );
          self::$orphan_post[$post_type] = $count;
        }
      }

      if ( $orphan_count > 0 ) {
        $output['_orphaned_posts'] = $orphan_count;
      }

      self::$orphan_post = $output;

      return $output;
    }

    /**
    * Get total post
    * 
    * @access public
    */
    public static function get_total_post(){
      if( null !== self::$total_meta_count ){
          return self::$total_meta_count;
      }

      global $wpdb;
      self::$total_meta_count = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->postmeta}" );
     return self::$total_meta_count;
   }


   /**
    * Get meta count
    * 
    * @access public
    */
    public static function get_total_meta(){
      if( null !== self::$total_meta_count ){
          return self::$total_meta_count;
      }

      global $wpdb;
      self::$total_meta_count = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->postmeta}" );
     return self::$total_meta_count;
   }

   /**
    * Get revisions count
    * 
    * @access public
    */
    public static function get_total_revisions(){
      if( null !== self::$total_revisions ){
          return self::$total_revisions;
      }

      global $wpdb;
      self::$total_revisions = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'revision'" );
      return self::$total_revisions;
   }

   /**
    * Get post by meta
    * 
    * @access public
    */
    public static function get_post_wise_meta(){
     if( null !== self::$post_meta_by_type ){
         return self::$post_meta_by_type;
     }

     global $wpdb;
     $results = $wpdb->get_results( "
       SELECT p.post_type, COUNT(pm.meta_id) as meta_count
       FROM {$wpdb->posts} p
       JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
       WHERE p.post_type NOT IN ('revision', 'nav_menu_item')
       GROUP BY p.post_type
      " , ARRAY_A);

      $output;

      foreach( $results as $row ){
         $output[$row['post_type']] = $row['meta_count'];
      }
      self::$post_meta_by_type = $output;

      return $output;
   }

    /**
    * get orphaned post types
    *
    * @access public
    */
   public static function get_orphaned_post_types() {
		return self::$orphan_post ?? [];
	 }

   /**
    * get percentages of all each post types
    *
    * @access public
    */
   public static function get_percentage_breakdown(){
      if( null !== self::$percentage ){
         return self::$percentage;
      }

      $total_post   = self::get_posts_count();
      $total_meta   = self::get_total_meta();
      $post_types   = self::get_type_counts();
      $meta_by_type = self::get_post_wise_meta();
      $orphan_post  = self::get_orphaned_post_types();
     
      $parcentage_post_type = [];
      $parcentage_meta_type = [];

      // Register post types parcentage
      foreach( $post_types as $type => $count ){
         if( $total_post > 0){
             $parcentage_post_type[$type] = round( ($count / $total_post) * 100, 2);
         }else{
             $parcentage_post_type[$type] = 0;
         }
      }

      // Percentages for post wise meta
      foreach( $meta_by_type as $type => $count ){
         if( $total_meta > 0){
             $parcentage_meta_type[$type] = round( ($count / $total_meta) * 100, 2);
         }else{
             $parcentage_meta_type[$type] = 0;
         }
       }

      // Percentage for orphan post type
      foreach ( $orphan_post as $type => $count ){
           if( $total_post > 0){
             $parcentage_post_type[$type] = round( ($count / $total_post) * 100, 2);
         }else{
             $parcentage_post_type[$type] = 0;
         }
      }

      // together post and meta in array
      self::$percentage = [
         'post_type_percentage' => $parcentage_post_type,
         'meta_type_parcentage' => $parcentage_meta_type,
      ];

      return self::$percentage;

     }
}

$a = new Post_Type();
var_dump($a->get_percentage_breakdown());
