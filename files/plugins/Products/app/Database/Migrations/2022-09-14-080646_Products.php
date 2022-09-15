<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    public function up()
    {
        //
        $cols = [
            'product_id'=>[
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>false,
            ],
            'product_name'=>[
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>false,
            ],
            'product_price'=>[
                'type'=>'INT',
                'constraint'=>11,
                'null'=>false,
            ],
            'product_trans_price'=>[
                'type'=>'INT',
                'constraint'=>11,
                'null'=>false,
            ],
            'product_cover'=>[
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>false,
            ],
            'product_intro'=>[
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>false,
            ],
            'product_content'=>[
                'type'=>'TEXT',
                'null'=>false,
            ],
            'status'=>[
                'type'=>'INT',
                'constraint'=>1,
                'null'=>false,
            ],
            'created_at'=>[
                'type'=>'DATETIME',
                'null'=>false,
            ],
            'updated_at'=>[
                'type'=>'DATETIME',
                'null'=>false,
            ],
            'deleted_at'=>[
                'type'=>'DATETIME',
                'null'=>true,
            ]
        ];
        $this->forge->addField($cols);
        $this->forge->addPrimaryKey('product_id');
        $this->forge->createTable('products');

        // 商品圖片子表
        $cols = [
            'product_id'=>[
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>false,
            ],
            'product_img'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
                'null'=>false,
            ],
            'sort'=>[
                'type'=>'INT',
                'constraint'=>11,
                'null'=>false,
            ]
        ];
        $this->forge->addField($cols);
        $this->forge->addKey('product_id');
        $this->forge->createTable('product_imgs');

        // 商品規格子表
        $cols = [
            'id'=>[
                'type'=>'INT',
                'constraint'=>11,
                'null'=>false,
                'auto_increment'=>true,
            ],
            'product_id'=>[
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>false,
            ],
            'product_spec'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
                'null'=>false,
            ],
            'product_spec_price'=>[
                'type'=>'INT',
                'constraint'=>11,
                'null'=>false,
            ],
            'sort'=>[
                'type'=>'INT',
                'constraint'=>11,
                'null'=>false,
            ],
        ];
        $this->forge->addField($cols);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('product_id');
        $this->forge->createTable('product_specs');


    }

    public function down()
    {
        //
    }
}
