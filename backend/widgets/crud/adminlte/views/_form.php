<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use backend\forms\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form backend\forms\ActiveForm */
?>

<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= "<?=\$title;?>" ?></h3>
        </div>

        <div class="box-body">
            <?= "<?php " ?>$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>

            <?php foreach ($generator->getColumnNames() as $attribute) {
                if (in_array($attribute, $safeAttributes)) {
                    echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
                }
            } ?>


            <div class="box-footer">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="text-type"></label>
                    <div class="col-xs-6 help-block">
                        <button type="submit" class="btn btn-primary btn-flat">保存</button>
                        <a href="<?= "<?=Url::to(['index']) ?>" ?>"><button type="button" class="btn btn-default btn-flat">取消</button></a>
                    </div>
                </div>
            </div>

            <?= "<?php " ?>ActiveForm::end(); ?>
        </div>
    </div>

</section>
