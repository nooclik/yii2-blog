<?php

namespace nooclik\blog\models;

use yii\db\ActiveQuery;
use Yii;

/**
 * Class CustomQuery
 * @package nooclik\blog\models
 */
class CustomQuery extends ActiveQuery
{
    /**
     * @param $slug
     * @return CustomQuery
     */
    public function slug($slug)
    {
        return $this->where(['post_slug' => $slug]);
    }
}