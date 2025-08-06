<?php

namespace App\Services\Admin;

use CodeIgniter\Validation\Validation;

use App\Models\CommonModel;
use App\Models\Admin\ApiModel;

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

    /** Customer Section */
    public function createdCustomer($data, $file)
    {
        $validationRules = [
            'name'      => 'required',
            'email'     => 'required',
            'mobile'    => 'required',
            'dob'       => 'required',
            'password'  => 'required'
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $vendorUid = generateUid();
        // Handle file upload
        $uploadResult = null;
        $timestamp = timestamp();
        $image_path = '';
        if ($file && $file->isValid() && !$file->hasMoved()) {

            $uploadResult = uploadFile($file, 'vendor', $timestamp);
            if (isset($uploadResult['error'])) {
                return [
                    'status'     => 'failed',
                    'statusCode' => 400,
                    'message'    => 'File upload failed',
                    'errors'     => ['Vendor Image' => $uploadResult['error']],
                ];
            }
            $image_path = $uploadResult['path'];
        }

        try {
            $plainPassword = $data['password'];
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

            $addData = [
                'uid'        => $vendorUid,
                'image'      => $image_path,
                'name'       => $data['name'],
                'mobile'     => $data['mobile'],
                'email'      => $data['email'],
                'password'   => $hashedPassword,
                'dob'        => $data['dob'],
                'created_by' => $data['user_id'] ?? NULL,
            ];
            $success = $this->commonModel->insertData(CUSTOMER_TABLE, $addData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Customer registration failed.',
                    ['error' => 'Database insert failed']
                ];
            }

            $this->sendCustomerPasswordToEmail($data['name'], $data['email'], $plainPassword);

            return [
                true,
                200,
                'Customer registered successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    public function updateCustomer($data, $file)
    {
        $validationRules = [
            'name'      => 'required',
            'email'     => 'required',
            'mobile'    => 'required',
            'dob'       => 'required'
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $customerUid = $data['customerUid'];
        $timestamp = timestamp();
        // Handle file upload
        $uploadResult = null;
        $image_path = '';
        if ($file && $file->isValid() && !$file->hasMoved()) {

            $uploadResult = uploadFile($file, 'customer', $timestamp);
            if (isset($uploadResult['error'])) {
                return [
                    'status'     => 'failed',
                    'statusCode' => 400,
                    'message'    => 'File upload failed',
                    'errors'     => ['customer Image' => $uploadResult['error']],
                ];
            }
            $image_path = $uploadResult['path'];
        }

        try {
            $updateData = [
                'name'       => $data['name'],
                'mobile'     => $data['mobile'],
                'email'      => $data['email'],
                'dob'        => $data['dob'],
                'updated_by' => $data['user_id'] ?? NULL,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            if (!empty($image_path)) {
                $updateData['image'] = $image_path;
            }

            $success = $this->commonModel->UpdateData(CUSTOMER_TABLE, ['uid' => $customerUid], $updateData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Customer Details Update failed.',
                    ['error' => 'Database update failed']
                ];
            }

            return [
                true,
                200,
                'Customer details update successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    public function updateCustomerStatus($data)
    {
        $validationRules = [
            'status'     => 'required',
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $customerUid = $data['uid'];

        try {
            $updateData = [
                'status'      => $data['status'],
                'updated_by' => $data['user_id'] ?? NULL,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $success = $this->commonModel->UpdateData(CUSTOMER_TABLE, ['uid' => $customerUid], $updateData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Customer Details Update failed.',
                    ['error' => 'Database update failed']
                ];
            }

            return [
                true,
                200,
                'Customer details update successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    public function deleteCustomer($data)
    {
        $validationRules = [
            'uid'      => 'required'
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $customerUid = $data['uid'];

        try {
            $updateData = [
                'status'     => DELETED_STATUS,
                'updated_by' => $data['user_id'] ?? NULL,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $success = $this->commonModel->UpdateData(CUSTOMER_TABLE, ['uid' => $customerUid], $updateData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Customer Details Deleted failed.',
                    ['error' => 'Database Deleted failed']
                ];
            }

            return [
                true,
                200,
                'Customer details Deleted successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    /** Customer Section */

    /** Vendor Section */
    public function createdVendor($data, $file)
    {
        $validationRules = [
            'name'      => 'required',
            'email'      => 'required',
            'mobile'      => 'required',
            'country'      => 'required',
            // 'dob'      => 'required'
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $vendorUid = generateUid();
        $timestamp = timestamp();
        // Handle file upload
        $uploadResult = null;
        $image_path = '';
        if ($file && $file->isValid() && !$file->hasMoved()) {

            $uploadResult = uploadFile($file, 'vendor', $timestamp);
            if (isset($uploadResult['error'])) {
                return [
                    'status'     => 'failed',
                    'statusCode' => 400,
                    'message'    => 'File upload failed',
                    'errors'     => ['Vendor Image' => $uploadResult['error']],
                ];
            }
            $image_path = $uploadResult['path'];
        }

        try {
            $plainPassword = generateRandomPassword(8);
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

            $addData = [
                'uid'        => $vendorUid,
                'country'    => $data['country'],
                'image'      => $image_path,
                'name'       => $data['name'],
                'mobile'     => $data['mobile'],
                'email'      => $data['email'],
                'password'   => $hashedPassword,
                'dob'        => $data['dob'] ?? "",
                'created_by' => $data['user_id'] ?? NULL,
                'company' => $data['company'] ?? null,
                'website' => $data['website'] ?? null,
                'address' => $data['address'] ?? null,
                'city' => $data['city'] ?? null,
                'states' => $data['states'] ?? null,
                'gst' => $data['gst'] ?? null,
                'created_by' => "",
                'status' => 'inactive' , 
            ];

            $success = $this->apiModel->createdVendor($addData);

            if (!$success) {
                return [
                    false,
                    500,
                    'Vendor registration failed.',
                    ['error' => 'Database insert failed']
                ];
            }
            $message = "🎉 Thank you for registering with Foundry as a vendor!
                        We’re reviewing your account, 
                        and once it’s activated, 
                        your login credentials will be shared with you via email.";

            $this->sendVendorPasswordToEmail($data['email'], $message);

            return [
                true,
                200,
                'Vendor registered successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    public function updateVendor($data, $file)
    {
        $validationRules = [
            'name'      => 'required',
            'email'      => 'required',
            'mobile'      => 'required',
            'country'      => 'required',
            'dob'      => 'required'
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $vendorUid = $data['vendorUid'];
        // Handle file upload
        $uploadResult = null;
        $timestamp = timestamp();
        $image_path = '';
        if ($file && $file->isValid() && !$file->hasMoved()) {

            $uploadResult = uploadFile($file, 'vendor', $timestamp);
            if (isset($uploadResult['error'])) {
                return [
                    'status'     => 'failed',
                    'statusCode' => 400,
                    'message'    => 'File upload failed',
                    'errors'     => ['Vendor Image' => $uploadResult['error']],
                ];
            }
            $image_path = $uploadResult['path'];
        }

        try {
            $updateData = [
                'country'    => $data['country'],
                'name'       => $data['name'],
                'mobile'     => $data['mobile'],
                'email'      => $data['email'],
                'dob'        => $data['dob'],
                'updated_by' => $data['user_id'] ?? NULL,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!empty($image_path)) {
                $updateData['image'] = $image_path;
            }

            $success = $this->commonModel->UpdateData(VENDOR_TABLE, ['uid' => $vendorUid], $updateData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Vendor Details Update failed.',
                    ['error' => 'Database update failed']
                ];
            }

            return [
                true,
                200,
                'Vendor details update successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    public function updateVendorStatus($data)
    {
        $validationRules = [
            'status'      => 'required'
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $vendorUid = $data['uid'];

        try {
            $updateData = [
                'status'     => $data['status'],
                'updated_by' => $data['user_id'] ?? NULL,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $success = $this->commonModel->UpdateData(VENDOR_TABLE, ['uid' => $vendorUid], $updateData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Vendor Details Update failed.',
                    ['error' => 'Database update failed']
                ];
            }

            return [
                true,
                200,
                'Vendor details update successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    public function deleteVendor($data)
    {
        $validationRules = [
            'uid'      => 'required'
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $vendorUid = $data['uid'];

        try {
            $updateData = [
                'status'     => DELETED_STATUS,
                'updated_by' => $data['user_id'] ?? NULL,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $success = $this->commonModel->UpdateData(VENDOR_TABLE, ['uid' => $vendorUid], $updateData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Vendor Details Deleted failed.',
                    ['error' => 'Database Deleted failed']
                ];
            }

            return [
                true,
                200,
                'Vendor details Deleted successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    /** Vendor Section */

    /** Category Section */
    public function createdCategory($data, $file)
    {
        $validationRules = [
            'name'       => 'required'
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $categoryUid = generateUid();
        $timestamp = timestamp();

        // Handle file upload
        $uploadResult = null;
        $image_path = null;
        if ($file && $file->isValid() && !$file->hasMoved()) {

            $uploadResult = uploadFile($file, 'category', $timestamp);
            if (isset($uploadResult['error'])) {
                return [
                    'status'     => 'failed',
                    'statusCode' => 400,
                    'message'    => 'File upload failed',
                    'errors'     => ['Vendor Image' => $uploadResult['error']],
                ];
            }
            $image_path = $uploadResult['path'];
        }

        try {
            $addData = [
                'uid'        => $categoryUid,
                'title'      => $data['name'],
                'image'      => $image_path,
                'path'       => $data['category'],
                'created_by' => $data['user_id'] ?? NULL,
            ];
            $success = $this->commonModel->insertData(CATEGORY_TABLE, $addData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Category Insert failed.',
                    ['error' => 'Database insert failed']
                ];
            }

            return [
                true,
                200,
                'Category Insert successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    public function updateCategory($data, $file)
    {
        $validationRules = [
            'name'      => 'required'
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $categoryUid = $data['categoryUid'];
        $timestamp = timestamp();
        // Handle file upload
        $uploadResult = null;
        $image_path = '';
        if ($file && $file->isValid() && !$file->hasMoved()) {

            $uploadResult = uploadFile($file, 'category', $timestamp);
            if (isset($uploadResult['error'])) {
                return [
                    'status'     => 'failed',
                    'statusCode' => 400,
                    'message'    => 'File upload failed',
                    'errors'     => ['customer Image' => $uploadResult['error']],
                ];
            }
            $image_path = $uploadResult['path'];
        }

        try {
            $updateData = [
                'title'      => $data['name'],
                'path'       => $data['path'],
                'updated_by' => $data['user_id'] ?? NULL,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            if (!empty($image_path)) {
                $updateData['image'] = $image_path;
            }

            $success = $this->commonModel->UpdateData(CATEGORY_TABLE, ['uid' => $categoryUid], $updateData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Category Details Update failed.',
                    ['error' => 'Database update failed']
                ];
            }

            return [
                true,
                200,
                'Category details update successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    public function deleteCategory($data)
    {
        $validationRules = [
            'uid'      => 'required'
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $categoryUid = $data['uid'];

        try {
            $updateData = [
                'status'     => DELETED_STATUS,
                'updated_by' => $data['user_id'] ?? NULL,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $success = $this->commonModel->UpdateData(CATEGORY_TABLE, ['uid' => $categoryUid], $updateData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Category Details Deleted failed.',
                    ['error' => 'Database Deleted failed']
                ];
            }

            return [
                true,
                200,
                'Category details Deleted successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }

    public function updateCategoryStatus($data)
    {
        $validationRules = [
            'status'     => 'required',
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $categoryUid = $data['uid'];

        try {
            $updateData = [
                'status'      => $data['status'],
                'updated_by' => $data['user_id'] ?? NULL,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $success = $this->commonModel->UpdateData(CATEGORY_TABLE, ['uid' => $categoryUid], $updateData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Category Details Update failed.',
                    ['error' => 'Database update failed']
                ];
            }

            return [
                true,
                200,
                'Category details update successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    /** Category Section */

    /** Product Section */
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
        $adminUid = $data['user_id'];

        try {
            $plainPassword = $data['password'];
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
            $updateData = [
                'password'      => $hashedPassword,
                'updated_by'    => $data['user_id'] ?? NULL,
                'updated_at'    => date('Y-m-d H:i:s')
            ];

            $success = $this->commonModel->UpdateData(ADMIN_TABLE, ['uid' => $adminUid], $updateData);
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

    private function sendVendorPasswordToEmail($email, $message)
    {
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setFrom('www.bd.project@gmail.com', 'Foundry');
        $emailService->setSubject('Thank you for registering with Foundry as a vendor');
        $emailService->setMessage(
            $message
        );

        if (!$emailService->send()) {
            log_message('error', 'Failed to send password email to ' . $email);
        }
    }

    private function sendCustomerPasswordToEmail($name, $email, $plainPassword)
    {
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setFrom('www.bd.project@gmail.com', 'Foundry');
        $emailService->setSubject('Your Account Password');
        $emailService->setMessage(
            "Dear $name,<br>" .
                "Your account has been created.<br>" .
                "Login Email: <b>$email</b><br>" .
                "Password: <b>$plainPassword</b><br>" .
                "You can log in here: <a href='http://localhost/foundry/customer/'>Login Page</a><br>" .
                "Thank you."
        );

        if (!$emailService->send()) {
            log_message('error', 'Failed to send password email to ' . $email);
        }
    }
}
