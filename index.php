<?php

require_once "vendor/autoload.php";

use Bootstrap\Api;
use Bootstrap\Handler;
use Telegram\Bot\Exceptions\TelegramSDKException;

try {
    $telegram = new Api(config('bot.token'));

    $handler = new Handler($telegram);
    $handler->map(['user', 'admin']);
} catch (TelegramSDKException $e) {
    file_put_contents('sdk_exception.log', $e->getMessage());
} catch (Exception $e) {
    file_put_contents('exception.log', $e->getMessage());
}
