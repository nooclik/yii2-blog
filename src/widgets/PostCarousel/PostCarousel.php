<?php

namespace nooclik\blog\widgets\postCarousel;

use yii\base\Widget;

class PostCarousel extends Widget
{
    public $data = [];
    public $slideToShow = 3;
    public $autoplay = true;
    public $urlToPost;

    public function run()
    {
        echo $this->render('carousel', [
            'data' => $this->data,
            'slideToShow' => $this->slideToShow,
            'autoplay' => $this->autoplay,
            'urlToPost' => $this->urlToPost
        ]);
    }
}