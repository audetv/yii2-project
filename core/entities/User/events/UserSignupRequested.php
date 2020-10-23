<?php

declare(strict_types=1);

namespace core\entities\User\events;

use core\entities\User\User;

class UserSignupRequested
{
    /**
     * @var User
     */
    public $user;

    /**
     * UserSignupRequested constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
