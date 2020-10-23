<?php

declare(strict_types=1);

namespace core\forms\auth;

use core\entities\User\User;
use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $agreement;

    public $required = 'Обязательно для заполнения';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => $this->required],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => $this->required],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],

            [['password', 'password_repeat'], 'required', 'message' => $this->required],
            [['password'], 'filter', 'filter' => 'trim'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],

            [
                'agreement',
                'required',
                'requiredValue' => true,
                'message' => 'Для продолжения вы должны принять условия пользовательского соглашения'
            ]
        ];
    }
}
