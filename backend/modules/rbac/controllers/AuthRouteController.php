<?php
/**
 * Created by PhpStorm.
 * User: wangtao
 * Date: 2017/5/27
 * Time: 13:38
 */

namespace backend\modules\rbac\controllers;

use Yii;
use yii\web\Response;
use backend\modules\rbac\utils\Routes;
use backend\components\BackendController;

class AuthRouteController extends BackendController
{
    public function actionUpdateLabel()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $route = Yii::$app->request->post('route');
        $label = Yii::$app->request->post('label');

        Routes::updateRouteLabel($route, $label);

        return ['code' => 1];
    }
}
