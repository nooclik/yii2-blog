<?php

namespace nooclik\blog\controllers;

use yii\helpers\Url;
use nooclik\blog\models\Category;
use nooclik\blog\models\PostCategory;
use nooclik\blog\models\PostLang;
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
                'url' => '/web/images/', // Directory URL address, where files are stored.
                'path' => '@webroot/images/', // Or absolute path to directory where files are stored.
            ],
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetImagesAction',
                'url' => '/web/images/', // Directory URL address, where files are stored.
                'path' => '@webroot/images/', // Or absolute path to directory where files are stored.
                'options' => ['only' => ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.ico']], // These options are by default.
            ],
            'file-delete' => [
                'class' => 'vova07\imperavi\actions\DeleteFileAction',
                'url' => '/web/images/', // Directory URL address, where files are stored.
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

    public function actionForm($id = null, $post_type, $lang = null)
    {
        $model = isset($id) ? Post::findOne($id) : new Post();
        $modelAttachment = Post::modelAttachment();

        if ($model->isNewRecord) {
            $model->created_at = date('d.m.Y');
        }

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

            $model->post_meta_keywords = serialize($model->post_meta_keywords);

            if ($model->save()) {
                $this->redirect(['form', 'post_type' => $post_type, 'id' => $model->id]);
            }


            if ($model->getScenario() == Post::SCENARIO_SINGLE) {
                foreach ($model->category as $item) {
                    PostCategory::save($model->id, (int)$item);
                }
            }
        }

        if ($modelAttachment->load($post = Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($modelAttachment, 'file');
            $model->addAttachment($modelAttachment, $file);
        }

        return $this->render('_form', compact('model', 'category', 'status', 'modelAttachment'));
    }

    /**
     * Форма редактирования перевода записи
     * @param null $id
     * @param null $post_id
     * @param null $lang_id
     * @return string
     */
    public function actionFormTranslate($id = null, $post_id = null, $lang_id = null)
    {
        $model = ($id == null) ? new PostLang() : PostLang::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($id == null) {
                $model->post_id = $post_id;
                $model->lang = $lang_id;
            }

            if ($model->save()) {
                    $post = Post::findOne($model->post_id);
                    $this->redirect(Url::to(['post/form', 'id' => $post->id, 'post_type' => $post->post_type]));
            }
        }

        return $this->render('_form-translate', compact('model'));
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Удаляет вложение
     * @throws \yii\db\Exception
     */
    public function actionDeleteAttachment()
    {
        if (Yii::$app->request->isAjax) {
            Post::deleteAttachment(Yii::$app->request->post()['id']);
        }
    }

    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }
}
