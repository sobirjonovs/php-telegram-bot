<?php

/**
 * @var $handler Handler
 * */

use Handlers\Handler;

/**
 * Agar $handler->add('method', [array]) metodini
 * ikkinchi parametriga text kaliti yozilsa
 * bu Message obyektini text atributi ekanligini bildiradi
 * va asosiy handler klass bu update MessageHandlerga tegishliligini
 * tushunadi. Agar text o'rnida data bo'ladigan bo'lsa, callbackQueryHandler
 * -ga tegishliligini anglatadi.
 *
 *                #####ID bo'yicha tekshirish#####
 * Agar message obyektidagi chat id bo'yicha filterlamoqchi bo'lsak,
 * chat.id deb yozamiz. Masalan:
 * $handler->add('start', ['chat.id' => USER_ID]);
 *               #####Regex bo'yicha tekshirish#####
 * Agar regex ishlatmoqchi bo'lsak, quyidagicha yozamiz:
 *
 * $handler->add('start', ['text' => '/^\/start$/']);
 * Ya'ni, matn /start bilan boshlangan bo'lsa, uni
 * MessageHandler sinfini start metodiga yo'naltiradi.
 */

$handler->add('start', ['text' => '/start']);
$handler->add('inline', ['text' => '/getinline']);
$handler->add('data', ['data' => 'salom']);