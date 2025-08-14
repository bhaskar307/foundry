<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Common extends BaseController
{

    protected $validation;
    protected $current_datetime;

    /** api response success */
    public function apiSuccess(
        int $httpStatus = 200,
        string $message,
        $data = null
    ) {

        $resp = [
            'success'    => true,
            'httpStatus' => $httpStatus,
            'message'    => $message,
            'data'       => $data,
        ];

        return $this->response
            ->setJSON($resp)
            ->setStatusCode($httpStatus)
            ->send();
    }

    /** api response error */
    public function apiError(
        int $httpStatus = 500,
        string $message,
        array $errors = [],
        $data = []
    ) {
        return $this->response
            ->setJSON([
                'success'    => false,
                'httpStatus' => $httpStatus,
                'message'    => $message,
                'errors'     => $errors,
                'data'       => $data,
            ])
            ->setStatusCode($httpStatus)
            ->send();
    }

    /** Check Admin JWT Tocken */
    public function validateJwtWebToken()
    {
        $jwt = $this->request->getCookie(ADMIN_JWT_TOKEN);

        if (empty($jwt)) {
            return false;
        }

        $data = validateJWT($jwt);
        return $data ?: false;
    }
    public function validateJwtApiToken()
    {
        $jwt  = $this->request->getCookie(ADMIN_JWT_TOKEN);

        if (empty($jwt)) {
            $this->apiError(401, 'Unauthorize access', ['auth_token_missing_401']);
            exit;
        } else {
            $data = validateJWT($jwt);

            if (!$data) {
                $this->apiError(401, 'Unauthorize access', ['auth_token_invalid_401']);
                exit;
            } else {
                return $data;
            }
        }
    }
    /** Check Admin JWT Tocken */

    /** Check Admin JWT Tocken */
    public function validateJwtWebTokenVendor()
    {
        $jwt = $this->request->getCookie(VENDOR_JWT_TOKEN);

        if (empty($jwt)) {
            return false;
        }

        $data = validateJWT($jwt);
        return $data ?: false;
    }
    public function validateJwtApiTokenVendor()
    {
        $jwt  = $this->request->getCookie(VENDOR_JWT_TOKEN);

        if (empty($jwt)) {
            $this->apiError(401, 'Unauthorize access', ['auth_token_missing_401']);
            exit;
        } else {
            $data = validateJWT($jwt);

            if (!$data) {
                $this->apiError(401, 'Unauthorize access', ['auth_token_invalid_401']);
                exit;
            } else {
                return $data;
            }
        }
    }
    /** Check Admin JWT Tocken */

    /** Check Customer JWT Tocken */
    public function validateJwtWebTokenCustomer()
    {
        $jwt = $this->request->getCookie(CUSTOMER_JWT_TOKEN);
        if (empty($jwt)) {
            return false;
        }

        $data = validateJWT($jwt);
        return $data ?: false;
    }
    public function validateJwtApiTokenCustomer()
    {
        $jwt  = $this->request->getCookie(CUSTOMER_JWT_TOKEN);

        if (empty($jwt)) {
            $this->apiError(401, 'Unauthorize access', ['auth_token_missing_401']);
            exit;
        } else {
            $data = validateJWT($jwt);

            if (!$data) {
                $this->apiError(401, 'Unauthorize access', ['auth_token_invalid_401']);
                exit;
            } else {
                return $data;
            }
        }
    }


    public function dd($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die;
    }
    /** Check Customer JWT Tocken */
}
