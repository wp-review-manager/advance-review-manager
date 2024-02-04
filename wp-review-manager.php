<?php

/**
 * Plugin Name: WP review manager
 * Plugin URI: http://wp-review-manager.com/
 * text-domain: wp-review-manager
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

// define('WP_REVIEW_MANAGER_PRODUCTION', 'yes');
define('WP_REVIEW_MANAGER_DEVELOPMENT', 'yes');

class WPReviewManager {
    public function boot()
    {
        $this->loadClasses();
        (new WPReviewManager\Classes\Shortcode)->registerShortCodes();
        (new WPReviewManager\Classes\AdminMenuHandler)->renderMenu();
        $this->loadTextDomain();
    }

    public function loadClasses()
    {
        require WPRM_DIR . 'includes/autoload.php';
    }

    public function loadTextDomain()
    {
        load_plugin_textdomain('wp-review-manager', false, dirname(plugin_basename(__FILE__)) . '/languages');
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



