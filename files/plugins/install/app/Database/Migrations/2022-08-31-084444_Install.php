<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Install extends Migration
{
    public function up()
    {
        //
        $cols = array(
            'pluginId'=>array(
                'type'=>'VARCHAR',
                'constraint'=>50,
                'null'=>false,
            ),
            'pluginName'=>array(
                'type'=>'VARCHAR',
                'constraint'=>50,
                'null'=>false,
            ),
            'pluginVersion'=>array(
                'type'=>'VARCHAR',
                'constraint'=>50,
                'null'=>false,
            ),
            'status'=>array(
                'type'=>'INT',
                'constraint'=>1,
                'null'=>false,
            ),
            'createdAt'=>array(
                'type'=>'DATETIME',
                'null'=>false,
            ),
            'updatedAt'=>array(
                'type'=>'DATETIME',
            ),
        );
        $this->forge->addField($cols);
        $this->forge->addPrimaryKey('pluginId');
        $this->forge->createTable('plugins');
        
    }

    public function down()
    {
        //
    }
}
