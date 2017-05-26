<?php
/**
 * Created by PhpStorm.
 * User: wangtao
 * Date: 2017/5/21
 * Time: 20:06
 */

namespace backend\modules\rbac\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "ig_auth_route".
 *
 * @property string $route
 * @property string $text
 */

class AuthRoute extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ig_auth_route';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['route', 'text'], 'required'],
            ['route', 'unique'],
            [['route', 'text'], 'string', 'max' => 100]
        ];
    }

    public function attributeLabels()
    {
        return [
            'route' => '路由地址',
            'text' => '标签名',
        ];
    }
}
