<?php

namespace App\Services\Customer;

use CodeIgniter\Validation\Validation;

//use App\Models\PerformanceModule\ReviewModel;
use App\Models\Customer\WebModel;

class WebService
{
    protected $validation;
    protected $webModel;
    //protected $commonModel;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->webModel = new WebModel();
        //$this->commonModel = new Common_model_new();
    }

    public function getCategoryData()  
    {
        $data = $this->webModel->getCategoryData();
        return $data;
    }

    /** Get All Product Details */
    public function getProductsDetails()  
    {
        $data = $this->webModel->getProductsDetails();
        return $data;
    }
    /** Get Product Details */ 
    
    /** Get Single Product Details */
    public function getProductsDetailsByProductId($productId)  
    {
        $data = $this->webModel->getProductsDetailsByProductId($productId);
        return $data;
    }
    /** Get Single Product Details */
}
