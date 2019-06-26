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
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('options', [
            'key' => $this->string(50),
            'value' => $this->string(100)
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('options');
    }

}
