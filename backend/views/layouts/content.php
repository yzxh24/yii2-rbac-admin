<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<style>
    .skin-blue-light .sidebar-menu>li:hover>a, .skin-blue-light .sidebar-menu>li.active>a {
        background: #3c8dbc;
        color: white;
    }
    .sidebar-menu .treeview-menu {
        padding-left: 20px;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>

        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
    </section>

        <?= Alert::widget() ?>
        <?= $content ?>
</div>


<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>