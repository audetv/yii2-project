<?php

declare(strict_types=1);

namespace core\entities\User;

use core\entities\AggregateRoot;
use core\entities\EventTrait;
use core\entities\User\events\UserSignUpConfirmed;
use core\entities\User\events\UserSignupRequested;
use DomainException;
use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class User
 * @property int id
 * @property string|null username
 * @property string|null auth_key
 * @property mixed|null password_hash
 * @property mixed|string|null password_reset_token
 * @property mixed|string|null email
 * @property mixed|null email_confirm_token
 * @property mixed|null status
 * @property int created_at
 * @property int updated_at
 * @package core\entities\User
 * @author Aleksey Gusev <audetv@gmail.com>
 */
class User extends ActiveRecord implements AggregateRoot
{
    use EventTrait;

    const STATUS_WAIT = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @return static
     * @throws Exception
     */
    public static function create(string $username, string $email, string $password): self
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword(!empty($password) ? $password : Yii::$app->security->generateRandomString());
        $user->status = self::STATUS_ACTIVE;
        $user->auth_key = Yii::$app->security->generateRandomString();
        return $user;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws Exception
     */
    private function setPassword(string $password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @return static
     * @throws Exception
     */
    public static function requestSignup(string $username, string $email, string $password): self
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->status = self::STATUS_WAIT;
        $user->email_confirm_token = Yii::$app->security->generateRandomString();
        $user->generateAuthKey();
        $user->recordEvent(new UserSignUpRequested($user));
        return $user;
    }

    /**
     * @throws Exception
     */
    private function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername(string $username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public function edit(string $username, string $email): void
    {
        $this->username = $username;
        $this->email = $email;
    }

    public function editProfile(string $email): void
    {
        $this->email = $email;
    }

    public function confirmSignup(): void
    {
        if (!$this->isWait()) {
            throw new DomainException('User is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
        $this->email_confirm_token = null;
        $this->recordEvent(new UserSignUpConfirmed($this));
    }

    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    /**
     * @throws Exception
     */
    public function requestPasswordReset(): void
    {
        if (!empty($this->password_reset_token) && self::isPasswordResetTokenValid($this->password_reset_token)) {
            throw new DomainException('Сброс пароля уже запрошен');
        }
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid(string $token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @param $password
     * @throws Exception
     */
    public function resetPassword($password): void
    {
        if (empty($this->password_reset_token)) {
            throw new DomainException('Password resetting is not requested.');
        }
        $this->setPassword($password);
        $this->password_reset_token = null;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
