<?php

use yii\db\Migration;

/**
 * Class m190608_094735_create_table_banners
 */
class m190608_094735_create_table_banners extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('banners', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'link' => $this->string(50)->notNull(),
            'image' => $this->string(150)->notNull(),
            'order' => $this->integer(2)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('banners');
    }
}
