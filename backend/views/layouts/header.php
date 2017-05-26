<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">Yii2</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= Yii::$app->user->identity->user_name?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a style="padding: 10px;" href="<?=Url::toRoute('/rbac/site/reset-password')?>"><i class="fa fa-cog"></i> 修改密码</a></li>
                        <li><a style="padding: 10px;" href="<?=Url::toRoute('/rbac/site/logout')?>"><i class="fa fa-sign-out"></i> 退出</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>
