<?php defined('ABSPATH') or die;

/**
 * Plugin Name: Advance Review Manager
 * Description: Advance Review Manager by WPulse is an advance review management plugin.
 * Author: WPulse
 * Author URI: https://www.akmelias.com/
 * Plugin URI: #
 * License: GPLv2 or later
 * Text Domain: advance-review-manager
 * Version: 1.1.0
 */

define('ADRM_URL', plugin_dir_url(__FILE__));
define('ADRM_DIR', plugin_dir_path(__FILE__));
define('ADRM_FILE', __FILE__);
define('ADRM_VERSION', '1.1.0');
define('ADRM_DB_VERSION', 1);

// define('ADVANCE_REVIEW_MANAGER_PRODUCTION', 'yes');
define('ADVANCE_REVIEW_MANAGER_PRODUCTION', 'yes');


use ADReviewManager\Classes\ActivationHandler;
use ADReviewManager\Classes\DeactivationHandler;

class AdvanceReviewManager {
    public function boot()
    {
        $this->loadClasses();
        (new ADReviewManager\Classes\AdminMenuHandler)->renderMenu();
        $this->loadTextDomain();
        // register hooks
        new ADReviewManager\Hooks\Actions();
        // require ADRM_DIR . 'includes/Hooks/Actions.php';
        (new ADReviewManager\Classes\Shortcode)->registerShortCodes();

        /**
         * Migrate the comment database
         * @since 1.0.3
         */
        if (!get_option('adrm_comments_module_enabled')){
            \ADReviewManager\Database\Migrations\ReviewComment::migrate(true);
            update_option('adrm_comments_module_enabled', 'yes');
        }
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
});

register_deactivation_hook(__FILE__, function () {
    DeactivationHandler::handle();
    // (new ADReviewManager\Classes\DeactivationHandler)->handle();
});


(new AdvanceReviewManager())->boot();



