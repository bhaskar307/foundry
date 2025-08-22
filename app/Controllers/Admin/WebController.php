<?php

namespace App\Controllers\Admin;

use App\Controllers\Common;
use App\Services\Admin\WebService;
use App\Models\CommonModel;
use App\Models\Customer\WebModel;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class WebController extends Common
{
    protected $webService;
    protected $commonModel;
    protected $webmodel;

    protected $db;
    public function __construct()
    {
        $this->session = session();
        $this->webService = new WebService();
        $this->commonModel = new CommonModel();
        $this->db = \Config\Database::connect();
        $this->webmodel = new WebModel();
    }

    /** Index */
    public function index()
    {
        $jwt = $this->request->getCookie(ADMIN_JWT_TOKEN);
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
    public function dashboard()
    {
        $payload = $this->validateJwtWebToken();
        if (!$payload) {
            return redirect()->to(base_url('admin/login'));
        }
        $data['statics'] = $this->webmodel->getStatics();
        // $this->dd($data) ; 
        return
            view('admin/templates/header.php') .
            view('admin/dashboard.php' , $data) .
            view('admin/templates/footer.php');
    }

    /** Vendor */
    public function vendors()
    {
        $payload = $this->validateJwtWebToken();
        if (!$payload) {
            return redirect()->to(base_url('admin/login'));
        }

        $resp['resp'] = $this->commonModel->getAllData(VENDOR_TABLE, ['status !=' => DELETED_STATUS]);
        return
            view('admin/templates/header.php') .
            view('admin/vendor.php', $resp) .
            view('admin/templates/footer.php');
    }

    /** customers */
    public function customers()
    {
        $payload = $this->validateJwtWebToken();
        if (!$payload) {
            return redirect()->to(base_url('admin/login'));
        }

        $resp['resp'] = $this->commonModel->getAllData(CUSTOMER_TABLE, ['status !=' => DELETED_STATUS]);
        return
            view('admin/templates/header.php') .
            view('admin/customer.php', $resp) .
            view('admin/templates/footer.php');
    }

    /** category */
    public function category()
    {
        $payload = $this->validateJwtWebToken();
        if (!$payload) {
            return redirect()->to(base_url('admin/login'));
        }

        $resp['category'] = $this->commonModel->getAllData(CATEGORY_TABLE, ['status' => ACTIVE_STATUS]);
        //$resp['resp'] = $this->commonModel->getAllData(CATEGORY_TABLE,['status !=' => DELETED_STATUS]);
        $resp['resp'] = $this->webService->getCategoryData();
        return
            view('admin/templates/header.php') .
            view('admin/category.php', $resp) .
            view('admin/templates/footer.php');
    }

    /** Products */
    public function products()
    {
        $payload = $this->validateJwtWebToken();
        if (!$payload) {
            return redirect()->to(base_url('admin/login'));
        }
        $resp['resp'] = $this->webService->getProductsDetails();
        // $this->dd($resp);
        return
            view('admin/templates/header.php') .
            view('admin/products.php', $resp) .
            view('admin/templates/footer.php');
    }


    /** Change Password */
    public function changePassword()
    {
        $payload = $this->validateJwtWebToken();
        if (!$payload) {
            return redirect()->to(base_url('admin/login'));
        }
        return
            view('admin/templates/header.php') .
            view('admin/change_password.php') .
            view('admin/templates/footer.php');
    }

    /** View Product Details */
    public function view_product()
    {
        $payload = $this->validateJwtWebToken();
        if (!$payload) {
            return redirect()->to(base_url('admin/login'));
        }
        $productId = $this->request->getGet('productId');
        $resp['resp'] = $this->webService->getProductsDetailsByProductId($productId);
        return
            view('admin/templates/header.php') .
            view('admin/view_product.php', $resp) .
            view('admin/templates/footer.php');
    }

    /** View vendor Details */
    public function view_vendor_details()
    {
        $payload = $this->validateJwtWebToken();
        if (!$payload) {
            return redirect()->to(base_url('admin/login'));
        }
        $vendorId = $this->request->getGet('vendorId');
        $resp['resp'] = $this->commonModel->getSingleData(VENDOR_TABLE, ['uid' => $vendorId, 'status !=' => DELETED_STATUS]);
        return
            view('admin/templates/header.php') .
            view('admin/vendor_details.php', $resp) .
            view('admin/templates/footer.php');
    }

    /** Requests */
    public function requests()
    {
        $payload = $this->validateJwtWebToken();
        if (!$payload) {
            return redirect()->to(base_url('admin/login'));
        }
        $resp['vendorUid'] = $this->request->getGet('vendor');
        $resp['customerUid'] = $this->request->getGet('customer');
        $resp['productUid'] = $this->request->getGet('product');
        $resp['date'] = $this->request->getGet('date');

        $resp['resp'] = $this->webService->getRequestsDetails($resp['vendorUid'], $resp['customerUid'], $resp['productUid'], $resp['date']);
        $resp['vendor'] = $this->commonModel->getAllData(VENDOR_TABLE, ['status' => ACTIVE_STATUS]);
        $resp['customer'] = $this->commonModel->getAllData(CUSTOMER_TABLE, ['status' => ACTIVE_STATUS]);
        $resp['product'] = $this->commonModel->getAllData(PRODUCT_TABLE, ['status' => ACTIVE_STATUS]);


        return
            view('admin/templates/header.php') .
            view('admin/requests.php', $resp) .
            view('admin/templates/footer.php');
    }

    /** Ratings */
    public function ratings()
    {
        $payload = $this->validateJwtWebToken();
        if (!$payload) {
            return redirect()->to(base_url('admin/login'));
        }
        $resp['customerUid'] = $this->request->getGet('customer');
        $resp['productUid'] = $this->request->getGet('product');
        $resp['customer'] = $this->commonModel->getAllData(CUSTOMER_TABLE, ['status' => ACTIVE_STATUS]);
        $resp['product'] = $this->commonModel->getAllData(PRODUCT_TABLE, ['status' => ACTIVE_STATUS]);
        $resp['resp'] = $this->webService->getCustomerReview($resp['customerUid'], $resp['productUid']);

        return
            view('admin/templates/header.php') .
            view('admin/ratings.php', $resp) .
            view('admin/templates/footer.php');
    }


    public function metaContent()
    {
        $payload = $this->validateJwtWebToken();
        if (!$payload) {
            return redirect()->to(base_url('admin/login'));
        }
        $getAllTags = $this->db->table('meta_tags')->orderBy('id', 'desc')->where('status', 'active')->get()->getResultArray();
        $data['metaDeatils'] = $getAllTags;
        // $this->dd($data);
        return
            view('admin/templates/header.php') .
            view('admin/seo_tags.php', $data) .
            view('admin/templates/footer.php');
    }

    /** Logout */
    public function logout()
    {
        $auth_cookie = deleteJwtToken(ADMIN_JWT_TOKEN);
        return redirect()
            ->to(base_url('admin/login'))
            ->setCookie($auth_cookie);
    }
}
