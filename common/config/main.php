<?php

use core\helpers\database\Table;
use yii\rbac\DbManager;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
        ],
        'authManager' => [
            'class' => DbManager::class,
            'itemTable' => Table::AUTH_ITEMS,
            'itemChildTable' => Table::AUTH_ITEM_CHILDREN,
            'assignmentTable' => Table::AUTH_ASSIGNMENTS,
            'ruleTable' => Table::AUTH_RULES,
        ],
    ],
];
