<?php

declare(strict_types=1);

namespace core\readModels;

use core\entities\User\User;
use core\helpers\database\Column;

class UserReadRepository
{
    public function find($id): ?User
    {
        return User::findOne($id);
    }

    /**
     * @param $id
     * @return User|null
     * @throws \Throwable
     */
    public function findActiveById($id): ?User
    {
        return User::getDb()->cache(function () use ($id) {
            return User::findOne([Column::ID => $id, Column::STATUS => User::STATUS_ACTIVE]);
        });
    }

    public function findActiveByUsername($username): ?User
    {
        return User::findOne([Column::USERNAME => $username, Column::STATUS => User::STATUS_ACTIVE]);
    }
}
