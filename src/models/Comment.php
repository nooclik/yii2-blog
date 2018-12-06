<?php

namespace nooclik\blog\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $post_id Запись
 * @property string $text Текст комментария
 * @property string $user_name Имя автора
 * @property string $user_email Email автора
 * @property integer $publish Опубликован
 * @property integer $seen Просмотрен
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Post $post
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    public function behaviors()
    {
        return [
            'time' => TimestampBehavior::className()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'text', 'user_email'], 'required'],
            [['post_id', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['user_name', 'user_email'], 'string', 'max' => 50],
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
            'post_id' => 'Запись',
            'text' => 'Текст',
            'user_name' => 'Имя автора',
            'user_email' => 'Email',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * Имеются ли новые комментарии
     *
     * @return bool
     */
    public static function haveNewComment(): bool
    {
        $newComments = (int)Comment::find()->where(['seen' => 0])->count();
        return $newComments != 0 ? true : false ;
    }

    /**
     * Количество новых комментариев
     *
     * @return int
     */
    public static function countNewComment(): int
    {
        return (int)Comment::find()->where(['seen' => 0])->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
}
