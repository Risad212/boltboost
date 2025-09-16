<?php

class Post_Type {

  private static $total_posts         =  null;
  private static $post_types          =  null;
  private static $post_types_orphans  =  null;
  private static $revisions           =  null;
  private static $post_meta_total     =  null;
  private static $post_meta_by_type   =  null;
  private static $percentages         =  null;

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
  public static function get_type_counts(){
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

    // get all orphaned post
    public static function get_orphaned_post_types() {
		return self::$cached_post_types_orphans ?? [];
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

   // percentages breakdown for show in view
   public static function get_percentage_breakdown(){
       if( null !== self::$percentages ){
          return self::$percentages;
       }

       	$total_posts  = self::get_posts_count();
		$total_meta   = self::get_meta_count();
		$post_types   = self::get_type_counts();
		$orphan_types = self::get_orphaned_post_types();
		$meta_by_type = self::get_type_wise_meta_counts();

        $percent_post_types = [];
		$percent_meta_types = [];

        // Registered post type percentages.
		foreach ( $post_types as $type => $count ) {
			$percent_post_types[$type] = $total_posts > 0 ? round( ( $count / $total_posts ) * 100, 2 ) : 0;
		}

		// Percentages for individual orphaned post types.
		foreach ( $orphan_types as $type => $count ) {
			$percent_post_types[$type] = $total_posts > 0 ? round( ( $count / $total_posts ) * 100, 2 ) : 0;
		}

		// Meta percentages include both registered and orphaned types plus orphaned meta.
		foreach ( $meta_by_type as $type => $count ) {
			$percent_meta_types[$type] = $total_meta > 0 ? round( ( $count / $total_meta ) * 100, 2 ) : 0;
		}

		self::$percentages = [
			'post_type_percentage' => $percent_post_types,
			'post_meta_percentage' => $percent_meta_types,
		];

		return self::$percentages;
   } 

   // get all information group by one array
   	public static function get_all() {
		return [
			'total_posts'       => self::get_posts_count(),
			'post_types'        => self::get_type_counts(),
			'revisions'         => self::get_revisions_count(),
			'post_meta_total'   => self::get_meta_count(),
			'post_meta_by_type' => self::get_type_wise_meta_counts(),
			'percentages'       => self::get_percentage_breakdown(),
		];
	}

    // get all information group by one array for make clear picture
    public static function get_all_details(){
        $post_types = self::get_type_counts();
		$post_meta  = self::get_type_wise_meta_counts();

        // Calculate percentage breakdowns once to avoid repeated work.
		$percentages          = self::get_percentage_breakdown();
		$post_type_percentage = $percentages['post_type_percentage'] ?? [];
		$post_meta_percentage = $percentages['post_meta_percentage'] ?? [];

        // make one array with all information about each registred post types
        $registered = [];
		foreach ( $post_types as $type => $count ) {
			$registered[$type] = [
				'count'           => $count,
				'meta'            => $post_meta[$type] ?? 0,
				'percentage'      => $post_type_percentage[$type] ?? 0,
				'meta_percentage' => $post_meta_percentage[$type] ?? 0,
			];
		}

         // make one array with all information about each orphaned post types
		$orphaned          = [];
		$orphan_post_total = 0;
		$orphan_meta_total = 0;
		foreach ( self::get_orphaned_post_types() as $type => $count ) {
			$meta_count = $post_meta[$type] ?? 0;
			$orphan_post_total += $count;
			$orphan_meta_total += $meta_count;
			$orphaned[$type] = [
				'count'           => $count,
				'meta'            => $meta_count,
				'percentage'      => $post_type_percentage[$type] ?? 0,
				'meta_percentage' => $post_meta_percentage[$type] ?? 0,
			];
		}

        return [
			'total_posts'        => self::get_posts_count(),
			'post_meta_total'    => self::get_meta_count(),
			'revisions'          => self::get_revisions_count(),
			'registered'         => $registered,
			'orphaned'           => $orphaned,
			'orphan_posts_total' => $orphan_post_total,
			'orphan_meta_total'  => $orphan_meta_total,
		];
     }
}


