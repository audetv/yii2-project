<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \core\entities\User\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/signup/confirm', 'token' => $user->email_confirm_token]);
?>
<div class="password-reset">
    <p>Уважаемый пользователь !</p>

    <p>Ссылка для подтверждения email адреса:<br>
    <?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
    <p>Перейдите по этой ссылке для регистрации аккаунта <?= Yii::$app->name; ?>.
    Если Вы не делали этот запрос, проигнорируйте это сообщение.</p>

</div>

