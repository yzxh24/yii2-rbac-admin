<?php
namespace backend\widgets;

/**
 * Created by PhpStorm.
 * User: wangtao
 * Date: 2017/3/28
 * Time: 17:44
 */
class GridView extends \yii\grid\GridView
{
    public $layout = "{items}\n<div class='row'><div class=\"col-sm-5\"><div class='dataTables_info'>{summary}</div></div>\n<div class=\"col-sm-7\"><div class=\"dataTables_paginate paging_simple_numbers\">{pager}</div></div></div>";

    public $pager = [
        'nextPageLabel' => '下一页',
        'prevPageLabel' => '上一页',
        'firstPageLabel' => '首页',
        'lastPageLabel' => '尾页'
    ];

    public $summaryOptions = ['class' => 'col-xs-5'];

    public $options = ["class" => "grid-view", "id" => "grid"];

    public $id = 'id';
}
