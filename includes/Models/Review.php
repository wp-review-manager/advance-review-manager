<?php
declare(strict_types=1);

namespace WPReviewManager\Models;
use WPReviewManager\Services\ArrayHelper as Arr;

class Review extends Model
{
    public function create() {
        dd('create review form', $_POST);
    }
}