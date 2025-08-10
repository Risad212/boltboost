<?php


class Assets {
    public function __construct(){
      add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );
    }

    public function register_assets(){
        wp_enqueue_style( 'bb-admin-css', BB_ASSETS. '/css/main.css' );
        wp_enqueue_script( 'bb-admin-js', BB_ASSETS. '/js/main.js', ['jquery'], false, true );
    }
}