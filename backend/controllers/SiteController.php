<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actionError()
    {
        $this->layout = false;

        $exception = Yii::$app->getErrorHandler()->exception;

        return $this->render('error', [
            'code' => $exception->statusCode,
            'message' => $exception->getMessage(),
        ]);
    }
}
