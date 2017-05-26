<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use backend\forms\ActiveForm;
use backend\models\AuthMenu;
use backend\modules\rbac\assets\AutocompleteAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthMenu */
/* @var $form backend\forms\ActiveForm */

AutocompleteAsset::register($this);
$opts = Json::htmlEncode([
    'menus' => AuthMenu::getMenuSource(),
    'routes' => AuthMenu::getSavedRoutes(),
]);

$this->registerJs("var _opts = $opts;");
$this->registerJs($this->render('_script.js'));
?>

<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?=$title;?></h3>
        </div>

        <div class="box-body">
            <?php $form = ActiveForm::begin(['fullSpan' => 7]); ?>

            <?= Html::activeHiddenInput($model, 'parent', ['id' => 'parent_id']); ?>

            <?= $form->field($model, 'name')->textInput() ?>

            <?= $form->field($model, 'parent_name')->textInput(['id' => 'parent_name']) ?>

            <?= $form->field($model, 'route')->textInput(['id' => 'route']) ?>

            <?= $form->field($model, 'order')->input('number') ?>

            <?= $form->field($model, 'data')->textarea(['rows' => 4]) ?>

            <div class="box-footer">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="text-type"></label>
                    <div class="col-xs-6 help-block">
                        <button type="submit" class="btn btn-primary btn-flat">保存</button>
                        <a href="<?=Url::to(['index']) ?>"><button type="button" class="btn btn-default btn-flat">取消</button></a>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</section>