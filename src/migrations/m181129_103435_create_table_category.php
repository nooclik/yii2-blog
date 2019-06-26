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
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%category}}',[
            'id' => $this->primaryKey(),
            'category_title' => $this->text()->notNull()->comment('Заголовок'),
            'category_slug' => $this->string(200)->notNull()->comment('Слаг'),
            'category_description' => $this->text()->comment('Описание'),
            'category_parent' => $this->integer(4)->comment('Родительская категория'),
            'category_thumbnail' => $this->string('200')->comment('Изображение')
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%category}}');
    }
}
