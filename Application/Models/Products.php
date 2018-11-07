<?php

namespace Models;

use PDO;
use Core\Model;

class Products extends Model
{
    protected $table = 'products';

    protected $allowed = [
        'name',
        'availability',
        'cost',
        'manufacturer_id'
    ];

    protected $timestamp = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function find($id)
    {
        $sql = 'SELECT t.*, m.name as manufacturerName FROM ' . $this->table . ' t ' .
               'INNER JOIN manufacturer m ON t.manufacturer_id = m.id ' .
               'WHERE t.id = ? ';

        $query = $this->db->prepare($sql);
        $query->bindValue(1, $id, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function findWhereIn($key, $array)
    {
        $in  = str_repeat('?,', count($array) - 1) . '?';
        $sql = 'SELECT t.*, m.name as manufacturerName FROM ' . $this->table . ' t ' .
               'INNER JOIN manufacturer m ON t.manufacturer_id = m.id ' .
               'WHERE t.' . $key . ' IN (' . $in . ') ';

        $stm = $this->db->prepare($sql);
        $stm->execute($array);

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchBy($key, $value, $from = 0)
    {
        $sql = 'SELECT t.*, m.name as manufacturerName FROM ' . $this->table . ' t ' .
               'INNER JOIN manufacturer m ON t.manufacturer_id = m.id ' .
               'WHERE t.' . $key . ' LIKE "%"?"%" ' .
               'LIMIT ?, ?';

        $from *= config('count_items_per_page');
        $query = $this->db->prepare($sql);
        $query->bindValue(1, $value, PDO::PARAM_STR_CHAR );
        $query->bindValue(2, $from, PDO::PARAM_INT);
        $query->bindValue(3, config('count_items_per_page'), PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}