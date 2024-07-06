<?php

namespace ADReviewManager\Services;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Managing Access Control
 * This is not complete on version 1.0.0 but we will definitely add this feature.
 * @since 1.0.0
 */
class AccessControl
{
    public static function hasGrandAccess()
    {
        $grandPermissions = array(
            'manage_options'
        );

        foreach ($grandPermissions as $grandPermission) {
            if (current_user_can($grandPermission)) {
                return $grandPermission;
            }
        }
        return false;
    }

    public static function hasTopLevelMenuPermission()
    {
        $menuPermissions = array(
            'manage_options',
        );
        foreach ($menuPermissions as $menuPermission) {
            if (current_user_can($menuPermission)) {
                return true;
            }
        }
        return false;
    }

    public static function checkUserPermission($permission = '')
    {
        if (current_user_can($permission)) {
            return true;
        }

        return false;
    }

    public static function checkAndPresponseError($endpoint = false, $group = false, $message = '')
    {
        if (self::hasEndPointPermission($endpoint, $group)) {
            return true;
        }

        wp_send_json_error(array(
            'message' => ($message) ? $message : __('Sorry, You do not have permission to do this action: ', 'advance-review-manager') . $endpoint,
            'action' => $endpoint
        ), 423);
    }

    public static function hasEndPointPermission($endpoint = false, $group = false)
    {

        if ($grandAccess = self::hasGrandAccess()) {
            return apply_filters('adrm/has_endpoint_access', $grandAccess, $endpoint, $group);
        }

        //will give custom access in future
        // elseif ($roleAccess = self::giveCustomAccess()['has_access']) {
        //     return apply_filters('adrm/has_endpoint_access', $roleAccess, $endpoint, $group);
        // }

        $permissions = self::getEndpointPermissionMaps($group);

        if (isset($permissions[$endpoint])) {
            $relatedPermission = $permissions[$endpoint];
            foreach ($relatedPermission as $permission) {
                if (current_user_can($permission)) {
                    return apply_filters('adrm/has_endpoint_access', $permission, $endpoint, $group);
                }
            }
        }
        return apply_filters('adrm/has_endpoint_access', false, $endpoint, $group);
    }

    public static function getEndpointPermissionMaps($group = false)
    {
        // we will set permission maps here
        $permissionGroups = array(
            '' => array(
                '' => array(
                ),
            ),
        );

        if (!$group || !isset($permissionGroups[$group])) {
            return array_merge(
                $permissionGroups[''],
                $permissionGroups[''],
                $permissionGroups['']
            );
        }

        return $permissionGroups[$group];
    }

    public static function getPermissionLists()
    {
        // we will set permission list here
        return array();
    }

    public function getAccessRoles()
    {
        if (!current_user_can('manage_options')) {
            return array(
                'capability' => array(),
                'roles' => array()
            );
        }

        if (!function_exists('get_editable_roles')) {
            require_once ABSPATH . 'wp-admin/includes/user.php';
        }
        $roles = \get_editable_roles();

        $formatted = array();
        foreach ($roles as $key => $role) {
            if ($key == 'administrator') {
                continue;
            }
            if ($key != 'subscriber') {
                $formatted[] = array(
                    'name' => $role['name'],
                    'key' => $key
                );
            }
        }

        $capability = get_option('_adrm_permission');

        if (is_string($capability)) {
            $capability = [];
        }
        return array(
            'capability' => $capability,
            'roles' => $formatted
        );
    }

}
