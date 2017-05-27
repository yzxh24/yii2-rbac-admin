<?php
/**
 * Created by PhpStorm.
 * User: wangtao
 * Date: 2017/5/27
 * Time: 19:40
 */

namespace backend\assets;


use yii\web\AssetBundle;

class GrowlAsset extends AssetBundle
{
    public $sourcePath = "@backend/assets/growl";

    public $js = [
        'growl.js'
    ];

    public $depends = [
        'kartik\growl\GrowlAsset',
        'kartik\base\AnimateAsset',
        'kartik\base\WidgetAsset'
    ];
}