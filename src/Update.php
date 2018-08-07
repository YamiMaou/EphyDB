<?php

namespace EphyDB;

class Update implements Preparable
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

    use Where;

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
            $fields .= $key . " = '" . $value . "' , ";
        }

        $fields = rtrim($fields, '?');
        $fields = rtrim($fields, ' ,');
        $this->query = sprintf('UPDATE  %s SET %s', $this->table, $fields);
        $this->query .= (!is_null($this->where)) ? $this->where : '';

        $stmt = $this->pdo->prepare($this->query);
        $this->bindValues($stmt);

        return $stmt;
    }
}