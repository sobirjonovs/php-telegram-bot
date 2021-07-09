<?php

namespace Handlers\User;

use Handlers\Handler;
use Telegram\Bot\Objects\Message;

class MessageHandler extends Handler
{
    public function start(): Message
    {
        $inline_button = $this->inlineKeyboard([
            ['text' => 'Inlayn tugma', 'callback_data' => 'tugma']
        ]);
        return $this->document("Test uchun rasm", [
            'document' => 'aaaa.jpg',
            'reply_markup' => $inline_button
        ]);
    }
}