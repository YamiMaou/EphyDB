<?php

namespace EphyDB\Adapter\Driver;

class PdoSqlite implements DriverInterface
{
    private $driver = null;

    public function __construct(array $arrayConfig)
    {
        if (! isset($arrayConfig['database']) && !empty($arrayConfig['database'])) {
            throw new \InvalidArgumentException('Parameter database can not be empty or does not exist');
        }

        $this->driver = "sqlite:".$arrayConfig['database'];
    }

    public function getDriver()
    {
        return $this->driver;
    }
}