<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\Cookie\Cookie;

/** Admin */
if (!function_exists('generateJwtTokenAdmin')) {
    function generateJwtTokenAdmin($data)
    {
        $key = getenv('JWT_SECRET');
        $issuedAt = time();
        $expireAt = $issuedAt + 360000; // 100 hours

        $payload = array_merge(
            [
                'iat'       => $issuedAt,
                'exp'       => $expireAt
            ],
            $data 
        );

        $token = JWT::encode($payload, $key, 'HS256');

        $cookie = new Cookie(ADMIN_JWT_TOKEN, $token, [
            'expires'  => $expireAt,
            'path'     => "/",
            'domain'   => "",
            'secure'   => false,
            'httponly' => false,
            // 'samesite' => 'none',
        ]);

        return [$token, $cookie];
    }
}
if (!function_exists('validateJWT')) {
    function validateJWT($token)
    {
        try {
            $key = getenv('JWT_SECRET');
            return JWT::decode($token, new Key($key, 'HS256'));
        } catch (Exception $e) {
            return false;
        }
    }
}
if (!function_exists('deleteJwtToken')) {
    function deleteJwtToken($name)
    {
        return new Cookie($name, '', [
            'expires'  => -1,
            'path'     => "/",
            'domain'   => "",
            'secure'   => false,
            'httponly' => false,
            // 'samesite' => 'none',
        ]);
    }
}
/** Admin */

/** Vendors */
if (!function_exists('generateJwtTokenVendor')) {
    function generateJwtTokenVendor($data)
    {
        $key = getenv('JWT_SECRET');
        $issuedAt = time();
        $expireAt = $issuedAt + 360000; // 100 hours

        $payload = array_merge(
            [
                'iat'       => $issuedAt,
                'exp'       => $expireAt
            ],
            $data 
        );

        $token = JWT::encode($payload, $key, 'HS256');

        $cookie = new Cookie(VENDOR_JWT_TOKEN, $token, [
            'expires'  => $expireAt,
            'path'     => "/",
            'domain'   => "",
            'secure'   => false,
            'httponly' => false,
            // 'samesite' => 'none',
        ]);

        return [$token, $cookie];
    }
}
/** Vendors */