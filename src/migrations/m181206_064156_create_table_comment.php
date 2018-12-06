<?php

use yii\db\Migration;

/**
 * Class m181206_064156_create_table_comment
 */
class m181206_064156_create_table_comment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull()->comment('Запись'),
            'text' => $this->text()->notNull()->comment('Текст комментария'),
            'user_name' => $this->string(50)->comment('Имя автора'),
            'user_email'=> $this->string(50)->notNull()->comment('Email автора'),
            'seen' => $this->integer(1)->defaultValue(0)->comment('Прсмотрен'),
            'publish' => $this->integer(1)->defaultValue(0)->comment('Опубликовано'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk_comment_post',
            '{{%comment}}',
            'post_id',
            '{{%post}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_comment_post', '{{%comment}}');
        $this->dropTable('{{%comment}}');
    }
}
