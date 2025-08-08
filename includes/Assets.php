<?php


class Assets {
    public function __construct(){
      add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
    }

    public function register_assets(){
        wp_enqueue_style( 'bb-admin-css', BB_URL. '/css/main.css' );
        wp_enqueue_script( 'bb-admin-js', BB_URL. '/js/main.js', ['jquery'], false, true );
    }
}