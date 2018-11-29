<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use nooclik\blog\models\Post;

/* @var $this yii\web\View */
/* @var $searchModel nooclik\blog\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Записи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['form'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'html',
                'attribute' => 'post_title',
                'value' => function ($model) {
                    return Html::a($model->post_title, ['form', 'id' => $model->id]);
                }
            ],
            'post_author_id',
            [
                'attribute' => 'post_status',
                'value' => function ($model) {
                    return Post::STATUS[$model->post_status];
                },
                'filter' => Html::activeDropDownList($searchModel, 'post_status', Post::STATUS, ['prompt' => 'Все', 'class' => 'form-control'])
            ],
            [
                'attribute' => 'post_type',
                'value' => function ($model) {
                    return Post::TYPE[$model->post_type];
                },
                'filter' => Html::activeDropDownList($searchModel, 'post_type', Post::TYPE, ['prompt' => 'Все', 'class' => 'form-control'])
            ],
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
