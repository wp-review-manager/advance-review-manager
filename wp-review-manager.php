<?php

/**
 * Plugin Name: WP review manager
 * Plugin URI: http://wp-review-manager.com/
 * Description: WP review manager is a plugin for wordpress that allows you to manage reviews for your website.
 * Author: #
 * Author URI: #
 * Version: 1.0.5
 */
define('WPM_URL', plugin_dir_url(__FILE__));
define('WPM_DIR', plugin_dir_path(__FILE__));

define('WPM_VERSION', '1.0.5');

class WPReviewManager {
    public function boot()
    {
        $this->loadClasses();
        (new WPReviewManager\Classes\Shortcode)->registerShortCodes();
        $this->ActivatePlugin();
        (new WPReviewManager\Classes\AdminMenuHandler)->renderMenu();
    }

    public function loadClasses()
    {
        require WPM_DIR . 'includes/autoload.php';
    }


    public function ActivatePlugin()
    {
        //activation deactivation hook
        register_activation_hook(__FILE__, function ($newWorkWide) {
            require_once(WPM_DIR . 'includes/Classes/Activator.php');
            $activator = new \WPReviewManager\Classes\Activator();
            $activator->migrateDatabases($newWorkWide);
        });
    }
}

(new WPReviewManager())->boot();



