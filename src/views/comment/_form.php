<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model nooclik\blog\models\Comment */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Комментарий к записи: ' . $model->post->post_title
?>

<div class="comment-page">

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'form' => 'comment-form']) ?>
        <?= Html::a('Закрыть', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger', 'data-method' => 'post']) ?>
        <button class="btn btn-info" data-toggle="modal" data-target="#myModal">
            Ответить
        </button>

    </div>

    <?php $form = ActiveForm::begin(['options' => ['id' => 'comment-form']]); ?>
    <div class="pull-right">
        <i class="glyphicon glyphicon-calendar"></i> <?= Yii::$app->formatter->asDate($model->created_at, 'long') ?>
    </div>
    <h3>
        <u><?= Html::a($model->post->post_title, ['/blog/post/form', 'id' => $model->post_id, 'post_type' => $model->post->post_type]) ?></u>
    </h3>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?= $form->field($model, 'user_email')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?php ActiveForm::end(); ?>

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Ответ пользователю: <?= $model->user_name ?></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="user_email" value="<?= $model->user_email ?>">
                <textarea class="form-control" name="reply-text" id="reply-text" cols="30" rows="10" placeholder="Ответ на комментарий к записи: <?= $model->post->post_title ?>"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" onclick="sendMessage()" class="btn btn-primary">Отправить</button>
            </div>
        </div>
    </div>
</div>