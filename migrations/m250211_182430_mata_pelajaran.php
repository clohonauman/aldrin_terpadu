<?php

use yii\db\Migration;

/**
 * Class m250211_182430_mata_pelajaran
 */
class m250211_182430_mata_pelajaran extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('mata_pelajaran', [
            'id' => $this->primaryKey(),
            'mata_pelajaran' => $this->string(255)->notNull(),
            'jam_pelajaran' => $this->integer(11)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('mata_pelajaran');
        return false;
    }
}
