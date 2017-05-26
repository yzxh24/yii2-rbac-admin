<?php
/**
 * Created by PhpStorm.
 * User: wangtao
 * Date: 2017/5/24
 * Time: 14:54
 */

namespace backend\modules\rbac\forms;

use Yii;
use yii\base\Model;
use yii\rbac\ManagerInterface;
use yii\rbac\Role;
use backend\models\AuthItem;

class RoleForm extends Model
{
    /** @var ManagerInterface */
    public $auth;
    public $name;
    public $description;
    public $type;
    private $_oldRole;

    public function init()
    {
        parent::init();
        $this->type = Role::TYPE_ROLE;
        $this->auth = Yii::$app->authManager;
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'isExists', 'on' => ['create']],
            ['name', 'string', 'min' => 2, 'max' => 64],
            ['description', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '角色名称',
            'description' => '描述',
        ];
    }

    public function isExists()
    {
        if (null != $this->auth->getRole($this->name)) {
            $this->addError('name', "该角色名称已经存在,请换一个");
        }
    }

    public function loadData(AuthItem $role)
    {
        $this->_oldRole = $this->auth->createRole($role->name);

        $this->name = $role->name;
        $this->description = $role->description;
    }

    public function createRole()
    {
        $role = $this->auth->createRole($this->name);
        $role->description = $this->description;
        $this->auth->add($role);
    }

    public function updateRole()
    {
        $role = $this->auth->createRole($this->name);
        $role->description = $this->description;
        $this->auth->update($this->_oldRole->name, $role);
    }
}
