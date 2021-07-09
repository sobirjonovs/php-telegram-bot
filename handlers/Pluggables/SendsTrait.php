<?php

namespace Handlers\Pluggables;

use Telegram\Bot\Objects\Message;

trait SendsTrait
{
    /**
     * @param array $params
     * @return Message
     */
    public function sendMessage(array $params): Message
    {
        return $this->telegram->sendMessage($params);
    }

    /**
     * @param array $params
     * @return Message
     */
    public function sendPhoto(array $params): Message
    {
        return $this->telegram->sendPhoto($params);
    }
    /**
     * @param array $params
     * @return Message
     */
    public function sendDocument(array $params): Message
    {
        return $this->telegram->sendDocument($params);
    }

    /**
     * @param string $text
     * @param array $params
     * @return Message
     */
    public function answer(string $text, array $params = []): Message
    {
        return $this->sendMessage(array_merge([
            'chat_id' => $this->chat_id,
            'text' => $text,
        ], $params));
    }

    /**
     * @param string $caption
     * @param array $params
     * @return Message
     */
    public function photo(string $caption, array $params = []): Message
    {
        return $this->sendPhoto(array_merge([
            'chat_id' => $this->chat_id,
            'caption' => $caption,
        ], $params));
    }

    public function document(string $caption, array $params = []): Message
    {
        return $this->sendDocument(array_merge([
            'chat_id' => $this->chat_id,
            'caption' => $caption,
        ], $params));
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function answerCallbackQuery(array $params)
    {
        return $this->telegram->answerCallbackQuery($params);
    }

    /**
     * @param string $text
     * @param array $params
     * @return mixed
     */
    public function callbackAnswer(string $text, array $params = [])
    {
        return $this->answerCallbackQuery(array_merge([
            'callback_query_id' => $this->callback_query_id,
            'text' => $text,
        ], $params));
    }
}