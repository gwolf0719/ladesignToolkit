<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Manager extends Seeder
{
    public function run()
    {
        //
        $data = [
            'managerId' => 'admin',
            'managerName' => 'admin',
            'managerPassword' => md5('admin'),
            'level' => 1,
            'authToken' => '',
            'limitTime' => '',
            'createdAt'=>date('Y-m-d H:i:s'),
        ];
        $this->db->table('managers')->insert($data);
        
    }
}
