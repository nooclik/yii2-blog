<?php

namespace nooclik\blog\models;

use Yii;
use yii\base\Model;

class Option extends Model
{
    public $siteName;
    public $email;


    public function init()
    {
        parent::init();
        $this->loadOptions();
    }

    public function rules()
    {
        return [
            [['siteName',], 'string', 'max' => 50],
            [['email'], 'email'],
            [['siteName', 'email'], 'trim'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'siteName' => 'Название сайта',
            'email' => 'Email',
        ];
    }

    /**
     * Возвращает значение параметра
     * @param $key
     * @return false|null|string
     * @throws \yii\db\Exception
     */
    public static function get($key)
    {
        return Yii::$app->db->createCommand('SELECT value FROM options WHERE `key` = :key')
            ->bindValue(':key', $key)->queryScalar();
    }

    /**
     * Устанавливает значение параметра
     * @param $key
     * @param $value
     * @return int
     * @throws \yii\db\Exception
     */
    public function set($post)
    {
        foreach ($post['Option'] as $key => $value) {
            Yii::$app->db->createCommand()->update('options', [
                'value' => $value
            ], ['key' => $key])->execute();
        }
    }


    public function loadOptions()
    {
        $options = Yii::$app->db->createCommand('SELECT * FROM options')->queryAll(\PDO::FETCH_KEY_PAIR);
        foreach ($this->attributes() as $attribute) {
            $this->$attribute = $options[$attribute];
        }
    }

}