<?php

use yii\db\Migration;

class m190220_103300_bonus_prizes extends Migration
{
    public const TABLE_NAME = 'bonus_prizes';

    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'prize_id' => $this->integer()->notNull()->comment('Приз'),
            'status' => $this->integer()->comment('Текущий статус'),
            'amount' => $this->float(2)->notNull()->comment('Размер бонусов')
        ]);

        $this->addCommentOnTable(self::TABLE_NAME, 'Призы "бонусные баллы"');

        $this->addForeignKey('fk_bonus_prize_prize', self::TABLE_NAME, 'prize_id', 'prizes', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_bonus_prize_status', self::TABLE_NAME, 'status', 'bonus_prize_status', 'id', 'RESTRICT', 'CASCADE');

        $this->createIndex('idx_bonus_prizes_prize_id', self::TABLE_NAME, 'prize_id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_bonus_prize_prize', self::TABLE_NAME);
        $this->dropForeignKey('fk_bonus_prize_status', self::TABLE_NAME);

        $this->dropTable(self::TABLE_NAME);
    }
}
