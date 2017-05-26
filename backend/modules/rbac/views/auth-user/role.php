<?php
/** @var $this \yii\web\View */

$this->title = "分配角色";
$this->params['breadcrumbs'][] = ['label' => '帐号列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <input type="hidden" id="user_id" value="<?= $id ?>" />
    <?php foreach ($roles as $role):?>
        <div class="col-xs-3">
            <div class="checkbox">
                <label>
                    <input <?php if (in_array($role->name, array_keys($userRoles))):?> checked<?php endif;?> type="checkbox" class="roles" value="<?= $role->name ?>" /> <?= $role->name ?>
                </label>
            </div>
        </div>
    <?php endforeach;?>
</div>
