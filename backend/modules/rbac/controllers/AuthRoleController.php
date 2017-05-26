<?php

namespace backend\modules\rbac\controllers;

use Yii;
use yii\rbac\Role;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use backend\models\AuthItem;
use backend\modules\rbac\utils\Routes;
use backend\modules\rbac\utils\Permissions;
use backend\modules\rbac\forms\RoleForm;
use backend\components\BackendController;
use backend\models\search\AuthItemSearch as AuthItemSearch;

/**
 * AuthRoleController implements the CRUD actions for AuthItem model.
 */
class AuthRoleController extends BackendController
{
    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['type' => Role::TYPE_ROLE]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 角色授权
     * @param int $id
     * @return string|\yii\web\Response
     */
    public function actionPermissions($id)
    {
        if (Yii::$app->request->isPost)
        {
            Permissions::updateRolePermissions($id, Yii::$app->request->post('permissions', []));

            return $this->redirect(['index']);
        }

        $permissions = array_keys(Yii::$app->authManager->getPermissionsByRole($id));

        return $this->render('permissions', [
            'routes' => Routes::getAllModuleRoutes(),
            'permissions' => $permissions,
        ]);
    }

    /**
     * 扫描所有模块,自动生成 routes.php 裡的数据结构
     * @return array
     */
    public function actionCreatePermissions()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $routes = Routes::getAllModuleRoutes();
        foreach ($routes as $route) {
            $route->generateRoutes();
        }

        return ['code' => 1];
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new RoleForm();
        $form->setScenario('create');

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->createRole();
//            return $this->redirect(['index']);
            Yii::$app->session->setFlash("success", "角色添加成功,现在你可以为角色分配权限了");
            return $this->redirect(['permissions', 'id' => $form->name]);
        }

        return $this->render('create', [
            'form' => $form,
        ]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $role = $this->findModel($id);
        $form = new RoleForm();
        $form->loadData($role);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->updateRole();
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'form' => $form,
        ]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($id);

        if (null != $role) {
            $auth->remove($role);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
