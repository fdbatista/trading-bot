<?php

use yii\db\Migration;

/**
 * Class m201209_031037_create_book_index
 */
class m201209_031037_create_book_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx_tick_book', 'tick', 'book');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201209_031037_create_book_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201209_031037_create_book_index cannot be reverted.\n";

        return false;
    }
    */
}
