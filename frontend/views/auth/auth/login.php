<?php

use core\forms\auth\LoginForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/** @var LoginForm $model */

?>
<div class="login-box">
    <div class="login-logo">
        <?= Html::a(Yii::$app->name, ['site/index']) ?>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Войдите в систему, чтобы начать сеанс</p>

            <?php $form = ActiveForm::begin([]); ?>
            <?php $emailTemplate = "<div class=\"input-group mb-3\">\n{input}\n<div class=\"input-group-append\">
                        <div class=\"input-group-text\">
                            <span class=\"fas fa-envelope\"></span>
                        </div>
                    </div>\n{hint}\n{error}"; ?>

            <?php $passwordTemplate = "<div class=\"input-group mb-3\">\n{input}\n<div class=\"input-group-append\">
                        <div class=\"input-group-text\">
                            <span class=\"fas fa-lock\"></span>
                        </div>
                    </div>\n{hint}\n{error}"; ?>

            <?= $form->field($model, 'username', ['template' => $emailTemplate])->input('email', ['placeholder' => 'Email']); ?>

            <?= $form->field($model, 'password', ['template' => $passwordTemplate])->input('password', ['placeholder' => 'Пароль']); ?>
            <div class="row">
                <div class="col-8">
                    <?= $form->field($model, 'rememberMe', [
                            'checkTemplate' => "\n{input}\n{label}\n{error}\n{hint}\n",
                            'options' => ['class' => 'icheck-primary'],
                    ])->checkbox(['class' => false, 'uncheck' => null])->label('Запомнить меня', ['class' => null]); ?>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Войти</button>
                </div>
                <!-- /.col -->
            </div>
            <?php ActiveForm::end(); ?>

            <p class="mb-1">
                <?= Html::a('Я забыл мой пароль', ['auth/reset/request']); ?>
            </p>
            <p class="mb-0">
                <?= Html::a('У меня еще нет аккаунта. Регистрация', ['auth/signup/request'], ['class' => 'text-center']); ?>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
