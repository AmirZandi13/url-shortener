<?php

namespace Src\utls\CacheService;

class CacheFactory
{
    public static function make()
    {
        try {
            return new ('Src\utls\CacheService\tools\\' . ucfirst(getenv('CACHE_CONNECTION')) . 'Client')();
        } catch(\Exception $exception) {
            throw new \Exception('redis connection is not implemented');
        }
    }
}