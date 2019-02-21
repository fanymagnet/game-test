<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'bonus' => $this->float(2)->defaultValue(0)->notNull()->comment('Баллы пользователя'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->insert('user', [
            'username' => 'admin',
            'auth_key' => 'auth_key',
            'password_hash' => '$2y$13$kiCUcY8Mz/tYmftpuy8pn.DB4ZwKzx7XGGoKdowUspbYQxRydScSi', // 127000
            'password_reset_token' => 'password_reset_token',
            'email' => 'test@test.ru',
            'created_at' => 1000,
            'updated_at' => 1000
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
