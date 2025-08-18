<?php

class Post_Type{

   /**
    * Declear variable
    * 
    * @access public
    */
    public $get_total_meta_count = null;
    public $get_total_revisions  = null; 

   /**
    * Get total meta count
    * 
    * @access public
    */
    public function get_total_meta(){
      if( null !== $this->get_total_meta_count ){
          return $this->get_total_meta_count;
      }
      global $wpdb;
		$this->get_total_meta_count = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->postmeta}" );
		return $this->get_total_meta_count;
   }

   /**
    * Get total revisions count
    * 
    * @access public
    */
    public function get_total_revisions(){
      if( null !== $this->get_total_revisions ){
          return $this->get_total_revisions;
      }
      global $wpdb;
		$this->get_total_revisions = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'revision'" );
		return $this->get_total_revisions;
   }
}

$a = new Post_Type();
var_dump($a->get_total_revisions());