<?php

namespace Src\models\repositories;

class RepositoryFactory
{
    /**
     * @param string $repository
     *
     * @return mixed
     * @throws \Exception
     */
    public static function make(string $repository)
    {
        try {
            return new ('Src\models\repositories\\' . getenv('DB_CONNECTION') . '\\' . $repository)();
        } catch(\Exception $exception) {
            throw new \Exception('db connection is not implemented');
        }
    }
}