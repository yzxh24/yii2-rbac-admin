<?php
namespace backend\models;

use Yii;
use yii\bootstrap\Html;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ig_auth_user".
 *
 * @property string $id
 * @property string $user_name
 * @property string $password
 * @property string $auth_key
 * @property string $last_ip
 * @property string $is_online
 * @property string $domain_account
 * @property integer $status
 * @property string $create_user
 * @property string $create_date
 * @property string $update_user
 * @property string $update_date
 */

class AuthUser extends ActiveRecord
{
    const STATUS_DISABLE = 0;
    const STATUS_ACTIVE = 10;

    public $password_repeat;

    public static $statusMap = [
        10 => "正常",
        0 => "停用",
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ig_auth_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['user_name', 'unique', 'message' => '该用户名已被使用'],
            [['user_name', 'password'], 'required'],
            [['status'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['user_name', 'domain_account', 'create_user'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 200, 'min' => 6],
            [['auth_key', 'last_ip'], 'string', 'max' => 50],
            [['is_online'], 'string', 'max' => 1],
            [['update_user'], 'string', 'max' => 101],
            ['password_repeat', 'required'],
            ['password_repeat', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => '两次输入的密码不一致'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => '用户名',
            'password' => '密码',
            'password_repeat' => '确认密码',
            'auth_key' => '自动登录key',
            'last_ip' => '最近一次登录ip',
            'is_online' => '是否在线',
            'domain_account' => '域账号',
            'status' => '状态',
            'create_user' => '创建人',
            'create_date' => '创建时间',
            'update_user' => '更新人',
            'update_date' => '更新时间',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_date = date('Y-m-d H:i:s');
            $this->update_date = $this->create_date;
            $this->update_user = $this->create_user;
            $this->password = static::generatePasswordHash($this->password);
        } else {
            $this->update_date = date('Y-m-d H:i:s');
        }

        return parent::beforeSave($insert);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        // 修改的时候只验证名称
        $scenarios['update'] = ['user_name', 'status'];

        return $scenarios;
    }

    public static function generatePasswordHash($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    public function getStatusView()
    {
        return static::$statusMap[$this->status];
    }

    public function getStatusColorView()
    {
        $view = $this->getStatusView();
        $colorClass = 'badge bg-red';
        if (self::STATUS_ACTIVE == $this->status) {
            $colorClass = 'badge bg-green';
        }

        return Html::tag("span", $view, ['class' => $colorClass]);
    }
}