<?php

use common\auth\Identity;
use core\api\storage\PublicKeyStorage;
use filsh\yii2\oauth2server\Module;
use filsh\yii2\oauth2server\Request;
use filsh\yii2\oauth2server\Response;
use OAuth2\GrantType\RefreshToken;
use OAuth2\GrantType\UserCredentials;
use OAuth2\Storage\JwtAccessToken;
use yii\filters\ContentNegotiator;
use yii\web\JsonResponseFormatter;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@staticRoot' => $params['staticPath'],
        '@static'   => $params['staticHostInfo'],
    ],
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => [
        'log',
        'common\bootstrap\SetUp',
        [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => 'json',
                'application/xml' => 'xml',
            ],
        ],
    ],
    'modules' => [
        'oauth2' => [
            'class' => Module::class,
            'components' => [
                'request' => function () {
                    return Request::createFromGlobals();
                },
                'response' => [
                    'class' => Response::class,
                ],
            ],
            'useJwtToken' => true,
            'tokenParamName' => false,
            'tokenAccessLifetime' => 3600 * 24,
            'storageMap' => [
                'access_token' => JwtAccessToken::class,
                'public_key' => PublicKeyStorage::class,
                'user_credentials' => Identity::class,
            ],
            'grantTypes' => [
                'user_credentials' => [
                    'class' => UserCredentials::class,
                ],
                'refresh_token' => [
                    'class' => RefreshToken::class,
                    'always_issue_new_refresh_token' => true
                ]
            ]
        ]
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'enableCookieValidation' => false,
            'enableCsrfValidation'   => false,
        ],
        'response' => [
            'formatters' => [
                'json' => [
                    'class' => JsonResponseFormatter::class,
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'user' => [
            'identityClass' => Identity::class,
            'enableAutoLogin' => false,
            'enableSession' => false,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => require __DIR__ . '/routes.php',
        ],
    ],
    'params' => $params,
];
