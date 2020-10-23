<?php

declare(strict_types=1);

namespace common\bootstrap;

use core\dispatchers\EventDispatcher;
use core\dispatchers\SimpleEventDispatcher;
use core\entities\User\events\UserSignupRequested;
use core\listeners\User\UserSignupRequestedListener;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\ErrorHandler;
use yii\caching\Cache;
use yii\di\Container;
use yii\mail\MailerInterface;
use yii\rbac\ManagerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(ErrorHandler::class, function () use ($app) {
            return $app->errorHandler;
        });

        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(ManagerInterface::class, function () use ($app) {
            return $app->authManager;
        });

        $container->setSingleton(Cache::class, function () use ($app) {
            return $app->cache;
        });

        $container->setSingleton(EventDispatcher::class, SimpleEventDispatcher::class);

        $container->setSingleton(SimpleEventDispatcher::class, function (Container $container) {
            return new SimpleEventDispatcher($container, [
                UserSignupRequested::class => [UserSignupRequestedListener::class],
//                UserSignUpConfirmed::class => [UserSignupConfirmedListener::class],
            ]);
        });
    }
}
