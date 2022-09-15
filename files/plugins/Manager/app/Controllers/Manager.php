<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Api;
use App\Models\ModManager;

class Manager extends BaseController
{

    public function __construct()
    {
        $this->manager = new ModManager();
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
     * @api {post} /Manager/createOne/      Manager Create One
     * @apiName Manager Create One
     * @apiSampleRequest /Manager/createOne/
     * @apiGroup Manager
     * @apiVersion 0.1.0
     * @apiDescription Create One
     * 
     * @apiHeader {String} Authorization Bearer + Token

     * @apiBody {String} managerId         Manager Id
     * @apiBody {String} managerName       Manager Name
     * @apiBody {String} managerPassword   Manager Password
     * @apiBody {Number} level             Manager Level
        
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * @apiSuccess {String} data Data
     */
    function createOne()
    {
        $cols = ['managerId', 'managerName', 'managerPassword', 'level'];
        $required = ['managerId', 'managerName', 'managerPassword', 'level'];
        $data = $this->api->chkJsonApi($cols, $required);
        // 如果 managerId 已經存在，就不要新增
        $chk = $this->manager->find($data['managerId']);
        if ($chk) {
            $this->api->show('500', 'error', 'managerId already exists');
        }
        $data['managerPassword'] = password_hash($data['managerPassword'], PASSWORD_DEFAULT);
        $this->manager->insert($data);
        $this->api->show('200', 'success', 'create success');
        
    }
    /**
     * @api {post} /Manager/setOne/      Manager Insert or Update One
     * @apiName Manager setOne One
     * @apiSampleRequest /Manager/setOne/
     * @apiGroup Manager
     * @apiVersion 0.1.0
     * @apiDescription Update One <span>這裡不提供修改密碼功能</span>
     * 
     * @apiHeader {String} Authorization Bearer {Token}
    
     * @apiBody {String} managerId         Manager Id
     * @apiBody {String} managerName       Manager Name
     * @apiBody {String} managerPassword   Manager Password
     * @apiBody {Number} level             Manager Level
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    

    function setOne(){
        $cols = ['managerId', 'managerName','managerPassword', 'level'];
        $required = ['managerId', 'managerName', 'level'];
        $data = $this->api->chkJsonApi($cols, $required);
        
        $data['level'] = 1;
        if($this->manager->find($data['managerId'])){
            $data['updatedAt'] = date('Y-m-d H:i:s');
            $res = $this->manager->update($data['managerId'],$data);
        }else{
            $res = $this->manager->set($data)->insert();
        }   
        $this->api->show('200', 'success', 'update success');
        
    }

    /**
     * @api {post} /Manager/resetPassWord/      Manager reset Password
     * @apiName Manager reset Password
     * @apiSampleRequest /Manager/resetPassWord/
     * @apiGroup Manager
     * @apiVersion 0.1.0
     * @apiDescription reset Password
     * 
     * @apiHeader {String} Authorization Bearer + Token
     * 
     * @apiBody {String} managerId         Manager Id
     * @apiBody {String} managerPassword   Manager Password
     * 
     * @apiSuccess {Number} sysCode Status Code
     */
    function resetPassWord()
    {
        if(!$this->manager->chkOnlyAuthToken()){
            $this->api->show('500', 'error', 'token error');
        }
        $cols = ['managerId', 'managerPassword'];
        $required = ['managerId', 'managerPassword'];
        $data = $this->api->chkJsonApi($cols, $required);
        $chk = $this->manager->find($data['managerId']);
        if (!$chk) {
            $this->api->show('500', 'error', 'managerId not exists');
        }
        $data['managerPassword'] = password_hash($data['managerPassword'], PASSWORD_DEFAULT);
        $data['updatedAt'] = date('Y-m-d H:i:s');
        $res = $this->manager->update($data['managerId'], $data);
        if ($res) {
            $this->api->show('200', 'success', 'update success');
        } else {
            $this->api->show('500', 'error', 'update fail');
        }
    }

    /**
     * @api {post} /Manager/deleteOne/      Manager Delete One
     * @apiName Manager Delete One
     * @apiSampleRequest /Manager/deleteOne/
     * @apiGroup Manager
     * 
     * @apiHeader {String} Authorization Bearer + Token
     * 
     * @apiBody {String} managerId         Manager Id
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function deleteOne()
    {
        $cols = ['managerId'];
        $required = ['managerId'];
        $data = $this->api->chkJsonApi($cols, $required);
        $chk = $this->manager->find($data['managerId']);
        if (!$chk) {
            $this->api->show('500', 'error', 'managerId not exists');
        }
        $res = $this->manager->delete($data['managerId']);
        if ($res) {
            $this->api->show('200', 'success', 'delete success');
        } else {
            $this->api->show('500', 'error', 'delete fail');
        }
    }
    /**
     * @api {post} /Manager/findOne/      Manager Find One
     * @apiName Manager Find One
     * @apiSampleRequest /Manager/findOne/
     * @apiGroup Manager
     * 
     * @apiHeader {String} Authorization Bearer + Token
     * 
     * @apiBody {String} managerId         Manager Id
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * @apiSuccess {String} data Data
     */
    function findOne()
    {
        $cols = ['managerId'];
        $required = ['managerId'];
        $data = $this->api->chkJsonApi($cols, $required);
        $chk = $this->manager->find($data['managerId']);
        if (!$chk) {
            $this->api->show('500', 'error', 'managerId not exists');
        }
        $res = $this->manager->find($data['managerId']);
        $this->api->show('200', 'success', $res);
    }
    /**
     * @api {post} /Manager/findOne/      Manager Find One
     * @apiName Manager Find One
     * @apiSampleRequest /Manager/findOne/
     * @apiGroup Manager
     * 
     * @apiHeader {String} Authorization Bearer + Token
     * 
     
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * @apiSuccess {String} data Data
     */
    function findOneByToken()
    {
        $res = $this->manager->chkOnlyAuthToken();
        print_r($res);
        $this->api->show('200', 'success', $res);
    }

    /**
     * @api {post} /Manager/findAll/      Manager Find All
     * @apiName Manager Find All
     * @apiSampleRequest /Manager/findAll/
     * @apiGroup Manager
     * 
     * @apiHeader {String} Authorization Bearer + Token
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * @apiSuccess {String} data Data
     */
    function findAll()
    {
        $res = $this->manager->findAll();
        $this->api->show('200', 'success', $res);
    }


    /**
     * @api {POST} /Manager/login/      Manager Login
     * @apiName Manager Login
     * @apiSampleRequest /Manager/login/
     * @apiGroup Manager
     * 
     
     * @apiBody {String} managerId         Manager Id
     * @apiBody {String} managerPassword   Manager Password
     *
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * @apiSuccess {String} data Authorization Bearer + Token
     */

    function login(){
        
        $cols = ['managerId', 'managerPassword'];
        $required = ['managerId', 'managerPassword'];
        
        $data = $this->api->chkJsonApi($cols, $required);
        $chk = $this->manager->find($data['managerId']);
        if (!$chk) {
            $this->api->show('500', 'error', 'managerId not exists');
        }
        
        $data['managerPassword'] = md5($data['managerPassword']);
        $managerId = $data['managerId'];
        $managerPassword = $data['managerPassword'];
        $res = $this->manager->chkIdPw($managerId,$managerPassword);

        if ($res) {
            $this->manager->setAuthToken($managerId);
            $manager = $this->manager->find($managerId);
            unset($manager['managerPassword']);
            $log = array(
                'managerId' => $managerId,
                'managerName' => $manager['managerName'],
                'loginIp' => $this->request->getIPAddress(),
                'status' => 1,
                'notices' => 'login success',
                'createdAt' => date('Y-m-d H:i:s')
            );
            $this->db->table('managers_login_history')->set($log)->insert();
            $this->api->show('200', 'success', $manager);
        } else {
            $this->api->show('500', 'error', 'login fail');
        }
    }
    /**
     * @api {GET} /Manager/logout/:managerId      Manager Logout
     * @apiName Manager Logout
     * @apiSampleRequest /Manager/logout/:managerId
     * @apiGroup Manager
     * 
     * @apiHeader {String} Authorization Bearer + Token
     * @apiParam {String} managerId         Manager Id
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     */
    function logout($managerId){
        if(!$this->manager->chkOnlyAuthToken()){
            $this->api->show('500', 'error', 'token error');
        }
        if($this->manager->chkAuthToken($managerId)){
            $this->manager->logOut($managerId);
            $this->api->show('200', 'success', 'logout success');
        }
        $this->api->show('500', 'error', 'logout fail');
    }


}
