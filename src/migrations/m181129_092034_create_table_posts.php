<?php

use yii\db\Migration;

/**
 * Class m181129_092034_create_table_posts
 */
class m181129_092034_create_table_posts extends Migration
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

        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'post_title' => $this->text()->notNull()->comment('Заголовок'),
            'post_slug' => $this->string(200)->notNull()->comment('Слаг'),
            'post_content' => $this->text()->notNull()->comment('Содержимое'),
            'post_author_id' => $this->integer()->comment('ID автора'),
            'post_status' => $this->smallInteger()->notNull()->defaultValue(0)->comment('Статус'),
            'post_type' => $this->string(15)->notNull()->comment('Тип (запись/страница)'),
            'post_thumbnail' => $this->string('20')->comment('Изображение записи'),
            'post_meta_keywords' => $this->string(100),
            'post_meta_description' => $this->string(100),
            'created_at' => $this->integer()->comment('Создано'),
            'updated_at' => $this->integer()->comment('Обновлено'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%post}}');
    }
}
