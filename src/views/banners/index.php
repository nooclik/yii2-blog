<?php

use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Баннеры';
?>

<div class="form-group">
    <?= Html::button('Добавить', ['class' => 'btn btn-success', 'onclick' => '$("#modal-form-banner").modal({backdrop: "static"})']) ?>
</div>

<?php Pjax::begin(['id' => 'pjax-banners']) ?>
    <table class="table">
        <thead>
        <th>Изображение</th>
        </thead>
        <?php foreach ($banners as $banner) : ?>
            <tr>
                <td width="150"><img width="250" title="<?= $banner->title ?>" src="/images/banners/<?= $banner->image ?>" class="thumbnail" alt=""></td>

                <td>
                    <p><?= $banner['link'] ?></p>
                    <?= $banner['title'] ?>
                    <a href="<?= Url::to(['delete', 'id' => $banner['id']]) ?>" data-method="post" data-pjax=0><i class="glyphicon glyphicon-remove text-danger"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php Pjax::end() ?>

<div class="modal fade" id="modal-form-banner">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Название модали</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['options' => ['date-pjax' => 1, 'enctype' => 'multipart/form-data']]) ?>
                    <?= $form->field($model, 'title')->textInput() ?>
                    <?= $form->field($model, 'link')->textInput() ?>
                    <?= $form->field($model, 'file')->fileInput() ?>

                <div class="form-group modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php
$js = <<<JS
    
JS;
$this->registerJS($js);
