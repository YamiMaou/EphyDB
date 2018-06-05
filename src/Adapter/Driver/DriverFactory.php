<?php
namespace EphyDB\Adapter\Driver;


class DriverFactory
{
    private $driverObj = null;

    public function __construct(array $arrayConfig)
    {
        $driver = __NAMESPACE__.'\\'.str_replace('_', '', $arrayConfig['driver']);

        if (!class_exists($driver)) {
            throw new \Exception("Class $driver not exists");
        }

        $this->driverObj = new $driver($arrayConfig);

        return $this;
    }

    /**
     * @return DriverInterface
     */
    public function getDriverObject()
    {
        return $this->driverObj;
    }

}