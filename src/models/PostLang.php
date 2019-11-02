<?php

namespace nooclik\blog\models;

use Yii;

/**
 * This is the model class for table "post_lang".
 *
 * @property int $id
 * @property string $lang
 * @property int $post_id
 * @property string $post_title
 * @property string $post_content
 *
 * @property Post $post
 */
class PostLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_title', 'post_content'], 'required'],
            [['post_id'], 'integer'],
            [['post_content'], 'string'],
            [['lang'], 'string', 'max' => 25],
            [['post_title'], 'string', 'max' => 255],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lang' => 'Lang',
            'post_id' => 'Post ID',
            'post_title' => 'Заголовок',
            'post_content' => 'Содержимое',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
}
