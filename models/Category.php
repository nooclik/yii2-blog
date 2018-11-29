<?php

namespace nooclik\blog\models;

use Yii;

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
 * @property PostCategory[] $postCategories
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
            [['category_title', 'category_slug'], 'required'],
            [['category_title', 'category_description'], 'string'],
            [['category_parent'], 'integer'],
            [['category_slug', 'category_thumbnail'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_title' => 'Category Title',
            'category_slug' => 'Category Slug',
            'category_description' => 'Category Description',
            'category_parent' => 'Category Parent',
            'category_thumbnail' => 'Category Thumbnail',
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
