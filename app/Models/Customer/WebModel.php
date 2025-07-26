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

    public function getProductList($categoryUid = [], $priceFrom = 0, $priceTo = 50000)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('product');
        $builder->select('*');
        $builder->where('status', ACTIVE_STATUS);
        if (!empty($categoryUid) && is_array($categoryUid)) {
            $builder->whereIn('category_id', $categoryUid);
        }
        if (is_numeric($priceFrom) && is_numeric($priceTo)) {
            $builder->where('price >=', $priceFrom);
            $builder->where('price <=', $priceTo);
        }
        $result = $builder->get()->getResultArray();
        return $result;
    }

}