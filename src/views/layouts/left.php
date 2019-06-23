<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
            </div>
            <div class="pull-left info">
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    ['label' => 'Категории', 'icon' => 'file-code-o', 'url' => ['/blog/category']],
                    ['label' => 'Записи', 'icon' => 'file-code-o', 'url' => ['/blog/post']],
                    ['label' => 'Комментарии', 'icon' => 'file-code-o', 'url' => ['/blog/comment']],
                    ['label' => 'Баннеры', 'icon' => 'file-code-o', 'url' => ['/blog/banners']],
                    ['label' => 'Параметры', 'icon' => 'file-code-o', 'url' => ['/blog/option']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                ],
            ]
        ) ?>

    </section>

</aside>
