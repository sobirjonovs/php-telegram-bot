<?php

namespace Handlers\User;

use Handlers\Handler;
use Telegram\Bot\Objects\Message;

class CallbackQueryHandler extends Handler
{
    /**
     * @return mixed
     */
    public function data()
    {
        return $this->callbackAnswer("Men bosildim!", [
            'show_alert' => true
        ]);
    }
}