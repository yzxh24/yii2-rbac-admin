<?php
/**
 * Created by PhpStorm.
 * User: wangtao
 * Date: 2017/5/26
 * Time: 10:29
 */

namespace backend\components;

use Yii;
use yii\rbac\BaseManager;
use backend\models\AuthMenu;

class MenuHelper
{
    /**
     * 获得当前用户有权访问的 route 列表
     * @param int $userId
     * @return array
     */
    public static function getAssignedRoutes($userId)
    {
        /** @var BaseManager $auth */
        $auth = Yii::$app->authManager;
        $routes = [];
        foreach ($auth->getPermissionsByUser($userId) as $permission) {
            $routes[] = $permission->name;
        }

        return $routes;
    }

    public static function getAssignedMenu($userId, $callback = null)
    {
        $menus = AuthMenu::find()->asArray()->indexBy('id')->all();
        $routes = static::getAssignedRoutes($userId);

        $routes = array_unique($routes);
        sort($routes);

        $assigned = AuthMenu::find()
            ->select(['id'])
            ->asArray()
            ->where(['route' => $routes])
            ->column();

        $assigned = static::requiredParent($assigned, $menus);
        $result = static::normalizeMenu($assigned, $menus, $callback);

        return $result;
    }

    /**
     * Ensure all item menu has parent.
     * @param  array $assigned
     * @param  array $menus
     * @return array
     */
    private static function requiredParent($assigned, &$menus)
    {
        $l = count($assigned);
        for ($i = 0; $i < $l; $i++) {
            $id = $assigned[$i];
            $parent_id = $menus[$id]['parent'];
            if ($parent_id !== null && !in_array($parent_id, $assigned)) {
                $assigned[$l++] = $parent_id;
            }
        }

        return $assigned;
    }

    /**
     * Normalize menu
     * @param  array $assigned
     * @param  array $menus
     * @param  \Closure $callback
     * @param  integer $parent
     * @return array
     */
    private static function normalizeMenu(&$assigned, &$menus, $callback, $parent = null)
    {
        $result = [];
        $order = [];
        foreach ($assigned as $id) {
            $menu = $menus[$id];
            if ($menu['parent'] == $parent) {
                $menu['children'] = static::normalizeMenu($assigned, $menus, $callback, $id);
                if ($callback !== null) {
                    $item = call_user_func($callback, $menu);
                } else {
                    $item = [
                        'label' => $menu['name'],
                        'url' => static::parseRoute($menu['route']),
                    ];
                    if ($menu['children'] != []) {
                        $item['items'] = $menu['children'];
                    }
                }
                $result[] = $item;
                $order[] = $menu['order'];
            }
        }
        if ($result != []) {
            array_multisort($order, $result);
        }

        return $result;
    }

    /**
     * Parse route
     * @param  string $route
     * @return mixed
     */
    public static function parseRoute($route)
    {
        if (!empty($route)) {
            $url = [];
            $r = explode('&', $route);
            $url[0] = '/' . $r[0];
            unset($r[0]);
            foreach ($r as $part) {
                $part = explode('=', $part);
                $url[$part[0]] = isset($part[1]) ? '/' . $part[1] : '';
            }

            return $url;
        }

        return '#';
    }
}