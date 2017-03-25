<?php
use \Longman\TelegramBot\Exception\TelegramException;


class DoController extends Controller
{
    public function actionIndex(){

        //try {
        $telegram = $this->module->telegramBot->bot;
        // Handle telegram webhook request
        $telegram->handle();
        //} catch (TelegramException $e) {
        //    echo $e->getMessage();
        //}
    }

    public function actionSetwebhook(){

        $telegram = new Longman\TelegramBot\Telegram( $this->module->telegramBot->token, $this->module->telegramBot->botName );
        $result = $telegram->setWebhook( $this->module->telegramBot->webhookUrl );
        if ($result->isOk()) {
            echo 'WebhookUrl: '.$this->module->telegramBot->webhookUrl."<br>\n";
            echo $result->getDescription()."<br>\n";
        }
    }
}