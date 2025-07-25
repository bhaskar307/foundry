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

    
}
