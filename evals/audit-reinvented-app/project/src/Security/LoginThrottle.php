<?php

namespace App\Security;

final class LoginThrottle
{
    private const int MAX_FAILURES = 5;
    private const int WINDOW_SECONDS = 60;

    public function isBlocked(string $ip, string $username): bool
    {
        return (int) apcu_fetch($this->key($ip, $username)) >= self::MAX_FAILURES;
    }

    public function recordFailure(string $ip, string $username): void
    {
        $key = $this->key($ip, $username);
        if (!apcu_add($key, 1, self::WINDOW_SECONDS)) {
            apcu_inc($key);
        }
    }

    public function reset(string $ip, string $username): void
    {
        apcu_delete($this->key($ip, $username));
    }

    private function key(string $ip, string $username): string
    {
        return 'login_failures_'.sha1($ip.'|'.strtolower($username));
    }
}
