<?php

namespace nooclik\blog\models;

use phpDocumentor\Reflection\Types\This;
use Yii;
use yii\base\DynamicModel;
use yii\db\ActiveRecord;
use yii\db\mssql\PDO;
use zabachok\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string $post_title Заголовок
 * @property string $post_slug Слаг
 * @property string $post_content Содержимое
 * @property string post_meta_description Мета-descriptoin
 * @property string post_meta_keywords Мета-keywords
 * @property int $post_author_id ID автора
 * @property int $post_status Статус
 * @property int $post_type Тип (запись/страница)
 * @property string $post_thumbnail Изображение записи
 * @property int $created_at Создано
 * @property int $updated_at Обновлено
 *
 * @property PostCategory[] $postCategories
 */
class Post extends \yii\db\ActiveRecord
{
    const STATUS = [
        0 => 'Опубликовано',
        1 => 'Черновик'
    ];

    const POST_TYPE_SINGLE = 'single';
    const POST_TYPE_PAGE = 'page';

    const SCENARIO_SINGLE = self::POST_TYPE_SINGLE;
    const SCENARIO_PAGE = self::POST_TYPE_PAGE;

    const TYPE = [
        self::POST_TYPE_SINGLE => 'Запись',
        self::POST_TYPE_PAGE => 'Страница'
    ];

    public $category;
    public $image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_title', 'category'], 'required'],
            [['post_title', 'post_type', 'post_meta_description'], 'string'],
            [['post_author_id', 'post_status', 'created_at', 'updated_at'], 'integer'],
            [['category', 'post_content', 'post_meta_keywords'], 'safe'],
            [['post_slug'], 'string', 'max' => 200],
            [['post_thumbnail'], 'string', 'max' => 20],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['single'] = ['post_title', 'post_slug', 'category', 'post_content', 'post_status', 'post_thumbnail', 'post_meta_description', 'post_meta_keywords'];
        $scenarios['page'] = ['post_title', 'post_slug', 'post_content', 'post_status', 'post_meta_description', 'post_meta_keywords'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_title' => 'Заголовок',
            'post_slug' => 'Слаг',
            'post_content' => 'Содержимое',
            'post_author_id' => 'Автор',
            'post_status' => 'Статус',
            'category' => 'Категория',
            'post_type' => 'Тип',
            'image' => 'Изображение',
            'attachment' => 'Вложение',
            'post_meta_description' => 'Мета-descriptoin',
            'post_meta_keywords' => 'Мета-keywords',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'post_title',
                'slugAttribute' => 'post_slug',
//                'immutable'=> false,
                'ensureUnique' => true,
            ],
            'time' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ]
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'post_author_id',
                'updatedByAttribute' => 'post_author_id',
            ]
        ];
    }

    /**
     * Переводы записи
     * @return \yii\db\ActiveQuery
     */
    public function getTranslate()
    {
        return $this->hasMany(PostLang::class, ['post_id' => 'id']);
    }

    /**
     * Загрузка изображения записи
     */
    public function imageUpload()
    {
        $img = time() . '.' . $this->image->extension;
        $this->image->saveAs('images/' . $img);
        $this->post_thumbnail = $img;
        $this->image = null;
    }

    /**
     * Модель загрузки вложения
     * @return DynamicModel
     */
    public static function modelAttachment()
    {
        $model = new DynamicModel(['title', 'file', 'type']);
        $model->addRule(['title', 'type'], 'string');
        $model->addRule(['file'], 'file');
        $model->addRule(['title', 'file'], 'required');

        return $model;
    }

    /**
     * Возвращает вложения записи
     * @return array
     * @throws \yii\db\Exception
     */
    public function getAttachment()
    {
        return Yii::$app->db->createCommand('SELECT * FROM attachment WHERE post_id = :post')
            ->bindValue(':post', $this->id)->queryAll();
    }

    /**
     * Загрузка вложения записи
     */
    public function attachmentUpload($attachment)
    {
        $file = $attachment->baseName . '.' . $attachment->extension;
        $attachment->saveAs('uploads/attachment/' . $file);
    }

    /**
     * Добавление вложения к записи
     * @param $post
     * @param $attachment
     * @throws \yii\db\Exceptionэ
     */
    public function addAttachment($post, $attachment)
    {
        $this->attachmentUpload($attachment);
        Yii::$app->db->createCommand()->insert('attachment', [
            'title' => $post['title'],
            'file' => $attachment->baseName . '.' . $attachment->extension,
            'post_id' => $this->id,
            'file_type' => $post['type']
        ])->execute();
    }

    /**
     * Удаление вложения
     * @param $id
     * @return int
     * @throws \yii\db\Exception
     */
    public static function deleteAttachment($id)
    {
        $file = Yii::$app->db->createCommand('SELECT file FROM attachment WHERE id = :id')
            ->bindValue(':id', $id)->queryScalar();
        unlink('uploads/attachment/' . $file);

        return Yii::$app->db->createCommand()->delete('attachment', [
            'id' => $id
        ])->execute();
    }

    /**
     * Возвращает записи по слагу категории
     * @param $slug
     * @return array
     * @throws \yii\db\Exception
     */
    public static function byCategorySlug($slug)
    {
        return Yii::$app->db->createCommand('SELECT p.*, c.* FROM post_category pc 
                                                    LEFT JOIN post p ON p.id = pc.post_id 
                                                    LEFT JOIN category c on pc.category_id = c.id 
                                                    WHERE (SELECT id FROM category WHERE category_slug = :slug)')
            ->bindValue(':slug', $slug, PDO::PARAM_STR)->queryAll();
    }

    /**
     * Возвращает записи по ID категории
     * @param $categoryId
     * @throws \Throwable
     */
    public static function byCategoryId($categoryId)
    {
        $posts = Yii::$app->db->cache(function () use ($categoryId) {
            return Yii::$app->db->createCommand('SELECT p.*, c.* FROM post_category pc 
                                                    LEFT JOIN post p ON p.id = pc.post_id 
                                                    LEFT JOIN category c on pc.category_id = c.id 
                                                    WHERE pc.category_id = ' . $categoryId)
                ->queryAll();
        }, 60);

        return $posts;
    }

    /**
     * Возвращает последние новости
     * @param $categoryId
     * @param $limit
     * @throws \Throwable
     */
    public static function latestNews($categoryId, $limit)
    {
        $posts = Yii::$app->db->cache(function () use ($categoryId, $limit) {
            return Post::find()->leftJoin('post_category', 'post.id=post_category.post_id')
                ->where(['post_category.category_id' => $categoryId, 'post_type' => self::POST_TYPE_SINGLE])
                ->orderBy(['updated_at' => SORT_DESC])->asArray()->limit($limit)->all();
        }, 60);


        return $posts;
    }

    /**
     * Имеются ли комментарии к записи
     *
     * @param $post_id
     * @return bool
     */
    public static function haveComments($post_id): bool
    {
        $commets = (int)Comment::find()->where(['post_id' => $post_id])->count();
        return $commets != 0 ? true : false;
    }


    /**
     * {@inheritdoc}
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomQuery(get_called_class());
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if (!empty($this->created_at)) {
                $this->created_at = strtotime($this->created_at);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Если язык по умолчанию не соответствует текущему языку, возвращаем переводы
     * Если не пустая дата создания, приводим к формату, иначе задаем текущую дату
     */
    public function afterFind()
    {
        parent::afterFind();

        if (Yii::$app->multiLanguage->default_lang != Yii::$app->language) {
            $translate = Yii::$app->db->createCommand('SELECT post_title, post_content FROM post_lang 
                                                      WHERE post_id = ' . $this->id . ' AND lang = "' . Yii::$app->language . '"')
                ->queryOne();

            if (!empty($translate)) {
                $this->post_title = $translate['post_title'];
                $this->post_content = $translate['post_content'];
            }
        }

        if (!empty($this->created_at)) {
            $this->created_at = date('d.m.Y', $this->created_at);
        }
    }
}
