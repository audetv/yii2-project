<?php

declare(strict_types=1);

namespace core\services;

use Yii;

class TransactionManager
{
    /**
     * @param callable $function
     * @throws \Throwable
     */
    public function wrap(callable $function): void
    {
        Yii::$app->db->transaction($function);
    }
}
