<?php

declare(strict_types=1);

namespace console\controllers;

use core\entities\User\User;
use core\repositories\exceptions\NotFoundException;
use core\useCases\UserManageService;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class RoleController extends Controller
{
    private $service;

    public function __construct($id, $module, UserManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @throws NotFoundException
     */
    public function actionAssign(): void
    {
        $username = $this->prompt('Username:', ['required' => true]);
        $user = $this->findModel($username);
        $role = $this->select('Role:', ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'));
        $this->service->assignRole($user->id, $role);
        $this->stdout('Done!' . PHP_EOL);
    }

    /**
     * @param $username
     * @return User
     * @throws NotFoundException
     */
    private function findModel($username): User
    {
        if (!$model = User::findOne(['username' => $username])) {
            throw new NotFoundException('User is not found');
        }
        return $model;
    }
}
