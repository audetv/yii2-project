<?php

use core\forms\auth\ResetPasswordForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/** @var ResetPasswordForm $model */

?>
<div class="login-box">
    <div class="login-logo">
        <?= Html::a(Yii::$app->name, ['site/index']); ?>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Восстановление пароля</p>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?php $passwordTemplate = "<div class=\"input-group mb-3\">\n{input}\n<div class=\"input-group-append\">
                        <div class=\"input-group-text\">
                            <span class=\"fas fa-lock\"></span>
                        </div>
                    </div>\n{hint}\n{error}"; ?>
            <?= $form->field($model, 'password', ['template' => $passwordTemplate])->input('password', ['autofocus' => true, 'placeholder' => 'Новый пароль']) ?>

            <?= $form->field($model, 'password_repeat', ['template' => $passwordTemplate])->input('password', ['placeholder' => 'Повторите пароль']) ?>

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Сохранить</button>
                </div>
                <!-- /.col -->
            </div>
            <?php ActiveForm::end(); ?>

            <p class="mt-3 mb-1">
                <?= Html::a('Вход', ['auth/auth/login']); ?>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
