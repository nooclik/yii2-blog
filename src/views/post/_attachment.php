<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<?php Pjax::begin(['id' => 'pjax-attachment']) ?>
    <fieldset>
        <legend>Вложения</legend>
        <div class="row">
            <div class="col-md-12">

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'data-pjax' => 1]]); ?>

                <div class="row">
                    <div class="col-md-8">
                        <?= $form->field($modelAttachment, 'title')->label('Заголовок') ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($modelAttachment, 'type')->dropDownList([''])->label('Тип файла') ?>
                    </div>
                </div>

                <?= $form->field($modelAttachment, 'file')->fileInput()->label('Вложение') ?>
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>

                <?php ActiveForm::end() ?>
            </div>
        </div>
        <?php if (!empty($model->attachment)) : ?>
            <hr>

            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <?php foreach ($model->attachment as $item) : ?>
                            <tr>
                                <td width="30"><span data-id="<?= $item['id'] ?>" class="text-danger"
                                                     onclick="deleteAttachment(this)"><i
                                                class="glyphicon glyphicon-remove" data-toggle="tooltip"
                                                title="Удалить"></i></span></td>
                                <td><?= $item['title'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </fieldset>
<?php Pjax::end() ?>

<?php
$js = <<<JS
    function deleteAttachment(el) {
        $.post('/blog/post/delete-attachment', {
            id: $(el).data('id')
        }).then(function() {
            $.pjax.reload({container: '#pjax-attachment'});
        });
    }
JS;

$this->registerJS($js, \yii\web\View::POS_HEAD);