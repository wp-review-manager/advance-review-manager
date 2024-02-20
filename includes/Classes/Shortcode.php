<?php
declare(strict_types=1);

namespace WPReviewManager\Classes;
class Shortcode {
    
    public function registerShortCodes() {
        add_action('plugin_loaded', function() {
            $this->WPReviewManagerShortcode();
        });
    }

    public function WPReviewManagerShortcode() {
        add_shortcode('wp-review-manager', function ($args) {
            // dd($args);
            Vite::enqueueScript('WPRM-form-preview-js', 'public/js/form_preview.js', array('jquery'), WPRM_VERSION, true);
            return "<h1>hello</h1>";
            // $args = shortcode_atts(
            //     array(
            //         'id' => '',
            //         'show_title' => false,
            //         'show_description' => false,
            //     ),
            //     $args
            // );
    
            // if (!$args['id']) {
            //     return;
            // }
    
            // $builder = new \WPPayForm\App\Modules\Builder\Render();
    
            // return $builder->render($args['id'], $args['show_title'], $args['show_description']);
        });
    }
}
