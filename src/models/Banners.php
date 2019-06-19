<?php
/**
 * Created by PhpStorm.
 * User: админ
 * Date: 11.06.2019
 * Time: 15:06
 */

namespace nooclik\blog\models;


use yii\db\ActiveRecord;

class Banners extends ActiveRecord
{
    public static function tableName()
    {
        return 'banners';
    }

    public function rules()
    {
        return [
            [['link', 'image'], 'required'],
            [['title', 'link', 'image'], 'string'],
            [['order'], 'integer'],
        ];
    }
}