<?php
/**
 * Created by PhpStorm.
 * User: wangtao
 * Date: 2017/5/24
 * Time: 19:12
 */

namespace backend\modules\rbac\utils;

use Yii;

class Permissions
{
    public static function updateRolePermissions($roleName, $routes)
    {
        $auth = Yii::$app->authManager;

        // 先添加新的权限项
        foreach ($routes as $route) {
            $permission = $auth->getPermission($route);
            if (null === $permission) {
                $permission = $auth->createPermission($route);
                $auth->add($permission);
            }
        }

        // 清空角色下的所有权限
        /**
        $rolePermissions = $auth->getPermissionsByRole($roleName);
        foreach ($rolePermissions as $rolePermission) {
            $auth->remove($rolePermission);
        }
        /**/
        $role = $auth->getRole($roleName);
        $rolePermissions = $auth->getPermissionsByRole($roleName);
        foreach ($rolePermissions as $rolePermission) {
            $auth->removeChild($role, $rolePermission);
        }

        // 给角色重新授权
        foreach ($routes as $route) {
            $permission = $auth->createPermission($route);
            $auth->addChild($role, $permission);
        }
    }
}