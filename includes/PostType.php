<?php

class Post_Type{

   // Cache properties to store results once queried
    public static $total_meta_count     = null;
    public static $total_revisions      = null;
    public static $post_types           = null;
    public static $total_post           = null;
    public static $orphan_post          = null;


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
    public function get_total_post(){
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
    public function get_total_meta(){
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
    public function get_total_revisions(){
      if( null !== self::$total_revisions ){
          return self::$total_revisions;
      }

      global $wpdb;
		  self::$total_revisions = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'revision'" );
		  return self::$total_revisions;
   }
}

$a = new Post_Type();
var_dump($a->get_total_revisions());