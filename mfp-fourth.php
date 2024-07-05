<?php


/**
 * Plugin Name: MFP Fourth 
**/



if ( ! defined( 'ABSPATH' ) ) {
    exit();
}



class Mfp_fourth{
    public static $instance;

    private function __construct() {
        $this->require_classes();
    }

    public function require_classes(){
        require_once __DIR__ . '/includes/admin-menu.php';
        new Mfp_admin_menu();
    }

    public static function get_instance(){
        if( ! isset( self::$instance ) ){
            self::$instance = new Mfp_fourth();
        }
        return self::$instance;
    }
}

Mfp_fourth::get_instance();