<?php
use yii\helpers\Url;
use dmstr\widgets\Alert;
use backend\assets\GrowlAsset;

use common\widgets\JsBlock;
use backend\forms\ActiveForm;

GrowlAsset::register($this);

$this->title = "角色授权";
$this->params['breadcrumbs'][] = ['label' => '角色列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
.action {margin-left: 20px;}
</style>

<?php JsBlock::begin()?>
<script>
    $(function () {
        var TimeFn = null;

        $(".checkAll").on('click', function(){
            clearTimeout(TimeFn);
            var controller = $(this).data('controller');
            var isChecked = this.checked;
            TimeFn = setTimeout(function () {
                $("input[class='" + controller + "']").prop("checked", isChecked);
            }, 300);
        });

        $('#create-permissions').on('click', function () {
            if (!confirm("扫描所有模块自动提取 action 生成权限列表,只做增量操作,不覆盖原有内容")) {
                return;
            }

            $.get('<?= Url::toRoute('create-permissions') ?>', function (response) {
                if (1 == response.code) {
                    growl.success("已生成,重新载入中...");
                    setTimeout(function () {
                        window.location.reload()
                    }, 3000);
                }
            });
        });

        $('.route-label').on('dblclick', function (e) {
            var label = $(this).text();
            var route = $(this).prev().val();

            var html = '<input type="text" value="' + label + '" />';
            $(this).html(html).find('input').focus().keyup(function (event) {
                var new_label = $(this).val();
                if (event.keyCode != 13) {
                    return;
                }

                var self = $(this);
                if (new_label == label) {
                    self.parent().append(new_label);
                    self.remove();
                } else {
                    $.post('<?= Url::toRoute('/rbac/auth-route/update-route-label')?>', {'route': route, 'label': new_label}, function (response) {
                        if (1 == response.code) {
                            self.parent().append(new_label);
                            self.remove();
                            growl.success("修改成功");
                        } else {
                            growl.danger(response.msg);
                        }
                    });
                }
            });
        });

        $('.controller-label').on('dblclick', function (e) {
            clearTimeout(TimeFn);

            var label = $(this).text();
            var controllerClass = $(this).data('controller');
            var module = $(this).data('module');

            var html = '<input type="text" value="' + label + '" />';
            $(this).html(html).find('input').focus().keyup(function (event) {
                var new_label = $(this).val();
                if (event.keyCode != 13) {
                    return;
                }

                var self = $(this);
                if (new_label == label) {
                    self.parent().append(new_label);
                    self.remove();
                } else {
                    $.post('<?= Url::toRoute('/rbac/auth-route/update-controller-label')?>', {'module': module, 'controller': controllerClass, 'label': new_label}, function (response) {
                        if (1 == response.code) {
                            self.parent().append(new_label);
                            self.remove();
                            growl.success("修改成功");
                        } else {
                            growl.danger(response.msg);
                        }
                    });
                }
            });
        });
    });
</script>
<?php JsBlock::end()?>

<section class="content">

        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <?php $index = 1;?>
                <?php foreach (array_keys($routes) as $moduleName):?>
                    <li class="<?php if (1 == $index):?>active<?php endif;?>"><a href="#tab_<?= $index++?>" data-toggle="tab"><?= $moduleName?>模块</a></li>
                <?php endforeach;?>
                <li class="pull-right"><button class="btn btn-success btn-flat" id="create-permissions"><i class="fa fa-plus"></i>自动生成权限列表</button></li>
            </ul>

            <div class="tab-content">
                <?php echo Alert::widget(['options' => ['class' => 'alert-success']])?>

                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal', 'onkeydown' => 'if(event.keyCode==13){return false;}']]); ?>
                <?php $index = 1;?>
                <?php foreach ($routes as $key => $route):?>
                <div class="tab-pane active" id="tab_<?= $index++?>">
                    <div class="row">

                        <?php foreach ($route->getControllers() as $controller):?>
                        <div class="col-xs-3">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title checkbox" style="font-size: 20px;">
                                        <label data-toggle="tooltip" data-placement="right" title="<?= $controller->getController()?>">
                                            <input type="checkbox" class="checkAll" data-controller="<?= $key?>-<?= $controller->getRouteName()?>">
                                            <div class="controller-label" data-controller="<?= $controller->getController()?>" data-module="<?= $moduleName?>"><?= $controller->getLabel()?></div>
                                        </label>
                                    </h3>
                                </div>

                                <div class="box-body">
                                    <?php foreach ($controller->getActions() as $action): ?>
                                        <div class="checkbox">
                                            <label class="action" data-toggle="tooltip" data-placement="right" title="<?= $action->getRoute()?>">
                                                <input<?php if(in_array($action->getRoute(), $permissions)):?> checked<?php endif;?> type="checkbox" name="permissions[]" value="<?= $action->getRoute()?>" class="<?= $key?>-<?= $controller->getRouteName()?>"> <div class="route-label"><?= $action->getLabel()?></div>
                                            </label>
                                        </div>

                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
                <?php endforeach;?>

            </div>
            <!-- /.tab-content -->

            <div class="box-footer">
                <div class="form-group">
                    <label class="col-xs-3 control-label" for="text-type"></label>
                    <div class="col-xs-2">
                        <div class="pull-right">
                        <button type="submit" class="btn btn-primary btn-flat">保存</button>
                        <a href="<?=Url::to(['index']) ?>"><button type="button" class="btn btn-default btn-flat">取消</button></a>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <span class="help-block">双击权限名称进行修改,回车保存</span>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <!-- nav-tabs-custom -->

</section>