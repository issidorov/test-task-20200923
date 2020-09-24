<?php

use yii\db\Migration;

/**
 * Class m200923_141851_create_table_plot
 */
class m200923_141851_create_table_plot extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('plot', [
            'id' => $this->primaryKey(),
            'number' => $this->string(),
            'address' => $this->text(),
            'price' => $this->money(),
            'area' => $this->money(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('plot');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200923_141851_create_table_plot cannot be reverted.\n";

        return false;
    }
    */
}
