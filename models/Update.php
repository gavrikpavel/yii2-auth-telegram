<?php

namespace app\models;

use app\models\User;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "update".
 *
 * @property int $id
 * @property string $username
 * @property int $update_id
 * @property int $chat_id
 * @property string $type
 * @property boolean $is_bot
 * @property string $text
 * @property int $user_id
 *
 */
class Update extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'update';
    }

    /**
     * @return int $update_id
     */
    public function getOffset()
    {
        $update = Update::find()->orderBy('id DESC')->limit(1)->one();
        return is_null($update) ? 0 : $update->update_id + 1;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function saveUpdate($data)
    {
        $update = new Update();
        $this->username = $data['username'];
        $this->update_id = $data['update_id'];
        $this->chat_id = $data['chat_id'];
        $this->type = $data['type'];
        $this->is_bot = $data['is_bot'];
        $this->text = $data['text'];
        $this->user_id = User::findOne(['username_tlgrm' => $data['username']])->id;

        return $this->save(false) ? $update : null;
    }
}
