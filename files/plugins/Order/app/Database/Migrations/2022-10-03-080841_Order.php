<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Order extends Migration
{
    public function up()
    {
        //
        $cols = array(
            'order_id' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ),
            'member_id' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ),
            'member_account' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ),
            'member_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ),
            'member_phone' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ),
            'member_email' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ),
            'lump_sum' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'comment'=>'總金額',
            ),
            'order_status'=> array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment'=>'訂單狀態',
            ),
            'payment_status'=> array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment'=>'付款狀態',
            ),
            'payment_method'=> array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment'=>'付款方式',
            ),
            'payment_track'=> array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment'=>'付款追蹤碼',
            ),
            'logistics_status'=> array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment'=>'物流狀態',
            ),
            'logistics_method'=> array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment'=>'物流方式',
            ),
            'logistics_track'=> array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment'=>'物流追蹤碼',
            ),
            'note'=> array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment'=>'備註',
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => false,
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => false,
            ),
            'deleted_at' => array(
                'type' => 'DATETIME',
                'null' => true,
            ),
        );
        $this->forge->addField($cols);
        $this->forge->addPrimaryKey('order_id');
        $this->forge->createTable('order');

        $cols = array(
            "order_id" => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ),
            "product_id" => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ),
            "product_name" => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ),
            "product_spec_id"=>array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                "comment"=>"商品規格ID",
            ),
            "product_spec"=> array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                "comment"=>"商品規格",
            ),
            "product_spec_price"=> array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                "comment"=>"商品規格價格",
            ),
            "product_price" => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                "comment"=>"單價",
            ),
            "product_trans_price" => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                "comment"=>"實際交易單價",
            ),
            "product_quantity" => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                "comment"=>"數量",
            ),
            "product_total" => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                "comment"=>"小計",
            ),  
        );
        $this->forge->addField($cols);
        $this->forge->addKey('order_id');
        $this->forge->addKey('product_id');
        $this->forge->createTable('order_detail');
    }

    public function down()
    {
        //
    }
}
