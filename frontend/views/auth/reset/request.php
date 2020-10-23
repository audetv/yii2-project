<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;


$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-logo">
        <?= Html::a(Yii::$app->name, ['site/index']) ?>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Вы забыли свой пароль? Введите email, указанный вами при регистрации.</p>
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
            <form action="recover-password.html" method="post">
                <?php $emailTemplate = "<div class=\"input-group mb-3\">\n{input}\n<div class=\"input-group-append\">
                        <div class=\"input-group-text\">
                            <span class=\"fas fa-envelope\"></span>
                        </div>
                    </div>\n{hint}\n{error}"; ?>
                    <?= $form->field($model, 'email', ['template' => $emailTemplate])->textInput(['autofocus' => true, 'placeholder' => 'Email']) ?>
                <div class="row">
                    <div class="col-12">
                        <?= Html::submitButton('Запрос нового пароля', ['class' => 'btn btn-primary btn-block']) ?>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <?php ActiveForm::end(); ?>

            <p class="mt-3 mb-1">
                <?= Html::a('Вход', ['auth/auth/login']); ?>
            </p>
            <p class="mb-0">
                <?= Html::a('У меня еще нет аккаунта. Регистрация', ['auth/signup/request'], ['class' => 'text-center']); ?>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->
