<?php

namespace EphyDB\Adapter\Driver;

interface DriverInterface
{
    public function __construct(array $arrayConfig);
    public function getDriver();
}