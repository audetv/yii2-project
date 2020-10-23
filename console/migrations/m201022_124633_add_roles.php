<?php

use core\access\Rbac;
use core\helpers\database\Column;
use core\helpers\database\Table;
use yii\db\Migration;
use yii\rbac\Permission;

/**
 * Class m201022_124633_add_roles
 */
class m201022_124633_add_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(Table::AUTH_ITEMS, [Column::TYPE, Column::NAME, Column::DESCRIPTION, Column::CREATED_AT, Column::UPDATED_AT], [
            [Permission::TYPE_ROLE, Rbac::ROLE_USER, 'Пользователь', time(), time()],
            [Permission::TYPE_ROLE, Rbac::ROLE_ADMIN, 'Администратор', time(), time()],
        ]);
        $this->batchInsert(Table::AUTH_ITEM_CHILDREN, [Column::PARENT, Column::CHILD], [
            [Rbac::ROLE_ADMIN, Rbac::ROLE_USER],
        ]);
        $this->execute('INSERT INTO {{%auth_assignments}} (item_name, user_id) SELECT \'user\', u.id FROM {{%users}} u ORDER BY u.id');

        $this->alterColumn(Table::USERS, Column::USERNAME, $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn(Table::USERS, Column::USERNAME, $this->string()->notNull());
        $this->delete(Table::AUTH_ITEMS, ['name' => [
            Rbac::ROLE_USER,
            Rbac::ROLE_ADMIN,
        ]]);
    }
}
