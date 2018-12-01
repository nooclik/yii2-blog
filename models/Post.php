<?php

namespace nooclik\blog\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string $post_title Заголовок
 * @property string $post_slug Слаг
 * @property string $post_content Содержимое
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
            [['post_title', 'post_type'], 'string'],
            [['post_author_id', 'post_status', 'created_at', 'updated_at'], 'integer'],
            [['category', 'post_content'], 'safe'],
            [['post_slug'], 'string', 'max' => 200],
            [['post_thumbnail'], 'string', 'max' => 20],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['single'] = ['post_title', 'category', 'post_content', 'post_status', 'post_thumbnail'];
        $scenarios['page'] = ['post_title', 'post_content', 'post_status',];
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
            'post_thumbnail' => 'Изображение',
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
     * {@inheritdoc}
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }
}
