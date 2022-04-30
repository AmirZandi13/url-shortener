<?php

namespace Src\utls\CacheService;

interface CacheClientInterface
{
    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key);

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function put(string $key, $value, $ttl);

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function has(string $key);

}