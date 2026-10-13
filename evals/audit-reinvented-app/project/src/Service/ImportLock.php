<?php

namespace App\Service;

final class ImportLock
{
    /** @var resource|null */
    private $handle = null;

    public function __construct(private readonly string $path = '/tmp/acme-import.lock')
    {
    }

    public function acquire(): bool
    {
        $this->handle = fopen($this->path, 'c');
        if (false === $this->handle) {
            throw new \RuntimeException('Cannot open the lock file.');
        }

        return flock($this->handle, LOCK_EX | LOCK_NB);
    }

    public function release(): void
    {
        if (null !== $this->handle) {
            flock($this->handle, LOCK_UN);
            fclose($this->handle);
            $this->handle = null;
        }
    }
}
