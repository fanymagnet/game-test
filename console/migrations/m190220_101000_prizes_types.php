<?php

use yii\db\Migration;

class m190220_101000_prizes_types extends Migration
{
    const TABLE_NAME = 'prizes_types';

    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Наименование приза'),
            'limit' => $this->integer()->notNull()->comment('Оставшиеся ресурсы'),
        ]);

        $this->addCommentOnTable(self::TABLE_NAME, 'Типы призов');

        $this->batchInsert(self::TABLE_NAME, ['name', 'limit'], [
            ['name' => 'Денежный приз', 'limit' => 1000],
            ['name' => 'Физический предмет', 'limit' => 50],
            ['name' => 'Бонусные баллы', 'limit' => -1]
        ]);
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
