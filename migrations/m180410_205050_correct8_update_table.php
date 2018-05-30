<?php

use yii\db\Migration;

/**
 * Class m180410_205050_correct8_update_table
 */
class m180410_205050_correct8_update_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('update', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'username' => $this->string()->notNull()->unique(),
            'update_id' => $this->integer()->notNull(),
            'chat_id' => $this->integer()->notNull(),
            'type' => $this->string(),
            'is_bot' => $this->boolean(),
            'text' => $this->string()
        ]);

        // creates index for column 'user_id'
        $this->createIndex(
            'idx-user_id',
            'update',
            'user_id'
        );

        // add foreign key for table 'update'
        $this->addForeignKey(
            'fk-user_id',
            'update',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180410_205050_correct8_update_table cannot be reverted.\n";

        return false;
    }
}
