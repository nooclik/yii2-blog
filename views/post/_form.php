<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model nooclik\blog\models\Post */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Запись';
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'post_title')->textInput(['placeholder' => 'Введите заголовок...']) ?>

    <?= $form->field($model, 'post_content')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 300,
            'plugins' => [
                'clips',
                'fullscreen',
            ],
        ],
    ]); ?>

    <?php if ($model->getScenario() == \nooclik\blog\models\Post::SCENARIO_SINGLE): ?>
        <?= $form->field($model, 'category')->widget(Select2::classname(), [
            'data' => $category,
            'options' => ['placeholder' => 'Выберите категорию...', 'multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'tokenSeparators' => [',', ' '],
                'maximumInputLength' => 10
            ],
        ]) ?>

        <?= $form->field($model, 'post_thumbnail')->textInput(['maxlength' => true]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'post_status')->dropDownList($status) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отмена', 'index', ['class' => 'btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
