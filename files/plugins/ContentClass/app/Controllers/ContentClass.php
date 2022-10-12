<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Api;
use App\Libraries\Arr;
class ContentClass extends BaseController
{
    function __construct(){
        $this->api = new Api();
        $this->arr = new Arr();
        $this->request = \Config\Services::request();
        $this->db = \Config\Database::connect();
    }

    // 建立分類
    /**
     * @api {post} /ContentClass/add/  新增分類
     * 
     * @apiName add
     * @apiGroup ContentClass
     * @apiSampleRequest /ContentClass/add/
     * @apiVersion 0.1.0
     * @apiDescription 新增
     * 
     * @apiBody {String} [id] ID
     * @apiBody {String} ref_model 模組
     * @apiBody {String} [parent_id] 上層ID
     * @apiBody {String} name 名稱
     * @apiBody {String} [sort] 排序
     */

     function add(){
        $cols = ['id','ref_model','parent_id','name','sort'];
        $required = ['ref_model','name'];
        $data = $this->api->chkJsonApi($cols, $required);

        if($data['id'] == ''){
            $data['id'] = uniqid();
        }
        if($this->db->table('content_class')->where('id',$data['id'])->countAllResults() > 0){
            $this->api->show(400, 'ID已存在');
        }

        $this->db->table('content_class')->insert($data);
        $this->api->show(200, '新增成功');
     }


    //  取得分類樹狀圖
    /**
     * @api {get} /ContentClass/getTree/:ref_model  取得分類樹狀圖
     * 
     * @apiName getTree
     * @apiGroup ContentClass
     * @apiSampleRequest /ContentClass/getTree/:ref_model
     * @apiVersion 0.1.0
     * @apiDescription 取得分類樹狀圖
     * 
        * @apiParam {String} ref_model 模組
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * @apiSuccess {Array} data 資料
     */

     function getTree($ref_model){
        
        $all = $this->db->table('content_class')->where('ref_model',$ref_model)->orderBy('sort','asc')->get()->getResultArray();
        $tree = $this->arr->toTree($all, 'id', 'parent_id', 'children');
        $this->api->show(200, '取得成功', $tree);
     }

    /**
     * @api {post} /ContentClass/del/ 刪除分類
     * 
     * @apiName del
     * @apiGroup ContentClass
     * @apiSampleRequest /ContentClass/del/
     * @apiVersion 0.1.0
     * @apiDescription 刪除分類
     * 
     * @apiBody {String} id ID
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */

     function del(){
        $cols = ['id'];
        $required = ['id'];
        $data = $this->api->chkJsonApi($cols, $required);
        $id = $data['id'];
        // 判斷分類存在
        if($this->db->table('content_class')->where('id',$id)->countAllResults() == 0){
            $this->api->show(400, '分類不存在');
        }
        // 判斷是否有子分類
        if($this->db->table('content_class')->where('parent_id',$id)->countAllResults() > 0){
            $this->api->show(400, '有子分類，無法刪除');
        }
        
        $this->db->table('content_class')->where('id',$id)->delete();
        $this->api->show(200, '刪除成功');
     }

    //  修改分類
    /**
     * @api {post} /ContentClass/edit/ 修改分類
     * 
     * @apiName edit
     * @apiGroup ContentClass
     * @apiSampleRequest /ContentClass/edit/
     * @apiVersion 0.1.0
     * @apiDescription 修改分類
     * 
     * @apiBody {String} id ID
     * @apiBody {String} [ref_model] 模組
     * @apiBody {String} [parent_id] 上層ID
     * @apiBody {String} [name] 名稱
     * @apiBody {String} [sort] 排序
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */

     function edit(){
        $cols = ['id','ref_model','parent_id','name','sort'];
        $required = ['id'];
        $data = $this->api->chkJsonApi($cols);

        // 判斷分類存在
        if($this->db->table('content_class')->where('id',$data['id'])->countAllResults() == 0){
            $this->api->show(400, '分類不存在');
        }
        $this->db->table('content_class')->where('id',$data['id'])->update($data);
        $this->api->show(200, '修改成功');
     }

    //  配對內容
    /**
     * @api {post} /ContentClass/setContentClassMapping/ 配對內容
     * @apiName setContentClassMapping
     * @apiGroup ContentClass
     * @apiSampleRequest /ContentClass/setContentClassMapping/
     * @apiVersion 0.1.0
     * @apiDescription 配對內容
     * 
     * @apiBody {String} ref_model 模組
     * @apiBody {String} ref_id 內容ID
     * @apiBody {String} ref_id_col 內容ID欄位
     * @apiBody {String} class_id 分類ID
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function setContentClassMapping(){
        $cols = ['ref_model','ref_id_col','ref_id','class_id','sort'];
        $required = ['ref_model','ref_id_col','ref_id','class_id'];
        $data = $this->api->chkJsonApi($cols);
        
        // 判斷內容是否存在
        if($this->db->table($data['ref_model'])->where($data['ref_id_col'],$data['ref_id'])->countAllResults() == 0){
            $sql = $this->db->getLastQuery()->getQuery();
            $this->api->show(400, '內容不存在',$sql);
        }
        // 判斷類別是否存在
        if($this->db->table('content_class')->where('id',$data['class_id'])->countAllResults() == 0){
            $this->api->show(400, '類別不存在');
        }
        // 判斷是否已經配對
        if($this->db->table('content_class_map')->where('ref_model',$data['ref_model'])->where('ref_id_col',$data['ref_id_col'])->where('ref_id',$data['ref_id'])->where('class_id',$data['class_id'])->countAllResults() > 0){
            $this->api->show(400, '已經配對');
        }
        // 設定配對
        $data['id'] = uniqid();
        
        $this->db->table('content_class_map')->insert($data);
        $this->api->show(200, '配對成功');
    }


    /**
     * @api {post} /ContentClass/unSetContentClassMapping/ 刪除配對
     * @apiName unSetContentClassMapping
     * @apiGroup ContentClass
     * @apiSampleRequest /ContentClass/unSetContentClassMapping/
     * @apiVersion 0.1.0
     * @apiDescription 刪除配對
     * 
     * @apiBody {String} ref_model 模組
     * @apiBody {String} ref_id 內容ID
     * @apiBody {String} ref_id_col 內容ID欄位
     * @apiBody {String} class_id 分類ID
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function unSetContentClassMapping(){
        $cols = ['ref_model','ref_id_col','ref_id','class_id'];
        $required = ['ref_model','ref_id_col','ref_id','class_id'];
        $data = $this->api->chkJsonApi($cols);
        // 判斷是否已經配對
        if($this->db->table('content_class_map')->where('ref_model',$data['ref_model'])->where('ref_id_col',$data['ref_id_col'])->where('ref_id',$data['ref_id'])->where('class_id',$data['class_id'])->countAllResults() == 0){
            $this->api->show(400, '未配對');
        }
        // 刪除配對
        $this->db->table('content_class_map')->where('ref_model',$data['ref_model'])->where('ref_id_col',$data['ref_id_col'])->where('ref_id',$data['ref_id'])->where('class_id',$data['class_id'])->delete();
        $this->api->show(200, '取消配對成功');
    }





}
