<?php

namespace backend\modules\rbac\controllers;

use backend\modules\rbac\utils\Routes;
use Yii;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use backend\models\AuthUser;
use backend\models\search\AuthUserSearch;
use backend\components\BackendController;

/**
 * AuthUserController implements the CRUD actions for AuthUser model.
 */
class AuthUserController extends BackendController
{
    /**
     * Lists all AuthUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 给用户分配角色
     * @param int $id
     * @return string
     */
    public function actionRole($id)
    {
        $roles = Yii::$app->authManager->getRoles();
        $userRoles = Yii::$app->authManager->getRolesByUser($id);

        return $this->renderAjax('role', [
            'id' => $id,
            'roles' => $roles,
            'userRoles' => $userRoles,
        ]);
    }

    public function actionSaveRole()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $auth = Yii::$app->authManager;
        $userId = Yii::$app->request->post('user_id');
        $roles = Yii::$app->request->post('roles');
        $userRoles = $auth->getRolesByUser($userId);

        if (empty($roles))
        {
            foreach ($userRoles as $userRole) {
                $auth->revoke($userRole, $userId);
            }
        }
        else
        {
            foreach ($userRoles as $userRole) {
                $auth->revoke($userRole, $userId);
            }

            foreach ($roles as $key) {
                $role = $auth->getRole($key);
                if (null !== $role) {
                    $auth->assign($role, $userId);
                }
            }
        }

        return ['code' => 0];
    }

    /**
     * Creates a new AuthUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthUser();
        $model->create_user = Yii::$app->user->identity->user_name;
        $model->status = AuthUser::STATUS_ACTIVE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AuthUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario("update");
        $model->update_user = Yii::$app->user->identity->user_name;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AuthUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
    * 批量删除
    * @return void
    */
//    public function actionBatchDelete()
//    {
//        $idArray = Yii::$app->request->post('id');
//        foreach ($idArray as $id)
//        {
//            $model = AuthUser::findOne($id);
//            if (null != $model) {
//                $model->delete();
//            }
//        }
//    }

    /**
     * Finds the AuthUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
