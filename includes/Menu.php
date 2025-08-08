<?php


class Menu {

    function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register admin menu
     *
     * @access public
     */
    public function admin_menu() {
        add_menu_page(
        __( 'BoltBoost', 'pedro-elementor-addons' ),  // Page title
        __( 'BoltBoost', 'pedro-elementor-addons' ), // Menu title
        'manage_options',                            // Capability
        'boltboost',                                 // Menu slug
        [ $this, 'plugin_page' ],                    // Callback function
        'dashicons-vault'                            // Icon
    );

    }

    /**
     * Render the plugin page
     *
     * @access public
     */
    public function plugin_page() {
        require_once dirname(__DIR__) . '/templates/layout.php';
    }
}