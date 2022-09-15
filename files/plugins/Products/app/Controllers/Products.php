<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Api;
use App\Models\ModProducts;

class Products extends BaseController
{
    function __construct(){
        $this->product = new \App\Models\ModProducts();
        $this->api = new Api();
        $this->request =\Config\Services::request();
        $this->db = \Config\Database::connect();
    }

    
    /**
     * @api {post} /Products/addProduct/    Products 建立商品
     * @apiName Products addProduct
     * @apiSampleRequest /Products/addProduct/
     * @apiGroup Products
     * @apiVersion 0.1.0
     * @apiDescription 建立商品
     * 
     * @apiBody {String} product_id 商品編號
     * @apiBody {String} product_name 商品名稱
     * @apiBody {Number} product_price 商品建議價格
     * @apiBody {Number} product_trans_price 商品交易金額
     * @apiBody {String} [product_cover] 商品封面圖
     * @apiBody {String} [product_intro] 商品簡述
     * @apiBody {String} [product_content] 商品詳情
     * @apiBody {Number} [status] 商品狀態
     * 
     * @apiSuccess {String} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * 
     */
    function addProduct(){
        $cols = ['product_id','product_name','product_price','product_trans_price','product_cover','product_intro','product_content','status'];
        $required = ['product_id','product_name','product_price','product_trans_price'];
        $data = $this->api->chkJsonApi($cols, $required);
        if($this->product->find($data['product_id'])){
            $this->api->show('500','商品編號已經存在');
        }
        $this->product->insert($data);
        $this->api->show('200','商品建立成功');

        
    }
    
    /**
     * @api {post} /Products/updateProduct/    Products 修改商品
     * @apiName Products updateProduct
     * @apiSampleRequest /Products/updateProduct/
     * @apiGroup Products
     * @apiVersion 0.1.0
     * @apiDescription 修改商品
     * 
     * @apiBody {String} product_id 商品編號
     * @apiBody {String} product_name 商品名稱
     * @apiBody {Number} product_price 商品建議價格
     * @apiBody {Number} product_trans_price 商品交易金額
     * @apiBody {String} [product_cover] 商品封面圖
     * @apiBody {String} [product_intro] 商品簡述
     * @apiBody {String} [product_content] 商品詳情
     * @apiBody {Number} [status] 商品狀態
     * 
     * 
     * @apiSuccess {String} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function updateProduct(){
        $cols = ['product_id','product_name','product_price','product_trans_price','product_cover','product_intro','product_content','status'];
        $required = ['product_id','product_name','product_price','product_trans_price'];
        $data = $this->api->chkJsonApi($cols, $required);
        if(!$this->product->find($data['product_id'])){
            $this->api->show('500','商品編號不存在');
        }
        $this->product->update($data['product_id'],$data);
        $this->api->show('200','商品修改成功');
    }
    
    /**
     * @api {get} /Products/deleteProduct/:product_id    Products 刪除商品
     * @apiName Products deleteProduct
     * @apiSampleRequest /Products/deleteProduct/:product_id
     * @apiGroup Products
     * @apiVersion 0.1.0
     * @apiDescription 刪除商品
     * 
     * @apiParam {String} product_id 商品編號
     * 
     * @apiSuccess {String} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function deleteProduct($product_id){
        if(!$this->product->find($product_id)){
            $this->api->show('500','商品編號不存在');
        }
        $this->product->delete($product_id);
        $this->api->show('200','商品刪除成功');
    }
    
    /**
     * @api {get} /Products/getProduct/:product_id    Products 查詢單一商品
     * @apiName Products getProduct
     * @apiSampleRequest /Products/getProduct/:product_id
     * @apiGroup Products
     * @apiVersion 0.1.0
     * @apiDescription 查詢單一商品
     * 
     * @apiParam {String} product_id 商品編號
     * 
     * @apiSuccess {String} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function getProduct($product_id){
        $data = $this->product->find($product_id);
        if(!$data){
            $this->api->show('500','商品編號不存在');
        }
        $data['images'] = $this->db->table('product_imgs')->where('product_id',$product_id)->orderBy('sort','asc')->get()->getResultArray();
        $this->api->show('200','查詢成功',$data);   
    }

    /**
     * @api {post} /Products/addProductImg/    images-建立商品圖片
     * @apiName Products addProductImg
     * @apiSampleRequest /Products/addProductImg/
     * @apiGroup Products
     * @apiVersion 0.1.0
     * @apiDescription 建立商品圖片
     * 
     * @apiBody {String} product_id 商品編號
     * @apiBody {String} product_img 圖片名稱
     * @apiBody {Number} [sort] 排序
    
     * 
     * @apiSuccess {String} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * 
     */
    function addProductImg(){
        $cols = ['product_id','product_img','sort'];
        $required = ['product_id','product_img'];
        $data = $this->api->chkJsonApi($cols, $required);
        if(!$this->product->find($data['product_id'])){
            $this->api->show('500','商品編號不存在');
        }
        $this->db->table('product_imgs')->set($data)->insert();
        $this->api->show('200','商品圖片建立成功');
    }
    
    /**
     * @api {post} /Products/delProductImg/    images-刪除商品圖片
     * @apiName Products delProductImg
     * @apiSampleRequest /Products/delProductImg/
     * @apiGroup Products
     * @apiVersion 0.1.0
     * @apiDescription 刪除商品圖片
     * 
     * @apiBody {String} product_id 商品編號
     * @apiBody {String} product_img 圖片名稱
     * 
     * @apiSuccess {String} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * 
     */
    function delProductImg(){
        $cols = ['product_id','product_img'];
        $required = ['product_id','product_img'];
        $data = $this->api->chkJsonApi($cols, $required);
        if($this->db->table('product_imgs')->where($data)->delete()){
            $this->api->show('200','商品圖片刪除成功');
        }else{
            $this->api->show('500','商品圖片刪除失敗');
        }
    }
    /**
     * @api {get} /Products/getProductImg/:product_id    images-查詢商品圖片
     * @apiName Products getProductImg
     * @apiSampleRequest /Products/getProductImg/:product_id
     * @apiGroup Products
     * @apiVersion 0.1.0
     * @apiDescription 查詢商品圖片
     * 
     * 
     * @apiParam {String} product_id 商品編號
     * 
     * @apiSuccess {String} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * @apiSuccess {Array} data 商品圖片
     * 
     */
    function getProductImg($product_id){
        if(!$this->product->find($product_id)){
            $this->api->show('500','商品編號不存在');
        }
        $data = $this->db->table('product_imgs')->where('product_id',$product_id)->get()->getResultArray();
        $this->api->show('200','查詢成功',$data);
        
    }
    /**
     * @api {post} /Products/sortProductImg/    images-設定圖片排序
     * @apiName Products sortProductImg
     * @apiSampleRequest /Products/sortProductImg/
     * @apiGroup Products
     * @apiVersion 0.1.0
     * @apiDescription 設定圖片排序，將所有的圖片直接包成陣列，並且依照順序排列傳送
     * 
     * @apiBody {String} product_id 商品編號
     * @apiBody {String} product_img 圖片路徑
     * @apiBody {Number} sort 排序
     * 
     * @apiExample {json} Request-Example: 
    [
        {
            "product_id": "1",
            "product_img": "photo2",
            "sort": "0"
        },
        {
            "product_id": "1",
            "product_img": "photo1",
            "sort": "2"
        }
    ]
     * 
     * @apiSuccess {String} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function sortProductImg(){
        // 將 php://input 轉成陣列
        $data = json_decode(file_get_contents('php://input'), true);
        $sets = [];
        
        $product_id = $data[0]['product_id'];
        // 判斷 product_id 是否存在
        if(!$this->product->find($product_id)){
            $this->api->show('500','商品編號不存在');
        }
        foreach($data as $key => $val){
            if($val['product_id'] != $product_id){
                $this->api->show('500','商品編號不一致');
            }
            $sets[] = [
                'product_id' => $product_id,
                'product_img' => $val['product_img'],
                'sort' => $val['sort']
            ];
        }
        // 如果 sets 沒有資料
        if(count($sets) == 0){
            $this->api->show('500','沒有資料');
        }
        // print_r($sets);
        // exit();
        $this->db->table('product_imgs')->where('product_id',$product_id)->delete();
        $this->db->table('product_imgs')->insertBatch($sets);
        $this->api->show('200','排序寫入成功');
    }
    /**
     * @api {post} /Products/setProductCover/    images-設定商品封面圖檔
     * @apiName Products setProductCover
     * @apiSampleRequest /Products/setProductCover/
     * @apiGroup Products
     * @apiVersion 0.1.0
     * @apiDescription 設定商品封面圖檔
     * 
     * @apiBody {String} product_id 商品編號
     * @apiBody {String} product_img 圖片名稱
     * 
     * @apiSuccess {String} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function setProductCover(){
        $cols = ['product_id','product_img'];
        $required = ['product_id','product_img'];
        $data = $this->api->chkJsonApi($cols, $required);
        if(!$this->product->find($data['product_id'])){
            $this->api->show('500','商品編號不存在');
        }
        $this->product->where('product_id',$data['product_id'])->set('product_cover',$data['product_img'])->update();
    }

    
    /**
     * @api {post} /Products/addProductSpec/    space-建立商品規格
     * @apiName Products addProductSpec
     * @apiSampleRequest /Products/addProductSpec/
     * @apiGroup Products
     * @apiVersion 0.1.0
     * @apiDescription 建立商品規格
     * 
     * @apiBody {String} product_id 商品編號
     * @apiBody {String} product_spec 規格名稱
     * @apiBody {String} product_spec_price 規格價格
     * 
     * @apiSuccess {String} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function addProductSpec(){
        $cols = ['product_id','product_spec','product_spec_price'];
        $required = ['product_id','product_spec','product_spec_price'];
        $data = $this->api->chkJsonApi($cols, $required);
        if(!$this->product->find($data['product_id'])){
            $this->api->show('500','商品編號不存在');
        }
       
        if($this->db->table('product_specs')->set($data)->insert()){
            $this->api->show('200','商品規格新增成功');
        }else{
            $this->api->show('500','商品規格新增失敗');
        }
    }
    /**
     * @api {post} /Products/editProductSpec/    space-編輯商品規格
     * @apiName Products editProductSpec
     * @apiSampleRequest /Products/editProductSpec/
     * @apiGroup Products
     * @apiVersion 0.1.0
     * @apiDescription 編輯商品規格
     * 
     * @apiBody {String} product_id 商品編號
     * @apiBody {String} product_spec 規格名稱
     * @apiBody {String} product_spec_price 規格價格
     * 
     * @apiSuccess {String} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function editProductSpec(){
        $cols = ['product_id','product_spec','product_spec_price'];
        $required = ['product_id','product_spec','product_spec_price'];
        $data = $this->api->chkJsonApi($cols, $required);
        if(!$this->product->find($data['product_id'])){
            $this->api->show('500','商品編號不存在');
        }
        if($this->db->table('product_specs')->set($data)->where('product_id',$data['product_id'])->update()){
            $this->api->show('200','商品規格修改成功');
        }else{
            $this->api->show('500','商品規格修改失敗');
        }

    }
    
    /**
     * @api {post} /Products/delProductSpec/:id    space-刪除商品規格
     * @apiName Products delProductSpec
     * @apiSampleRequest /Products/delProductSpec/:id
     * @apiGroup Products
     * @apiVersion 0.1.0
     * @apiDescription 刪除商品規格
     * 
     * @apiParam {String} id 商品規格編號
     * 
     * @apiSuccess {String} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function delProductSpec($id){
        if($this->db->table('product_specs')->where('id',$id)->delete()){
            $this->api->show('200','商品規格刪除成功');
        }else{
            $this->api->show('500','商品規格刪除失敗');
        }
    }
    /**
     * @api {post} /Products/setProductSpecSort/    space-設定商品規格排序
     * @apiName Products setProductSpecSort
     * @apiSampleRequest /Products/setProductSpecSort/
     * @apiGroup Products
     * @apiVersion 0.1.0
     * @apiDescription 設定商品規格排序
     * 
     * @apiBody {String} product_id 商品編號
     * @apiBody {String} product_spec 規格名稱
     * @apiBody {String} product_spec_price 規格價格
     * @apiExample {json} Request-Example:
     * [
     *  {
     *      "product_id": "1",
     *      "product_spec": "規格1",
     *      "product_spec_price": "100",
     *      "sort": "1"
     *  },
     *  {
     *      "product_id": "1",
     *      "product_spec": "規格2",
     *      "product_spec_price": "200",
     *      "sort": "2"
     *  }
     * ]
     * 
     * @apiSuccess {String} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function setProductSpecSort(){
        // 將 php://input 轉成陣列
        $data = json_decode(file_get_contents('php://input'), true);
        $sets = [];
        
        $product_id = $data[0]['product_id'];
        // 判斷 product_id 是否存在
        if(!$this->product->find($product_id)){
            $this->api->show('500','商品編號不存在');
        }
        foreach($data as $key => $val){
            if($val['product_id'] != $product_id){
                $this->api->show('500','商品編號不一致');
            }
            $sets[] = [
                'product_id' => $product_id,
                'product_specs' => $val['product_specs'],
                'product_specs_price' => $val['product_specs_price'],
                'sort' => $val['sort']
            ];
        }
        // 如果 sets 沒有資料
        if(count($sets) == 0){
            $this->api->show('500','沒有資料');
        }
        $this->db->table('product_specs')->where('product_id',$product_id)->delete();
        $this->db->table('product_specs')->insertBatch($sets);
        $this->api->show('200','排序寫入成功');
    }


}
