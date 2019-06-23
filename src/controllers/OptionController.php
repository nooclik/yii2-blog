<?php

namespace nooclik\blog\controllers;

use nooclik\blog\models\Option;
use Yii;
use yii\web\Controller;

class OptionController extends Controller
{
    public function actionIndex()
    {
        $model = new Option();
        if($model->load($post = Yii::$app->request->post())) {
            $model->set($post);
        }

        return $this->render('index', compact('model'));
    }
}