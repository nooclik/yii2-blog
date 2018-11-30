<?php

namespace nooclik\blog\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

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

    const TYPE = [
        0 => 'Запись',
        1 => 'Страница'
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
            [['post_title'], 'required'],
            [['post_title', 'post_content'], 'string'],
            [['post_author_id', 'post_status', 'post_type', 'category', 'created_at', 'updated_at'], 'integer'],
            [['post_slug'], 'string', 'max' => 200],
            [['post_thumbnail'], 'string', 'max' => 20],
        ];
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
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories()
    {
//        return $this->hasMany(PostCategory::className(), ['post_id' => 'id']);
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
