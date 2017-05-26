<?php
use yii\helpers\Url;
use backend\forms\ActiveForm;
//use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\rbac\forms\ResetPasswordForm */
/* @var $form ActiveForm */

$this->title = "重设密码";
?>

<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?=$this->title;?></h3>
        </div>


        <div class="box-body">

            <?php $form = ActiveForm::begin(['fullSpan' => 7]); ?>

            <?= $form->field($model, 'old_password')->passwordInput() ?>

            <?= $form->field($model, 'new_password')->passwordInput() ?>

            <?= $form->field($model, 'new_password_repeat')->passwordInput() ?>

            <div class="form-group">
                <div class="col-xs-2"></div>
                <div class="col-xs-5">
                    <p class="help-block">修改成功后需要重新登录</p>
                </div>
            </div>
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
