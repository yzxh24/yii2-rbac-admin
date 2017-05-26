<?php

/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */

$this->title = "修改角色";
$this->params['breadcrumbs'][] = ['label' => '角色列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <?= $this->render('_form', [
        'model' => $form,
        'title' => $this->title
    ]) ?>

</div>