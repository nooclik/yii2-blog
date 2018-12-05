<?php

namespace nooclik\blog\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $category_title Заголовок
 * @property string $category_slug Слаг
 * @property string $category_description Описание
 * @property int $category_parent Родительская категория
 * @property string $category_thumbnail Изображение
 *
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_title'], 'required'],
            [['category_title', 'category_description'], 'string'],
            [['category_parent'], 'integer'],
            [['category_slug', 'category_thumbnail'], 'string', 'max' => 200],
        ];
    }

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'category_title',
                'slugAttribute' => 'category_slug'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_title' => 'Заголовок',
            'category_slug' => 'Слаг',
            'category_description' => 'Описание',
            'category_parent' => 'Родитель',
            'category_thumbnail' => 'Изображение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories()
    {
//        return $this->hasMany(PostCategory::className(), ['category_id' => 'id']);
    }


    public static function getList()
    {
        return Category::find()->select('category_title, id')->indexBy('id')->orderBy('category_title')->column();
    }
}
