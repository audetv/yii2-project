<?php

declare(strict_types=1);

namespace core\useCases;

use core\entities\User\User;
use core\forms\User\UserCreateForm;
use core\forms\User\UserEditForm;
use core\repositories\exceptions\NotFoundException;
use core\repositories\user\UserRepository;
use core\services\RoleManager;
use core\services\TransactionManager;
use yii\base\Exception;
use yii\db\StaleObjectException;

class UserManageService
{
    /**
     * @var UserRepository
     */
    protected $repository;
    /**
     * @var RoleManager
     */
    protected $roles;
    /**
     * @var TransactionManager
     */
    protected $transaction;

    public function __construct(
        UserRepository $repository,
        RoleManager $roles,
        TransactionManager $transaction
    )
    {
        $this->repository = $repository;
        $this->roles = $roles;
        $this->transaction = $transaction;
    }

    /**
     * @param UserCreateForm $form
     * @return User
     * @throws \Throwable
     * @throws Exception
     */
    public function create(UserCreateForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->password
        );

        $this->transaction->wrap(function () use ($user, $form) {
            $this->repository->save($user);
            $this->roles->assign($user->id, $form->role);
        });

        return $user;
    }

    /**
     * @param $id
     * @param UserEditForm $form
     * @throws NotFoundException
     * @throws \Throwable
     */
    public function edit($id, UserEditForm $form): void
    {
        $user = $this->repository->get($id);

        $user->edit(
            $form->username,
            $form->email
        );

        $this->transaction->wrap(function () use ($user, $form) {
            $this->repository->save($user);
            $this->roles->assign($user->id, $form->role);
        });
    }

    /**
     * @param $id
     * @param $role
     * @throws NotFoundException
     * @throws \Exception
     */
    public function assignRole($id, $role): void
    {
        $user = $this->repository->get($id);
        $this->roles->assign($user->id, $role);
    }

    /**
     * @param $id
     * @throws NotFoundException
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function remove($id): void
    {
        $user = $this->repository->get($id);
        $this->repository->remove($user);
    }
}
