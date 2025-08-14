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
        $result = array_map(function ($row) {
            $row['created_at'] = $this->timeAgo($row['created_at']);
            return $row;
        }, $result);
        return $result;
    }




    function timeAgo($datetime)
    {
        $time = strtotime($datetime); // convert date string to timestamp
        $diff = time() - $time; // difference in seconds

        if ($diff < 60) {
            return 'Just now';
        } elseif ($diff < 3600) {
            return floor($diff / 60) . ' minute' . (floor($diff / 60) > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 86400) {
            return floor($diff / 3600) . ' hour' . (floor($diff / 3600) > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 604800) {
            return floor($diff / 86400) . ' day' . (floor($diff / 86400) > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 2628000) { // about 1 month
            return floor($diff / 604800) . ' week' . (floor($diff / 604800) > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 31536000) { // about 1 year
            return floor($diff / 2628000) . ' month' . (floor($diff / 2628000) > 1 ? 's' : '') . ' ago';
        } else {
            return floor($diff / 31536000) . ' year' . (floor($diff / 31536000) > 1 ? 's' : '') . ' ago';
        }
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
            v.is_verify AS is_vendor_verify,
            v.company AS vendor_company,
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
        $builder->orderBy('p.is_verify', 'DESC');
        $builder->orderBy('p.uid', 'DESC');
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
                        v.is_verify AS is_vendor_verify,
                        v.company AS vendor_company,
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
            $builder->groupStart()
                ->whereIn('p.category_id', $categoryUid)
                ->orWhereIn('p.subcategory_id', $categoryUid)
                ->groupEnd();
        }

        // Price range filter
        if (is_numeric($priceFrom) && is_numeric($priceTo)) {
            $builder->where('p.price >=', $priceFrom);
            $builder->where('p.price <=', $priceTo);
        }
        $builder->orderBy('p.is_verify', 'DESC');
        $builder->orderBy('p.uid', 'DESC');
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




    public function getAllMightBeProductDetails($categoryUid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('product p');

        $builder->select('
            p.*, 
            v.name AS vendor_name,
            v.is_verify AS is_vendor_verify,
            v.company AS vendor_company,
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
        $builder->orderBy('p.is_verify', 'DESC');
        $builder->orderBy('p.uid', 'DESC');
        $builder->where('p.category_id', $categoryUid);
        $result = $builder->get()->getResultArray();

        return $result;
    }


    public function getVendorCountryList()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('vendor'); // fixed typo from 'venodr'
        $builder->select('country');
        $builder->distinct();
        $builder->where('status', ACTIVE_STATUS);
        $result = $builder->get()->getResultArray();
        return $result;
    }
}
