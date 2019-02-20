<?php

use yii\db\Migration;

class m190220_102500_money_prizes extends Migration
{
    const TABLE_NAME = 'money_prizes';

    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'prize_id' => $this->integer()->notNull()->comment('Приз'),
            'status' => $this->integer()->notNull()->comment('Текущий статус'),
            'amount' => $this->float(2)->notNull()->comment('Размер приза'),
            'is_sent_to_bank' => $this->boolean()->defaultValue(false)->comment('Приз отправлен в банк')
        ]);

        $this->addCommentOnTable(self::TABLE_NAME, 'Денежные призы');

        $this->addForeignKey('fk_money_prize_prize', self::TABLE_NAME, 'prize_id', 'prizes', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_money_prize_status', self::TABLE_NAME, 'status', 'money_prize_status', 'id', 'RESTRICT', 'CASCADE');

        $this->createIndex('idx_money_prizes_prize_id', self::TABLE_NAME, 'prize_id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_money_prize_prize', self::TABLE_NAME);
        $this->dropForeignKey('fk_money_prize_status', self::TABLE_NAME);

        $this->dropTable(self::TABLE_NAME);
    }
}
