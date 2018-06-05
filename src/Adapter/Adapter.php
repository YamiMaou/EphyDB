<?php
namespace EphyDB\Adapter;


use EphyDB\Adapter\Driver\DriverFactory;

class Adapter
{
    private $arrayConfig;
    private $driver;
    private $username = null;
    private $pass = null;
    private $port = null;
    private $attributes = [];

    public function __construct(array $arrayConfig)
    {
        if (!is_array($arrayConfig)) {
            throw new \InvalidArgumentException("Array config is not valid");
        }

        if (! key_exists('driver', $arrayConfig)) {
            throw new \InvalidArgumentException("Paramter driver not found in array");
        }

        $driverFactory = new DriverFactory($arrayConfig);
        $this->driver = $driverFactory->getDriverObject()->getDriver();

        $this->arrayConfig = $arrayConfig;

        $this->setUsername();
        $this->setPass();
    }

    /**
     * @return null
     */
    public function getUsername()
    {
        return $this->username;
    }


    private function setUsername()
    {
        if (isset($this->arrayConfig['username'])) {
            $this->username = $this->arrayConfig['username'];
        }

        return $this;
    }

    /**
     * @return null
     */
    public function getPass()
    {
        return $this->pass;
    }

    private function setPass()
    {
        if (isset($this->arrayConfig['password'])) {
            $this->pass = $this->arrayConfig['password'];
        }

        return $this;
    }

    public function getDriver()
    {
        return $this->driver;
    }

    private function setAttributes()
    {
        if (isset($this->arrayConfig['attributes']) && is_array($this->arrayConfig['attributes'])) {
            $this->attributes = $this->arrayConfig['attributes'];
        }

        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}