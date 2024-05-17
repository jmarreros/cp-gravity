<?php

namespace dcms\cpgravity\includes;

/**
 * Class for creating a dashboard submenu
 */
class Submenu{
    // Constructor
    public function __construct(){
        add_action('admin_menu', [$this, 'register_submenu']);
    }

    // Register submenu
    public function register_submenu(){
        add_submenu_page(
            DCMS_CPGRAVITY_SUBMENU,
            __('Código Postal Gravity','cpgravity'),
            __('Código Postal Gravity','cpgravity'),
            'manage_options',
            'cpgravity',
            [$this, 'submenu_page_callback']
        );
    }

    // Callback, show view
    public function submenu_page_callback(){
        include_once (DCMS_CPGRAVITY_PATH. '/views/main-screen.php');
    }
}