<?php
/*
Plugin Name: BoltBoost
Plugin URI: 
Description: perfomance analying
Version: 1.0.0
Author: hmrisad
Author URI: 
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
Text Domain: boltboost
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// inclused folder
include_once 'includes/Assign-Menu.php';
include_once 'includes/Assets.php';

final class BoltBoost {

    /**
     * define plugin version
     * 
     * @const
     */
     const version = '1.0.0';

    /**
    * Class construcotr
    * 
    * @access private
    */
    private function __construct() {
        $this->define_constants();

        add_action( 'plugins_loaded', [ $this, 'plugin_setup' ] );
    }

    /**
    * Initializes a singleton instance
    *
    * @access public
    */
    public static function plugin_init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
    * Define the required plugin constants
    *
    * @access public
    */
    public function define_constants() {
        define( 'BB_VERSION',  self::version );
        define( 'BB_FILE',     __FILE__ );
        define( 'BB_PATH',     __DIR__ );
        define( 'BB_URL',      plugins_url( '', BB_FILE ) );
        define( 'BB_ASSETS',   BB_URL . '/assets' );
        define( 'BB_DIR_PATH', plugin_dir_path(BB_FILE) );
    }

    /**
    * setup main class
    *
    * @access public
    */
    public function plugin_setup(){
         if( is_admin() ){
              new Assets();
              new Assign_Menu();
         }
    }

}
BoltBoost::plugin_init();