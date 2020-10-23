<?php

use common\widgets\Alert;
use frontend\assets\AuthAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

AuthAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= Alert::widget() ?>
<div class="container">
    <?= $content; ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
