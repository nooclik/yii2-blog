<?php

use yii\widgets\Pjax;
use yii\helpers\Url;

?>

<?php Pjax::begin(['id' => 'pjax-banners']) ?>
    <table class="table">
        <thead>
        <th>Изображение</th>
        </thead>
        <?php foreach ($banners as $banner) : ?>
            <tr>
                <td width="150"><img src="/images/<?= $banner->image ?>" class="thumbnail" alt=""></td>

                <td>
                    <p><?= $banner['link'] ?></p>
                    <?= $banner['title'] ?>
                    <a href="<?= Url::to(['delete', 'id' => $banner['id']]) ?>"><i class="glyphicon glyphicon-remove text-danger"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php Pjax::end() ?>