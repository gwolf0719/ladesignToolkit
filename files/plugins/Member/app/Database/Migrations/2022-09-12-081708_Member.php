<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Member extends Migration
{
    public function up()
    {
        //
        $cols = array(
            'id'=>[
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'account'=>[
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false
            ],
            'name'=>[
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'avatar'=>[
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'phone'=>[
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'email'=>[
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'password'=>[
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'authToken'=>[
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'limitTime'=>[
                'type' => 'DATETIME',
            ],
            'created_at'=>[
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'=>[
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at'=>[
                'type' => 'DATETIME',
                'null' => true,
            ],
        );
        $this->forge->addField($cols);
        $this->forge->addKey('id', true);
        $this->forge->createTable('members');

        $cols = array(
            'id'=>[
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'account'=>[
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false
            ],
            'name'=>[
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'ip'=>[
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'user_agent'=>[
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at'=>[
                'type' => 'DATETIME',
                'null' => true,
            ],
        );
        $this->forge->addField($cols);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('member_logs');
    }

    public function down()
    {
        //
    }
}
