<?php 

namespace App\Models\Vendors;

use CodeIgniter\Model;

class WebModel extends Model {

    public function getCategoryData()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('category c'); 
        $builder->select('c.*, cp.title AS path_name');
        $builder->join('category cp', 'cp.uid = c.path', 'left'); 
        $builder->where('c.status !=', DELETED_STATUS);    
        $result = $builder->get()->getResultArray();

        return $result;
    }

    
}