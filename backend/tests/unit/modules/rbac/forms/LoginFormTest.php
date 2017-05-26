<?php
namespace backend\tests\unit\modules\rbac\forms;

/**
 * 测试后台登录功能
 * User: wangtao
 * Date: 2017/5/22
 * Time: 12:46
 */

use Yii;
use Codeception\Test\Unit;
use backend\modules\rbac\forms\LoginForm;

class LoginFormTest extends Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;


    public function _before()
    {

    }

    public function testLoginNoUser()
    {
        $model = new LoginForm([
            'user_name' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        expect('登录失败', $model->login())->false();
        expect('用户为未登录状态', Yii::$app->user->isGuest)->true();
    }

    public function testLoginWrongPassword()
    {
        $model = new LoginForm([
            'user_name' => 'bayer.hudson',
            'password' => 'wrong_password',
        ]);

        expect('登录失败', $model->login())->false();
        expect('登录密码错误', $model->errors)->hasKey('password');
        expect('用户为未登录状态', Yii::$app->user->isGuest)->true();
    }

    public function testLoginCorrect()
    {
        $model = new LoginForm([
            'user_name' => 'admin',
            'password' => 'admin',
        ]);

        expect('登录成功', $model->login())->true();
        expect('没有错误提示', $model->errors)->hasntKey('password');
        expect('用户为登录状态', Yii::$app->user->isGuest)->false();
    }
}