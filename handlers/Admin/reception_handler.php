<?php

namespace Handlers\Admin;

use Bootstrap\Handler;

/**
 * @var $handler Handler
 * */

$handler->when(['text' => '/product'])->do(ReceptionHandler::class, 'reception');