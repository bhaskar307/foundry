<?php

if (!function_exists('generateUid')) {
    function generateUid($prefix = '')
    {
        $uniquePart = bin2hex(random_bytes(8));
        $uid = $prefix . $uniquePart;
        return strtoupper($uid);
    }
}
if (!function_exists('timestamp')) {
    function timestamp()
    {
        return date('Ymd_His');
    }
}

