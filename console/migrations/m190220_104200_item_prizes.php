<?php

use yii\db\Migration;

class m190220_104200_item_prizes extends Migration
{
    public const TABLE_NAME = 'item_prizes';

    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'prize_id' => $this->integer()->notNull()->comment('Приз'),
            'status' => $this->integer()->notNull()->comment('Текущий статус'),
            'item_id' => $this->integer()->notNull()->comment('Предмет')
        ]);

        $this->addCommentOnTable(self::TABLE_NAME, 'Призы "физические предметы"');

        $this->addForeignKey('fk_item_prize_prize', self::TABLE_NAME, 'prize_id', 'prizes', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_item_prize_status', self::TABLE_NAME, 'status', 'item_prize_status', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_item_prize_item', self::TABLE_NAME, 'item_id', 'ref_items', 'id', 'RESTRICT', 'CASCADE');

        $this->createIndex('idx_item_prizes_prize_id', self::TABLE_NAME, 'prize_id');
        $this->createIndex('idx_item_prizes_item_id', self::TABLE_NAME, 'item_id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_item_prize_prize', self::TABLE_NAME);
        $this->dropForeignKey('fk_item_prize_status', self::TABLE_NAME);
        $this->dropForeignKey('fk_item_prize_item', self::TABLE_NAME);

        $this->dropTable(self::TABLE_NAME);
    }
}
