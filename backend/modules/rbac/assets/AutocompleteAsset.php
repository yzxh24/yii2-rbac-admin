<?php
/**
 * Created by PhpStorm.
 * User: wangtao
 * Date: 2017/5/25
 * Time: 19:34
 */

namespace backend\modules\rbac\assets;


use rmrevin\yii\fontawesome\cdn\AssetBundle;

class AutocompleteAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@backend/modules/rbac/assets/autocomplete';

    /**
     * @inheritdoc
     */
    public $css = [
        'jquery-ui.css',
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'jquery-ui.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}