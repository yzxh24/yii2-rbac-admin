<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh-CN',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        "authManager" => [
            "class" => 'yii\rbac\DbManager',
            "itemTable" => "ig_auth_item",
            "itemChildTable" => "ig_auth_item_child",
            "assignmentTable" => "ig_auth_assignment",
            "ruleTable" => "ig_auth_rule",
        ],
    ],
];
