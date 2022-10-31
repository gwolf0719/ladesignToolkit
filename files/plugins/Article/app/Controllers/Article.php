<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModArticle;
use App\Libraries\Api;

class Article extends BaseController
{
    function __construct(){
        $this->article = new ModArticle();
        $this->api = new Api();
        $this->request = \Config\Services::request();
        $this->db = \Config\Database::connect();
    }

    /**
     * @api {post} /Article/add/  新增
     * 
     * @apiName add
     * @apiGroup Article
     * @apiSampleRequest /Article/add/
     * @apiVersion 0.1.0
     * @apiDescription 新增
     * 
     * @apiBody {String} [id] ID
     * @apiBody {String} subject 標題
     * @apiBody {String} [cover] 封面
     * @apiBody {String} content 內容
     * @apiBody {String} [sort] 排序
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function add(){
        $cols = ['id','subject', 'cover', 'content', 'sort'];
        $required = ['subject', 'content'];
        $data = $this->api->chkJsonApi($cols, $required);
        
        
        if($data['id'] == ''){
            $data['id'] = uniqid();
        }
        if($this->db->table('article')->where('id',$data['id'])->countAllResults() > 0){
            $this->api->show(400, 'ID已存在');
        }

        $this->article->insert($data);
        $this->api->show(200, '新增成功');
    }

    /**
     * @api {post} /Article/edit/  編輯
     * 
     * @apiName edit
     * @apiGroup Article
     * @apiSampleRequest /Article/edit/
     * @apiVersion 0.1.0
     * @apiDescription 編輯
     * 
     * @apiBody {String} id ID
     * @apiBody {String} [subject] 標題
     * @apiBody {String} [cover] 封面
     * @apiBody {String} [content] 內容
     * @apiBody {String} [sort] 排序
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function edit(){
        $cols = ['id','subject', 'cover', 'content', 'sort'];
        $required = ['id'];
        $data = $this->api->chkJsonApi($cols, $required);
        if($this->db->table('article')->where('id',$data['id'])->countAllResults() == 0){
            $this->api->show(404, 'ID不存在');
        }
        $this->article->update($data['id'], $data);
        $this->api->show(200, '編輯成功');
    }

    /**
     * @api {post} /Article/del/  刪除
     * 
     * @apiName del
     * @apiGroup Article
     * @apiSampleRequest /Article/del/
     * @apiVersion 0.1.0
     * @apiDescription 刪除
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
        if($this->db->table('article')->where('id',$data['id'])->countAllResults() == 0){
            $this->api->show(404, 'ID不存在');
        }
        $this->article->delete($data['id']);
        $this->api->show(200, '刪除成功');
    }

    /**
     * @api {post} /Article/get/  取得
     * 
     * @apiName get
     * @apiGroup Article
     * @apiSampleRequest /Article/get/
     * @apiVersion 0.1.0
     * @apiDescription 取得
     * 
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * @apiSuccess {Array} data Data
     */
    function get(){
        $data = $this->article->orderBy('sort','asc')->orderBy('created_at','desc')->get()->getResultArray();
        $this->api->show(200, '取得成功', $data);
    }

    /**
     * @api {post} /Article/getOne/:id  取得單筆
     * 
     * @apiName getOne
     * @apiGroup Article
     * @apiSampleRequest /Article/getOne/
     * @apiVersion 0.1.0
     * @apiDescription 取得單筆
     * 
     * @apiParam {String} id ID
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * @apiSuccess {Array} data Data
     */
    function getOne($id){
        $data = $this->article->where('id',$id)->first();
        if($data == null){
            $this->api->show(404, 'ID不存在');
        }
        $this->api->show(200, '取得成功', $data);
    }
}
