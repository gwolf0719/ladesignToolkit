<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Contact extends Migration
{
    public function up()
    {
        //
        $cols = [
            'id'=>[
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>false,
            ],
            'com'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
                'null'=>true,
            ],
            'department'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
                'null'=>true,
            ],
            'title'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
                'null'=>true,
            ],
            'name'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
                'null'=>false,
            ],
            'email'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
                'null'=>true,
            ],
            'phone'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
                'null'=>true,
            ],
            'message_type'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
                'null'=>true,
            ],
            'message'=>[
                'type'=>'TEXT',
                'null'=>false,
            ],
            'status'=>[
                'type'=>'INT',
                'constraint'=>1,
            ],
            'created_at'=>[
                'type'=>'DATETIME',
                'null'=>false,
            ],
            'updated_at'=>[
                'type'=>'DATETIME',
                'null'=>true,
            ],
            'deleted_at'=>[
                'type'=>'DATETIME',
                'null'=>true,
            ],
        ];
        $this->forge->addField($cols);
        $this->forge->addPrimaryKey('id', true);
        $this->forge->createTable('contact');
    }

    public function down()
    {
        //
    }
}
