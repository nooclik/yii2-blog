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
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'post_title' => $this->text()->notNull()->comment('Заголовок'),
            'post_slug' => $this->string(200)->notNull()->comment('Слаг'),
            'post_content' => $this->text()->notNull()->comment('Содержимое'),
            'post_author_id' => $this->integer()->comment('ID автора'),
            'post_status' => $this->smallInteger()->notNull()->defaultValue(0)->comment('Статус'),
            'post_type' => $this->smallInteger()->notNull()->comment('Тип (запись/страница)'),
            'post_thumbnail' => $this->string('20')->comment('Изображение записи'),
            'created_at' => $this->integer()->comment('Создано'),
            'updated_at' => $this->integer()->comment('Обновлено'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('posts');
    }
}
