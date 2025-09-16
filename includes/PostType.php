<?php

class Post_Type {

  private static $total_posts         =  null;
  private static $post_types          =  null;
  private static $post_types_orphans  =  null;
  private static $revisions           =  null;
  private static $post_meta_total     =  null;
  private static $post_meta_by_type   =  null;

  // get post type count
  public static function get_posts_count(){
     if( null !== self::$total_posts ){
        return self::$total_posts;
     }

     // query all post except reiviions and nan_menu_item in variable
     global $wpdb;
     self::$total_posts = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type NOT IN ('revision', 'nav_menu_item')" );

     return self::$total_posts;
  } 

  // get post type count
  public function get_type_counts(){
    if( null !== self::$post_types ){
        return self::$post_types;
    }

    global $wpdb;
    // query all post types as a count
    	$results = $wpdb->get_results( "
            SELECT post_type, COUNT(*) as count
            FROM {$wpdb->posts}
            WHERE post_type NOT IN ('revision', 'nav_menu_item')
            GROUP BY post_type
        ", ARRAY_A );

      $output = [];
		foreach ( $results as $row ) {
			$output[$row['post_type']] = $row['count'];
	   }

     // Add orphaned posts
		$registered   = get_post_types(); // get all post types
		$orphan_count = 0;

		foreach ( $output as $post_type => $count ) {
            // check if post types is a registered valid post types
			if ( ! in_array( $post_type, $registered, true ) ) {
				$orphan_count += $count;
				unset( $output[$post_type] ); // we'll bucket them under _orphaned_posts
				self::$post_types_orphans[$post_type] = $count;
			}
		}

		if ( $orphan_count > 0 ) {
			$output['_orphaned_posts'] = $orphan_count;
		}

		self::$post_types = $output;
		return $output;
  }

   // get revision count of post types
   public static function get_revisions_count(){
        if ( null !== self::$revisions ) {
			return self::$revisions;
		}

        global $wpdb;
        // query all revison from wp_post table
		self::$revisions = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'revision'" );

		return self::$revisions;
   } 

   // total post meta
   public static function get_meta_count(){
     if ( null !== self::$post_meta_total ) {
			return self::$post_meta_total;
		}

        global $wpdb;
        // query all revison from wp_postmeta table
		self::$post_meta_total = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->postmeta}" );

		return self::$post_meta_total;
   }

   // get post types wise meta count each post types how much meta availabe
   public static function get_type_wise_meta_counts(){
       if ( null !== self::$post_meta_by_type ) {
			return self::$post_meta_by_type;
		}

        global $wpdb;
        $results = $wpdb->get_results( "
            SELECT p.post_type, COUNT(pm.meta_id) as meta_count
            FROM {$wpdb->posts} p
            JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
            WHERE p.post_type NOT IN ('revision', 'nav_menu_item')
            GROUP BY p.post_type
        ", ARRAY_A );

        $output = [];
		foreach ( $results as $row ) {
			$output[$row['post_type']] = (int) $row['meta_count'];
		}

		self::$post_meta_by_type = $output;

		return $output;
   }
}

$res = new Post_Type();
$res->get_type_wise_meta_counts();