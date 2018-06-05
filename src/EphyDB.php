<?php

namespace EphyDB\Adapter;


class EphyDB
{
    private $adapter = null;
    private $pdo = null;

    public function __construct(\EphyDB\Adapter\Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->connect();

        var_dump($this->pdo);
    }

    private function connect()
    {
        if (is_null($this->pdo)) {
            if (!is_null($this->adapter->getUsername()) && !is_null($this->adapter->getPass())) {
                $this->pdo = new \PDO(
                    $this->adapter->getDriver(),
                    $this->adapter->getUsername(),
                    $this->adapter->getPass()
                );
            } else {
                $this->pdo = new \PDO($this->adapter->getDriver());
            }
        }
    }
}