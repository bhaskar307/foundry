<?php
namespace App\Services\Vendors;
use CodeIgniter\Validation\Validation;

use App\Models\CommonModel;
use App\Models\Vendors\ApiModel;

class ApiService
{
    protected $validation;
    protected $apiModel;
    protected $commonModel;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->apiModel = new ApiModel();
        $this->commonModel = new CommonModel();
    }

    /** Login */
    public function login($data) 
    {
        $validationRules = [
            'email'      => 'required',
            'password'   => 'required',
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        
        try {
            $success = $this->apiModel->checkAdminLogin($data['email']);
            if (!$success) {
                return [false, 401, 'Invalid email', ['invalid_credentials']];
            }

            $plainPassword = $data['password']; 
            $hashedPassword = $success['password'];
            if (!password_verify($plainPassword, $hashedPassword)) {
                return [false, 401, 'Invalid Password', ['invalid_credentials']];
            } 

            return [true, 200, "Login successfully", ["data" => $success]];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    /** Login */

    /** Product Section */
    public function createdProduct($data,$file)  
    {
        $validationRules = [
            'name'        => 'required',
            'category'    => 'required',
            'description' => 'required'
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $productUid = generateUid();
        $timestamp = timestamp();   
        // Handle file upload
        $uploadResult = null;
        $image_path = '';
        if ($file && $file->isValid() && !$file->hasMoved()) {

            $uploadResult = uploadFile($file, 'products', $timestamp);
            if (isset($uploadResult['error'])) {
                return [
                    'status'     => 'failed',
                    'statusCode' => 400,
                    'message'    => 'File upload failed',
                    'errors'     => ['products Image' => $uploadResult['error']],
                ];
            }
            $image_path = $uploadResult['path'];
        }
        
        try {
            $addData = [
                'uid'          => $productUid,
                'name'         => $data['name'],
                'description'  => $data['description'],
                'vendor_id'    => $data['user_id'],
                'category_id'  => $data['category'],
                'image'        => $image_path,
                'created_by'   => $data['user_id'] ?? NULL,
            ];
            $success = $this->commonModel->insertData(PRODUCT_TABLE, $addData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Product Data Insert failed.',
                    ['error' => 'Database insert failed']
                ];
            }
            return [
                true,
                200,
                'Product Data Insert successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    public function updateProduct($data,$file)    
    {
        $validationRules = [
            'name'        => 'required',
            'category'    => 'required',
            'description' => 'required'
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $productUid = $data['productUid'];
        $timestamp = timestamp();   
        // Handle file upload
        $uploadResult = null;
        $image_path = '';
        if ($file && $file->isValid() && !$file->hasMoved()) {

            $uploadResult = uploadFile($file, 'product', $timestamp);
            if (isset($uploadResult['error'])) {
                return [
                    'status'     => 'failed',
                    'statusCode' => 400,
                    'message'    => 'File upload failed',
                    'errors'     => ['product Image' => $uploadResult['error']],
                ];
            }
            $image_path = $uploadResult['path'];
        }
        
        try {
            $updateData = [
                'name'         => $data['name'],
                'description'  => $data['description'],
                'vendor_id'    => $data['user_id'],
                'category_id'  => $data['category'],
                'updated_by'   => $data['user_id'] ?? NULL,
                'updated_at'   => date('Y-m-d H:i:s')
            ];
            if(!empty($image_path)){
                $updateData['image'] = $image_path;
            }   
           
            $success = $this->commonModel->UpdateData(PRODUCT_TABLE, ['uid' => $productUid], $updateData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Product Details Update failed.',
                    ['error' => 'Database update failed']
                ];
            }

            return [
                true,
                200,
                'Product details update successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    public function updateProductStatus($data)   
    {
        $validationRules = [
            'status'     => 'required',
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $productUid = $data['uid'];
        
        try {
            $updateData = [
                'status'      => $data['status'],
                'updated_by' => $data['user_id'] ?? NULL,
                'updated_at' => date('Y-m-d H:i:s')
            ]; 
           
            $success = $this->commonModel->UpdateData(PRODUCT_TABLE, ['uid' => $productUid], $updateData);
            if (!$success) {
                return [
                    false,
                    500,
                    'pproduct Status Update failed.',
                    ['error' => 'Database update failed']
                ];
            }

            return [
                true,
                200,
                'pproduct Status update successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    public function deleteProduct($data)   
    {
        $validationRules = [
            'uid'      => 'required'
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $productUid = $data['uid'];
        
        try {
            $updateData = [
                'status'     => DELETED_STATUS,
                'updated_by' => $data['user_id'] ?? NULL,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $success = $this->commonModel->UpdateData(PRODUCT_TABLE, ['uid' => $productUid], $updateData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Product Details Deleted failed.',
                    ['error' => 'Database Deleted failed']
                ];
            }

            return [
                true,
                200,
                'Product details Deleted successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    /** Product Section */

    /** Update Password */
    public function updatePassword($data)   
    {
        $validationRules = [
            'password'     => 'required',
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $vendorUid = $data['user_id'];
        
        try {
            $plainPassword = $data['password'];
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
            $updateData = [
                'password'      => $hashedPassword,
                'updated_by'    => $data['user_id'] ?? NULL,
                'updated_at'    => date('Y-m-d H:i:s')
            ]; 
           
            $success = $this->commonModel->UpdateData(VENDOR_TABLE, ['uid' => $vendorUid], $updateData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Password Update failed.',
                    ['error' => 'Database update failed']
                ];
            }

            return [
                true,
                200,
                'Password update successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    /** Update Password */
}
