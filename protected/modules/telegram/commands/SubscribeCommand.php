<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

class SubscribeCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'subscribe';

    /**
     * @var string
     */
    protected $description = 'Subscribe user to messages from bot';
    protected $successResponseText = 'You successfuly subscribed on bot messages.';
    protected $failResponseText = 'Wrong password.';

    /**
     * @var string
     */
    protected $usage = '/subscribe <password>';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * Conversation Object
     *
     * @var \Longman\TelegramBot\Conversation
     */
    protected $conversation;


    /**
     * Command execute method
     *
     * @return mixed
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        $message  = $this->getMessage();
        $chatId   = $message->getChat()->getId();
        $text     = trim($message->getText(true));
        $password = \Yii::app()->getModule('telegram')->telegramBot->password;

        if ( $password === null ){
            // Without password
            $this->saveChatId( $chatId );
            $responseText = $this->successResponseText;
        } else {

            if ($text === ''){
                $responseText = 'Command usage: ' . $this->getUsage();
            } else {

                if ( $text === $password ){
                    $this->saveChatId( $chatId );
                    $responseText = $this->successResponseText;
                } else {
                    $responseText = $this->failResponseText;
                }
            }
        }


        $response = [
            'chat_id' => $chatId,
            'text'    => $responseText,
        ];

        return Request::sendMessage($response);
    }

    private function saveChatId($chatId)
    {
        $chatIdFilePath = \Yii::app()->getModule('telegram')->telegramBot->chatIdFilePath;
        if (file_exists( $chatIdFilePath )) {
            $savedIds = file_get_contents( $chatIdFilePath );
            $savedIds = explode(",", $savedIds);
            array_push($savedIds, $chatId);
            $savedIds = array_unique($savedIds);
        } else {
            $savedIds = [$chatId];
        }

        return file_put_contents( $chatIdFilePath, implode(",", $savedIds));
    }
}
