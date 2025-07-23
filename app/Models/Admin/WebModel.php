<?php 

namespace App\Models\Admin;

use CodeIgniter\Model;

class WebModel extends Model {

    /** Get Category Details */
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
    /** Get Category Details */
    
    /** Get Product Details */
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
    /** Get Product Details */
}