<?php 

namespace App\Models\Admin;

use CodeIgniter\Model;

class WebModel extends Model {

    public function test($email, $password)   
    {
        $db = \Config\Database::connect();
        $builder = $db->table(ADMIN_TABLE);
        $loginDetails = $builder
            ->select('*')
            ->where('email', $email)
            ->where('password', $password)
            ->where('status', ACTIVE_STATUS)
            ->get()
            ->getRowArray();
        return $loginDetails;
    }

    
}