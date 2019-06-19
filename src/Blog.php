<?php

namespace nooclik\blog;

/**
 * blog module definition class
 */
class Blog extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'nooclik\blog\controllers';
    public $layout = 'main';
    
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

    }
}
