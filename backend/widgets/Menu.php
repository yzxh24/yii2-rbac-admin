<?php
namespace backend\widgets;

use Yii;
use dmstr\widgets\Menu as DmMenu;

/**
 * 扩展 dmstr 的 Menu 类,使其可以更精准识别 action menu
 * Theme menu widget.
 */
class Menu extends DmMenu
{
    protected function isItemActive($item)
    {
        $isActive = parent::isItemActive($item);

        if (false === $isActive)
        {
            $route = $item['url'][0];
            $exp1 = explode('/', $this->route);
            $exp2 = explode('/', ltrim($route, '/'));

            if (isset($item['options']) && isset($item['options']['multi-controller']) && $item['options']['multi-controller'])
            {
                if (is_array($item['options']['multi-controller']) && in_array($this->route, $item['options']['multi-controller'])) {
                    return true;
                }
                if (is_string($item['options']['multi-controller']) && $this->route === $item['options']['multi-controller']) {
                    return true;
                }
            }

            if (isset($exp1[1]) && isset($exp2[1]) && $exp1[1] == $exp2[1]) {
                return true;
            }
        }

        return $isActive;
    }
}
