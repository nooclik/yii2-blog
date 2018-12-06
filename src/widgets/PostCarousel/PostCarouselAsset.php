<?php
/**
 * Created by PhpStorm.
 * User: Админ
 * Date: 06.12.2018
 * Time: 13:39
 */

namespace nooclik\blog\widgets\postCarousel;


use yii\web\AssetBundle;

class PostCarouselAsset extends AssetBundle
{
    public $sourcePath = '@vendor/nooclik/yii2-blog/src/widgets/postCarousel/assets';
    public $publishOptions = ['forceCopy' => true];

    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js'
    ];

    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css',
        'css/carousel.css',
    ];
}