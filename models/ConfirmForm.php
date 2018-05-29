<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ConfirmForm is the model behind the confirm form.
 *
 */
class ConfirmForm extends Model
{
    public $confirmToken;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['confirmToken', 'integer'],
            ['confirmToken', 'required'],
        ];
    }

    /**
     * Validates the confirm token.
     */
    public function validateConfirmToken()
    {
        if (!$this->validate()) {
            return null;
        }
        if (!User::findByConfirmToken($this->confirmToken)) {
            $this->addError('Incorrect confirm token');
            return false;
        }
        else {
            $user = User::findByConfirmToken($this->confirmToken);
            $user->status = User::STATUS_ACTIVE;
            return true;
        }
    }
}