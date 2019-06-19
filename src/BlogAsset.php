<?php

namespace nooclik\blog;

use yii\web\AssetBundle;

class BlogAsset extends AssetBundle
{
    public $sourcePath = '@vendor/nooclik/yii2-blog/assets';
    public $publishOptions = ['forceCopy' => true];

    public $css = [
        'css/blog.css',
    ];
    public $js = [
        'js/blog.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}