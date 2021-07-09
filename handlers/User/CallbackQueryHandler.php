<?php

namespace Handlers\User;

use Handlers\Handler;
use Telegram\Bot\Objects\Message;

class CallbackQueryHandler extends Handler
{
    public function hello(): Message
    {
        return $this->answer('Salom!', [
            'show_alert' => true
        ]);
    }
}