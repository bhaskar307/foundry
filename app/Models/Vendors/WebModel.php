<?php 

namespace App\Models\Vendors;

use CodeIgniter\Model;

class WebModel extends Model {

    public function getProductsDetails()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('product p');
        $builder->select('
            p.*, 
            v.name AS vendor_name, 
            c.title AS category_name
        ');
        $builder->join('vendor v', 'v.uid = p.vendor_id', 'left');
        $builder->join('category c', 'c.uid = p.category_id', 'left');
        $builder->where('p.status !=', DELETED_STATUS);
        
        $result = $builder->get()->getResultArray();
        return $result;
    }

    
}