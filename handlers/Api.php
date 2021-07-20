<?php

namespace Handlers;

use Payment\IpakYuli;
use Telegram\Bot\Api as BaseApi;
use Telegram\Bot\Objects\Message;

class Api extends BaseApi
{
    /**
     * @object IpakYuli
     */
    public $payment;

    /**
     * @param array $params
     * @return Message
     */
    public function answerCallbackQuery(array $params): Message
    {
        $response = $this->post('answerCallbackQuery', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Returns webhook updates sent by Telegram.
     * Works only if you set a webhook.
     *
     * @see setWebhook
     *
     * @return array
     */
    public function getWebhookUpdates(): array
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}