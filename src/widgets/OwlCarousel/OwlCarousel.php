<?php

namespace nooclik\blog\widgets\owlCarousel;

use yii\base\Widget;
use yii\helpers\Json;

class OwlCarousel extends Widget
{
    public $pluginOptions = [];
    public function init()
    {
        parent::init();
        ob_start();
    }

    public function run()
    {
        OwlCarouselAsset::register($this->view);
        $this->view->registerJs("$('.owl-carousel').owlCarousel(".Json::encode($this->pluginOptions).");");

        return ob_get_clean();
    }
}