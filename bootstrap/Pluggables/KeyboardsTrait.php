<?php

namespace Bootstrap\Pluggables;

trait KeyboardsTrait
{
    /**
     * @param array $params
     * @param array $options
     * @return string
     */
    public function inlineKeyboard(array $params, array $options = []): string
    {
        return $this->telegram->replyKeyboardMarkup([
            'inline_keyboard' => [
                $params
            ], $options
        ]);
    }

    /**
     * @param array $keyboard
     * @param bool $resize_keyboard
     * @param bool $one_time_keyboard
     * @return mixed
     */
    public function keyboard(array $keyboard, bool $resize_keyboard = true, bool $one_time_keyboard = true)
    {
        return $this->telegram->replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => $resize_keyboard,
            'one_time_keyboard' => $one_time_keyboard
        ]);
    }

    /**
     * @return mixed
     */
    public function forceReply()
    {
        return $this->telegram->forceReply();
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function keyboardMarkup(array $params)
    {
        return $this->telegram->replyKeyboardMarkup($params);
    }

    /**
     * @return mixed
     */
    public function hideKeyboard()
    {
        return $this->telegram->replyKeyboardHide();
    }
}