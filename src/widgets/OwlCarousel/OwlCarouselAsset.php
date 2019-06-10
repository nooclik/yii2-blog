<?php

namespace nooclik\blog\widgets\owlCarousel;

use yii\web\AssetBundle;

class OwlCarouselAsset extends AssetBundle
{
    public $sourcePath = '@vendor/nooclik/yii2-blog/src/widgets/OwlCarousel/dist';

    public $css = [
        'owl.carousel.min.css',
        'owl.theme.default.min.css',
    ];

    public $js = [
        'owl.carousel.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}