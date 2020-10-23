<?php

namespace core\useCases\auth;

use core\access\Rbac;
use core\entities\User\User;
use core\forms\auth\SignupForm;
use core\repositories\exceptions\NotFoundException;
use core\repositories\user\UserRepository;
use core\services\RoleManager;
use core\services\TransactionManager;
use DomainException;
use yii\base\Exception;

class SignupService
{
    private $users;
    private $roles;
    private $transaction;

    public function __construct(
        UserRepository $users,
        RoleManager $roles,
        TransactionManager $transaction
    )
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->transaction = $transaction;
    }

    /**
     * @param SignupForm $form
     * @throws \Throwable
     * @throws Exception
     */
    public function signup(SignupForm $form): void
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password
        );
        $this->transaction->wrap(function () use ($user) {
            $this->users->save($user);
            $this->roles->assign($user->id, Rbac::ROLE_USER);
        });
    }

    /**
     * @param $token
     * @throws NotFoundException
     */
    public function confirm($token): void
    {
        if (empty($token)) {
            throw new DomainException('Empty confirm token.');
        }
        $user = $this->users->getByEmailConfirmToken($token);
        $user->confirmSignup();
        $this->users->save($user);
    }
}
