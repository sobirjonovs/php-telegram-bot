<?php

namespace Handlers\Admin;

use Bootstrap\Handler;

/**
 * @var $handler Handler
 * */

$handler->when(['text' => '/reception'])
    ->do(ReceptionHandler::class, 'reception');