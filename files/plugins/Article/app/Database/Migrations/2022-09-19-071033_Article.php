<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Article extends Migration
{
    public function up()
    {
        //
        $cols = [
            'id'=>[
                'type'=>'VARCHAR',
                'constraint'=>20
            ],
            'subject'=>[
                'type'=>'VARCHAR',
                'constraint'=>255
            ],
            'cover'=>[
                'type'=>'VARCHAR',
                'constraint'=>255
            ],
            'content'=>[
                'type'=>'TEXT',
                'null'=>true
            ],
            'sort'=>[
                'type'=>'INT',
                'constraint'=>11,
                'default'=>0
            ],
            'created_at'=>[
                'type'=>'DATETIME',
                'null'=>true
            ],
            'updated_at'=>[
                'type'=>'DATETIME',
                'null'=>true
            ],
            'deleted_at'=>[
                'type'=>'DATETIME',
                'null'=>true
            ]
        ];
        $this->forge->addField($cols);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('article');
    }

    public function down()
    {
        //
    }
}
