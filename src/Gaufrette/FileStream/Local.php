<?php

namespace Gaufrette\FileStream;

use Gaufrette\FileStream;
use Gaufrette\StreamMode;

/**
 * Local stream
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class Local implements FileStream
{
    private $path;
    private $fileHandle;

    /**
     * Constructor
     *
     * @param  string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * {@inheritDoc}
     */
    public function open(StreamMode $mode)
    {
        $fileHandle = fopen($this->path, $mode->getMode());

        if (false === $fileHandle) {
            return false;
        }

        $this->mode = $mode;
        $this->fileHandle = $fileHandle;

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function read($count)
    {
        return fread($this->fileHandle, $count);
    }

    /**
     * {@inheritDoc}
     */
    public function write($data)
    {
        return fwrite($this->fileHandle, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function close()
    {
        $closed = fclose($this->fileHandle);

        if ($closed) {
            $this->mode = null;
            $this->fileHandle = null;
        }

        return $closed;
    }

    /**
     * {@inheritDoc}
     */
    public function flush()
    {
        return fflush($this->fileHandle);
    }

    /**
     * {@inheritDoc}
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        return fseek($this->fileHandle, $offset, $whence);
    }

    /**
     * {@inheritDoc}
     */
    public function tell()
    {
        return ftell($this->fileHandle);
    }

    /**
     * {@inheritDoc}
     */
    public function eof()
    {
        return feof($this->fileHandle);
    }
}
