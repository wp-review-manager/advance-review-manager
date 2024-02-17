<?php
namespace WPReviewManager\Classes;

class View
{
    public static function make($path, $data = [])
    {
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        $file = WPRM_DIR.'includes/Views/'.$path.'.php';
        // dd($file);
        ob_start();
        extract($data);
        include $file;
        return ob_get_clean();
    }

    public static function render($path, $data = [])
    {
        echo static::make($path, $data);
    }
}