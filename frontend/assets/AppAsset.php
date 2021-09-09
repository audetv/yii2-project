<?php

namespace frontend\assets;

use yii\bootstrap4\BootstrapAsset;
use yii\bootstrap4\BootstrapPluginAsset;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
        AdminlteAsset::class,
        FontAwesomeAsset::class,
    ];
}
