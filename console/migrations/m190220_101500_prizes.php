<?php

use yii\db\Migration;

class m190220_101500_prizes extends Migration
{
    const TABLE_NAME = 'prizes';

    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('Пользователь'),
            'type' => $this->integer()->notNull()->comment('Текущий статус'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->comment('Дата выигрыша')
        ]);

        $this->addCommentOnTable(self::TABLE_NAME, 'Призы пользователей');

        $this->addForeignKey('fk_prize_user', self::TABLE_NAME, 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_prize_type', self::TABLE_NAME, 'type', 'prizes_types', 'id', 'RESTRICT', 'CASCADE');

        $this->createIndex('idx_prizes_user_id', self::TABLE_NAME, 'user_id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_prize_user', self::TABLE_NAME);
        $this->dropForeignKey('fk_prize_type', self::TABLE_NAME);

        $this->dropTable(self::TABLE_NAME);
    }
}
