<?php

namespace App\Controllers\Admin;
use App\Controllers\Common;
use App\Services\Admin\ApiService;
//use App\Models\AdminModel;

use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class ApiController extends Common
{
    protected $apiService;
    public function __construct()
    {
        $this->session = session();
        $this->apiService = new ApiService();
        //$this->AdminModel = new AdminModel();
    }

    /** Login */
    public function login()
    {
        $loginDetails = $this->request->getJSON(true);
        $resp = $this->apiService->login($loginDetails);   
        if (!$resp[0]) {
            $this->apiError($resp[1], $resp[2], $resp[3]);
        } else {
            $data['user_id'] = $resp[3]['data']['uid'];
            $data['user_name'] = $resp[3]['data']['name'];
            $data['user_image'] = $resp[3]['data']['image'];
            $data['user_type'] = USER_TYPE_ADMIN;
            list($auth_token, $auth_cookie) = generateJwtTokenAdmin($data);
            $this
                ->response
                ->setStatusCode(200)
                ->setCookie($auth_cookie);
                
            $this->apiSuccess($resp[1], $resp[2], $resp[3]);
        }
    }

    /** Customer */
    public function createdCustomer()
    {
        $payload = $this->validateJwtApiToken();
        
        $customerDetails = $this->request->getPost();
        $imageFile = $this->request->getFile('image');
        $customerDetails['user_id'] = $payload->user_id;
        $customerDetails['user_type'] = $payload->user_type;
        
        $resp = $this->apiService->createdCustomer($customerDetails,$imageFile);
        if (!$resp[0]) {
            $this->apiError($resp[1], $resp[2], $resp[3]);
        } else {
            $this->apiSuccess($resp[1], $resp[2], $resp[3]);
        }
    }
    public function updateCustomer() 
    {
        $payload = $this->validateJwtApiToken();
        
        $customerDetails = $this->request->getPost();
        $imageFile = $this->request->getFile('image');
        $customerDetails['user_id'] = $payload->user_id;
        $customerDetails['user_type'] = $payload->user_type;
        
        $resp = $this->apiService->updateCustomer($customerDetails,$imageFile);
        if (!$resp[0]) {
            $this->apiError($resp[1], $resp[2], $resp[3]);
        } else {
            $this->apiSuccess($resp[1], $resp[2], $resp[3]);
        }
    }
    public function deleteCustomer()
    {
        $payload = $this->validateJwtApiToken();
        
        $customerDetails = $this->request->getPost();
        $customerDetails['user_id'] = $payload->user_id;
        $customerDetails['user_type'] = $payload->user_type;
        
        $resp = $this->apiService->deleteCustomer($customerDetails);
        if (!$resp[0]) {
            $this->apiError($resp[1], $resp[2], $resp[3]);
        } else {
            $this->apiSuccess($resp[1], $resp[2], $resp[3]);
        }
    }
    public function updateCustomerStatus()  
    {
        $payload = $this->validateJwtApiToken();
        
        $customerDetails = $this->request->getJSON(true);
        $customerDetails['user_id'] = $payload->user_id;
        $customerDetails['user_type'] = $payload->user_type;  
        $resp = $this->apiService->updateCustomerStatus($customerDetails);
        if (!$resp[0]) {
            $this->apiError($resp[1], $resp[2], $resp[3]);
        } else {
            $this->apiSuccess($resp[1], $resp[2], $resp[3]);
        }
    }
    /** Customer */

    /** Vendor Section */
    public function createdVendor()
    {
        $payload = $this->validateJwtApiToken();
        
        $vendorDetails = $this->request->getPost();
        $imageFile = $this->request->getFile('image');
        $vendorDetails['user_id'] = $payload->user_id;
        $vendorDetails['user_type'] = $payload->user_type;
        
        $resp = $this->apiService->createdVendor($vendorDetails,$imageFile);
        if (!$resp[0]) {
            $this->apiError($resp[1], $resp[2], $resp[3]);
        } else {
            $this->apiSuccess($resp[1], $resp[2], $resp[3]);
        }
    }
    public function updateVendor() 
    {
        $payload = $this->validateJwtApiToken();
        
        $vendorDetails = $this->request->getPost();
        $imageFile = $this->request->getFile('image');
        $vendorDetails['user_id'] = $payload->user_id;
        $vendorDetails['user_type'] = $payload->user_type;
        
        $resp = $this->apiService->updateVendor($vendorDetails,$imageFile);
        if (!$resp[0]) {
            $this->apiError($resp[1], $resp[2], $resp[3]);
        } else {
            $this->apiSuccess($resp[1], $resp[2], $resp[3]);
        }
    }
    public function updateVendorStatus() 
    {
        $payload = $this->validateJwtApiToken();
        
        $vendorDetails = $this->request->getJSON(true);
        $vendorDetails['user_id'] = $payload->user_id;
        $vendorDetails['user_type'] = $payload->user_type;
        
        $resp = $this->apiService->updateVendorStatus($vendorDetails);
        if (!$resp[0]) {
            $this->apiError($resp[1], $resp[2], $resp[3]);
        } else {
            $this->apiSuccess($resp[1], $resp[2], $resp[3]);
        }
    }
    public function deleteVendor()
    {
        $payload = $this->validateJwtApiToken();
        
        $vendorDetails = $this->request->getPost();
        $vendorDetails['user_id'] = $payload->user_id;
        $vendorDetails['user_type'] = $payload->user_type;
        
        $resp = $this->apiService->deleteVendor($vendorDetails);
        if (!$resp[0]) {
            $this->apiError($resp[1], $resp[2], $resp[3]);
        } else {
            $this->apiSuccess($resp[1], $resp[2], $resp[3]);
        }
    }
    /** Vendor Section */

    /** Category Section */
    public function createdCategory()
    {
        $payload = $this->validateJwtApiToken();
        $categoryDetails = $this->request->getPost();
        $imageFile = $this->request->getFile('image');
        
        $categoryDetails['user_id'] = $payload->user_id;
        $categoryDetails['user_type'] = $payload->user_type;
        
        $resp = $this->apiService->createdCategory($categoryDetails,$imageFile);
        if (!$resp[0]) {
            $this->apiError($resp[1], $resp[2], $resp[3]);
        } else {
            $this->apiSuccess($resp[1], $resp[2], $resp[3]);
        }
    }
    public function updateCategory() 
    {
        $payload = $this->validateJwtApiToken();
        
        $categoryDetails = $this->request->getPost();
        $imageFile = $this->request->getFile('image');
        $categoryDetails['user_id'] = $payload->user_id;
        $categoryDetails['user_type'] = $payload->user_type;

        $resp = $this->apiService->updateCategory($categoryDetails,$imageFile);
        if (!$resp[0]) {
            $this->apiError($resp[1], $resp[2], $resp[3]);
        } else {
            $this->apiSuccess($resp[1], $resp[2], $resp[3]);
        }
    }
    public function deleteCategory()
    {
        $payload = $this->validateJwtApiToken();
        
        $categoryDetails = $this->request->getPost();
        $categoryDetails['user_id'] = $payload->user_id;
        $categoryDetails['user_type'] = $payload->user_type;
        
        $resp = $this->apiService->deleteCategory($categoryDetails);
        if (!$resp[0]) {
            $this->apiError($resp[1], $resp[2], $resp[3]);
        } else {
            $this->apiSuccess($resp[1], $resp[2], $resp[3]);
        }
    }
    public function updateCategoryStatus()  
    {
        $payload = $this->validateJwtApiToken();
        
        $categoryDetails = $this->request->getJSON(true);
        $categoryDetails['user_id'] = $payload->user_id;
        $categoryDetails['user_type'] = $payload->user_type;  
        $resp = $this->apiService->updateCategoryStatus($categoryDetails);
        if (!$resp[0]) {
            $this->apiError($resp[1], $resp[2], $resp[3]);
        } else {
            $this->apiSuccess($resp[1], $resp[2], $resp[3]);
        }
    }
    /** Category Section */

    /** Product Section */
    public function deleteProduct()
    {
        $payload = $this->validateJwtApiToken();
        
        $productDetails = $this->request->getPost();
        $productDetails['user_id'] = $payload->user_id;
        $productDetails['user_type'] = $payload->user_type;
        
        $resp = $this->apiService->deleteProduct($productDetails);
        if (!$resp[0]) {
            $this->apiError($resp[1], $resp[2], $resp[3]);
        } else {
            $this->apiSuccess($resp[1], $resp[2], $resp[3]);
        }
    }
    public function updateProductStatus()  
    {
        $payload = $this->validateJwtApiToken();
        
        $productDetails = $this->request->getJSON(true);
        $productDetails['user_id'] = $payload->user_id;
        $productDetails['user_type'] = $payload->user_type;  
        $resp = $this->apiService->updateProductStatus($productDetails);
        if (!$resp[0]) {
            $this->apiError($resp[1], $resp[2], $resp[3]);
        } else {
            $this->apiSuccess($resp[1], $resp[2], $resp[3]);
        }
    }
    /** Product Section */
}
