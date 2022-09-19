<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Section extends Migration
{
    public function up()
    {
        //
        $cols = [
            'id'=>[
                'type'=>'VARCHAR',
                'constraint'=>50,
            ],
            'ref_model'=>[
                'type'=>'VARCHAR',
                'constraint'=>50,
            ],
            'ref_id'=>[
                'type'=>'VARCHAR',
                'constraint'=>50,
            ],
            'description'=>[
                'type'=>'TEXT',
            ],
            'sort'=>[
                'type'=>'INT',
                'constraint'=>11,
            ],
            'created_at'=>[
                'type'=>'DATETIME',
                'null'=>true,
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
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('section');

    }

    public function down()
    {
        //
    }
}
