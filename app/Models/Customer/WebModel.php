<?php

namespace App\Models\Customer;

use CodeIgniter\Model;

class WebModel extends Model
{

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

    public function getCustomerReviewByProductId($productId)
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
        $builder->where('pr.product_id', $productId);
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

    public function getProductDetailsByProductId_old($productId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('product p');
        $builder->select('
            p.*, 
            v.name AS vendor_name, 
            v.mobile AS vendor_mobile, 
            v.email AS vendor_email, 
            cat.title AS category_name
        ');
        $builder->join('vendor v', 'v.uid = p.vendor_id', 'left');
        $builder->join('category cat', 'cat.uid = p.category_id', 'left');
        $builder->where('p.uid', $productId);
        $product = $builder->get()->getRowArray();

        $imageBuilder = $db->table('product_image');
        $imageBuilder->select('*');
        $imageBuilder->where('product_id', $productId);
        $images = $imageBuilder->get()->getResultArray();

        $product['images'] = $images;

        return $product;
    }

    public function getAllProductDetails()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('product p');

        $builder->select('
            p.*, 
            v.name AS vendor_name,
            (SELECT COUNT(*) FROM product_rating r WHERE r.product_id = p.uid) AS total_customer_review,
            (SELECT SUM(r.rating) FROM product_rating r WHERE r.product_id = p.uid) AS total_rating,
            (
                CASE 
                    WHEN (SELECT COUNT(*) FROM product_rating r WHERE r.product_id = p.uid) > 0 
                    THEN ROUND((SELECT SUM(r.rating) FROM product_rating r WHERE r.product_id = p.uid) / (SELECT COUNT(*) FROM product_rating r WHERE r.product_id = p.uid), 1)
                    ELSE 0
                END
            ) AS total_rating_percent
        ');
        $builder->join('vendor v', 'v.uid = p.vendor_id', 'inner');
        $builder->where('p.status', ACTIVE_STATUS);
        $result = $builder->get()->getResultArray();
        return $result;
    }


    public function getFilteredProductDetails($categoryUid = [], $priceFrom = 0, $priceTo = 50000)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('product p');

        $builder->select('
                        p.*, 
                        v.name AS vendor_name,
                        (SELECT COUNT(*) FROM product_rating r WHERE r.product_id = p.uid) AS total_customer_review,
                        (SELECT SUM(r.rating) FROM product_rating r WHERE r.product_id = p.uid) AS total_rating,
                        (
                            CASE 
                                WHEN (SELECT COUNT(*) FROM product_rating r WHERE r.product_id = p.uid) > 0 
                                THEN ROUND(
                                    (SELECT SUM(r.rating) FROM product_rating r WHERE r.product_id = p.uid) / 
                                    (SELECT COUNT(*) FROM product_rating r WHERE r.product_id = p.uid), 1)
                                ELSE 0
                            END
                        ) AS total_rating_percent
                    ');
        $builder->join('vendor v', 'v.uid = p.vendor_id');
        $builder->where('p.status', ACTIVE_STATUS);

        // Category filter
        if (!empty($categoryUid) && is_array($categoryUid)) {
            $builder->whereIn('p.category_id', $categoryUid);
        }

        // Price range filter
        if (is_numeric($priceFrom) && is_numeric($priceTo)) {
            $builder->where('p.price >=', $priceFrom);
            $builder->where('p.price <=', $priceTo);
        }

        $result = $builder->get()->getResultArray();
        return $result;
    }

    public function getProductDetailsByProductId($productId)
    {
        $db = \Config\Database::connect();

        // Product + Vendor + Category + Ratings
        $builder = $db->table('product p');
        $builder->select('
            p.*, 
            v.name AS vendor_name, 
            v.mobile AS vendor_mobile, 
            v.email AS vendor_email, 
            cat.title AS category_name,
            (
                SELECT COUNT(*) FROM product_rating r WHERE r.product_id = p.uid
            ) AS total_customer_review,
            (
                SELECT SUM(r.rating) FROM product_rating r WHERE r.product_id = p.uid
            ) AS total_rating,
            (
                CASE 
                    WHEN (SELECT COUNT(*) FROM product_rating r WHERE r.product_id = p.uid) > 0 
                    THEN ROUND(
                        (SELECT SUM(r.rating) FROM product_rating r WHERE r.product_id = p.uid) /
                        (SELECT COUNT(*) FROM product_rating r WHERE r.product_id = p.uid), 1
                    )
                    ELSE 0
                END
            ) AS total_rating_percent
        ');
        $builder->join('vendor v', 'v.uid = p.vendor_id', 'left');
        $builder->join('category cat', 'cat.uid = p.category_id', 'left');
        $builder->where('p.uid', $productId);
        $product = $builder->get()->getRowArray();

        // Get product images
        $imageBuilder = $db->table('product_image');
        $imageBuilder->select('*');
        $imageBuilder->where('product_id', $productId);
        $images = $imageBuilder->get()->getResultArray();

        // Append images to product
        $product['images'] = $images;

        return $product;
    }
}
