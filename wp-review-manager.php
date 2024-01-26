<?php

/**
 * Plugin Name: WP review manager
 * Plugin URI: http://wp-review-manager.com/
 * Description: WP review manager is a plugin for wordpress that allows you to manage reviews for your website.
 * Author: #
 * Author URI: #
 * Version: 1.0.5
 */

use WPReviewManager\Classes\ActivationHandler;
use WPReviewManager\Classes\DeactivationHandler;

if (!defined('ABSPATH')) {
    exit;
}
define('WPRM_URL', plugin_dir_url(__FILE__));
define('WPRM_DIR', plugin_dir_path(__FILE__));
define('WPRM_FILE', __FILE__);
define('WPRM_VERSION', '1.0.5');
define('WPRM_DB_VERSION', 1);

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
        require WPRM_DIR . 'includes/autoload.php';
    }


    public function ActivatePlugin()
    {
        //activation deactivation hook
        // register_activation_hook(__FILE__, function ($newWorkWide) {
        //     $activator = new \WPReviewManager\Classes\ActivationHandler();
        //     $activator->handle($newWorkWide);
        // });
    }
}


register_activation_hook(__FILE__, function () {
 
     ActivationHandler::handle();
    // (new WPReviewManager\Classes\ActivationHandler)->handle();
});

register_deactivation_hook(__FILE__, function () {
    DeactivationHandler::handle();
    // (new WPReviewManager\Classes\DeactivationHandler)->handle();
});


(new WPReviewManager())->boot();



