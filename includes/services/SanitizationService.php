<?php

namespace ADReviewManager\Services;

if (!defined('ABSPATH')) {
    exit;
}

class SanitizationService
{
    public static function sanitize_array_values($data) {

        array_walk_recursive($data, function (&$value, $key) {
            $value = sanitize_text_field($value, $key);
        });

        return $data;
    }
}