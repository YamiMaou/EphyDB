<?php

namespace EphyDB;

class Insert implements Preparable
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

    /**
     * @var array
     */
    private $data;

    /**
     * Insert constructor.
     * @param \PDO $pdo
     * @param string $table
     * @param array $data
     */
    public function __construct(\PDO $pdo, $table, $data)
    {
        $this->pdo = $pdo;

        if (empty($table)) {
            throw new \InvalidArgumentException("Table name can not be empty to insert");
        }

        if (!is_array($data)) {
            throw new \InvalidArgumentException("Variable data is not an array");
        }

        if (count($data) <= 0) {
            throw new \InvalidArgumentException("There is no data to insert");
        }

        $this->table = $table;
        $this->data = $data;
    }

    public function __toString()
    {
        return $this->query;
    }

    public function prepare()
    {
        $fields = '';

        foreach ($this->data as $key => $value) {
            $fields .= $key.', ';
        }

        $values = rtrim(str_repeat('?,', count($this->data)), ',');
        $fields = rtrim($fields, ', ');

        $this->query = sprintf('INSERT INTO %s (%s) VALUES(%s)', $this->table, $fields, $values);

        $stmt = $this->pdo->prepare($this->query);

        $i = 1;
        foreach ($this->data  as $key => $value) {
            $stmt->bindValue($i, $value);
            $i++;
        }

        return $stmt;
    }

    /**
     * @return int
     */
    public function lastInsertID()
    {
        return (int) $this->pdo->lastInsertId();
    }
}