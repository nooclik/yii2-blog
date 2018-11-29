<?php

namespace nooclik\blog\controllers;

use nooclik\blog\models\Category;
use Yii;
use nooclik\blog\models\Post;
use nooclik\blog\models\PostSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostsController implements the CRUD actions for Posts model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['form'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['form'],
                        'roles' => ['@']
                    ],
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionForm($id = null)
    {
        $model = isset($id) ? Post::findOne($id) : new Post();
        $category = Category::getList();
        $status = Post::STATUS;

        $model->post_author_id = Yii::$app->user->id;

        return $this->render('_form', compact('model', 'category', 'status'));
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
