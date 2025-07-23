<?php

namespace App\Services\Vendors;

use CodeIgniter\Validation\Validation;

//use App\Models\PerformanceModule\ReviewModel;
use App\Models\Vendors\WebModel;

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

    public function getProductsDetails()  
    {
        $data = $this->webModel->getProductsDetails();
        return $data;
    }
    
}
