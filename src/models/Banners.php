<?php
/**
 * Created by PhpStorm.
 * User: админ
 * Date: 11.06.2019
 * Time: 15:06
 */

namespace nooclik\blog\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Banners extends ActiveRecord
{

    public $file;

    public static function tableName()
    {
        return 'banners';
    }

    public function rules()
    {
        return [
            [['link', 'image'], 'required'],
            [['title', 'link', 'image'], 'string'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['order'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'link' => 'Ссылка',
            'title' => 'Заголовок',
            'file' => 'Изображение',
        ];
    }

    public function uploadFile()
    {
        $fileName = $this->file->baseName . '.' . $this->file->extension;
        $this->image = $fileName;
        $this->file->saveAs('images/banners/' . $fileName);
    }

    public function afterDelete()
    {
        parent::afterDelete();

        unlink('images/banners/' . $this->image);
    }

}