<?php

declare(strict_types=1);

namespace core\listeners\User;

use core\entities\User\events\UserSignupRequested;
use RuntimeException;
use Yii;
use yii\mail\MailerInterface;

class UserSignupRequestedListener
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function handle(UserSignUpRequested $event): void
    {
        $sent = $this->mailer
            ->compose(
                ['html' => 'auth/signup/confirm-html', 'text' => 'auth/signup/confirm-text'],
                ['user' => $event->user]
            )
            ->setTo($event->user->email)
            ->setSubject('Проверка адреса эл. почты аккаунта ' . Yii::$app->name)
            ->send();
        if (!$sent) {
            throw new RuntimeException('Email sending error.');
        }
    }
}
