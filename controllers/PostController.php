<?php

namespace nooclik\blog\controllers;

use nooclik\blog\models\Category;
use nooclik\blog\models\PostCategory;
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


    public function actionForm($id = null, $post_type)
    {
        $model = isset($id) ? Post::findOne($id) : new Post();

        if (!$model->isNewRecord) {
            $model->category = PostCategory::getCategoryByPost($id);
        }

        switch ($post_type) {
            case POST::SCENARIO_SINGLE :
                $model->scenario = POST::SCENARIO_SINGLE;
                break;
            case POST::SCENARIO_PAGE:
                $model->scenario = POST::SCENARIO_PAGE;
                break;
            default :
                $model->scenario = POST::SCENARIO_SINGLE;
        }

        $category = Category::getList();
        $status = Post::STATUS;

        if ($model->load(Yii::$app->request->post()))
        {
            $model->post_type = $model->getScenario();
            $model->save();

            if ($model->getScenario() == Post::SCENARIO_SINGLE) {
                foreach ($model->category as $item) {
                    PostCategory::save($model->id, (int)$item);
                }
            }

            $this->redirect('index');
        }

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
