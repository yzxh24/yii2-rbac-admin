<?php
return [
    'rbac' => [
        'label' => '用户权限管理',
        'controllers' => [
            'auth-menu' => [
                'label' => '后台菜单管理',
                'controller' => 'AuthMenuController',
                'actions' => [
                    'index' => '菜单列表',
                    'create' => '添加菜单',
                    'update' => '修改菜单',
                    'delete' => '删除菜单',
                ],
            ],
            'auth-role' => [
                'label' => '后台角色管理',
                'controller' => 'AuthRoleController',
                'actions' => [
                    'index' => '角色列表',
                    'permissions' => '角色授权',
                    'create-permissions' => '自动生成权限列表',
                    'create' => '添加角色',
                    'update' => '修改角色',
                    'delete' => '删除角色',
                ],
            ],
            'auth-user' => [
                'label' => '后台用户管理',
                'controller' => 'AuthUserController',
                'actions' => [
                    'index' => '用户列表',
                    'role' => '分配用户角色',
                    'save-role' => '保存用户角色',
                    'create' => '添加用户',
                    'update' => '修改用户',
                ],
            ],
            'site' => [
                'label' => '后台首页',
                'controller' => 'SiteController',
                'actions' => [
                    'index' => '后台首页',
                    'login' => '登录系统',
                    'logout' => '退出登录',
                    'reset-password' => '修改密码',
                ],
            ],
        ],
    ],
];
