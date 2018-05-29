<?php

namespace app\models;

use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $username_tlgrm;
    public $password;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username_tlgrm', 'trim'],
            ['username_tlgrm', 'required'],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i'],
            ['username_tlgrm', 'string', 'min' => 5, 'max' => 255],
            ['username_tlgrm', 'filter', 'filter' => function ($value) {return strpos($value, '@') ?  $value : '@' .  $value;}],
            ['username_tlgrm', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username telegram has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $user->username = $this->username;
        $user->username_tlgrm = $this->username_tlgrm;
        $user->status = User::STATUS_WAIT;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateConfirmToken();

        return $user->save() ? $user : null;
    }
}