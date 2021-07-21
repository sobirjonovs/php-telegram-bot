<?php

namespace Handlers\Admin;

use Bootstrap\Handler;
use Telegram\Bot\Objects\Message;

class ReceptionHandler extends Handler
{
    /**
     * @return Message
     */
    public function reception(): Message
    {
        return $this->answer('Salom, admin!');
    }
}