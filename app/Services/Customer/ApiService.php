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

            if($success['status'] == INACTIVE_STATUS){
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
            $productDetails = $this->commonModel->getSingleData(PRODUCT_TABLE,['uid' => $data['productId'],'status' => ACTIVE_STATUS]);
            $addData = [
                'uid'          => $requestUid,
                'customer_id'  => $data['user_id'],
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

            //$this->sendCustomerPasswordToEmail($data['name'],$data['email'], $plainPassword);

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

    private function sendVendorPasswordToEmail($name,$email, $plainPassword)
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
            "You can log in here: <a href='http://localhost/foundry/admin/'>Login Page</a><br>" .
            "Thank you."
        );

        if (!$emailService->send()) {
            log_message('error', 'Failed to send password email to ' . $email);
        }
    }

    private function sendCustomerPasswordToEmail($name,$email, $plainPassword)
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
