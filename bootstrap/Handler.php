<?php

namespace Bootstrap;

use Bootstrap\Pluggables\KeyboardsTrait;
use Bootstrap\Pluggables\SendsTrait;
use Storage\Storage;
use Storage\StorageManager;

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
     * @var StorageManager
     */
    public $storage;
    /**
     * @var bool
     */
    private $isRelated;
    /**
     * @var false|string
     */
    public $type;

    /**
     * Handler constructor.
     * @param Api $telegram
     */
    public function __construct(Api $telegram)
    {
        $this->update = $telegram->getWebhookUpdates();
        $this->telegram = $telegram;
        $this->storage = Storage::openStorage();
        $this->assignUpdates();
    }

    /**
     * Parses updates
     */
    private function assignUpdates()
    {
        if (isset($this->update['message'])) {
            $this->messageUpdate();
        }

        if (isset($this->update['callback_query'])) {
            $this->callbackUpdate();
        }
    }

    /**
     * Processes callback query updates
     */
    private function callbackUpdate()
    {
        $this->chat_id = $this->update('callback_query.message.chat.id');
        $this->callback_data = $this->update('callback_query.data');
        $this->callback_query_id = $this->update('callback_query.id');
        $this->message_id = $this->update('callback_query.message.message_id');
        $this->name = $this->update('callback_query.message.chat.first_name');
    }

    /**
     * Processes message updates
     */
    private function messageUpdate()
    {
        $this->from = $this->update('message.from');
        $this->text = $this->update('message.text');
        $this->chat_id = $this->update('message.chat.id');
        $this->name = $this->update('message.chat.first_name');
    }

    /**
     * @param string $target
     * @param string|null $customValue
     * @return bool|string|null
     */
    private function update(string $target, string $customValue = null)
    {
        if (isset($this->update)) {
            $this->type = strstr($target, '.', true);
            $updateValue = getNested($target, $this->update);
            if ($customValue) {
                return $updateValue == $customValue;
            }
            return $updateValue;
        }
        return null;
    }

    /**
     * @param array $condition
     * @return $this
     */
    public function when(array $condition): Handler
    {
        $this->isRelated = $this->isRelatedUpdate($condition);
        return $this;
    }

    /**
     * @param string $class
     * @param string $method
     * @return false|mixed|void
     */
    public function do(string $class, string $method)
    {
        if ($this->isRelated) {
            return call_user_func([new $class($this->telegram), $method]);
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
     * @param string $key
     * @return string
     */
    private function getUpdateType(string $key): string
    {
        return "{$this->type}.$key";
    }

    /**
     * This method scans *_handler.php file in each handlers/$path folder
     * @param array $filePath
     */
    public function map(array $filePath)
    {
        foreach ($filePath as $path) {
            foreach(glob($this->getPath(ucfirst(strtolower($path)))) as $file) {
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
        return __DIR__ . "/../handlers/" . $path . "/" . '*' . self::TARGET_FILE;
    }
}
