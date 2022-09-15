<?php

namespace App\Models;

use CodeIgniter\Model;

class ModMember extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'members';
    protected $primaryKey       = 'account';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','account','password','name','email','phone','avatar','authToken','limitTime','created_at','updated_at','deleted_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

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

    // 驗證帳密是否吻合
    function chkIdPw($account,$password){
        $member = $this->find($account);
        if($member['password'] == $password){
            return true;
        }else{
            return false;
        }
    }
    // 寫入 authToken
    function setAuthToken($account){
        $member = $this->find($account);
        $key = $member['account'].$member['password'].date('YmdHis');
        $member['authToken'] = md5($key);
        $member['limitTime'] = date('Y-m-d H:i:s',time()+60*60*24);
        $this->update($account,$member);
        return $member['authToken'];
    }
    // 從 http header 中取得 authToken
    function getAuthToken(){
        $authToken = $_SERVER['HTTP_AUTHORIZATION'];
        
        if ($authToken == null || $authToken == ''){
            return false;
        }
        // 去除 Bearer 字串
        // $authToken = substr($authToken,7);
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
        $member = $this->where('authToken',$authToken)->first();
        if($member){
            if($member['limitTime'] > date('Y-m-d H:i:s')){
                return $member;
            }
        }
        return false;
        
    }
    
    // token + account 時驗證 用於自己對自己的資料才能操作的 API
    function chkAuthToken($account){
        $authToken = $this->getAuthToken();
        if(!$authToken){
            return false;
        }
        $member = $this->find($account);
        if($member['authToken'] == $authToken){
            if($member['limitTime'] > date('Y-m-d H:i:s')){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    function logOut($account){
        $member = $this->find($account);
        $member['authToken'] = '';
        $member['limitTime'] = '';
        $this->update($account,$member);
        return true;
    }
}
