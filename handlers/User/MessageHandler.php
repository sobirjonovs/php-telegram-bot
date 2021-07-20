<?php

namespace Handlers\User;

use Handlers\Handler;
use Telegram\Bot\Objects\Message;

class MessageHandler extends Handler
{
    /**
     * @return Message
     */
    public function start(): Message
    {
        $keyboard = $this->keyboard([
            [
                'Matn 1', 'Matn 2'
            ],
            [
                'Matn 3', 'Matn 4'
            ]
        ]);

        return $this->answer("Assalomu alaykum!", [
            'reply_markup' => $keyboard,
            'parse_mode' => 'markdown'
        ]);
    }

    /**
     * @return Message
     */
    public function inline(): Message
    {
        $inline = $this->inlineKeyboard([
            [
                'text' => "Inlayn 1", 'callback_data' => 'salom'
            ]
        ]);

        return $this->answer("Inlayn namuna", [
            'reply_markup' => $inline
        ]);
    }
}