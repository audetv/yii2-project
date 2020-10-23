<?php

namespace frontend\controllers\auth;

use core\repositories\exceptions\NotFoundException;
use core\useCases\auth\PasswordResetService;
use DomainException;
use Yii;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use core\forms\auth\PasswordResetRequestForm;
use core\forms\auth\ResetPasswordForm;
use yii\web\Response;

class ResetController extends Controller
{
    public $layout = 'auth';

    private $service;

    public function __construct($id, $module, PasswordResetService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return string|Response
     * @throws NotFoundException
     * @throws Exception
     */
    public function actionRequest()
    {
        $form = new PasswordResetRequestForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->request($form);
                Yii::$app->session->setFlash('success', 'На ваш электронный адрес было отправлено письмо со ссылкой для восстановления пароля. Пройдите по ссылке и придумайте новый пароль.');
                return $this->goHome();
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('request', [
            'model' => $form,
        ]);
    }

    /**
     * @param $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionConfirm($token)
    {
        try {
            $this->service->validateToken($token);
        } catch (DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $form = new ResetPasswordForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->reset($token, $form);
                Yii::$app->session->setFlash('success', 'Отлично, ваш пароль был успешно изменен! Теперь вы можете войти.');
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->goHome();
        }

        return $this->render('confirm', [
            'model' => $form,
        ]);
    }
}
