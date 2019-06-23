<?php

namespace nooclik\blog\controllers;

use Yii;
use nooclik\blog\models\Banners;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

class BannersController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $banners = Banners::find()->all();

        $model = new Banners();

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->image = $model->file->baseName . '.' . $model->file->extension;
            $model->save();
            $model->uploadFile();
            $this->redirect(['/blog/banners/index']);
        }

        return $this->render('index', compact('banners', 'model'));
    }

    public function actionDelete($id)
    {
        $model = Banners::findOne($id);
        if ($model->delete()) $this->redirect(['/blog/banners/index']);
    }
}