<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%group}}`.
 */
class m250612_161106_create_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%group}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'parent_id' => $this->integer(),
            'is_deleted' => $this->boolean()->defaultValue(false),
        ]);
        
        $this->addForeignKey(
            'fk-group-parent_id',
            'group',
            'parent_id',
            'group',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-group-parent_id', '{{%group}}');
        $this->dropTable('{{%group}}');
    }
}
