<?php
namespace EphyDB;

trait Where
{
    protected $where = null;
    private $cond = [];
    protected $values = [];
    protected $types = [];

    /**
     *
     * @param string $cond
     * @param null|string|array $value
     * @param null|int|array $type
     * @return $this
     */
    public function where($cond, $value = null, $type = null)
    {
        $this->_where($cond, $value, $type, 'AND');
        return $this;
    }

    /**
     *
     * @param string $cond
     * @param null|string|array $value
     * @param null|int|array $type
     * @return $this
     */
    public function orWhere($cond, $value = null, $type = null)
    {
        $this->_where($cond, $value, $type, 'OR');
        return $this;
    }

    /**
     * @param $cond
     * @param $value
     * @param null $type
     * @param string $condAndOr
     */
    private function _where($cond, $value, $type = null, $condAndOr = 'AND')
    {
        $this->setValues($value);
        $this->setTypes($type);

        if (is_null($this->where)) {
            $this->where .= ' WHERE '.$cond;
        } else {
            $this->where .= " {$condAndOr} ".$cond;
        }
    }

    private function setValues($value)
    {
        if (! is_null($value)) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $this->values[] = $v;
                }

            } else {
                $this->values[] = $value;
            }
        }
    }

    private function setTypes($type)
    {
        if (is_null($type)) {
            if (is_array($this->values)) {
                foreach ($this->values as $k => $v) {
                    $this->types[] = \PDO::PARAM_STR;
                }
            } else {
                $this->types[] = \PDO::PARAM_STR;
            }

        } else if (is_array($type)) {
            foreach ($type as $k => $v) {
                $this->types[] = $v;
            }
        } else {
            $this->types[] = $type;
        }
    }

    /**
     * @param \PDOStatement $stmt
     */
    protected function bindValues(\PDOStatement $stmt)
    {
        if (count($this->values) > 0) {
            foreach ($this->values as $key => $value) {
                $stmt->bindValue($key+1, $value, $this->types[$key]);
            }
        }
    }
}