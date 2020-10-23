<?php

declare(strict_types=1);

namespace core\repositories\user;


use core\dispatchers\EventDispatcher;
use core\entities\User\User;
use core\helpers\database\Column;
use core\repositories\exceptions\NotFoundException;
use core\repositories\exceptions\RemovingErrorException;
use core\repositories\exceptions\SavingErrorException;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;

class UserRepository
{
    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return User[]
     */
    public function findAll(): array
    {
        return User::find()->all();
    }

    /**
     * @param $value
     * @return ActiveRecord|User|null
     */
    public function findByUsernameOrEmail($value): ?User
    {
        return User::find()->andWhere(['or', [Column::USERNAME => $value], [Column::EMAIL => $value]])->one();
    }

    /**
     * @param $id
     * @return ActiveRecord|User
     * @throws NotFoundException
     */
    public function get($id): User
    {
        return $this->getBy(['id' => $id]);
    }

    /**
     * @param $token
     * @return User
     * @throws NotFoundException
     */
    public function getByEmailConfirmToken($token): User
    {
        try {
            return $this->getBy([Column::EMAIL_CONFIRM_TOKEN => $token]);
        } catch (NotFoundException $e) {
            throw new NotFoundException('Ссылка для активации устарела');
        }

    }

    /**
     * @param $email
     * @return User
     * @throws NotFoundException
     */
    public function getByEmail($email): User
    {
        return $this->getBy([Column::EMAIL => $email]);
    }

    /**
     * @param $token
     * @return ActiveRecord|User
     * @throws NotFoundException
     */
    public function getByPasswordResetToken($token): User
    {
        return $this->getBy([Column::PASSWORD_RESET_TOKEN => $token]);
    }

    public function existsByPasswordResetToken(string $token): bool
    {
        return (bool) User::findByPasswordResetToken($token);
    }

    /**
     * @param User $user
     */
    public function save(User $user): void
    {
        if (!$user->save()) {
            throw new SavingErrorException('Saving error.');
        }
        $this->dispatcher->dispatchAll($user->releaseEvents());
    }

    /**
     * @param ActiveRecord|User $user
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function remove(User $user): void
    {
        if (!$user->delete()) {
            throw new RemovingErrorException('Removing error.');
        }
        $this->dispatcher->dispatchAll($user->releaseEvents());
    }

    /**
     * @param array $condition
     * @return ActiveRecord|User
     * @throws NotFoundException
     */
    private function getBy(array $condition): User
    {
        if (!$user = User::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('Пользователь не найден.');
        }
        return $user;
    }
}
