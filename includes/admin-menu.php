<?php

class Mfp_admin_menu{
    public function __construct(){
        add_action("admin_menu", array( $this, "admin_menu") );
    }
    public function admin_menu(){
        add_menu_page("MFP", "MFP", "manage_options", "mfp", array( $this, "mfp_menu_callback"), "dashicons-image-filter" );
    }

    public function mfp_menu_callback(){
        include_once __DIR__ . "/templates/mfp-menu.php";
    }
}