<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\forms\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */
/* @var $form backend\forms\ActiveForm */
?>

<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?=$title;?></h3>
        </div>

        <div class="box-body">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rule_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>



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
