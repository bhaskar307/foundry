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
            return view('vendor/login.php');
        }
        $data = validateJWT($jwt);
        if (!$data) {
            return view('vendor/login.php');
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
            view('vendor/templates/header.php') .
            view('vendor/dashboard.php') .
            view('vendor/templates/footer.php');
    }

    /** Products */
    public function products(){ 
        $payload = $this->validateJwtWebTokenVendor();
        if (!$payload) {
            return redirect()->to(base_url('vendors/login'));
        }

        //$resp['resp'] = $this->commonModel->getAllData(VENDOR_TABLE,['status !=' => DELETED_STATUS]);
        $resp['resp'] = '';
        return
            view('vendors/templates/header.php').
            view('vendors/products.php',$resp).
            view('vendors/templates/footer.php');
    }

    /** customers */
    public function customers(){  
        $payload = $this->validateJwtWebToken();
        if (!$payload) {
            return redirect()->to(base_url('admin/login'));
        }

        $resp['resp'] = $this->commonModel->getAllData(CUSTOMER_TABLE,['status !=' => DELETED_STATUS]);
        return
            view('admin/templates/header.php').
            view('admin/customer.php',$resp).
            view('admin/templates/footer.php');
    }

    /** category */
    public function category(){  
        $payload = $this->validateJwtWebToken();
        if (!$payload) {
            return redirect()->to(base_url('admin/login'));
        }

        $resp['category'] = $this->commonModel->getAllData(CATEGORY_TABLE,['status' => ACTIVE_STATUS]);
        //$resp['resp'] = $this->commonModel->getAllData(CATEGORY_TABLE,['status !=' => DELETED_STATUS]);
        $resp['resp'] = $this->webService->getCategoryData();
        return
            view('admin/templates/header.php').
            view('admin/category.php',$resp).
            view('admin/templates/footer.php');
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
