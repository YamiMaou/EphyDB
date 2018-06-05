<?php

namespace EphyDB\Adapter\Driver;

class PdoMysql extends PdoAbstractDriver implements DriverInterface
{
    const DRIVER_NAME = 'mysql';
    const PORT = 3306;
    const CHARSET = 'UTF8';

    public function __construct(array $config)
    {
        $port = (!isset($config['port'])) ? self::PORT : $config['port'];
        $charset = (!isset($config['charset'])) ? self::CHARSET : $config['charset'];

        parent::__construct(self::DRIVER_NAME, $config['database'], $config['hostname'], $port, $charset);
    }

}