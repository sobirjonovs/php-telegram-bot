<?php

namespace Storage;

/**
 * Class FileManager
 * @package Storage
 */
class FileManager implements FileInterface
{
    /**
     * @param string $file
     * @param string $mode
     * @return false|resource
     */
    public function open(string $file, string $mode = "r+")
    {
        return fopen($file, $mode);
    }

    /**
     * @param resource $handle
     * @param int|string $size
     * @return string
     */
    public function read($handle, $size): string
    {
        return fread($handle, $size);
    }

    /**
     * @param resource $handle
     * @param int|string $data
     * @return int
     */
    public function write($handle, $data): int
    {
        return fwrite($handle, $data);
    }

    /**
     * @param $handle
     * @return bool
     */
    public function close($handle): bool
    {
        return fclose($handle);
    }

    /**
     * @param $handle
     * @return bool|string
     */
    public function gets($handle)
    {
        return fgets($handle);
    }

    /**
     * @param $handle
     * @param int $position
     * @return int
     */
    public function seek($handle, int $position): int
    {
        return fseek($handle, $position);
    }

    /**
     * @param $handle
     * @return bool
     */
    public function rewind($handle): bool
    {
        return rewind($handle);
    }

    /**
     * @param string $filename
     * @param bool $include_path
     * @param null $context
     * @param int $offset
     * @param int|null $length
     * @return false|string
     */
    public function get_contents(
        string $filename,
        bool $include_path = false,
        $context = null,
        int $offset = 0
    )
    {
        return file_get_contents($filename, $include_path, $context, $offset);
    }

    /**
     * @param string $filename
     * @param $data
     * @param int $flags
     * @param null $context
     * @return false|int
     */
    public function put_contents(
        string $filename,
        $data,
        int $flags = 0,
        $context = null
    )
    {
        return file_put_contents($filename, $data, $flags, $context);
    }
}