<?php

/**
 * Plugin Name:  Advance Review Manager
 * Plugin URI: http://advance-review-manager.com/
 * text-domain: advance-review-manager
 * Description: Advance Review Manager is a plugin for wordpress that allows you to manage reviews for your website.
 * Author: Nitesh Dash, AKM Elias
 * Author URI: #
 * Version: 1.0.0
 */

use ADReviewManager\Classes\ActivationHandler;
use ADReviewManager\Classes\DeactivationHandler;
use ADReviewManager\Hooks\Actions;

if (!defined('ABSPATH')) {
    exit;
}
define('ADRM_URL', plugin_dir_url(__FILE__));
define('ADRM_DIR', plugin_dir_path(__FILE__));
define('ADRM_FILE', __FILE__);
define('ADRM_VERSION', '1.0.0');
define('ADRM_DB_VERSION', 1);

// define('ADVANCE_REVIEW_MANAGER_PRODUCTION', 'yes');
define('ADVANCE_REVIEW_MANAGER_PRODUCTION', 'yes');

class AdvanceReviewManager {
    public function boot()
    {
        $this->loadClasses();
        (new ADReviewManager\Classes\AdminMenuHandler)->renderMenu();
        $this->loadTextDomain();
        // register hooks
        new ADReviewManager\Hooks\Actions();
        (new ADReviewManager\Classes\Shortcode)->registerShortCodes();
    }

    public function loadClasses()
    {
        require ADRM_DIR . 'includes/autoload.php';
    }

    public function loadTextDomain()
    {
        load_plugin_textdomain('advance-review-manager', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
}


register_activation_hook(__FILE__, function () {
 
     ActivationHandler::handle();
    // (new ADReviewManager\Classes\ActivationHandler)->handle();
});

register_deactivation_hook(__FILE__, function () {
    DeactivationHandler::handle();
    // (new ADReviewManager\Classes\DeactivationHandler)->handle();
});


(new AdvanceReviewManager())->boot();



