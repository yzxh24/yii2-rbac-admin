<?php
namespace backend\components;

/**
 * 要做权限验证的后台操作都要继承这个控制器
 * User: wangtao
 * Date: 2017/5/21
 * Time: 19:38
 */
use Yii;
use yii\web\ForbiddenHttpException;

class BackendController extends \yii\web\Controller
{
    protected $excludeRoutes = [
//        'rbac/site/reset-password', // 允许某些情况下不许用户修改密码
        'rbac/site/logout',
        'rbac/site/login',
    ];

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest && !in_array($this->route, Yii::$app->user->loginUrl)) {
            Yii::$app->user->loginRequired();
            return false;
        } else {
            if (!in_array($this->route, $this->excludeRoutes) && !Yii::$app->user->can($this->route)) {
                throw new ForbiddenHttpException("您无权访问该页面");
            }
        }

        return parent::beforeAction($action);
    }
}
