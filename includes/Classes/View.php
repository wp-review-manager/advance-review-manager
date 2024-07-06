<?php
namespace ADReviewManager\Classes;

use ParagonIE\Sodium\Core\Curve25519\H;

if (!defined('ABSPATH')) {
    exit;
}
class View
{
    public static function make($path, $data = [])
    {
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        $file = ADRM_DIR.'includes/Views/'.$path.'.php';
        ob_start();
        extract($data);
        include $file;
        return ob_get_clean();
    }

    public static function render($path, $data = [])
    {
        echo wp_kses(static::make($path, $data), Helper::allowedHTMLTags());
    }
}