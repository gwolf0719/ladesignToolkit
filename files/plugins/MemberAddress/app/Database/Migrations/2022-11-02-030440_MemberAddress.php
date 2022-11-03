<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MemberAddress extends Migration
{
    public function up()
    {
        //
        $cols = array(
            'id'=>array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ),
            'account'=>array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ),
            'province'=>array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'comment'=>'省',
            ),
            'city'=>array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'comment'=>'市',
            ),
            'area'=>array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'comment'=>'區',
            ),
            'address'=>array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment'=>'地址',
            ),
            'target'=>array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'comment'=>'收件人',
            ),
            'phone'=>array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'comment'=>'電話',
            ),
            'sort'=>array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'default' => 0,
                'comment' => '排序',
            ),
            'is_default'=>array(
                'type' => 'INT',
                'constraint' => 1,
                'null' => false,
                'default' => 0,
                'comment' => '是否預設',
            ),
            'created_at'=>array(
                'type' => 'DATETIME',
                'null' => false,
            ),
            'updated_at'=>array(
                'type' => 'DATETIME',
                'null' => false,
            ),
            'deleted_at'=>array(
                'type' => 'DATETIME',
                'null' => true,
            )
            
        );
        $this->forge->addField($cols);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('account');
        $this->forge->createTable('members_address');
        
    }

    public function down()
    {
        //
    }
}
