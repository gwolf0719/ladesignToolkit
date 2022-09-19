<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModSection;
use App\Libraries\Api;

class Section extends BaseController
{
    function __construct(){
        $this->section = new \App\Models\ModSection();
        $this->api = new Api();
        $this->request =\Config\Services::request();
        $this->db = \Config\Database::connect();
    }

    /**
     * @api {post} /Section/add/  新增
     * 
     * @apiName add
     * @apiGroup Section
     * @apiSampleRequest /Section/add/
     * @apiVersion 0.1.0
     * @apiDescription 新增
     * 
     * 

     * @apiBody {String} ref_model 模組
     * @apiBody {String} [ref_id_col] 模組ID欄位
     * @apiBody {String} ref_id 模組ID
     * @apiBody {String} description 內容
     * @apiBody {String} [sort] 排序
     * @apiBody {String} [overwrite] 是否覆蓋回主要model內容
     * @apiBody {String} [overwrite_col] 覆蓋欄位
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */

    function add(){
        $cols = ['ref_model','ref_id_col','ref_id','description','sort','overwrite','overwrite_col'];
        $required = ['ref_model','ref_id','description'];
        $data = $this->api->chkJsonApi($cols, $required);
        $data['id'] = uniqid();
        // 檢查 ref 對象
        $key_col = $data['ref_id_col'] ? $data['ref_id_col'] : 'id';
        if($this->db->table($data['ref_model'])->where($key_col,$data['ref_id'])->countAllResults() == 0){
            $this->api->show(404, '對象不存在');
        }
        // 設定排序
        if($data['sort'] == ''){
            $max = $this->db->table('section')->where('ref_model',$data['ref_model'])->where('ref_id',$data['ref_id'])->selectMax('sort')->get()->getRowArray();
            $data['sort'] = $max['sort'] + 1;
        }
        // 寫入section
        $set = array(
            'id'=>$data['id'],
            'ref_model'=>$data['ref_model'],
            'ref_id'=>$data['ref_id'],
            'description'=>$data['description'],
            'sort'=>$data['sort'],
        );
        $this->section->insert($set);
        // 覆蓋回主要model內容
        if($data['overwrite'] == true){
            $des = '';
            $rows = $this->db->table('section')->where('ref_model',$data['ref_model'])->where('ref_id',$data['ref_id'])->orderBy('sort','asc')->get()->getResultArray();
            foreach($rows as $row){
                $des .= $row['description'];
            }
            $this->db->table($data['ref_model'])->where($key_col,$data['ref_id'])->update([$data['overwrite_col']=>$des]);
        }
        $this->api->show(200, '新增成功');
    }

    // 刪除
    /**
     * @api {post} /Section/del/  刪除
     * 
     * @apiName del
     * @apiGroup Section
     * @apiSampleRequest /Section/del/
     * @apiVersion 0.1.0
     * @apiDescription 刪除
     * 
     * 
     * @apiBody {String} id ID
     * 
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */

    function del(){
        $cols = ['id'];
        $required = ['id'];
        $data = $this->api->chkJsonApi($cols, $required);
        $this->mod->delete($data['id']);
        $this->api->show(200, '刪除成功');
    }


    // 更新
    /**
     * @api {post} /Section/update/  更新
     * 
     * @apiName update
     * @apiGroup Section
     * @apiSampleRequest /Section/update/
     * @apiVersion 0.1.0
     * @apiDescription 更新
     * 
     * 
     * @apiBody {String} id ID
     * @apiBody {String} [ref_model] 模組
     * @apiBody {String} [ref_id_col] 模組ID欄位
     * @apiBody {String} [ref_id] 模組ID
     * @apiBody {String} [description] 內容
     * @apiBody {String} [sort] 排序
     * @apiBody {String} [overwrite] 是否覆蓋回主要model內容
     * ＠apiBody {String} [overwrite_col] 覆蓋欄位
     * 
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */

     function update(){
        $cols = ['id','ref_model','ref_id_col','ref_id','description','sort','overwrite','overwrite_col'];
        $required = ['id'];
        $data = $this->api->chkJsonApi($cols, $required);
        // 檢查 id 是否存在
        if($this->mod->find($data['id']) == null){
            $this->api->show(404, 'ID不存在');
        }
        // 檢查 ref 對象
        $key_col = $data['ref_id_col'] ? $data['ref_id_col'] : 'id';
        if($data['ref_id'] && $this->db->table($data['ref_model'])->where($key_col,$data['ref_id'])->countAllResults() == 0){
            $this->api->show(404, '對象不存在');
        }
        // 寫入section
        $set = array(
            'ref_model'=>$data['ref_model'],
            'ref_id'=>$data['ref_id'],
            'description'=>$data['description'],
            'sort'=>$data['sort'],
        );
        $this->mod->update($data['id'],$set);
        // 覆蓋回主要model內容
        if($data['overwrite'] == true){
            $des = '';
            $rows = $this->db->table('section')->where('ref_model',$data['ref_model'])->where('ref_id',$data['ref_id'])->orderBy('sort','asc')->get()->getResultArray();
            foreach($rows as $row){
                $des .= $row['description'];
            }
            $this->db->table($data['ref_model'])->where($key_col,$data['ref_id'])->update([$data['overwrite_col']=>$des]);
        }
        $this->api->show(200, '更新成功');
     }

    

    

    /**
     * @api {post} /Section/getList/  取得列表
     * 
     * @apiName getList
     * @apiGroup Section
     * @apiSampleRequest /Section/getList/
     * @apiVersion 0.1.0
     * @apiDescription 取得列表
     * 
     * 
     * @apiBody {String} ref_model 模組
     * @apiBody {String} [ref_id_col] 模組ID欄位P
     * @apiBody {String} ref_id 模組ID
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * @apiSuccess {Object[]} data 資料
     */
    function getList(){
        $cols = ['ref_model','ref_id'];
        $required = ['ref_model','ref_id'];
        $data = $this->api->chkJsonApi($cols, $required);
        $list = $this->section->where('ref_model',$data['ref_model'])->where('ref_id',$data['ref_id'])->orderBy('sort','asc')->findAll();
        $this->api->show(200, '取得成功', $list);
    }

}
