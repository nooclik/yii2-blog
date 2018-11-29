<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model nooclik\blog\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_title')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'category_slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'category_parent')->textInput() ?>

    <?= $form->field($model, 'category_thumbnail')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
