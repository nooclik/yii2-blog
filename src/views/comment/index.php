<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Комментарии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'html',
                'attribute' => 'post_id',
                'value' => function ($model) {
                    return Html::a($model->post->post_title,
                        ['/blog/post/form', 'id' => $model->post->id, 'post_type' => $model->post->post_type]);
                }
            ],
            'user_name',
            'user_email:email',
            [
                'format' => 'html',
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->created_at);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"</span>', ['view', 'id' => $model->id]);
                    }
                ],
                'template' => '{view} {delete}',
            ],
        ],
    ]); ?>
</div>
