<?php
namespace backend\forms;

/**
 * 后台通用的 ActiveForm 组件,待扩展
 * Class ActiveForm
 * @package backend\forms
 */

use backend\forms\ActiveField;

//class ActiveForm extends \yii\widgets\ActiveForm
//{
//    public $fieldClass = 'backend\forms\ActiveField';
//}

class ActiveForm extends \kartik\widgets\ActiveForm
{
    public $type = parent::TYPE_HORIZONTAL;
    public $formConfig = [
        'labelSpan' => 2,
        'deviceSize' => parent::SIZE_SMALL
    ];
}
