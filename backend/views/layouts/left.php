<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->user_name ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?php
        // 单条菜单的回调处理
        $callback = function($menu) {
            $data = json_decode($menu['data'], true);
            $items = $menu['children'];
            $return = [
                'label' => $menu['name'],
                'url' => ['/' . $menu['route']],
            ];

            //处理我们的配置
            if ($data) {
                isset($data['visible']) && $return['visible'] = $data['visible'];
                isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon'];
                $return['options'] = $data;
            }

            //没配置图标的显示默认图标
            (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'circle-o';
            $items && $return['items'] = $items;

            return $return;
        };

        echo \backend\widgets\Menu::widget([
            'options' => ['class' => 'sidebar-menu'],
            'items' => \backend\components\MenuHelper::getAssignedMenu(Yii::$app->user->id, $callback)
        ]) ?>

    </section>

</aside>
