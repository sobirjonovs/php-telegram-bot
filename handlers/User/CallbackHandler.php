<?php

namespace Handlers\User;

use Bootstrap\Handler;

class CallbackHandler extends Handler
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