<?php

namespace Handlers\User;

use Bootstrap\Handler;

/**
 * @var $handler Handler
 * */

$handler->when(['data' => 'salom'])
    ->do(CallbackHandler::class, 'data');