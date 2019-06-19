<?php

namespace nooclik\blog\controllers;

use nooclik\blog\models\Banners;
use yii\web\Controller;

class BannersController extends Controller
{
    public function actionIndex()
    {
        $banners = Banners::find()->all();

        return $this->render('index', compact('banners'));
    }

    public function actionDelete($id)
    {
        $model = Banners::findOne($id);
        if ($model->delete()) $this->redirect('index');
    }
}