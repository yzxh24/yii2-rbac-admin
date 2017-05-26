<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = "登录";
?>

<div class="login-box">

    <div class="login-logo">
        <a href="<?= Url::toRoute('site/login') ?>"><b>后台登录</b></a>
    </div>

    <div class="login-box-body">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <?= Html::errorSummary($model)?>
        <div class="form-group has-feedback">
            <?= Html::activeTextInput($model, 'user_name', ['id' => 'user_name', 'class' => 'form-control', 'placeholder' => "用户名"]) ?>
        </div>

        <div class="form-group has-feedback">
            <?= Html::activePasswordInput($model, 'password', ['class' => 'form-control', 'placeholder' => '密码']) ?>
        </div>

        <div class="row">
            <div class="col-xs-8">
                <label>
                    <?= Html::activeCheckbox($model, 'rememberMe')?>
                </label>
            </div>

            <div class="col-xs-4">
                <button id="login_btn" type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
            </div>

        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<?php \common\widgets\JsBlock::begin()?>
<script>
    $(function() {
        $('#user_name').focus();
        $('#login_btn').on('click', function (e) {
            $(this).text("登录中...");
        })
    });
</script>
<?php \common\widgets\JsBlock::end()?>