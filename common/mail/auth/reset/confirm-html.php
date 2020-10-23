<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset/confirm', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Кто-то хочет восстановить пароль для входа в ваш аккаунт на сайте <a
                href="<?= Yii::$app->params['frontendHostInfo']; ?>"
                target="_blank"><?= Yii::$app->params['frontendHostInfo']; ?></a>.</p>
    <p>Если это вы, пройдите по ссылке (в противном случае просто проигнорируйте это письмо).</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
