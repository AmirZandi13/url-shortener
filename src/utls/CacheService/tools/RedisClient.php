<?php

namespace Src\utls\CacheService\tools;

use Predis\Client;
use Src\utls\CacheService\CacheClientInterface;

class RedisClient implements CacheClientInterface
{
    /**
     * @var Client
     */
    private $redis;

    /**
     * RedisClient Constructor
     */
    public function __construct()
    {
        $this->redis = new Client(
            [
                'scheme' => 'tcp',
                'host'   => getenv('CACHE_HOST'),
                'port'   => getenv('CACHE_PORT'),
            ]
        );
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->redis->get($key);
    }

    /**
     * @param string $key
     * @param $value
     * @param $ttl
     *
     * @return mixed
     */
    public function put(string $key, $value, $ttl)
    {
        return $this->redis->setex($key, (int) $ttl, $value);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function has(string $key)
    {
        return $this->redis->exists($key);
    }
}