<?php

namespace App\Controllers;

use App\Controllers\BaseController;



use App\Libraries\Api;
use App\Models\ModMember;
use App\Models\ModOrder;
use App\Models\ModProducts;
use App\Models\ModCart;

class Order extends BaseController
{
    public function __construct()
    {
        $this->member = new ModMember();
        $this->order = new ModOrder();
        $this->product = new ModProducts();
        $this->cart = new ModCart();
        $this->api = new Api();
        $this->request =\Config\Services::request();
        $this->db = \Config\Database::connect();
    }


    // 添加商品到購物車
    function addCart(){
        $cols = ['member_id','product_id','product_spec_id','product_qty'];
        $required = ['product_id','product_qty'];
        $data = $this->api->chkJsonApi($cols, $required);
        // 確認商品存在
        $product = $this->product->where('product_id', $data['product_id'])->first();
        if(!$product){
            $this->api->show(400, '商品不存在');
        }
        // 如果商品有規格則需要傳入規格id
        $product_specs = $this->db->table('product_specs')->where('product_id', $data['product_id'])->get()->getResultArray();
        if($product_specs){
            if(!isset($data['product_spec_id'])){
                $this->api->show(400, '商品有規格，請傳入規格id');
            }
            $product_spec = $this->db->table('product_specs')->where('id', $data['product_spec_id'])->get()->getRowArray();
            if(!$product_spec){
                $this->api->show(400, '商品規格不存在');
            }
        }
        // 將商品添加到購物車
        $productData = array(
            'product_id' => $data['product_id'],
            'product_spec_id' => $data['product_spec_id'] ?? '',
            'product_qty'  => $data['product_qty'],
        );
        $cart = $this->cart->setItem($productData);

    }
}
