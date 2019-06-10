<?php

use yii\db\Migration;

/**
 * Class m190608_110211_create_table_options
 */
class m190608_110211_create_table_options extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('options', [
            'name' => $this->string(50),
            'value' => $this->string(100)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('options');
    }

}
