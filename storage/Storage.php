<?php

namespace Storage;

use Exception;

/**
 * @method static getStorage()
 * @method static openStorage()
 * @method static writeStorage([] $array)
 */
class Storage
{
    public const OPEN = 'open';
    public const WRITE = 'write';
    public const READ = 'read';
    public const TYPES = ['open', 'read', 'write'];

    /**
     * @throws Exception
     */
    public static function __callStatic($name, $arguments)
    {
        $storageManager = new StorageManager();
        return $storageManager->dynamicAccessor(
            $name, static::getType($name), $arguments[0] ?? null
        );
    }

    /**
     * @param string $type
     * @return false|string
     */
    public static function getType(string $type)
    {
        foreach (self::TYPES as $localType) {
            if (strpos($type, $localType) !== false) {
                return $localType;
            }
        }
        return false;
    }
}