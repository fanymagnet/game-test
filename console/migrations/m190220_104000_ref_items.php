<?php

use yii\db\Migration;

class m190220_104000_ref_items extends Migration
{
    public const TABLE_NAME = 'ref_items';

    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Наименование предмета'),
        ]);

        $this->addCommentOnTable(self::TABLE_NAME, 'Справочник призов "физические предметы"');

        $this->batchInsert(self::TABLE_NAME, ['name'], [
            [
                'name' => 'Аааавтомобиль'
            ],
            [
                'name' => 'Чайник'
            ],
            [
                'name' => 'Кружка'
            ]
        ]);
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
