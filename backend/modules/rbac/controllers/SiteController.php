<?php
/**
 * Created by PhpStorm.
 * User: wangtao
 * Date: 2017/5/21
 * Time: 19:33
 */

namespace backend\modules\rbac\controllers;

use Yii;
use backend\components\BackendController;
use backend\modules\rbac\forms\LoginForm;
use backend\modules\rbac\forms\ResetPasswordForm;

class SiteController extends BackendController
{
    public function actionIndex()
    {
        $sysInfo = [
            ['name' => '软件版本', 'value' => '1.0 beta'],
            ['name' => '操作系统', 'value' => php_uname('s')],
            ['name' => 'PHP版本', 'value' => phpversion()],
            ['name' => 'Yii版本', 'value' => Yii::getVersion()],
            ['name' => '数据库', 'value' => $this->getDbVersion()],
        ];

        return $this->render('index', [
            'sysInfo' => $sysInfo
        ]);
    }

    /**
     * 后台登录
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * 退出登录
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * 修改密码
     * @return string
     */
    public function actionResetPassword()
    {
        $model = new ResetPasswordForm();
        $model->user_id = Yii::$app->user->getId();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->saveNewPassword();
            Yii::$app->user->logout();
            return Yii::$app->user->loginRequired();
        }

        return $this->render('reset-password', [
            'model' => $model
        ]);
    }

    /**
     * 获得数据库版本
     * @return string
     */
    private function getDbVersion()
    {
        $driverName = Yii::$app->db->driverName;

        if (strpos($driverName, 'mysql') !== false) {
            $v = Yii::$app->db->createCommand('SELECT VERSION() AS v')->queryOne();
            $driverName = $driverName . '_' . $v['v'];
        }

        return $driverName;
    }
}
