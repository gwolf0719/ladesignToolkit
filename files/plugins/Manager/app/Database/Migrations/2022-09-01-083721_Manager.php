<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Manager extends Migration
{
    public function up()
    {
        $cols = [
            'managerId' => [
                'type'           => 'VARCHAR',
                'constraint'     => 50,
                'null'           => false,
            ],
            'managerName' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'managerPassword'=>[
                'type'       => 'TEXT',
                'null'       => false,
            ],
            'level'=>[
                'type'       => 'INT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0,
            ],
            'authToken'=>[
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => '',
            ],
            'limitTime'=>[
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'createdAt' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updatedAt' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ];
        $this->forge->addField($cols);
        $this->forge->addPrimaryKey('managerId');
        $this->forge->createTable('managers');

        $cols = [
            'id'=>[
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
                'null'           => false,
            ],
            'managerId' => [
                'type'           => 'VARCHAR',
                'constraint'     => 50,
                'null'           => false,
            ],
            'managerName' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'loginIP'=>[
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'status'=>[
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'notices'=>[
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'createdAt' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ];
        $this->forge->addField($cols);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('managers_login_history');
    }

    public function down()
    {
        //
    }
}
