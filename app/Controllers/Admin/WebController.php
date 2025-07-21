<?php

namespace App\Controllers\Admin;
use App\Controllers\Common;
use App\Services\Admin\WebService;
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
        $jwt = $this->request->getCookie(TOKEN_NAME_JWT);
        if (empty($jwt)) {
            return view('admin/login.php');
        }
        $data = validateJWT($jwt);
        if (!$data) {
            return view('admin/login.php');
        }
        return redirect()->to(base_url('admin/dashboard'));
    }

    /** Dashboard */
    public function dashboard(){ 
        $payload = $this->validateJwtWebToken();
        if (!$payload) {
            return redirect()->to(base_url('admin/login'));
        }

        return
            view('admin/templates/header.php') .
            view('admin/dashboard.php') .
            view('admin/templates/footer.php');
    }

    /** Vendor */
    public function vendors(){ 
        $payload = $this->validateJwtWebToken();
        if (!$payload) {
            return redirect()->to(base_url('admin/login'));
        }

        $resp['resp'] = $this->commonModel->getAllData(VENDOR_TABLE,['status !=' => DELETED_STATUS]);
        return
            view('admin/templates/header.php').
            view('admin/vendor.php',$resp).
            view('admin/templates/footer.php');
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

    /** Logout */
    public function logout()
    {
        $auth_cookie   = deleteJwtToken(TOKEN_NAME_JWT);
        return redirect()
            ->to(base_url('admin/login'))
            ->setCookie($auth_cookie);
    }
}
