<?php

namespace nooclik\blog\models;

use Yii;

class PostCategory
{
    public static function save($post_id, $category_id)
    {
        Yii::$app->db->createCommand()->delete('{{post_category}}', ['post_id' => $post_id])
            ->execute();

        Yii::$app->db->createCommand()->insert('post_category', [
            'post_id' => $post_id,
            'category_id' => $category_id
        ])->execute();
    }

    public static function getCategoryByPost($post_id)
    {
        $category = Yii::$app->db->createCommand('SELECT category_id FROM post_category WHERE post_id = :post_id')
            ->bindValue(':post_id', $post_id, SQL_INTEGER)
            ->queryColumn();
        return $category;
    }
}