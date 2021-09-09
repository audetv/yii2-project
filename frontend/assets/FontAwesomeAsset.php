<?php

declare(strict_types=1);

namespace frontend\assets;

use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@npm/fortawesome--fontawesome-free/js';

    public $js = [
        'all.js',
    ];
}