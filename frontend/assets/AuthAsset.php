<?php

declare(strict_types=1);

namespace frontend\assets;

use yii\bootstrap4\BootstrapPluginAsset;
use yii\web\AssetBundle;

class AuthAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //BootstrapAsset::class,
        BootstrapPluginAsset::class,
        FontAwesomeAsset::class,
        AdminlteAsset::class,
        IcheckBootstrapAsset::class,
    ];
}