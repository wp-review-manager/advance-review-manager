<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

// global functions here
function ADRM_getAvatar($email, $size)
{
    $hash = md5(strtolower(trim($email)));

    /**
     * Gravatar URL by Email
     *
     * @return HTML $gravatar img attributes of the gravatar image
     */
    return apply_filters('adrm_get_avatar',
        "https://www.gravatar.com/avatar/{$hash}?s={$size}&d=mm&r=g",
        $email
    );
}