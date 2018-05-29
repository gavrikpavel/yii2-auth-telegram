<?php

namespace app\components\bot\jobs;

use app\components\bot\TelegramBotTrait;
use app\models\Update;
use app\models\User;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class UpdateJob extends BaseObject implements JobInterface
{
    use TelegramBotTrait;

    public $offset;

    public function execute($queue)
    {
        $model = new Update();

        // Getting update from Telegram
        $updateData = $this->request('getUpdates', ['offset' => $this->offset]);
        if ($updateData) {
            if ($update = $model->saveUpdate($updateData)) {
                // Sending confirm token to Telegram
                $confirmToken = User::findOne(['id' => $update->user_id])->confirm_token;
                $this->request('sendMessages', [
                        'chatId' => $update->chat_id,
                        'text' => $confirmToken
                ]);
            }
        }
        else {
            $this->execute($queue);
        }
    }
}