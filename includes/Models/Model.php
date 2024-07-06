<?php
 
namespace ADReviewManager\Models;

class Model
{
    protected $model = '';
    protected $db;
    protected $wheres = [];
    protected $whereBetween = [];
    protected $selects = [];
    protected $limit = false;
    protected $offset = false;
    protected $orderBy = false;

    public function __construct($table = '')
    {
        global $wpdb;
        if ($table) {
            $this->model = $wpdb->prefix.$table;
        }
        $this->db = $wpdb;
    }

    public function table($table)
    {
        $this->model = $this->db->prefix.$table;
        return $this;
    }

    public function select($selects)
    {
        if (is_array($selects)) {
            $selects = array_unique(array_merge($selects, $this->selects));
        } else {
            $this->selects[] = $selects;
            $selects = array_unique($selects);
        }
        $this->selects = $selects;
        return $this;
    }

    public function where($column, $operator, $value = '')
    {
        if (func_num_args() == 2) {
            $value = $operator;
            $operator = '=';
        }
        $this->wheres[] = array(
            $column, $operator, $value
        );
        return $this;
    }

    public function whereBetween($column, $firstVal, $lastVal = '')
    {
        $this->whereBetween[] = array(
            $column, $firstVal, $lastVal, ''
        );
       return $this;
    }

    public function orWhereBetween($column, $firstVal, $lastVal = '')
    {
        $this->whereBetween[] = array(
            $column, $firstVal, $lastVal, 'OR'
        );
       return $this;
    }

    public function andWhereBetween($column, $firstVal, $lastVal = '')
    {
        $this->whereBetween[] = array(
            $column, $firstVal, $lastVal, ' AND '
        );
       return $this;
    }

    public function whereIn($column, $values)
    {
        if (!$values) {
            return $this;
        }
        if (count($values) == 1) {
            $this->wheres[] = array($column, '=', reset($values));
        } else {
            array_walk($values, function (&$x) {
                $x = "'$x'";
            });
            $this->wheres[] = array(
                $column, 'IN', '('.implode(',', $values).')'
            );
        }

        return $this;
    }


    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function orderBy($column, $orderBy = 'ASC')
    {
        $this->orderBy = array($column, $orderBy);
        return $this;
    }

    public function reset()
    {
        $this->wheres = [];
        $this->selects = [];
        $this->limit = false;
        $this->offset = false;
        $this->orderBy = false;
        $this->whereBetween = [];
    }

    private function getWhereStatement()
    {
        $statement = '';
        if ($this->wheres) {
            foreach ($this->wheres as $index => $where) {
                if (is_numeric($where[2])) {
                    $whereValue = $where[2];
                } else {
                    if ($where[1] != 'IN') {
                        $whereValue = "'".$where[2]."'";
                    } else {
                        $whereValue = $where[2];
                    }
                }
                if ($index == 0) {
                    $statement = 'WHERE '.$where[0].' '.$where[1].' '.$whereValue;
                } else {
                    $statement .= ' AND '.$where[0].' '.$where[1].' '.$whereValue;
                }
            }
        }
        if ($this->whereBetween && !$this->wheres) {
            foreach ($this->whereBetween as $whereBetween) {
                $statement .= ' WHERE '.$whereBetween[0].' BETWEEN "'.$whereBetween[1].'" AND "'.$whereBetween[2].'"';
            }
        }

        if ($this->whereBetween && $this->wheres) {
            foreach ($this->whereBetween as $whereBetween) {
                $statement .= ' '.$whereBetween[3]. ' ' .$whereBetween[0].' BETWEEN "'.$whereBetween[1].'" AND "'.$whereBetween[2].'"';
            }
        }
        return $statement;
    }

    private function getSelects()
    {
        if ($this->selects) {
            return implode(',', $this->selects);
        }
        return '*';
    }

    private function getOtherStatements()
    {
        $statement = '';

        if ($this->orderBy) {
            $statement .= 'ORDER BY '.$this->orderBy[0].' '.$this->orderBy[1]. ' ';
        }

        if ($this->limit) {
            $statement .= "LIMIT {$this->offset}, {$this->limit}";
        }

        return $statement;
    }

    public function find($columnValue = false, $column = 'id')
    {
        if ($columnValue) {
            $this->wheres[] = array(
                $column, '=', $columnValue
            );
        }

        $statement = $this->db->prepare("SELECT %1s FROM %1s %1s", $this->getSelects(), $this->model, $this->getWhereStatement());
        $this->reset();
        return $this->db->get_row($statement);
    }

    public function first()
    {
        $query = $this->db->prepare("SELECT %1s FROM %1s $1s %1s", $this->getSelects(), $this->model, $this->getWhereStatement(), $this->getOtherStatements());
        $this->reset();
        return $this->db->get_row($query);
    }

    public function get()
    {
        $query = $this->db->prepare("SELECT %1s FROM %1s $1s %1s", $this->getSelects(), $this->model, $this->getWhereStatement(), $this->getOtherStatements());
        $this->reset();
        return $this->db->get_results($query);
    }

    public function insert($data)
    {
        try {
            $this->db->insert($this->model, $data);
            return $this->db->insert_id;
        } catch (\Exception $exception) {
            $exception->getMessage();
        }
    }

    public function update($data)
    {
        $whereArray = array();
        $whereFormatArray = array();
        foreach ($this->wheres as $where) {
            $whereArray[$where[0]] = $where[2];
            if (is_numeric($where[2])) {
                $whereFormatArray[] = '%d';
            } else {
                $whereFormatArray[] = '%s';
            }
        }

        $formatArray = [];
        foreach ($data as $datum) {
            if (is_numeric($datum)) {
                $formatArray[] = '%d';
            } else {
                $formatArray[] = '%s';
            }
        }
        return $this->db->update($this->model, $data, $whereArray, $formatArray, $whereFormatArray);
    }

    public function delete()
    {
        $whereArray = array();
        $whereFormatArray = array();
        foreach ($this->wheres as $where) {
            $whereArray[$where[0]] = $where[2];
            if (is_numeric($where[2])) {
                $whereFormatArray[] = '%d';
            } else {
                $whereFormatArray[] = '%s';
            }
        }
        return $this->db->delete($this->model, $whereArray, $whereFormatArray);
    }

    public function getCount()
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM %1s %1s", $this->model, $this->getWhereStatement());
        return $this->db->get_var($query);
    }

    public function getDISTINCT($row)
    {
        $query = $this->db->prepare("SELECT DISTINCT %1s FROM %1s", $row, $this->model);
        return $this->db->get_results($query);
    }

    public function getDB()
    {
        return $this->db;
    }
}
