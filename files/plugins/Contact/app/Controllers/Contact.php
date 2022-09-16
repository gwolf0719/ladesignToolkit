<?php
/**
 * 聯絡我們  Controller
 */
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModContact;
use App\Libraries\Api;

class Contact extends BaseController
{
    function __construct()
    {
        $this->contact = new ModContact();
        $this->api = new Api();
        $this->request =\Config\Services::request();
        $this->db = \Config\Database::connect();

        $this->message_type = ['一般問題','產品問題','其他'];
    }
    

    
    /**
     * @api {post} /Contact/add/  新增聯絡我們
     * 
     * @apiName add
     * @apiGroup Contact
     * @apiSampleRequest /Contact/add/
     * @apiVersion 0.1.0
     * @apiDescription 新增聯絡我們
     * 
     * 
     * 
     * @apiBody {String} [com] 公司名稱
     * @apiBody {String} [department] 部門
     * @apiBody {String} [title] 職稱
     * @apiBody {String} name 姓名
     * @apiBody {String} [email] 信箱
     * @apiBody {String} [phone] 電話
     * @apiBody {String} [message_type] 類型
     * @apiBody {String} message 內容
     * @apiBody {String} [status] 狀態
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function add(){
        $cols = ['com','department','title','name','email','phone','message_type','message','status'];
        $required = ['name','message'];
        $data = $this->api->chkJsonApi($cols, $required);
        $data['id'] = uniqid();
        $this->contact->insert($data);
        $this->api->show(200, '新增成功');
        
    }
    /**
     * @api {post} /Contact/switchStatus/  切換狀態
     * @apiName switchStatus
     * @apiGroup Contact
     * @apiSampleRequest /Contact/switchStatus/
     * @apiVersion 0.1.0
     * @apiDescription 切換狀態
     * 
     * @apiBody {String} id 聯絡我們ID
     * @apiBody {String} status 狀態
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function switchStatus(){
        $cols = ['id','status'];
        $required = ['id','status'];
        $data = $this->api->chkJsonApi($cols, $required);
        $this->contact->update($data['id'], ['status'=>$data['status']]);
        $this->api->show(200, '修改成功');
    }
    /**
     * @api {post} /Contact/del/  刪除聯絡我們
     * @apiName del
     * @apiGroup Contact
     * @apiSampleRequest /Contact/del/
     * @apiVersion 0.1.0
     * @apiDescription 刪除聯絡我們
     * 
     * @apiBody {String} id 聯絡我們ID
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function del(){
        $cols = ['id'];
        $required = ['id'];
        $data = $this->api->chkJsonApi($cols, $required);
        $this->contact->delete($data['id']);
        $this->api->show(200, '刪除成功');
    }
    /**
     * @api {post} /Contact/getList/  查詢聯絡我們清單
     * @apiName getList
     * @apiGroup Contact
     * @apiSampleRequest /Contact/getList/
     * @apiVersion 0.1.0
     * @apiDescription 查詢聯絡我們清單
     * 
     * @apiBody {String} [com] 公司名稱
     * @apiBody {String} [department] 部門
     * @apiBody {String} [title] 職稱
     * @apiBody {String} [name] 姓名
     * @apiBody {String} [email] 信箱
     * @apiBody {String} [phone] 電話
     * @apiBody {String} [message_type] 類型
     * @apiBody {String} [message] 內容
     * @apiBody {String} [status] 狀態    
     * 
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * @apiSuccess {Object} data 資料
     */
    function getList(){
        $cols = ['com','department','title','name','email','phone','message_type','message','status'];
        $required = [];
        $data = $this->api->chkJsonApi($cols, $required);
        $where = [];
        foreach($data as $k=>$v){
            if($v){
                $where[$k] = $data[$k];
            }
        }
        if(count($where) > 0){
            $this->contact->where($where);
        }
        $this->api->show(200, '查詢成功', $this->contact->orderBy('created_at','desc')->findAll());
    }

}
