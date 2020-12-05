<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tick}}`.
 */
class m201205_205539_create_tick_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tick}}', [
            'id' => $this->primaryKey(),
            'high' => $this->string(),
            'low' => $this->string(),
            'last' => $this->string(),
            'created_at' => $this->date(),
            'book' => $this->string(),
            'volume' => $this->string(),
            'vwap' => $this->string(),
            'ask' => $this->string(),
            'bid' => $this->string(),
            'change_24' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tick}}');
    }
}
