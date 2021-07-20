<?php

namespace Storage;

use Exception;

/**
 * Class StorageManager
 * @package Storage
 */
class StorageManager extends FileManager
{
    /**
     * @var
     */
    public $handle;

    public const PATH = "files";
    public const DS = DIRECTORY_SEPARATOR;
    public const DIR = __DIR__;
    public $name;
    /**
     * @var mixed
     */
    public $data;
    /**
     * @var mixed
     */
    public $derived_data;
    public $table;

    /**
     * @param $name
     * @param $type
     * @return mixed
     * @throws Exception
     */
    public function dynamicAccessor($name, $type, $data = null)
    {
        $this->name = $this->getFile($name);

        if ($type === Storage::OPEN) {
            $this->handle = $this->open($this->name);
            return $this;
        }

        if ($type === Storage::READ) {
            $this->handle = $this->open($this->getFile($name));
            $filesize = filesize($this->getFile($name));
            $file = $this->read($this->handle, $filesize);
            return unserialize($file);
        }

        if ($type === Storage::WRITE) {
            $this->handle = $this->open($this->getFile($name));
            return $this->insert($data);
        }

        throw new Exception("Couldn't find something meaningful");
    }

    /**
     * @param null $size
     * @param bool $close
     * @return string
     */
    public function reader($size = null, bool $close = true): string
    {
        $this->handle = $this->open($this->name);
        $file = parent::read($this->handle, filesize($this->handle));
        $this->rewind($this->handle);
        if ($close) {
            $this->close($this->handle);
        }
        return $file;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool
    {
        $this->put_contents($this->name, serialize($this->merge($data)));
        return true;
    }

    /**
     * @param string|null $key
     * @return mixed
     */
    public function get(string $key = null)
    {
        if ($key !== null) {
            return getNested($key, $this->derived_data);
        }
        return $this->derived_data;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return unserialize($this->get_contents($this->name));
    }

    /**
     * @param string $table
     * @return $this|bool
     */
    public function from(string $table)
    {
        $this->data = unserialize(
            $this->get_contents($this->name)
        );

        $this->derived_data = $this->data[$table] ?? [];
        $this->table = $table;
        return $this;
    }

    /**
     * @param $search
     * @param array|null $from
     * @param mixed ...$keys
     * @return bool
     */
    public function exists($search, array $from = null, ...$keys): bool
    {
        return array_key_exists(
            $search, array_column($from ?? $this->derived_data, ...$keys)
        );
    }

    /**
     * @param $needle_key
     */
    public function delete($needle_key)
    {
        function delete(&$data, $needle_key) {
            foreach ($data as $key => &$value) {
                if ($key === $needle_key) {
                    unset($data[$key]);
                }
                if (is_array($value)) {
                    delete($value, $needle_key);
                }
            }
            return $data;
        }
        $replaced_data = [
            $this->table => delete($this->derived_data, $needle_key)
        ];
        $this->put_contents($this->name, serialize(array_replace($this->data, $replaced_data)));
    }

    /**
     * @param array $data
     * @return array
     */
    public function merge(array $data): array
    {
        return array_replace_recursive(
            unserialize($this->get_contents($this->name)) ?: [], $data
        );
    }

    /**
     * @param string $name
     * @return string
     */
    public function getFile(string $name): string
    {
        $fileName = explode("_", snake_case($name));
        $filePath = self::DIR . self::DS . self::PATH . self::DS . end($fileName) . '.txt';
        if (file_exists($filePath)) {
            return $filePath;
        }
        $this->open($filePath, 'w');
        return $filePath;
    }
}
