<?php
/**
 * Created by PhpStorm.
 * User: wangtao
 * Date: 2017/5/22
 * Time: 17:57
 */

namespace backend\modules\rbac\utils;

use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;

class Routes
{
    private $_module;
    private $_routes = [];

    public function __construct($module)
    {
        $this->_module = $module;
        $this->_routes = $this->getRoutes();
    }

    public static function updateRouteLabel($route, $label)
    {
        // TODO 以下实现有点搓,想办法改改
        $allRoutes = static::getAllModuleRoutes();
        foreach ($allRoutes as $module => $routes)
        {
            if ($module == substr($route, 0, strlen($module)))
            {
                $controllers = $routes->getControllers();
                foreach ($controllers as $controller) {
                    $actions = $controller->getActions();
                    foreach ($actions as $action) {
                        if ($action->getRoute() == $route) {
                            $_routes = $routes->toArray();
                            $_routes['controllers'][$controller->getRouteName()]['actions'][$action->getActionRouteUrl()] = $label;
                            $routes->save($_routes);
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    public static function getAllModules()
    {
        $modules = [];
        foreach (array_keys(Yii::$app->modules) as $module) {
            if (!in_array($module, ['gii', 'debug'])) {
                $modules[] = $module;
            }
        }

        return $modules;
    }

    /**
     * @return Routes[]
     */
    public static function getAllModuleRoutes()
    {
        $modules = static::getAllModules();
        $routes = [];
        foreach ($modules as $module) {
            $routes[$module] = new Routes($module);
        }

        return $routes;
    }

    public function getModuleName()
    {
        return $this->_module;
    }

    /**
     * 模块的名称
     * @return string
     */
    public function getLabel()
    {
        return $this->_routes['label'];
    }

    /**
     * @return OneController[]
     */
    public function getControllers()
    {
        $controllers = [];
        foreach ($this->_routes['controllers'] as $controllerName => $controller) {
            $structure = new OneControllerStructure();
            $structure->name = $controllerName;
            $structure->label = $controller['label'];
            $structure->controller = $controller['controller'];
            $structure->actionsStructure = $this->createActionsStructure($controller['actions']);

            $controllers[] = new OneController($this->_module, $structure);
        }

        return $controllers;
    }

    /**
     * 将 routes.php 裡的 action 数组转换成一个结构对象列表
     * @param array $actionArray
     * @return OneActionStructure[]
     */
    private function createActionsStructure($actionArray)
    {
        $oneActionStructures = [];
        foreach ($actionArray as $action => $label) {
            $oneActionStructures[] = new OneActionStructure($label, $action);
        }

        return $oneActionStructures;
    }

    /**
     * 获得路由的配置文件
     * @return array
     * @throws Exception
     */
    public function getRoutes()
    {
        if ([] != $this->_routes) {
            return $this->_routes;
        }

        $routeFile = $this->getRoutesFile();
        if (!is_file($routeFile)) {
            throw new Exception("无法找到模块" . $this->_module . "的路由配置文件: " . $routeFile);
        }

        $routes = require($routeFile);

        return $routes[$this->_module];
    }

    /**
     * @return string
     */
    private function getRoutesFile()
    {
        return $this->getModuleDir() . 'routes.php';
    }

    private function getModuleDir()
    {
        return Yii::getAlias("@app") . '/modules/' . $this->_module . '/';
    }

    /**
     * 自动搜索模块下所有的控制器文件,提取里面的action方法生成 routes.php 裡的数据项
     * 搜索出来的数据不会覆盖原有文件裡的,只做增量
     * @param bool $backUp
     * @return array
     */
    public function generateRoutes($backUp = false)
    {
//        $routesFile = $this->getRoutesFile();
//        if (!is_file($routesFile)) {
//            file_put_contents($routesFile, "<?php\nreturn [\n\n];", LOCK_EX);
//        }

        if ($backUp) {
            $this->backUp();
        }

        $generator = new RoutesGenerator($this->_module);
        $routes = ArrayHelper::merge($generator->getRoutes(), $this->getRoutes());
//        file_put_contents($routesFile, "<?php\nreturn " . VarDumper::export([$this->getModuleName() => $routes]) . ";\n", LOCK_EX);
//        $this->_routes = $routes;
//
//        return $routes;
        return $this->save($routes);
    }

    public function save($routes)
    {
        $routesFile = $this->getRoutesFile();
        if (!is_file($routesFile)) {
            file_put_contents($routesFile, "<?php\nreturn [\n\n];", LOCK_EX);
        }

        file_put_contents($routesFile, "<?php\nreturn " . VarDumper::export([$this->getModuleName() => $routes]) . ";\n", LOCK_EX);
        $this->_routes = $routes;

        return $routes;
    }

    public function toArray()
    {
        $routes = [];
        $controllers = $this->getControllers();
        foreach ($controllers as $controller)
        {
            $controllerStructure = $controller->createRoutesStructure();
            $key = array_keys($controllerStructure)[0];
            $routes[$key] = $controllerStructure[$key];
        }

        return [
            'label' => $this->_module,
            'controllers' => $routes
        ];
    }

    /**
     * 备份原来的数据
     * @return void
     */
    private function backUp()
    {
        $routesFile = $this->getRoutesFile();
        $backFile = $this->getModuleDir() . 'routes_' . date('Y-m-d_H-i-s') . '.php';

        if (is_file($routesFile)) {
            copy($routesFile, $backFile);
        }
    }
}

class RoutesGenerator
{
    private $_module;

    public function __construct($module)
    {
        $this->_module = $module;
    }

    /**
     * 获得新的 routes.php 数据结构
     * @return array
     */
    public function getRoutes()
    {
        $controllers = $this->getControllers();
        $routes = [];
        foreach ($controllers as $controller)
        {
            $controllerStructure = $controller->createRoutesStructure();
            $key = array_keys($controllerStructure)[0];
            $routes[$key] = $controllerStructure[$key];
        }

        return [
            'label' => $this->_module,
            'controllers' => $routes
        ];
    }

    /**
     * @return OneController[]
     */
    public function getControllers()
    {
        $controllerNameSpace = Yii::$app->getModule($this->_module)->controllerNamespace;
        $controllerFiles = glob(Yii::getAlias("@app") . '/modules/' . $this->_module . '/controllers/*Controller.php');

        $controllers = [];
        foreach ($controllerFiles as $controllerFile) {
            $controllers[] = $this->createOneController($controllerFile, $controllerNameSpace);
        }

        return $controllers;
    }

    public function createOneController($controllerFile, $classNameSpace)
    {
        $info = pathinfo($controllerFile);
        $controllerName = $info['filename'];
        $controllerClass = $classNameSpace . '\\' . $info['filename'];
        $controllerRoute = Inflector::camel2id(StringHelper::basename(substr($controllerName, 0, strlen($controllerName) - 10)));
        $actionMethods = get_class_methods($controllerClass);

        $validActionsStructure = [];
        foreach ($actionMethods as $actionMethod)
        {
            if ($this->isValidControllerAction($actionMethod)) {
                $validActionsStructure[] = new OneActionStructure("", Inflector::camel2id(substr($actionMethod, 6, strlen($actionMethod))));
            }
        }

        $oneControllerStructure = new OneControllerStructure();
        $oneControllerStructure->name = $controllerRoute;
        $oneControllerStructure->label = "";
        $oneControllerStructure->controller = $controllerName;
        $oneControllerStructure->actionsStructure = $validActionsStructure;

        return new OneController($this->_module, $oneControllerStructure);
    }

    /**
     * @param string $method
     * @return bool
     */
    protected function isValidControllerAction($method)
    {
        return $method != 'actions' && false !== StringHelper::startsWith($method, 'action');
    }
}

/**
 * 将一个 action 封装成对象
 * Class OneAction
 * @package backend\modules\rbac\utils
 */
class OneAction
{
    /** @var OneActionStructure */
    private $_structure;

    public $module = "";
    public $controller = "";

    public function __construct($module, $controller, OneActionStructure $structure)
    {
        $this->module = $module;
        $this->controller = $controller;
        $this->_structure = $structure;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->module . '/' . $this->controller . '/' . $this->getActionRouteUrl();
    }

    public function getActionRouteUrl()
    {
        return $this->_structure->actionMethod;
    }

    /**
     * @return array
     */
    public function createRoutesStructure()
    {
        return $this->_structure->toArray();
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        if (empty($this->_structure->label)) {
            return $this->getRoute();
        }

        return $this->_structure->label;
    }

    public function setLabel($label)
    {
        $this->_structure->label = $label;
    }
}

class OneController
{
    private $_module = "";

    /** @var  OneControllerStructure */
    private $_structure;

    /** @var OneAction[] */
    private $_actions = [];

    public function __construct($module, OneControllerStructure $structure)
    {
        $this->_module = $module;
        $this->_structure = $structure;
        $this->createActions();
    }

    /**
     * 生成一个可以保存在routes.php裡的数据结构
     * @return array
     */
    public function createRoutesStructure()
    {
        return $this->_structure->toArray();
    }

    public function createActionsStructure()
    {
        $structures = [];
        $actions = $this->getActions();
        foreach ($actions as $action) {
            $structures[] = $action->createRoutesStructure();
        }

        return $structures;
    }

    /**
     * @return OneAction[]
     */
    public function getActions()
    {
        return $this->_actions;
    }

    /**
     * @param string $action
     * @return OneAction
     * @throws Exception
     */
    public function getAction($action)
    {
        if (!isset($this->getActions()[$action])) {
            throw new Exception("不存在的action");
        }

        return $this->getActions()[$action];
    }

    private function createActions()
    {
        foreach ($this->_structure->actionsStructure as $action)
        {
            $this->_actions[$action->actionMethod] = new OneAction(
                $this->_module,
                $this->_structure->name,
                $action
            );
        }
    }

    public function getLabel()
    {
        if (isset($this->_structure->label) && !empty($this->_structure->label)) {
            return $this->_structure->label;
        }

        return $this->getController();
    }

    public function getRouteName()
    {
        return $this->_structure->name;
    }

    public function getController()
    {
        return $this->_structure->controller;
    }
}

/**
 * Class OneActionStructure
 * @package backend\modules\rbac\utils
 */
class OneActionStructure
{
    public $label;
    public $actionMethod;

    public function __construct($label, $actionMethod)
    {
        $this->label = $label;
        $this->actionMethod = $actionMethod;
    }

    public function toArray()
    {
        return [
            $this->actionMethod => $this->label ? $this->label : $this->actionMethod,
        ];
    }
}

/**
 * 一个 controller 的数据结构体
 * 传数组不知道结构的话简直要瞎
 * Class OneControllerStructure
 * @package backend\modules\rbac\utils
 */
class OneControllerStructure
{
    // 类似admin-log
    public $name;
    public $label;

    // 类似AdminLogController
    public $controller;

    /** @var OneActionStructure[] */
    public $actionsStructure;

    public function toArray()
    {
        $actions = [];
        foreach ($this->actionsStructure as $structure) {
            $actions[$structure->actionMethod] = $structure->label;
        }

        return [$this->name => [
                'label' => $this->label,
                'controller' => $this->controller,
                'actions' => $actions
            ]
        ];
    }
}
