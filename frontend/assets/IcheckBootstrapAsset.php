<?php

declare(strict_types=1);

namespace frontend\assets;

use yii\web\AssetBundle;

class IcheckBootstrapAsset extends AssetBundle
{
    public $sourcePath = '@bower/icheck-bootstrap';

    public $css = [
        'icheck-bootstrap.css',
    ];
}