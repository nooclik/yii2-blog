<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model nooclik\blog\models\Category */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Рубрика';
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_title')->textInput() ?>

    <?= $form->field($model, 'category_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'category_parent')->widget(Select2::classname(), [
        'data' => $category,
        'options' => ['placeholder' => 'Выберите категорию...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'category_thumbnail')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отмена', ['/blog/category'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
