<?php

namespace nooclik\blog;

use yii\web\AssetBundle;

class BlogAsset extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@vendor/nooclik/yii2-blog/assets';

    public $css = [
        'css/blog.css',
    ];
    public $js = [
    ];
}