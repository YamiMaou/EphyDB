<?php

namespace EphyDB\Adapter\Driver;

class PdoPgsql extends PdoAbstractDriver implements DriverInterface
{
    const DRIVER_NAME = 'pgsql';
    const PORT = 5432;

    public function __construct(array $config)
    {
        $port = (!isset($config['port'])) ? self::PORT : $config['port'];

        $this->driver = sprintf(
            "%s:dbname=%s;host=%s;port=%s",
            self::DRIVER_NAME, $config['database'], $config['hostname'], $port
        );
    }

}