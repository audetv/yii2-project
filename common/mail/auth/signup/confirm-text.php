<?php

use core\entities\User\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/signup/confirm', 'token' => $user->email_confirm_token]);

?>
Уважаемый пользователь !

Ссылка для подтверждения email адреса: <?= Html::a(Html::encode($confirmLink), $confirmLink) ?>
Перейдите по этой ссылке для регистрации аккаунта <?= Yii::$app->name; ?>.
Если Вы не делали этот запрос, проигнорируйте это сообщение.
