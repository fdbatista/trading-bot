<?php

use yii\db\Migration;

/**
 * Class m201206_005248_change_created_at_datatype
 */
class m201206_005248_change_created_at_datatype extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('tick', 'created_at', 'bigint');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201206_005248_change_created_at_datatype cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201206_005248_change_created_at_datatype cannot be reverted.\n";

        return false;
    }
    */
}
