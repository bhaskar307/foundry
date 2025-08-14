<?php

namespace App\Controllers\Customer;

use App\Controllers\Common;
use App\Services\Customer\WebService;
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
    public function __construct()
    {
        $this->session = session();
        $this->webService = new WebService();
        $this->commonModel = new CommonModel();
        $this->webmodel = new WebModel();
    }

    /** Index */
    public function index()
    {
        $resp['category'] = $this->commonModel->getCategory();
        //$resp['product'] = $this->commonModel->getAllData(PRODUCT_TABLE,['status' => ACTIVE_STATUS]);
        $resp['product'] = $this->webService->getAllProductDetails();
        $resp['review'] = $this->webService->getCustomerReview();
        // print_r($resp); die ; 
        return
            view('customer/templates/header.php') .
            view('customer/home.php', $resp) .
            view('customer/templates/footer.php');
    }

    /** Product List */
    public function product_list()
    {
        $filterData = [];
        $filter = $this->request->getGet('filter');

        if ($filter) {
            $decoded = base64_decode($filter);
            $filterData = json_decode($decoded, true); // associative array
            // echo '<pre>';
            // print_r($filterData);
            // die();
            $resp['categoryUid'] = $filterData['categories'];
            $resp['priceFrom'] = $filterData['price']['from'];
            $resp['priceTo'] = $filterData['price']['to'];
            $resp['name'] = $filterData['name'] ?? '';
        } else {
            $resp['name'] = '';
            $resp['categoryUid'] = [];
            $resp['priceFrom'] = 100;
            $resp['priceTo'] = 50000;
        }
        $db = \Config\Database::connect();


        // $resp['category'] = $this->commonModel->getAllData(CATEGORY_TABLE, ['status' => ACTIVE_STATUS]);
        $builder = $db->table(CATEGORY_TABLE);
        $builder->select('*');
        $builder->where('status', ACTIVE_STATUS);
        $query = $builder->get();
        $categories = $query->getResultArray();

        // Organize into parent → children structure
        $categoryTree = [];
        foreach ($categories as $category) {
            if (empty($category['path'])) {
                // This is a main category
                $categoryTree[$category['uid']] = $category;
                $categoryTree[$category['uid']]['subcategories'] = [];
            }
        }

        foreach ($categories as $subcategory) {
            if (!empty($subcategory['path']) && isset($categoryTree[$subcategory['path']])) {
                $categoryTree[$subcategory['path']]['subcategories'][] = $subcategory;
            }
        }

        $resp['category'] =  $categoryTree;
        //$resp['product'] = $this->webService->getProductList($resp['categoryUid'],$resp['priceFrom'],$resp['priceTo']);
        $resp['product'] = $this->webService->getFilteredProductDetails($resp['categoryUid'], $resp['priceFrom'], $resp['priceTo']);

        $resp['review'] = $this->webService->getCustomerReview();
        $resp['vendorCountryList'] = $this->webmodel->getVendorCountryList();

         

        return
            view('customer/templates/header.php') .
            view('customer/product_list.php', $resp) .
            view('customer/templates/footer.php');
    }

    /** Category Product */
    public function category_product()
    {
        $resp['category'] = $this->commonModel->getCategory();
        $resp['product'] = $this->commonModel->getAllData(PRODUCT_TABLE, ['status' => ACTIVE_STATUS]);
        $resp['review'] = $this->webService->getCustomerReview();
        return
            view('customer/templates/header.php') .
            view('customer/category.php', $resp) .
            view('customer/templates/footer.php');
    }

    /** Product Details */
    public function product_details($productId)
    {
        $payload = $this->validateJwtWebTokenCustomer();

        if (!empty($payload)) {
            $resp['customerDetails'] = [
                'name' => $payload->user_name,
                'email' => $payload->user_email,
                'phone' => $payload->user_mobile
            ];
        } else {
            $resp['customerDetails'] = [];
        }

        $resp['resp'] = $this->webService->getProductDetailsByProductId($productId);
        $resp['reviews'] = $this->webService->getCustomerReviewByProductId($productId);

        // $resp['product'] = $this->commonModel->getAllData(PRODUCT_TABLE, ['category_id' => $resp['resp']['category_id'], 'status' => ACTIVE_STATUS]);
        $categoryUID = $resp['resp']['category_id'];



        $resp['product'] = $this->webmodel->getAllMightBeProductDetails($categoryUID);
        $vendorUid = $resp['product'][0]['vendor_id'] ?? null;

        // $isMatch = in_array($categoryUID, array_column($resp['product'], 'uid')) ? 1 : 0;

        if (!empty($vendorUid)) {
            $resp['vendor'] = $this->commonModel->getAllData(
                VENDOR_TABLE,
                ['uid' => $vendorUid],
            );
        }
        // print_r($resp['resp']);
        // die;
        return
            view('customer/templates/header.php') .
            view('customer/product_details.php', $resp) .
            view('customer/templates/footer.php');
    }


    /** Register */
    public function registration()
    {
        return
            view('customer/templates/header.php') .
            view('customer/registration.php') .
            view('customer/templates/footer.php');
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
        $payload = $this->validateJwtWebTokenVendor();
        if (!$payload) {
            return redirect()->to(base_url('vendor/login'));
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
        $payload = $this->validateJwtWebTokenVendor();
        if (!$payload) {
            return redirect()->to(base_url('vendor/login'));
        }
        $vendorId = $this->request->getGet('vendorId');
        $resp['resp'] = $this->commonModel->getSingleData(VENDOR_TABLE, ['uid' => $vendorId, 'status !=' => DELETED_STATUS]);
        return
            view('admin/templates/header.php') .
            view('admin/vendor_details.php', $resp) .
            view('admin/templates/footer.php');
    }

    /** Product List */
    public function vendor_register()
    {
        return
            view('customer/templates/header.php') .
            view('customer/vendor_register.php') .
            view('customer/templates/footer.php');
    }

    /** Logout */
    public function logout()
    {
        $auth_cookie   = deleteJwtToken(CUSTOMER_JWT_TOKEN);
        return redirect()
            ->to(base_url())
            ->setCookie($auth_cookie);
    }

    public function getCategory()
    {
        $db = \Config\Database::connect();
        $builder = $db->table(CATEGORY_TABLE);
        $builder->groupStart()
            ->where('path', '')     // Empty string
            ->orWhere('path IS NULL', null, false) // NULL value
            ->groupEnd();
        $builder->where(['status' => ACTIVE_STATUS]);
        return $builder->get()->getResultArray();
    }
}
