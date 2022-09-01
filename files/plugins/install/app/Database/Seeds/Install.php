<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Install extends Seeder
{
    public function run()
    {
        $data = array(
                'pluginId' => 'install',
                'pluginName' => 'Install',
                'pluginVersion' => '1.0.0',
                'status' => 1,
                'createdAt' => date('Y-m-d H:i:s'),
            );
        // 判斷 pluginId 是否存在
        $query = $this->db->table('plugins')->where(array('pluginId' => 'install'))->get()->getNumRows();
        if ($query > 0) {
            // 更新
            $this->db->table('plugins')->update($data, array('pluginId' => 'install'));
        } else {
            // 新增
            $this->db->table('plugins')->insert($data);
        }
        
    }
}
