<?php
/**
 * Created by PhpStorm.
 * User: wangtao
 * Date: 2017/5/27
 * Time: 13:38
 */

namespace backend\modules\rbac\controllers;

use Yii;
use sergeymakinen\facades\Request;
use backend\modules\rbac\utils\Routes;
use backend\components\BackendController;

class AuthRouteController extends BackendController
{
    /**
     * 修改路由器显示名称
     * @return \yii\web\Response
     */
    public function actionUpdateRouteLabel()
    {
        $route = Request::post('route');
        $label = Request::post('label');

        Routes::updateRouteLabel($route, $label);

        return $this->asJson(['code' => 1]);
    }

    /**
     * 修改控制器显示名称
     * @return \yii\web\Response
     */
    public function actionUpdateControllerLabel()
    {
        $module = Request::post("module");
        $controller = Request::post("controller");
        $label = Request::post('label');

        Routes::updateControllerLabel($module, $controller, $label);

        return $this->asJson(['code' => 1]);
    }
}
