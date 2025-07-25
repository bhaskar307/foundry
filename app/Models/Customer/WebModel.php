<?php 
namespace App\Models\Customer;
use CodeIgniter\Model;
class WebModel extends Model {
    
    public function getCustomerReview()  
    {
        $db = \Config\Database::connect();
        $builder = $db->table('product_rating pr');
        $builder->select('
            pr.*, 
            c.name AS customer_name, 
            c.image AS customer_image, 
            c.mobile AS customer_mobile, 
            c.email AS customer_email, 
            p.name AS product_name
        ');
        $builder->join('customer c', 'c.uid = pr.customer_id', 'left');
        $builder->join('product p', 'p.uid = pr.product_id', 'left');
        $builder->where('pr.status', ACTIVE_STATUS);
        $result = $builder->get()->getResultArray();
        return $result;
    }
}