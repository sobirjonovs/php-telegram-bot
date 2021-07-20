<?php

require_once "vendor/autoload.php";

use Handlers\Api;
use Payment\IpakYuli;
use Handlers\Handler;
use Telegram\Bot\Exceptions\TelegramSDKException;

try {
    $telegram = new Api(config('bot.token'));
    $telegram->payment = new IpakYuli();

    $handler = new Handler($telegram);
    $handler->map(['User']);
} catch (TelegramSDKException | Exception $e) {
    file_put_contents('error.log', $e->getMessage());
}