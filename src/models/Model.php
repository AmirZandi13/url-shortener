<?php

namespace Src\models;

use Src\system\DatabaseConnector;

class Model extends AbstractModel
{
    public function __construct()
    {
        $this->setDb((new DatabaseConnector())->getConnection());
    }
}