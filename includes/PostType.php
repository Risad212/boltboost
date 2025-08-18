<?php

class Post_Type{

   // Cache properties to store results once queried
    public static $get_total_meta_count = null;
    public static $get_total_revisions  = null; 

   /**
    * Get total meta count
    * 
    * @access public
    */
    public function get_total_meta(){
      if( null !== self::$get_total_meta_count ){
          return self::$get_total_meta_count;
      }

      global $wpdb;
		  self::$get_total_meta_count = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->postmeta}" );
		 return self::$get_total_meta_count;
   }

   /**
    * Get total revisions count
    * 
    * @access public
    */
    public function get_total_revisions(){
      if( null !== self::$get_total_revisions ){
          return self::$get_total_revisions;
      }

      global $wpdb;
		  self::$get_total_revisions = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'revision'" );
		  return self::$get_total_revisions;
   }
}

$a = new Post_Type();
var_dump($a->get_total_revisions());