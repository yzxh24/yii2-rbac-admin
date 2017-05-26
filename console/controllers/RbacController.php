<?php
namespace console\controllers;

/**
 * RBAC练习工具
 * User: wangtao
 * Date: 2017/5/21
 * Time: 13:25
 */

use Yii;

class RbacController extends \yii\console\Controller
{
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
//        $role = $auth->createRole('test');
//        $auth->add($role);
        $role = $auth->getRole('test1');
        print_r($role);

        /**
        // 添加 createPost 权限
        $createPost = $auth->createPermission("createPost");
        $createPost->description = "Create a post";
        $auth->add($createPost);

        // 添加 updatePost 权限
        $updatePost = $auth->createPermission("updatePost");
        $updatePost->description = "Update a post";
        $auth->add($updatePost);

        // 添加 author 角色并赋予 createPost 权限
        $author = $auth->createRole("author");
        $auth->add($author);
        $auth->addChild($author, $createPost);

        // 添加 admin 角色并赋予 updatePost 权限和 author 角色
        $admin = $auth->createRole("admin");
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);

        $auth->assign($author, 2);
        $auth->assign($admin, 1);
        /**/
    }
}
