<?php

declare(strict_types=1);

namespace console\controllers;

use core\forms\User\UserCreateForm;
use core\useCases\UserManageService;

use Exception;
use yii\console\Controller;

class UserController extends Controller
{
    /**
     * @var UserManageService
     */
    private $service;

    public function __construct($id, $module, UserManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @throws \Throwable
     */
    public function actionCreate(): void
    {
        $message = 'Done!';
        $username = $this->prompt('Username:', ['required' => true]);
        $email = $this->prompt('Email:', ['required' => true]);
        $password = $this->prompt('Password:', ['required' => true]);

        $model = new UserCreateForm();
        $model->load([
            'username' => $username,
            'email' => $email,
            'password' => $password
        ], '');

        try {
            $this->service->create($model);
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        $this->stdout($message . PHP_EOL);
    }
}
