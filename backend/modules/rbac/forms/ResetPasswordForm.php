<?php
/**
 * Created by PhpStorm.
 * User: wangtao
 * Date: 2017/5/26
 * Time: 15:23
 */

namespace backend\modules\rbac\forms;


use yii\base\Model;
use backend\models\BackendUser;

class ResetPasswordForm extends Model
{
    public $user_id;
    public $old_password;
    public $new_password;
    public $new_password_repeat;

    /** @var BackendUser */
    private $_user;

    public function rules()
    {
        return [
            [['old_password', 'new_password', 'new_password_repeat'], 'required'],
            [['new_password', 'new_password_repeat'], 'string', 'min' => 5],
            ['old_password', 'validatePassword'],
            ['new_password_repeat', 'compare', 'compareAttribute' => 'new_password', 'message' => '两次输入的密码不一致'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'old_password' => '旧密码',
            'new_password' => '新密码',
            'new_password_repeat' => '确认密码',
        ];
    }

    public function saveNewPassword()
    {
        $user = $this->getUser();
        $user->password = BackendUser::generatePasswordHash($this->new_password);
        $user->save(false);
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->old_password)) {
                $this->addError($attribute, '旧密码不正确');
            }
        }
    }

    /**
     * @return BackendUser|\yii\web\IdentityInterface
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = BackendUser::findIdentity($this->user_id);
        }

        return $this->_user;
    }
}
