<?php

declare(strict_types=1);

namespace core\useCases\auth;

use core\entities\User\User;
use core\forms\auth\LoginForm;
use core\repositories\user\UserRepository;
use DomainException;

class AuthService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth(LoginForm $form): User
    {
        $user = $this->users->findByUsernameOrEmail($form->username);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new DomainException('Undefined user or password.');
        }
        return $user;
    }
}
