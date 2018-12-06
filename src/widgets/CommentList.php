<?php

namespace nooclik\blog\widgets;

use nooclik\blog\models\Comment;
use Yii;
use yii\base\Widget;

class CommentList extends Widget
{
    public $post_id;

    public function run()
    {
        $comments = Comment::find()->where(['post_id' => $this->post_id])->asArray()->all();
        ?>
        <h3>Комментарии</h3>
        <ul id="comment-list">
            <?php foreach ($comments as $comment): ?>
                <li>
                    <div class="comment-info">
                        <span class="glyphicon glyphicon-user"></span> <b><?= $comment['user_email'] ?></b><br>
                        <span class="glyphicon glyphicon-calendar"></span> <?= Yii::$app->formatter->asDate($comment['created_at']) ?>
                    </div>
                    <hr>
                    <div class="comment-content">
                        <?= $comment['text'] ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
    }
}