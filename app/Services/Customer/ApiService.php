<?php

namespace App\Services\Customer;

use CodeIgniter\Validation\Validation;

use App\Models\CommonModel;
use App\Models\Customer\ApiModel;

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
            $success = $this->apiModel->checkCustomerLogin($data['email']);
            if (!$success) {
                return [false, 401, 'Invalid email', ['invalid_credentials']];
            }

            if ($success['status'] == INACTIVE_STATUS) {
                return [false, 401, 'Account Inactive. Please contact Admin.', ['account_inactive']];
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

    /** Register */
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
    /** Register */

    /** Request Section */
    public function createdRequest($data)
    {
        $validationRules = [
            'productId'  => 'required',
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $requestUid = generateUid();

        try {
            $productDetails = $this->commonModel->getSingleData(PRODUCT_TABLE, ['uid' => $data['productId'], 'status' => ACTIVE_STATUS]);
            $addData = [
                'uid'          => $requestUid,
                'customer_id'  => $data['user_id'],
                'message'      => $data['message'],
                'product_id'   => $data['productId'],
                'vendor_id'    => $productDetails['vendor_id'],
            ];
            $success = $this->commonModel->insertData(REQUEST_LIST_TABLE, $addData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Request failed.',
                    ['error' => 'Database insert failed']
                ];
            }
            $vendor = $this->commonModel->getSingleData(VENDOR_TABLE, ['uid' => $productDetails['vendor_id'], 'status !=' => DELETED_STATUS]);
            $product = $this->commonModel->getSingleData(PRODUCT_TABLE, ['uid' => $data['productId'], 'status !=' => DELETED_STATUS]);
            $customer = $this->commonModel->getSingleData(CUSTOMER_TABLE, ['uid' => $data['user_id'], 'status !=' => DELETED_STATUS]);

            $this->sendCustomerProductRequestEmail($customer['name'], $customer['email'], $product['name']);
            $this->sendVendorProductRequestEmail($vendor['name'], $vendor['email'], $data['user_id'], $customer['name'], $customer['email'], $product['name']);

            return [
                true,
                200,
                'Request successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }
    /** Request Section */

    public function createdRating($data)
    {
        $validationRules = [
            'productId'  => 'required',
            'rating'  => 'required',
            'review'     => 'required',
        ];
        $validationResult = validateData($data, $validationRules);
        if (!$validationResult['success']) {
            return [false, $validationResult['status'], $validationResult['message'], $validationResult['errors']];
        }
        $ratingUid = generateUid();

        try {
            $addData = [
                'uid'          => $ratingUid,
                'product_id'   => $data['productId'],
                'customer_id'  => $data['user_id'],
                'rating'       => $data['rating'],
                'review'       => $data['review'],
            ];
            $success = $this->commonModel->insertData(PRODUCT_RATING_LIST_TABLE, $addData);
            if (!$success) {
                return [
                    false,
                    500,
                    'Rating failed.',
                    ['error' => 'Database insert failed']
                ];
            }

            //$this->sendCustomerPasswordToEmail($data['name'],$data['email'], $plainPassword);

            return [
                true,
                200,
                'Rating successfully.',
                ['data' => $success]
            ];
        } catch (\Throwable $e) {
            return [false, 500, 'Unexpected server error occurred', [$e->getMessage()]];
        }
    }

    private function sendCustomerProductRequestEmail($name, $email, $product_name)
    {
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setFrom('www.bd.project@gmail.com', 'Foundry');
        $emailService->setSubject('Product Request Confirmation');

        $message = "
            Dear $name,<br><br>
            Thank you for your interest in our product.<br>
            We have received your request for: <b>$product_name</b>.<br><br>
            Our team will review your request and get back to you shortly.<br><br>
            Regards,<br>
            Foundry Team
        ";

        $emailService->setMessage($message);

        if (!$emailService->send()) {
            log_message('error', 'Failed to send product request confirmation email to ' . $email);
        }
    }

    private function sendVendorProductRequestEmail($vendor_name, $vendor_email, $customer_id, $customer_name, $customer_email, $product_name)
    {
        $emailService = \Config\Services::email();
        $emailService->setTo($vendor_email);
        $emailService->setFrom('www.bd.project@gmail.com', 'Foundry');
        $emailService->setSubject('New Product Request from a Customer');

        $message = "
            Dear $vendor_name,<br><br>
            You have received a new product request.<br><br>

            <b>Product:</b> $product_name<br>
            <b>Requested by:</b> $customer_name<br>
            <b>Customer Email:</b> $customer_email<br><br>

            Please login to your dashboard to view the details.<br><br>
            Regards,<br>
            Foundry Team
        ";

        $emailService->setMessage($message);

        if (!$emailService->send()) {
            log_message('error', 'Failed to send product request notification to vendor ' . $vendor_email);
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
                "You can log in here: <a href='http://localhost/foundry'>Login Page</a><br>" .
                "Thank you."
        );

        if (!$emailService->send()) {
            log_message('error', 'Failed to send password email to ' . $email);
        }
    }


    public function productSearch($search)
    {
        $search = trim($search);
        $db = \Config\Database::connect();
        $products = $db->table(PRODUCT_TABLE)
            ->select('uid, name')
            ->where('status', ACTIVE_STATUS)
            ->like('name', $search)
            ->orLike('description', $search)
            ->get()
            ->getResultArray();
        if (empty($products)) {
            return [false, 404, 'No products found', []];
        }
        return [true, 200, 'Products found', ['products' => $products]];
    }


    public function productSearchInProductList($search)
    {
        $search = trim($search);
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

        $builder->groupStart()
            ->like('p.name', $search)
            ->orLike('p.description', $search)
            ->orLike('v.name', $search)
            ->groupEnd();
        $result = $builder->get()->getResultArray();
        return [true, 200, 'Products found', ['products' => $result]];
        // return $result;
    }
}
