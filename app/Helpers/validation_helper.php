<?php

use Config\Services;

if (!function_exists('validateData')) {
    /**
     * Validation wrapper
     * 
     * @param array $data  - Input data to validate
     * @param array $rules - Validation rules
     * 
     * @return array [success => bool, status => int, message => string, errors => array]
     */
    function validateData(array $data, array $rules): array
    {
        $validation = Services::validation();

        if (!$validation->setRules($rules)->run($data)) {
            $errorsAssoc = $validation->getErrors();

            $errors = [];
            foreach ($errorsAssoc as $field => $msg) {
                $errors[] = strtolower(str_replace(' ', '_', $msg.'_422'));
            }

            return [
                'success' => false,
                'status'  => 422,
                'message' => 'Validation error',
                'errors'  => $errors
            ];
        }

        return [
            'success' => true
        ];
    }
}
