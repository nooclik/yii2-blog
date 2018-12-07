<?php

namespace nooclik\blog\widgets\category;


use yii\base\Widget;

class Category extends Widget
{
    private $category = [];

    public function init()
    {
        $this->category = \Yii::$app->db
            ->createCommand('select c1.category_title as category, c2.category_title as parent from category c1 LEFT JOIN category c2 on c1.category_parent = c2.id')
            ->queryAll();
    }

    public function run()
    {

    }

}