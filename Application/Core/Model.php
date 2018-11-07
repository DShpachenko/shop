<?php

namespace Core;

use PDO;

class Model
{
    public $db;

    protected $table;
    protected $allowed;
    protected $timestamp;

    protected function __construct()
    {
        $db = config('db');

        $this->db = $this->connection($db['defoult']);
    }

    public function connection($options)
    {
        return new PDO('mysql:host=' . $options['db_host'] . ';dbname='
                                               . $options['db_name'],
                                                 $options['db_user'],
                                                 $options['db_password']
        );
    }

    public function find($id)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' ' .
               'WHERE id = ? ';

        $query = $this->db->prepare($sql);
        $query->bindValue(1, $id, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function findOneBy($key, $value)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' ' .
               'WHERE ' . $key . ' = ? ';

        $query = $this->db->prepare($sql);
        $query->bindValue(1, $value, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);        
    }

    public function findBy($key, $value)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' ' .
               'WHERE ' . $key . ' = ? ';

        $query = $this->db->prepare($sql);
        $query->bindValue(1, $value, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchBy($key, $value, $from = 0)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' ' .
               'WHERE ' . $key . ' LIKE "%"?"%" ' .
               'LIMIT ?, ?';

        $from *= config('count_items_per_page');
        $query = $this->db->prepare($sql);
        $query->bindValue(1, $value, PDO::PARAM_STR_CHAR );
        $query->bindValue(2, $from, PDO::PARAM_INT);
        $query->bindValue(3, config('count_items_per_page'), PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findWhereIn($key, $array)
    {
        $in  = str_repeat('?,', count($array) - 1) . '?';
        $sql = 'SELECT * FROM ' . $this->table . ' ' .
               'WHERE ' . $key . ' IN (' . $in . ') ';

        $stm = $this->db->prepare($sql);
        $stm->execute($array);

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($arr)
    {
        $sql = 'INSERT INTO ' . $this->table . ' SET ' . $this->pdoSet('create', $arr, $values);
        $stm = $this->db->prepare($sql);
        $stm->execute($values);

        return $this->db->lastInsertId();
    }

    public function edit($arr)
    {
        $sql = 'UPDATE ' . $this->table . ' SET ' . $this->pdoSet('update', $arr, $values) . ' WHERE id = :id';
        $stm = $this->db->prepare($sql);
        $values['id'] = $arr['id'];
        $stm->execute($values);
    }

    public function destroy($id)
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);   
        $stmt->execute();
    }

    protected function pdoSet($type, $source = [], &$values)
    {
        $set = '';
        $values = [];

        foreach($this->allowed as $field) {
            if(isset($source[$field])) {
                $set .= '`' . str_replace('`', '``', $field) . '`' . ' = :' . $field . ', ';
                $values[$field] = $source[$field];
            }
        }

        if($this->timestamp) {
            $now = date('Y-m-d H:i:s');

            if($type == 'create') {
                $set .= '`created_at` = "' . $now . '", ';
            }

            $set .= '`updated_at` = "' . $now . '"';
        } else {
            return substr($set, 0, -2);
        }

        return $set; 
    }
}