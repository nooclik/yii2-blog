<?php $this->title = 'Управление блогом' ?>
<div class="blog-default-index">
    <div class="row" id="block-action">
        <div class="col-md-3">
            <h1><i class="glyphicon glyphicon-tasks"></i></h1>
            <h4><a href="/blog/category">Рубрики</a></h4>
        </div>
        <div class="col-md-3">
            <h1><i class="glyphicon glyphicon-pushpin"></i></h1>
            <h4><a href="/blog/post">Записи</a></h4>
        </div>
        <div class="col-md-3">
            <h1><i class="glyphicon glyphicon-comment"></i></h1>
            <h4><a href="/blog/comment">Комментарии <?= \nooclik\blog\models\Comment::haveNewComment() ? '<span class="badge">' . \nooclik\blog\models\Comment::countNewComment() . '</span>' : '' ?> </a></h4>
        </div>
    </div>
</div>
<?php
echo \nooclik\blog\widgets\category\Category::widget();