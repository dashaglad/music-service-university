<?php

declare(strict_types=1);

namespace App\Services;

use App\Utils\RedisConnection;

class CacheService
{
    public function getOrAdd(string $key, ?callable $callback = null, ?int $ttl = null): mixed
    {
        $connection = RedisConnection::appCache();

        $data = $connection->get($key);

        if ($data !== null) {
            return json_decode($data);
        }

        if ($callback !== null) {
            $data = $callback();
            $connection->set($key, $data, 'EX', $ttl);
        }

        return $data;
    }
}
