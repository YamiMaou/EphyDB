<?php

namespace EphyDB\Adapter\Driver;

abstract class PdoAbstractDriver
{
    protected $driver = null;

    public function __construct($driverName, $database, $hostname, $port, $charset)
    {
        $this->driver = sprintf(
            "%s:dbname=%s;host=%s;port=%s;charset=%s",
            $driverName, $database, $hostname, $port, $charset
        );
    }

    public function getDriver()
    {
        return $this->driver;
    }
}