<?php

use core\forms\auth\SignupForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/** @var SignupForm $model */

?>
<div class="register-box">
    <div class="register-logo">
        <?= Html::a(Yii::$app->name, ['site/index']); ?>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Заполните данные для регистрации</p>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?php $usernameTemplate = "<div class=\"input-group mb-3\">\n{input}\n<div class=\"input-group-append\">
                        <div class=\"input-group-text\">
                            <span class=\"fas fa-user\"></span>
                        </div>
                    </div>\n{hint}\n{error}"; ?>
            <?= $form->field($model, 'username', ['template' => $usernameTemplate])->textInput(['autofocus' => true, 'placeholder' => 'ФИО']) ?>

            <?php $emailTemplate = "<div class=\"input-group mb-3\">\n{input}\n<div class=\"input-group-append\">
                        <div class=\"input-group-text\">
                            <span class=\"fas fa-envelope\"></span>
                        </div>
                    </div>\n{hint}\n{error}"; ?>
            <?= $form->field($model, 'email', ['template' => $emailTemplate])->input('email', ['placeholder' => 'Email']) ?>

            <?php $passwordTemplate = "<div class=\"input-group mb-3\">\n{input}\n<div class=\"input-group-append\">
                        <div class=\"input-group-text\">
                            <span class=\"fas fa-lock\"></span>
                        </div>
                    </div>\n{hint}\n{error}"; ?>
            <?= $form->field($model, 'password', ['template' => $passwordTemplate])->input('password', ['placeholder' => 'Пароль']) ?>

            <?php $passwordTemplate = "<div class=\"input-group mb-3\">\n{input}\n<div class=\"input-group-append\">
                        <div class=\"input-group-text\">
                            <span class=\"fas fa-lock\"></span>
                        </div>
                    </div>\n{hint}\n{error}"; ?>
            <?= $form->field($model, 'password_repeat', ['template' => $passwordTemplate])->input('password', ['placeholder' => 'Повторите пароль']) ?>

            <div class="row">
                <div class="col-12">
                    <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary btn-block']) ?>
                </div>
                <div class="col-12">
                    <?= $form->field($model, 'agreement', [
                        'checkTemplate' => "\n{input}\n{label}\n{error}\n{hint}\n",
                        'options' => ['class' => 'icheck-primary'],
                    ])->checkbox(['class' => false, 'uncheck' => null])->label('Я принимаю условия <a href="#">Пользовательского соглашения</a>', ['class' => null]); ?>
                </div>
                <!-- /.col -->
                <!-- /.col -->
            </div>
            <?php ActiveForm::end(); ?>
            <?= Html::a('Я уже зарегистрирован', ['auth/auth/login'], ['class' => 'text-center']); ?>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
