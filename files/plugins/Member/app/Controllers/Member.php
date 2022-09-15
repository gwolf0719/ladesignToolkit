<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Api;
use App\Models\ModMember;
use App\Models\ModManager;


class Member extends BaseController
{

    public function __construct()
    {
        $this->manager = new ModManager();
        $this->member = new ModMember();
        $this->api = new Api();
        $this->request =\Config\Services::request();
        $this->db = \Config\Database::connect();
    }

    /***
     * =========================================================
     * CRUD
     * =========================================================
     */

    
   /**
     * @api {post} /Member/register/    Member 註冊
     * @apiName Member register
     * @apiSampleRequest /Member/register/
     * @apiGroup Member
     * @apiVersion 0.1.0
     * @apiDescription 會員註冊功能
     * 

     * @apiBody {String} account 帳號
     * @apiBody {String} password 密碼
     * @apiBody {String} [name] 姓名
     * @apiBody {String} [phone] 電話
     * @apiBody {String} [email] 信箱
        
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     
     */
    public function register()
    {
        $cols = ['account','password','name','email','phone'];
        $required = ['account','password'];
        $data = $this->api->chkJsonApi($cols, $required);
        // 如果 $data['acctount'] 已經存在，就回傳錯誤訊息
        $chk = $this->member->where('account', $data['account'])->first();
        if($chk){
            $this->api->show(400, '帳號已經存在');
        }
        $data['password'] = md5($data['password']);
        $this->member->insert($data);
        $this->api->show(200, '註冊成功');
    }
    
    /**
     * @api {post} /Member/update/    Member 修改
     * @apiName Member update
     * @apiSampleRequest /Member/update/
     * @apiGroup Member
     * @apiVersion 0.1.0
     * @apiDescription 會員修改功能，如果有給 Authorization 就不可以有 account
     * 
     * @apiHeader {String} Authorization Bearer + Token
     * 
     * @apiBody {String} account 帳號
     * @apiBody {String} [name] 姓名
     * @apiBody {String} [phone] 電話
     * @apiBody {String} [email] 信箱
     * @apiBody {String} [avatar] avatar
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    
    public function update()
    {

        $manager = $this->manager->chkOnlyAuthToken();
        $member = $this->member->chkOnlyAuthToken();
        // 如果有管理員 token 就可以指定 account

        
        $cols = ['account','name','email','phone','avatar'];
        $required = [];
        $data = $this->api->chkJsonApi($cols, $required);
        // 如果有給 Authorization 就不可以有 account
        if($member && $data['account']){
            $this->api->show(400, '不可以有 account');
        }
        if(!$member && !$data['account']){
            $this->api->show(400, '沒有 Authorization，就必須有 account');
        }
        if($member){
            $data['account'] = $member['account'];
        }
         
        $member = $this->member->where('account', $data['account'])->first();
        if(!$member){
            $this->api->show(400, '帳號不存在');
        }
        $this->member->update($member['account'], $data);
        $this->api->show(200, '修改成功');
    }
    

    
    /**
     * @api {post} /Member/setPassword/    Member 設定密碼
     * @apiName Member setPassword
     * @apiSampleRequest /Member/setPassword/
     * @apiGroup Member
     * @apiVersion 0.1.0
     * @apiDescription 會員設定密碼功能，如果有給 Authorization 就不可以有 account
     * 
     * @apiHeader {String} Authorization Bearer + Token
     * 
     * @apiBody {String} account 帳號
     * @apiBody {String} password 密碼
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
     function setPassword(){
        $member = $this->member->chkOnlyAuthToken();
        $cols = ['account','password'];
        $required = ['password'];
        $data = $this->api->chkJsonApi($cols, $required);
        // 如果有給 Authorization 就不可以有 account
        if($member && $data['account']){
            $this->api->show(400, '不可以有 account');
        }
        if(!$member && !$data['account']){
            $this->api->show(400, '沒有 Authorization，就必須有 account');
        }
        if($member){
            $data['account'] = $member['account'];
        }
         
        $member = $this->member->where('account', $data['account'])->first();
        if(!$member){
            $this->api->show(400, '帳號不存在');
        }
        $data['password'] = md5($data['password']);
        $this->member->update($member['account'], $data);
        $this->api->show(200, '修改成功');
     }

    // TODO 查詢會員清單
    /**
     * @api {post} /Member/list/    Member 查詢會員清單
     * @apiName Member list
     * @apiSampleRequest /Member/list/
     * @apiGroup Member
     * @apiVersion 0.1.0
     * @apiDescription 會員查詢會員清單功能
     * 
     * 
     * @apiBody {String} [account] 帳號
     * @apiBody {String} [name] 姓名
     * @apiBody {String} [phone] 電話
     * @apiBody {String} [email] 信箱
     * @apiBody {String} [avatar] avatar
     * @apiBody {String} [page] 頁碼
     * @apiBody {String} [perpage] 每頁筆數
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * @apiSuccess {Object} data Data
     * 
     */

     function list(){
        $member = $this->member->chkOnlyAuthToken();
        $cols = ['account','name','email','phone','avatar','page','perpage'];
        $required = [];
        $data = $this->api->chkJsonApi($cols, $required);
        $page = $data['page'] ?? 1;
        $perpage = $data['perpage'] ?? 10;
        $data = $this->member->where($data)->paginate($perpage, ['*'], 'page', $page);
        $this->api->show(200, '查詢成功', $data);
     }
    // TODO 取得單一會員資料
    // TODO 刪除會員

  
    // TODO 登入
    /**
     * @api {post} /Member/login/    Member 登入
     * @apiName Member login
     * @apiSampleRequest /Member/login/
     * @apiGroup Member
     * @apiVersion 0.1.0
     * @apiDescription 會員登入功能
     * 
     * @apiBody {String} account 帳號
     * @apiBody {String} password 密碼
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * 
     */
    function login(){
        $cols = ['account', 'password'];
        $required = ['account', 'password'];
        
        $data = $this->api->chkJsonApi($cols, $required);
        $chk = $this->member->find($data['account']);
        if (!$chk) {
            $this->api->show('500', 'error', 'account not exists');
        }
        $data['password'] = md5($data['password']);
        
        $res = $this->member->chkIdPw($data['account'],$data['password']);
        
        if ($res) {
            $this->member->setAuthToken($data['account']);
            $member = $this->member->find($data['account']);
            $log = array(
                'account' => $data['account'],
                'name'=> $member['name'],
                'ip' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent(),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $this->db->table('member_logs')->set($log)->insert();
            $this->api->show('200', 'success', $member);
        } else {
            $this->api->show('500', 'error', 'login fail');
        }
    }
    // TODO 登出





}
