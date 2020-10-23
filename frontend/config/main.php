<?php

use common\auth\Identity;
use common\bootstrap\SetUp;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', SetUp::class],
    'language' => 'ru',
    'aliases' => [
        '@staticRoot' => $params['staticPath'],
        '@static'   => $params['staticHostInfo'],
    ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'cookieValidationKey' => $params['cookieValidationKey'],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
            'linkAssets' => true,
        ],
        'user' => [
            'identityClass' => Identity::class,
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity',
                'httpOnly' => true,
                'domain' => $params['cookieDomain']
            ],
            'loginUrl' => ['auth/auth/login'],
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            // this is the name of the session cookie used for login on the frontend
            'name' => '_session',
            'cookieParams' => [
                'domain' => $params['cookieDomain'],
                'httpOnly' => true,
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'backendUrlManager' => require __DIR__ . '/../../backend/config/urlManager.php',
        'frontendUrlManager' => require __DIR__ . '/urlManager.php',
        'urlManager' => function () {
            return Yii::$app->get('frontendUrlManager');
        },
    ],
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'except' => [
            'auth/auth/login',
            'auth/signup/request',
            'auth/signup/confirm',
            'auth/reset/request',
            'auth/reset/confirm',
            'site/error'
        ],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['user'],
            ],
        ],
    ],
    'params' => $params,
];
