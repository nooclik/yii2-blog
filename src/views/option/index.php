<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Параметры сайта'
?>

<div id="page">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'siteName') ?>
    <?= $form->field($model, 'email') ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end() ?>
</div>
