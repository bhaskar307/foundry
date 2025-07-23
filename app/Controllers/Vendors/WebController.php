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
        return redirect()->to(base_url('vendors/dashboard'));
    }

    /** Dashboard */
    public function dashboard(){ 
        $payload = $this->validateJwtWebTokenVendor();
        if (!$payload) {
            return redirect()->to(base_url('vendors/login'));
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
            return redirect()->to(base_url('vendors/login'));
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
            return redirect()->to(base_url('vendors/login'));
        }
        return
            view('vendors/templates/header.php').
            view('vendors/change_password.php').
            view('vendors/templates/footer.php');
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
