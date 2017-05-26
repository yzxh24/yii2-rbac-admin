<?php


/* @var $this yii\web\View */
/* @var $model backend\models\AuthUser */

$this->title = "修改帐号";
$this->params['breadcrumbs'][] = ['label' => '帐号列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-user-create">

    <?= $this->render('_form', [
    'model' => $model,
    'title' => $this->title
    ]) ?>

</div>
