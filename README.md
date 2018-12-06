Blog for Yii2
=============
Blog for Yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nooclik/yii2-blog "dev-master"
```

or add

```
"nooclik/yii2-blog": "*"
```

to the require section of your `composer.json` file.

```php
yii migrate/create --migrationPath="vendor\nooclik\yii2-blog\src\migrations" 
```

Usage
-----

````php
'modules' => [
        'blog' => [
            'class' => 'nooclik\blog\Blog',
            'params' =>
            [
                // Включить работу с комментариями
                'useComment' => true
            ]
        ]
    ],