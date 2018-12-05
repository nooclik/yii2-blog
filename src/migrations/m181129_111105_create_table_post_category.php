<?php

use yii\db\Migration;

/**
 * Class m181129_111105_create_table_post_category
 */
class m181129_111105_create_table_post_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('post_category', [
            'post_id' => $this->integer(),
            'category_id' => $this->integer(),
        ]);

        $this->createIndex('idx_post_post_category', 'post_category', 'post_id');
        $this->createIndex('idx_category_post_category', 'post_category', 'category_id');

        $this->addForeignKey('fk_post_category_post',
            'post_category',
            'post_id',
            'posts',
            'id',
            'CASCADE'
        );

        $this->addForeignKey('fk_category_category_post',
            'post_category',
            'category_id',
            'category',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropIndex('idx_post_post_category', 'post_category');
        $this->dropIndex('idx_category_post_category', 'post_category');
        $this->dropForeignKey('fk_post_category_post', 'post_category');
        $this->dropForeignKey('fk_category_category_post', 'post_category');
        $this->dropTable('post_category');
    }
}
