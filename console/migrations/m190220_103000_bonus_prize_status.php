<?php

use yii\db\Migration;

class m190220_103000_bonus_prize_status extends Migration
{
    public const TABLE_NAME = 'bonus_prize_status';

    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Наименование статуса')
        ]);

        $this->addCommentOnTable(self::TABLE_NAME, 'Статусы призов "бонусные баллы"');

        $this->batchInsert(self::TABLE_NAME, ['id', 'name'], [
            [
                'id' => 1,
                'name' => 'Отказ'
            ],
            [
                'id' => 2,
                'name' => 'Зачислено на счет лояльности'
            ]
        ]);
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
