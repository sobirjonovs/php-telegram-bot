<?php

namespace Handlers;

use Handlers\Pluggables\KeyboardsTrait;
use Handlers\Pluggables\SendsTrait;
use Handlers\User\CallbackQueryHandler;
use Handlers\User\MessageHandler;
use Storage\FileManager;
use Storage\Storage;
use Storage\StorageManager;
use function snake_case;

/**
 * Class Handler
 * @package Handlers
 */
class Handler
{
    use KeyboardsTrait, SendsTrait;

    /**
     * Hendler funksiyalari yoziladigan faylning kengaytmasi
     */
    public const TARGET_FILE = "_handler.php";

    /**
     * @var
     */
    public $chat_id;

    /**
     * @var
     */
    public $message;

    /**
     * @var
     */
    public $from;

    /**
     * @var
     */
    public $text;
    /**
     * @array
     */
    public $update;
    /**
     * @var Api
     */
    public $telegram;
    /**
     * @var
     */
    public $payment;
    /**
     * @var mixed|null
     */
    public $callback_query_id;
    /**
     * @var mixed|null
     */
    public $callback_data;
    /**
     * @var mixed|null
     */
    public $message_id;
    /**
     * @var mixed|null
     */
    public $name;
    /**
     * @var CallbackQueryHandler|MessageHandler|void
     */
    public $handler;
    /**
     * @var StorageManager
     */
    public $storage;

    /**
     * Handler constructor.
     * @param Api $telegram
     */
    public function __construct(Api $telegram)
    {
        $this->update = $telegram->getWebhookUpdates();
        $this->telegram = $telegram;
        $this->storage = Storage::openStorage();
        $this->assignUpdates(false);
    }

    /**
     * Parses updates
     * @return MessageHandler|CallbackQueryHandler|void
     */
    private function assignUpdates($handler = true)
    {
        if (isset($this->update['message'])) {
            $this->messageUpdate($handler);
        }

        if (isset($this->update['callback_query'])) {
            $this->callbackUpdate($handler);
        }
    }

    /**
     * Processes callback query updates
     * @return CallbackQueryHandler|void
     */
    private function callbackUpdate($handler = false)
    {
        $this->chat_id = $this->update('callback_query.message.chat.id');
        $this->callback_data = $this->update('callback_query.data');
        $this->callback_query_id = $this->update('callback_query.id');
        $this->message_id = $this->update('callback_query.message.message_id');
        $this->name = $this->update('callback_query.message.chat.first_name');

        if ($handler) {
            $this->handler = new CallbackQueryHandler($this->telegram);
        }
    }

    /**
     * Processes message updates
     * @return MessageHandler|void
     */
    private function messageUpdate($handler = false)
    {
        $this->from = $this->update('message.from');
        $this->text = $this->update('message.text');
        $this->chat_id = $this->update('message.chat.id');
        $this->name = $this->update('message.chat.first_name');

        if ($handler) {
            $this->handler = new MessageHandler($this->telegram);
        }
    }

    /**
     * @param string $target
     * @param string|null $customValue
     * @return bool|string|null
     */
    private function update(string $target, string $customValue = null)
    {
        if (isset($this->update)) {
            $updateValue = getNested($target, $this->update);
            if ($customValue) {
                return $updateValue == $customValue;
            }
            return $updateValue;
        }
        return null;
    }

    /**
     * @param string $method
     * @param array $condition
     * @return false|mixed|void
     */
    public function add(string $method, array $condition = [])
    {
        $this->assignUpdates();
        if ($this->isRelatedUpdate($condition)) {
            return call_user_func([$this->handler, $method]);
        }
    }

    /**
     * @param array $condition
     * @return bool
     */
    private function isRelatedUpdate(array $condition): bool
    {
        return $this->filterUpdate($condition, true);
    }

    /**
     * @return string
     */
    public function pattern(): string
    {
        return "#^(\/|\#|\~)([\|\(\)\{\}\s\\\\\/a-zA-Z0-9-\[\]\^\$\~\+_.]+)(\/|\#|\~)$#";
    }

    /**
     * @param array $condition
     * @param bool $check_array_count
     * @return array|bool
     */
    public function filterUpdate(array $condition, bool $check_array_count = false)
    {
        $filteredUpdate = array_filter($condition, function ($update, $type) {
            if (preg_match($this->pattern(), $update)) {
                if (preg_match($update, $this->update($this->getUpdateType($type)))) {
                    return true;
                }
            }
            return $this->update($this->getUpdateType($type), $update);
        }, ARRAY_FILTER_USE_BOTH);

        if ($check_array_count) {
            return $filteredUpdate && count($filteredUpdate) == count($condition);
        }
        return $filteredUpdate;
    }

    /**
     * @param string $className
     * @return false|mixed
     */
    private function getClassName(string $className)
    {
        $className = explode("\\", $className);
        return end($className);
    }

    /**
     * @param string $update_key
     * @return string
     */
    private function getUpdateType(string $update_key): string
    {
        return snake_case($this->getClassName(get_class($this->handler))) . '.' . $update_key;
    }

    /**
     * This method scans *_handler.php file in each handlers/$path folder
     * @param array $filePath
     */
    public function map(array $filePath)
    {
        foreach ($filePath as $path) {
            foreach(glob($this->getPath($path)) as $file) {
                $handler = $this;
                require_once $file;
            }
        }
    }

    /**
     * @param string $path
     * @return string
     */
    private function getPath(string $path): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . '*' . self::TARGET_FILE;
    }
}
