<?php

/**
 * Usage:
 *
 * 1) Install https://github.com/akalongman/php-telegram-bot via composer
 *      Not forget to add "require __DIR__ . '/vendor/autoload.php';" before all createApplication and createConsoleApplication.
 *
 * 2) Add configuration:
        'modules' => [
            'telegram' => [
                'components' => [
                    'telegramBot' => [
                        'class' => 'application.modules.telegram.components.TelegramBot',
                        'token' => '123456789:ABCDef-gFsadasdlksajdmlksaasdjldkc', // Get from @BotFather in Telegram
                        'botName' => 'botname',  // Set by @BotFather in Telegram
                        'webhookUrl' => 'https://<domain.ru>/telegram/do/', // Insert your domain name
                        'commandsFolder' => 'application.modules.telegram.commands',
                        'password' => '1234567890', // null if without password
                    ],
                ]
            ]
        ],
 *
 * 3) Set webhook by url in browser:
        https://<domain.ru>/telegram/do/setwebhook
 *      HTTPS is required by Telegram.
 *
 * 4) Each subscriber should find your bot by name in Telegram (for example: @my_bot)
 *
 * 5) Subscribe to messages by sending command (password - from configuration):
        /subscribe <password>
 *
 * 6) Send message from your code like this:
        Yii::app()->getModule('telegram')->telegramBot->sendMessage('Hello world');
 *      All subscribers will receive your message.
 *
 */
use \Longman\TelegramBot\Telegram;
use \Longman\TelegramBot\Request;

class TelegramBot extends CApplicationComponent
{
    public $token;
    public $bot;
    public $password;
    public $botName;
    public $webhookUrl;
    public $commandsFolder = 'application.modules.telegram.commands';

    public $chatIdFilename = "chatList.dat";
    public $chatIdPath;
    public $chatIdFilePath;

    public function init()
    {
        $this->bot = new Telegram( $this->token, $this->botName );

        if ( $this->commandsFolder ){
            // Set commands folder
            $this->bot->addCommandsPath( Yii::getPathOfAlias($this->commandsFolder).DIRECTORY_SEPARATOR );
        }

        if ( !$this->chatIdPath ) $this->chatIdPath = __DIR__;
        $this->chatIdFilePath = $this->chatIdPath . DIRECTORY_SEPARATOR . $this->chatIdFilename;
    }


    /**
     * Send messages to all subscribers, saved to file
     * @param $message
     * @param array $chatIdList
     */
    public function sendMessage($message)
    {
        $chatIdList = [];
        // Try to get chatId list from file
        if ( file_exists($this->chatIdFilePath) ) {
            $chatIdListString = file_get_contents($this->chatIdFilePath);
            $chatIdList = explode(",", $chatIdListString);
        }

        $this->sendMessageByChatIdList($message, $chatIdList);
    }


    /**
     * Send messages to chatIds
     * @param $message
     * @param array $chatIdList
     */
    public function sendMessageByChatIdList($message, $chatIdList = [])
    {
        foreach ($chatIdList as $chatId) {

            $result = Request::sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        }
    }
}

?>