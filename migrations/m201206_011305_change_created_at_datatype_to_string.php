<?php

use yii\db\Migration;

/**
 * Class m201206_011305_change_created_at_datatype_to_string
 */
class m201206_011305_change_created_at_datatype_to_string extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('tick', 'created_at', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201206_011305_change_created_at_datatype_to_string cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201206_011305_change_created_at_datatype_to_string cannot be reverted.\n";

        return false;
    }
    */
}
