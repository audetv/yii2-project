<?php

declare(strict_types=1);

namespace common\auth;

use core\entities\User\User;
use core\readModels\UserReadRepository;
use OAuth2\Storage\UserCredentialsInterface;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\di\NotInstantiableException;
use yii\web\IdentityInterface;

class Identity implements IdentityInterface, UserCredentialsInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param int|string $id
     * @return Identity|IdentityInterface|null
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     * @throws \Throwable
     */
    public static function findIdentity($id): ?self
    {
        $user = self::getRepository()->findActiveById($id);
        return $user ? new self($user): null;
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return Identity|IdentityInterface|null
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     * @throws \Throwable
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $data = self::getOauth()->getServer()->getResourceController()->getToken();
        return !empty($data['user_id']) ? static::findIdentity($data['user_id']) : null;
    }

    public function getId(): int
    {
        return $this->user->id;
    }

    public function getUsername(): string
    {
        return ($this->user->username) ? $this->user->username : $this->user->email;
    }

    public function getAuthKey(): string
    {
        return $this->user->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public function checkUserCredentials($username, $password): bool
    {
        if (!$user = self::getRepository()->findActiveByUsername($username)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    /**
     * @param mixed $username
     * @return array
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public function getUserDetails($username): array
    {
        $user = self::getRepository()->findActiveByUsername($username);
        return ['user_id' => $user->id];
    }

    /**
     * @return UserReadRepository
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    private static function getRepository(): UserReadRepository
    {
        return Yii::$container->get(UserReadRepository::class);
    }

    /**
     * @return Module
     */
    private static function getOauth(): Module
    {
        return Yii::$app->getModule('oauth2');
    }
}
