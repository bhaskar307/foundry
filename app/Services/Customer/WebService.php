<?php
namespace App\Services\Customer;
use CodeIgniter\Validation\Validation;
use App\Models\Customer\WebModel;

class WebService
{
    protected $validation;
    protected $webModel;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->webModel = new WebModel();
    }

    public function getCustomerReview()   
    {
        $data = $this->webModel->getCustomerReview();
        return $data;
    }

    public function getAllProductDetails()   
    {
        $data = $this->webModel->getAllProductDetails();
        return $data;
    }

    public function getCustomerReviewByProductId($productId)   
    {
        $data = $this->webModel->getCustomerReviewByProductId($productId);
        return $data;
    }

    public function getProductList($categoryUid,$priceFrom,$priceTo)   
    {
        $data = $this->webModel->getProductList($categoryUid,$priceFrom,$priceTo);
        return $data;
    }

    public function getFilteredProductDetails($categoryUid,$priceFrom,$priceTo)   
    {
        $data = $this->webModel->getFilteredProductDetails($categoryUid,$priceFrom,$priceTo);
        return $data;
    }

    public function getProductDetailsByProductId($productId)   
    {
        $data = $this->webModel->getProductDetailsByProductId($productId);
        return $data;
    }
}
