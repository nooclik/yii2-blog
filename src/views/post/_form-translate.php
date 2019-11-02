<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model nooclik\blog\models\Post */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Запись';
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'post_title')->textInput(['placeholder' => 'Введите заголовок...']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <?= $form->field($model, 'post_content')->widget(Widget::className(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 300,
                    'imageUpload' => Url::to(['image-upload']),
                    'imageManagerJson' => Url::to(['images-get']),
                    'imageDelete' => Url::to(['file-delete']),
                    'plugins' => [
                        'clips',
                        'fullscreen',
                        'imagemanager',
                    ],
                ],
            ]); ?>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Закрыть', Yii::$app->request->referrer, ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
