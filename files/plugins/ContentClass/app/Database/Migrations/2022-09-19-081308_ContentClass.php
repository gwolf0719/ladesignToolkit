<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContentClass extends Migration
{
    public function up()
    {
        //
        $cols = [
            'id'=>[
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'default' => '',
                'comment' => 'ID',
            ],
            'ref_model'=>[
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'default' => '',
                'comment' => '模組',
            ],
            'parent_id'=>[
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'default' => '',
                'comment' => '父ID',
            ],
            'name'=>[
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'default' => '',
                'comment' => '名稱',
            ],
            'sort'=>[
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'default' => 0,
                'comment' => '排序',
            ]
        ];
        $this->forge->addField($cols);
        $this->forge->addKey('id', true);
        $this->forge->createTable('content_class');


        $cols = [
            'id'=>[
                'type'=>'VARCHAR',
                'constraint'=>20,
            ],
            'ref_model'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
            ],
            'ref_id_col'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
            ],
            'ref_id'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
            ],
            'class_id'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
            ],
            'sort'=>[
                'type'=>'INT',
                'constraint'=>11,
            ]
        ];
        $this->forge->addField($cols);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('content_class_map');
    }

    public function down()
    {
        //
    }
}
