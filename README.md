# telegramBot
Telegram bot Yii1 based on [akalongman/php-telegram-bot](https://github.com/akalongman/php-telegram-bot) for messaging with password protection.

## Installation

1. Install https://github.com/akalongman/php-telegram-bot via composer.
Follow the instructions in README.md of this rep.
Don\`t forget to add `require __DIR__ . '/vendor/autoload.php';` before all createApplication and createConsoleApplication.



2. Add to configuration file:

    ```
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
            ],
        ],
    ],
    ```
    
3. Set webhook by url in browser:
    ```
    https://<domain.ru>/telegram/do/setwebhook
    ```
    HTTPS is required by Telegram.
 

4. Each subscriber should find your bot by name in Telegram (for example: `@my_bot`)

5. Subscribe to messages by sending command (password - from configuration):
    ```
    /subscribe <password>
    ```
    
6. Send message from your code like this:
    ```
    Yii::app()->getModule('telegram')->telegramBot->sendMessage('Hello world');
    ```
    All subscribers will receive your message.