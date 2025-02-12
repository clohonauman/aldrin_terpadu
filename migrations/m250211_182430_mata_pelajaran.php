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

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250211_182430_mata_pelajaran cannot be reverted.\n";

        return false;
    }
    */
}
