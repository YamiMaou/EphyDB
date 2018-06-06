<?php

namespace EphyDB;

class Delete implements Preparable
{
    /**
     * @var string
     */
    private $query;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var string
     */
    private $table;

    use Where;

    /**
     * Delete constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo, $table)
    {
        $this->pdo = $pdo;

        if (empty($table)) {
            throw new \InvalidArgumentException("Table name can not be empty to delete");
        }

        $this->table = $table;
    }

    public function __toString()
    {
        return $this->query;
    }

    public function prepare()
    {
        $query = sprintf('DELETE FROM %s', $this->table);
        $query .= (!is_null($this->where)) ? $this->where : '';
        $this->query = $query;

        $stmt = $this->pdo->prepare($this->query);
        $this->bindValues($stmt);

        return $stmt;
    }
}