<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel nooclik\blog\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рубрики';
$this->params['breadcrumbs'][] = $this->title;;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a('<i class="glyphicon glyphicon-plus"> </i> Новая рубрика', ['form'], ['class' => 'btn btn-default']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'html',
                'attribute' => 'category_title',
                'value' => function ($model) {
                    return Html::a($model->category_title, ['form', 'id' => $model->id]);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>