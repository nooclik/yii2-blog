<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="row">
    <div class="col-md-12">
        <?php Pjax::begin(['id' => 'pjax-attachment']) ?>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'data-pjax' => 1]]); ?>

        <?= $form->field($modelAttachment, 'title')->label('Заголовок') ?>
        <?= $form->field($modelAttachment, 'file')->fileInput()->label('Вложение') ?>

        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>

        <?php ActiveForm::end() ?>
        <?php Pjax::end() ?>
    </div>
</div>