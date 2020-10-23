<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */


$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset/confirm', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    Кто-то хочет восстановить пароль для входа в ваш аккаунт на сайте <?= Yii::$app->params['frontendHostInfo']; ?>.
    Если это вы, пройдите по ссылке (в противном случае просто проигнорируйте это письмо).

    <?= $resetLink ?>
</div>
