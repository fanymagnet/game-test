<?php

use yii\db\Migration;

class m190220_102300_money_prize_status extends Migration
{
    const TABLE_NAME = 'money_prize_status';

    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Наименование статуса'),
        ]);

        $this->addCommentOnTable(self::TABLE_NAME, 'Статусы денежных призов');

        $this->batchInsert(self::TABLE_NAME, ['id', 'name'], [
            [
                'id' => 1,
                'name' => 'Отказ'
            ],
            [
                'id' => 2,
                'name' => 'Сконвертированно в баллы лояльности'
            ],
            [
                'id' => 3,
                'name' => 'Переведено на счет в банке'
            ]
        ]);
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
