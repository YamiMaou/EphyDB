<?php

namespace EphyDB;

class Select implements Preparable
{
    private $columns = [];
    private $from = null;
    private $limit = null;
    private $group = null;
    private $order = null;
    private $having = null;

    /**
     * @var string
     */
    private $query;

    /**
     * @var \PDO
     */
    private $pdo;

    use Where;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    private function getColumnsToString()
    {
        if (count($this->columns) > 0) {
            $columns = '';
            foreach ($this->columns as $key => $value) {

                $value = ($value instanceof Select) ? '('.$value.')' : $value;

                $columns .= (! is_int($key))
                    ? sprintf('%s AS %s, ', $value, $key)
                    : sprintf('%s, ', $value);
            }

            return rtrim($columns, ', ');
        }

        return '*';
    }

    /**
     * @param array $columns
     * @return Select
     */
    public function columns(array $columns)
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     * @return Select
     */
    public function from($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     * @return Select
     */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param string|array $group
     * @return Select
     */
    public function group($group)
    {
        $this->group = (is_array($group)) ? implode(',', $group) : $group;
        return $this;
    }

    /**
     * @return null
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param string|array $fields
     * @param string|array $order
     * @return Select
     */
    public function order($fields, $order = 'ASC')
    {
        if (is_array($fields) && is_array($order)) {

            if (count($fields) <> count($order)) {
                new \Exception("The number of fields must be the same as the ordering");
            }

            $this->order = ' ORDER BY ';

            $i = 0;
            foreach ($fields as $field) {
                $this->order .= $field . ' '. $order[$i] .', ';
                $i++;
            }

            $this->order = rtrim($this->order, ', ');
        } else {
            $this->order = ' ORDER BY ' . $fields . ' ' . $order;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getHaving()
    {
        return $this->having;
    }

    /**
     * @param string $condition
     * @return Select
     */
    public function having($condition)
    {
        $this->having = $condition;
        return $this;
    }



    /**
     * @return string
     */
    public function __toString()
    {
        return $this->query;
    }

    /**
     * @return \PDOStatement
     */
    public function prepare()
    {
        $query = "SELECT ";
        $query .= $this->getColumnsToString();
        $query .= ' FROM '.$this->getFrom();
        $query .= (!is_null($this->where)) ? $this->where : '';
        $query .= (!is_null($this->getGroup())) ? ' GROUP BY '.$this->getGroup() : '';
        $query .= (!is_null($this->getHaving())) ? ' HAVING '.$this->getHaving() : '';
        $query .= (!is_null($this->getOrder())) ? $this->getOrder() : '';
        $query .= (!is_null($this->getLimit())) ? ' LIMIT '.$this->getLimit() : '';
        $this->query = $query;

        $stmt = $this->pdo->prepare($this->query);
        $this->bindValues($stmt);

        return $stmt;
    }
}