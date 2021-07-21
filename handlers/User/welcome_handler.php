<?php

namespace Handlers\User;

use Bootstrap\Handler;

/**
 * @var $handler Handler
 * */

$handler->when(['text' => '/start'])
    ->do(WelcomeHandler::class, 'start');