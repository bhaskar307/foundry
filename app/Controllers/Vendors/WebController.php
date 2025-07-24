<?php

namespace App\Controllers\Vendors;
use App\Controllers\Common;
use App\Services\Vendors\WebService;
use App\Models\CommonModel;

use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class WebController extends Common
{
    protected $webService;
    protected $commonModel;
    public function __construct()
    {
        $this->session = session();
        $this->webService = new WebService();
        $this->commonModel = new CommonModel();
    }
    
    /** Index */
    public function index()
    {
        $jwt = $this->request->getCookie(VENDOR_JWT_TOKEN);
        
        if (empty($jwt)) {
            return view('vendors/login.php');
        }
        $data = validateJWT($jwt);
        if (!$data) {
            return view('vendors/login.php');
        }
        return redirect()->to(base_url('vendor/dashboard'));
    }

    /** Dashboard */
    public function dashboard(){ 
        $payload = $this->validateJwtWebTokenVendor();
        if (!$payload) {
            return redirect()->to(base_url('vendor/login'));
        }

        return
            view('vendors/templates/header.php') .
            view('vendors/dashboard.php') .
            view('vendors/templates/footer.php');
    }

    /** Products */
    public function products(){ 
        $payload = $this->validateJwtWebTokenVendor();
        if (!$payload) {
            return redirect()->to(base_url('vendor/login'));
        }
        $resp['category'] = $this->commonModel->getAllData(CATEGORY_TABLE,['status' => ACTIVE_STATUS]);
        $resp['resp'] = $this->webService->getProductsDetails();
        return
            view('vendors/templates/header.php').
            view('vendors/products.php',$resp).
            view('vendors/templates/footer.php');
    }

    /** Change Password */
    public function changePassword(){  
        $payload = $this->validateJwtWebTokenVendor();
        if (!$payload) {
            return redirect()->to(base_url('vendor/login'));
        }
        return
            view('vendors/templates/header.php').
            view('vendors/change_password.php').
            view('vendors/templates/footer.php');
    }

    /** Profile */
    public function profile(){ 
        $payload = $this->validateJwtWebTokenVendor();
        if (!$payload) {
            return redirect()->to(base_url('vendor/login'));
        }
        $resp['resp'] = $this->commonModel->getSingleData(VENDOR_TABLE,['uid' => $payload->user_id,'status !=' => DELETED_STATUS]);
        // echo '<pre>';
        // print_r($resp);
        // die;
        return
            view('vendors/templates/header.php').
            view('vendors/profile.php',$resp).
            view('vendors/templates/footer.php');
    }

    /** Update Profile */
    public function edit_profile(){   
        $payload = $this->validateJwtWebTokenVendor();
        if (!$payload) {
            return redirect()->to(base_url('vendor/login'));
        }
        $resp['resp'] = $this->commonModel->getSingleData(VENDOR_TABLE,['uid' => $payload->user_id,'status !=' => DELETED_STATUS]);

        return
            view('vendors/templates/header.php').
            view('vendors/edit_profile.php',$resp).
            view('vendors/templates/footer.php');
    }

    /** Update Profile Data */
    public function edit_profile_data(){   
        $payload = $this->validateJwtWebTokenVendor();
        if (!$payload) {
            return redirect()->to(base_url('vendor/login'));
        }
        $vendorDetails = $this->request->getPost();
        $imageFile = $this->request->getFile('image');
        $vendorDetails['user_id'] = $payload->user_id;
        $resp = $this->webService->updateProfile($vendorDetails,$imageFile);

        $profile = $this->commonModel->getSingleData(VENDOR_TABLE,['uid' => $payload->user_id,'status !=' => DELETED_STATUS]);
        $data['user_id'] = $profile['uid'];
        $data['user_name'] = $profile['name'];
        $data['user_image'] = $profile['image'];
        $data['user_type'] = USER_TYPE_VENDORS;
        list($auth_token, $auth_cookie) = generateJwtTokenVendor($data);
        $this
            ->response
            ->setStatusCode(200)
            ->setCookie($auth_cookie);
        $payload = $this->validateJwtWebTokenVendor();
        echo '<pre>';
        print_r($data);
        die;
        return redirect()->to(base_url('vendor/profile'));
        // if ($resp[0]) {
        //     return redirect()->to(base_url('vendor/profile'));
        // } 
    }


    /** Logout */
    public function logout()
    {
        $auth_cookie   = deleteJwtToken(VENDOR_JWT_TOKEN);
        return redirect()
            ->to(base_url('vendor/login'))
            ->setCookie($auth_cookie);
    }
}
