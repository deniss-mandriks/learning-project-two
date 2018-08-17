<?php

namespace App\Services;

class SessionService
{

    public function all(): array
    {
        return $_SESSION;
    }

    public function get($key)
    {
        return $this->has($key) ? $_SESSION[$key] : null;
    }

    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function setArray(array $array): void
    {
        foreach ($array as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function has($key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public function delete($key): void
    {
        unset($_SESSION[$key]);
    }

    public function flush(): void
    {
        session_unset();
    }
}