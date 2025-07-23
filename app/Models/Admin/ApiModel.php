<?php 

namespace App\Models\Admin;

use CodeIgniter\Model;

class ApiModel extends Model {

    public function checkAdminLogin($email)   
    {
        $db = \Config\Database::connect();
        $builder = $db->table(ADMIN_TABLE);
        $loginDetails = $builder
            ->select('*')
            ->where('email', $email)
            ->where('status', ACTIVE_STATUS)
            ->get()
            ->getRowArray();
        return $loginDetails;
    }

    public function createdVendor($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table(VENDOR_TABLE); 

        $success = $builder->insert($data); 

        if ($success) {
            return $data;
        } else {
            return false;
        }
    }
}