<?php

use yii\db\Migration;

/**
 * Class m250217_140459_create_log_aktivitas_terpadu
 */
class m250217_140459_create_log_aktivitas_terpadu extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Membuat tabel log_aktivitas_terpadu
        $this->createTable('log_aktivitas_terpadu', [
            'id' => $this->primaryKey(),
            'id_akun' => $this->integer()->notNull(),
            'action' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('log_aktivitas_terpadu');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250217_140459_create_log_aktivitas_terpadu cannot be reverted.\n";

        return false;
    }
    */
}
