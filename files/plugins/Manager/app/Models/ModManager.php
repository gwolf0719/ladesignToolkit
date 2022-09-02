<?php

namespace App\Models;

use CodeIgniter\Model;

class ModManager extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'managers';
    protected $primaryKey       = 'managerId';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['managerId', 'managerName', 'managerPassword','authToken','limitTime', 'createdAt', 'updatedAt'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'createdAt';
    protected $updatedField  = 'updatedAt';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];



    function chkIdPw($managerId,$managerPassword){
        $manager = $this->find($managerId);
        if($manager['managerPassword'] == $managerPassword){
            return true;
        }else{
            return false;
        }
    }
    function setAuthToken($managerId){
        $manager = $this->find($managerId);
        $key = $manager['managerId'].$manager['managerPassword'].date('YmdHis');
        $manager['authToken'] = md5($key);
        $manager['limitTime'] = date('Y-m-d H:i:s',time()+60*60*24);
        $this->update($managerId,$manager);
        return $manager['authToken'];
    }
    // 從 http header 中取得 authToken
    function getAuthToken(){
        $authToken = $_SERVER['HTTP_AUTHORIZATION'];
        if ($authToken == null || $authToken == ''){
            return false;
        }
        // 去除 Bearer 字串
        $authToken = substr($authToken,7);
        // 去除空白字元
        $authToken = preg_replace('/\s+/', '', $authToken);
        return $authToken;
    }
    // 只有 token 時驗證
    function chkOnlyAuthToken(){
        $authToken = $this->getAuthToken();
        if(!$authToken){
            return false;
        }
        $manager = $this->where('authToken',$authToken)->first();
        if($manager['limitTime'] > date('Y-m-d H:i:s')){
            return $manager;
        }else{
            return false;
        }
    }
    
    // token + managerId 時驗證 用於自己對自己的資料才能操作的 API
    function chkAuthToken($managerId){
        $authToken = $this->getAuthToken();
        if(!$authToken){
            return false;
        }
        $manager = $this->find($managerId);
        if($manager['authToken'] == $authToken){
            if($manager['limitTime'] > date('Y-m-d H:i:s')){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    function logOut($managerId){
        $manager = $this->find($managerId);
        $manager['authToken'] = '';
        $manager['limitTime'] = '';
        $this->update($managerId,$manager);
        return true;
    }
}
