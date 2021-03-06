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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Новая запись', ['form', 'post_type' => POST::SCENARIO_SINGLE], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Новая страница', ['form', 'post_type' => POST::SCENARIO_PAGE], ['class' => 'btn btn-primary']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            if ($model->post_status == 1) {
                return ['class' => 'text-muted'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'html',
                'attribute' => 'post_title',
                'value' => function ($model) {
                    return Html::a($model->post_title, ['form', 'id' => $model->id, 'post_type' => $model->post_type]);
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
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->created_at, 'long');
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
