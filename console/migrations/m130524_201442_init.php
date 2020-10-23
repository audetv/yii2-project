<?php

use core\entities\User\User;
use core\helpers\database\Column;
use core\helpers\database\Table;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = Table::OPTIONS;
        }

        $this->createTable(Table::USERS, [
            Column::ID => $this->primaryKey(),
            Column::USERNAME => $this->string()->notNull()->unique(),
            Column::AUTH_KEY => $this->string(32)->notNull(),
            Column::PASSWORD_HASH => $this->string()->notNull(),
            Column::PASSWORD_RESET_TOKEN => $this->string()->unique(),
            Column::EMAIL => $this->string()->notNull()->unique(),
            Column::EMAIL_CONFIRM_TOKEN => $this->string()->unique(),
            Column::PHONE => $this->string()->unique(),
            Column::STATUS => $this->smallInteger()->notNull()->defaultValue(User::STATUS_WAIT),
            Column::CREATED_AT => $this->integer()->notNull(),
            Column::UPDATED_AT => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable(Table::USERS);
    }
}
