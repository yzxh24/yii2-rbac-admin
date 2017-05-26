<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\CheckboxColumn;
use backend\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$batchDeleteUrl = Url::to(['batch-delete']);
$js = <<<EOT
    $(document).on('click', '#batch-delete', function () {
        if (!confirm('确定要删除吗？')) {
            return false;
        }
        var keys = $("#grid").yiiGridView("getSelectedRows");
        $.post('{$batchDeleteUrl}', {id: keys}, function(data){
            window.location.reload();
        });
    });
EOT;

$this->registerJs($js);

$this->title = "角色列表";
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content">

    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">记录列表</h3>
        </div>

        <?=Html::beginForm(["update-sort"]) ?>
        <div class="box-body">
            <a href="<?= Url::to(["create"]) ?>" class="btn btn-success btn-flat "><i class="fa fa-fw fa-plus"></i>添加新角色</a>
        </div>


        <div class="box-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => CheckboxColumn::className(),
                        'checkboxOptions' => function($data, $row) {
                            return ['value' => $data->name];
                        }
                    ],

                    'name',
                    'description:ntext',
                    'rule_name',
                    'data',
                    // 'created_at',
                    // 'updated_at',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                        'template' => '{permissions}{update}{delete}',
                        'buttons' => [
                            'permissions' => function($url, $model, $key) {
                                return Html::a("分配权限", Url::to(['permissions', 'id' => $model->name]), [
                                    'class' => 'btn btn-primary btn-flat'
                                ]);
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a("修改", Url::to(['update', 'id' => $model->name]), [
                                    'class' => 'btn btn-success btn-flat'
                                ]);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a("删除", Url::to(['delete', 'id' => $model->name]), [
                                    'data' => ['confirm' => "确定要删除吗?"],
                                    'class' => 'btn btn-warning btn-flat'
                                ]);
                            }
                        ]
                    ],
                ]]); ?>
        </div>

        <?=Html::endForm() ?>    </div>

</section>