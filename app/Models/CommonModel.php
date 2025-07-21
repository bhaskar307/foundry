<?php 

namespace App\Models;

use CodeIgniter\Model;

class CommonModel extends Model {

    public function insertData($tableName, $field)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($tableName);
        $builder->insert($field);
        return $db->insertID();
    }

    public function UpdateData($tableName, $whereArray, $updateData)
    {
        return $this->db->table($tableName)->where($whereArray)->set($updateData)->update();
    }

    public function getAllData($tableName, $whereArray, $selectFields = NULL)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($tableName);
        if (!is_null($selectFields) && $selectFields != "") {
            $builder->select($selectFields);
        }
        $builder->where($whereArray);
        return $query   = $builder->get()->getResultArray();
    }
}