<?php

namespace nooclik\blog\models;

use Yii;
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
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'post_author_id',
                'updatedByAttribute' => 'post_author_id',
            ]
        ];
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
     * Возвращает записи по слагу категории
     * @param $slug
     * @return array
     * @throws \yii\db\Exception
     */
    public static function postByCategory($slug)
    {
        return Yii::$app->db->createCommand('SELECT p.*, c.* FROM post_category pc 
                                                    LEFT JOIN post p ON p.id = pc.post_id 
                                                    LEFT JOIN category c on pc.category_id = c.id 
                                                    WHERE (SELECT id FROM category WHERE category_slug = :slug)')
            ->bindValue(':slug', $slug, PDO::PARAM_STR)->queryAll();
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
}
