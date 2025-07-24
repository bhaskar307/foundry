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

    public function getProductsDetailsByProductId($productId) 
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
        $builder->where('p.uid', $productId);
        
        $result = $builder->get()->getRowArray();
        return $result;
    }

    public function getRequestsDetails($vendorId=null,$customer=null,$product=null,$date=null)  
    {
        $db = \Config\Database::connect();
        $builder = $db->table('request r');
        $builder->select('
            r.*, 
            c.name AS customer_name, 
            c.mobile AS customer_mobile, 
            c.email AS customer_email, 
            p.name AS product_name,
            v.name AS vendor_name
        ');
        $builder->join('customer c', 'c.uid = r.customer_id', 'left');
        $builder->join('product p', 'p.uid = r.product_id', 'left');
        $builder->join('vendor v', 'v.uid = r.vendor_id', 'left');
        
        $builder->where('r.status', ACTIVE_STATUS);
        if($vendorId != null){
            $builder->where('r.vendor_id', $vendorId);
        }
        if($customer != null){
            $builder->where('r.customer_id', $customer);
        }
        if($product != null){
            $builder->where('r.product_id', $product);
        }
        if ($date != null) {
            $builder->where('DATE(r.created_at)', $date);
        }
        $result = $builder->get()->getResultArray();
        return $result;
    }
}