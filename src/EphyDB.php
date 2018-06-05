<?php

namespace EphyDB;


class EphyDB
{
    private $adapter = null;

    /**
     * @var \PDO
     */
    private $pdo = null;

    public function __construct(\EphyDB\Adapter\Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->connect();
    }

    /**
     * @return Select
     */
    public function select()
    {
        return new Select($this->pdo);
    }

    public function execute(Select $select) {
        $stmt = $select->prepare();
        $stmt->execute();
        return $stmt;
    }

    /**
     * @param $sql
     * @param int $fetch
     * @return \PDOStatement
     */
    public function query($sql, $fetch = \PDO::FETCH_ASSOC)
    {
        return $this->pdo->query($sql, $fetch);
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

            if ($this->adapter->getAttributes() && count($this->adapter->getAttributes()) > 0) {
                foreach ($this->adapter->getAttributes() as $key => $value) {
                    $this->pdo->setAttribute($key, $value);
                }
            }
        }
    }

}