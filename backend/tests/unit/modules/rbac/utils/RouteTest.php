<?php
/**
 * Created by PhpStorm.
 * User: wangtao
 * Date: 2017/5/22
 * Time: 18:57
 */

namespace backend\tests\unit\modules\utils;


use Codeception\Test\Unit;
use backend\modules\rbac\utils\OneController;
use backend\modules\rbac\utils\OneAction;
use backend\modules\rbac\utils\Routes;

class RouteTest extends Unit
{
    /** @var Routes */
    public $route;

    public function _before()
    {
        parent::_before();

        $this->route = new Routes('rbac');
    }

    public function testGetControllers()
    {
        $controllers = $this->route->getControllers();

        expect("获取 rbac 模块所有控制器", count($controllers) > 0)->true();
        expect("正确的控制器类型", $controllers[0])->isInstanceOf(OneController::class);
        expect("正确的路由类型", $controllers[0]->getActions()['index'])->isInstanceOf(OneAction::class);
        expect("正确的路由", $controllers[0]->getAction('index'))->isInstanceOf(OneAction::class);
    }

    public function testGetConfig()
    {
        $routes = $this->route->getRoutes();

        expect("配置文件为空", empty($routes))->false();
        expect("获取 rbac 模块路由器配置文件", is_array($routes))->true();
    }

    public function testRoutesGenerate()
    {
        $routes = $this->route->generateRoutes();

        expect("routes 生成正确1", is_array($routes))->true();
        expect("routes 生成正确2", count($routes) > 0)->true();
        expect("routes 生成正确3", !empty($routes['controllers']['route']))->true();
        expect("routes 生成正确4", $routes['controllers']['site']['actions']['index'] == '后台首页')->true();
    }
}
