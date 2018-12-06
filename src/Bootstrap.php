<?php

namespace nooclik\blog;

use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->setModule('blog', ['class' => 'nooclik\blog\Blog']);
    }
}