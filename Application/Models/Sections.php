<?php

namespace Models;

use PDO;
use Core\Model;

class Sections extends Model
{
    protected $table = 'sections';

    protected $allowed = [
        'parrent_id',
        'name'
    ];

    protected $timestamp = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function nestedSections($sectionId)
    {
        $sql = "select 
                    id, name, parent_id
                from 
                    (select * from sections order by parent_id, id) products_sorted, 
                    (select @pv := ?) initialisation 
                where 
                    find_in_set(parent_id, @pv) and 
                    length(@pv := concat(@pv, ',', id))";

        $query = $this->db->prepare($sql);
        $query->bindValue(1, $sectionId, PDO::PARAM_INT);
        $query->execute();

        $sections = $query->fetchAll(PDO::FETCH_ASSOC);

        $ids = [$sectionId];

        for($i = 0; $i < count($sections); $i++) {
            $ids[] = $sections[$i]['id'];
        }

        return $ids;
    }
}