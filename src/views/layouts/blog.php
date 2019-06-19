<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use nooclik\blog\BlogAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
BlogAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrapper">
    <div class="container-fluid">
        <?= Alert::widget() ?>
        <div class="row">
            <nav class="col-md-2 bg-light text-white">
                <?= $this->render('left') ?>
            </nav>


            <!--            --><? //= Breadcrumbs::widget([
            //                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            //            ]) ?>
            <main role="main" class="col-md-10">
                <?= $content ?>
            </main>
        </div>

    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
