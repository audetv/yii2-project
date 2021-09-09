<?php

declare(strict_types=1);

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class AdminlteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';

    public $css = [
        'css/adminlte.css'
    ];

    public $js = [
        'js/adminlte.js',
    ];

    public $depends = [
        YiiAsset::class,
        //BootstrapAsset::class
    ];
}