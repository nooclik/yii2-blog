<?php

use yii\db\Migration;

/**
 * Class m181129_103435_create_table_category
 */
class m181129_103435_create_table_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('category',[
            'id' => $this->primaryKey(),
            'category_title' => $this->text()->notNull()->comment('Заголовок'),
            'category_slug' => $this->string(200)->notNull()->comment('Слаг'),
            'category_description' => $this->text()->comment('Описание'),
            'category_parent' => $this->integer(4)->comment('Родительская категория'),
            'category_thumbnail' => $this->string('200')->comment('Изображение')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('category');
    }
}
