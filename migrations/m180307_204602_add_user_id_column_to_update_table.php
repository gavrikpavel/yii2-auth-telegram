<?php

use yii\db\Migration;

/**
 * Handles adding user_id to table `update`.
 */
class m180307_204602_add_user_id_column_to_update_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('update', 'user_id', $this->integer());

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
        $this->dropColumn('update', 'user_id');
    }
}
