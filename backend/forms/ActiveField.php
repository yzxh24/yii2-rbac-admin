<?php
namespace backend\forms;

/**
 * 后台通用 ActiveField 类,待扩展
 * Class ActiveField
 * @package backend\forms
 */

class ActiveField extends \yii\widgets\ActiveField
{
    public $template = "{label}\n<div class=\"col-sm-10\">{input}</div>\n{hint}\n{error}";

    public $labelOptions = ["class" => "col-sm-2 control-label"];

    public $inputDivClass = "";

    public function init()
    {
        parent::init();

        if (!empty($this->inputDivClass)) {
            $this->template = "{label}\n<div class=\"{$this->inputDivClass}\">{input}</div>\n{hint}\n{error}";
        }
    }
}
