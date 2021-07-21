<?php

namespace Handlers\User;

use Bootstrap\Handler;
use Telegram\Bot\Objects\Message;

class WelcomeHandler extends Handler
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
}