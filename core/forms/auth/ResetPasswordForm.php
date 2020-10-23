<?php

declare(strict_types=1);

namespace core\forms\auth;

use yii\base\Model;

class ResetPasswordForm extends Model
{
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['password'], 'required', 'message' => 'Введите новый пароль'],
            [['password_repeat'], 'required', 'message' => 'Введите новый пароль еще раз'],
            [['password', 'password_repeat'], 'filter', 'filter' => 'trim'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
        ];
    }
}
