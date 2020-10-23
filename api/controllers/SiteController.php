<?php

declare(strict_types=1);

namespace api\controllers;

use api\controllers\common\ApiController;


class SiteController extends ApiController
{
    public function actionIndex()
    {
        return [
            'version' => '0.1.0',
        ];
    }
}
