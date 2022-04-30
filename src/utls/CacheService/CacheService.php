<?php

namespace Src\utls\CacheService;

class CacheService
{
    /**
     * @var CacheClientInterface
     */
    private $cacheClient;

    public function __construct()
    {
        $this->cacheClient = CacheFactory::make();
    }

    public function getCacheClient()
    {
        return $this->cacheClient;
    }
}