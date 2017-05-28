<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\CheckboxColumn;
use kartik\widgets\Select2;
use backend\widgets\GridView;
use common\widgets\JsBlock;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\AuthUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "帐号列表";
$this->params['breadcrumbs'][] = $this->title;
?>

<?php JsBlock::begin()?>

<script>
    $(function () {
        $('#modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var href = button.attr('href');
            $.get(href, function (response) {
                $('.modal-body').html(response);
            });
        });

        $('#btn-save').on('click', function (event) {
            var user_id = $('#user_id').val();
            var checkedRoles = new Array();
            $('input[class="roles"]:checked').each(function () {
                checkedRoles.push($(this).val());
            });

            $.post('<?= Url::to(['save-role'])?>', {'user_id': user_id, 'roles': checkedRoles}, function (data) {
                $('#modal').modal('hide');
            });
        });
    });
</script>

<?php JsBlock::end()?>
<style>
.select2-container .select2-selection--single .select2-selection__rendered {margin-top: 0}
</style>
<section class="content">

    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">记录列表</h3>
        </div>

        <?=Html::beginForm(["update-sort"]) ?>
        <div class="box-body">
            <a href="<?= Url::to(["create"]) ?>" class="btn btn-success btn-flat "><i class="fa fa-fw fa-plus"></i>添加新帐号</a>
        </div>


        <?php Modal::begin([
            'options' => ['id' => 'modal'],
            'header' => '<h3>分配角色</h3>',
//            'toggleButton' => ['label' => 'click me'],
            'footer' => '<button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button><button type="button" id="btn-save" class="btn btn-primary">保存</button>',
        ]);?>

        <?php Modal::end()?>

        <div class="box-body">

		<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => CheckboxColumn::className(),
                'checkboxOptions' => function($data, $row) {
                    return ['value' => $data->id];
                }
            ],

            'id',
            'user_name',
            'last_ip',
            // 'is_online',
            // 'domain_account',
            [
                'attribute' => 'status',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status',
                    'data' => \backend\models\AuthUser::$statusMap,
                    'hideSearch' => true,
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'options' => [
                        'placeholder' => '帐号状态',
                    ]
                ]),
                'content' => function($data, $row) {
                    return $data->getStatusColorView();
                }
            ],
            // 'create_user',
            // 'create_date',
             'update_user',
             'update_date',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{role}{update}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a("<i class='glyphicon glyphicon-edit icon-white'></i>修改", Url::to(['update', 'id' => $model->id]), [
                                        'class' => 'btn btn-success btn-flat'
                        ]);
                    },
                    'role' => function($url, $model, $key) {
                        return Html::a("<i class='glyphicon glyphicon-zoom-in icon-white'></i>分配角色", Url::to(['role', 'id' => $model->id]), [
                            'class' => 'btn btn-primary btn-flat',
                            'data-toggle' => 'modal',
                            'data-target' => '#modal'
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a("删除", Url::to(['delete', 'id' => $model->id]), [
                                        'data' => ['confirm' => "确定要删除吗?"],
                                        'class' => 'btn btn-warning btn-flat'
                        ]);
                    }
                ]
            ],
		]]); ?>
        </div>

        <?=Html::endForm() ?>
    </div>

</section>
