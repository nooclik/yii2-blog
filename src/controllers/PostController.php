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
use yii\web\UploadedFile;

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
            /*'access' => [
                'class' => AccessControl::className(),
                'only' => ['form'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['form'],
                        'roles' => ['*']
                    ],
                ]
            ],*/
        ];
    }

    public function actions()
    {
        return [
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => '/images/', // Directory URL address, where files are stored.
                'path' => '@webroot/images/', // Or absolute path to directory where files are stored.
            ],
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetImagesAction',
                'url' => '/images/', // Directory URL address, where files are stored.
                'path' => '@webroot/images/', // Or absolute path to directory where files are stored.
                'options' => ['only' => ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.ico']], // These options are by default.
            ],
            'file-delete' => [
                'class' => 'vova07\imperavi\actions\DeleteFileAction',
                'url' => '/images/', // Directory URL address, where files are stored.
                'path' => '@webroot/images/', // Or absolute path to directory where files are stored.
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
        $modelAttachment = Post::modelAttachment();

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
        $model->post_meta_keywords = unserialize($model->post_meta_keywords);

        if ($model->load(Yii::$app->request->post())) {
            $model->post_type = $model->getScenario();
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->image) {
                $model->imageUpload();
            }

            $model->attachment = UploadedFile::getInstance($model, 'attachment');
            if($model->attachment) {
                $model->attachmentUpload();
            }

            $model->post_meta_keywords = serialize($model->post_meta_keywords);
            $model->save();


            if ($model->getScenario() == Post::SCENARIO_SINGLE) {
                foreach ($model->category as $item) {
                    PostCategory::save($model->id, (int)$item);
                }
            }

            if ($modelAttachment->load($post = Yii::$app->request->post()) && $modelAttachment->validate() ){
                $attachment = UploadedFile::getInstance($th)
                Post::addAttachment($post);
            }
        }

        return $this->render('_form', compact('model', 'category', 'status', 'modelAttachment'));
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
