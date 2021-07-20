<?php

namespace Storage;

interface FileInterface
{
    /**
     * @param string $file
     * @param string $mode
     * @return mixed
     */
    public function open(string $file, string $mode);

    /**
     * @param resource $handle
     * @param int|string $size
     * @return mixed
     */
    public function read($handle, $size);

    /**
     * @param resource $handle
     * @param string|int $data
     * @return mixed
     */
    public function write($handle, $data);

    /**
     * @return mixed
     */
    public function close($handle): bool;
}