<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\models\AuthMenu */

$this->title = "添加新菜单";
$this->params['breadcrumbs'][] = ['label' => '菜单列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <?=
    $this->render('_form', [
        'model' => $model,
        'title' => $this->title,
    ])
    ?>

</div>
