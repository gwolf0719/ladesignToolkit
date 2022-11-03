<?php

namespace App\Controllers;


use App\Libraries\Api;
use App\Models\ModMember;
use App\Models\ModManager;
use App\Models\ModMembersAddress;

use App\Controllers\BaseController;

class MemberAddress extends BaseController
{
    public function __construct()
    {
        $this->manager = new ModManager();
        $this->member = new ModMember();
        $this->MemberAddress = new ModMembersAddress();
        $this->api = new Api();
        $this->request =\Config\Services::request();
        $this->db = \Config\Database::connect();
    }
    // 取得會員地址簿
    /**
     * @api {get} /MemberAddress/getMemberAddress/:account 取得會員地址簿
     * @apiName getMemberAddress
     * @apiSampleRequest /MemberAddress/getMemberAddress/:account
     * @apiGroup MemberAddress
     * @apiDescription 取得會員地址簿
     * 
     * @apiParam {String} account 會員帳號
     * 
     * @apiSuccess {String} sysCode 狀態碼
     * @apiSuccess {String} sysMsg 訊息
     * @apiSuccess {Object} data 資料
     * 
     */
    public function getMemberAddress($account)
    {
        // 確認會員存在
        if($this->member->where('account',$account)->countAllResults() == 0){
            return $this->api->show('404','會員不存在');
        }
        $data = $this->MemberAddress->where('account',$account)->orderBy('sort','asc')->findAll();
        return $this->api->show('200','',$data);
    }
    // 新增會員地址簿
    /**
     * @api {post} /MemberAddress/addMemberAddress 新增會員地址簿
     * @apiName addMemberAddress
     * @apiSampleRequest /MemberAddress/addMemberAddress
     * @apiGroup MemberAddress
     * @apiDescription 新增會員地址簿
     * 
     * @apiBody {String} account 會員帳號
     * @apiBody {String} province 省
     * @apiBody {String} city 市
     * @apiBody {String} area 區
     * @apiBody {String} target 收件人姓名
     * @apiBody {String} phone 收件人電話
     * @apiBody {String} address 收件人地址
     * @apiBody {String} [sort] 排序
     */
    public function addMemberAddress()
    {
        $cols = ['account','province','city','area','address','target','phone','sort'];
        $required = ['account','province','city','area','address','target','phone'];
        $data = $this->api->chkJsonApi($cols, $required);
        $data['id'] = uniqid();
        // 確認會員存在
        if($this->member->where('account',$data['account'])->countAllResults() == 0){
            return $this->api->show('404','會員不存在');
        }
        $this->MemberAddress->insert($data);
        return $this->api->show('200','新增成功');
    }
    /**
     * @api {post} /MemberAddress/editMemberAddress 修改會員地址簿
     * @apiName editMemberAddress
     * @apiSampleRequest /MemberAddress/editMemberAddress
     * @apiGroup MemberAddress
     * @apiDescription 修改會員地址簿
     * 
     * @apiBody {String} id 會員地址簿id
     * @apiBody {String} account 會員帳號
     * @apiBody {String} province 省
     * @apiBody {String} city 市
     * @apiBody {String} area 區
     * @apiBody {String} target 收件人姓名
     * @apiBody {String} phone 收件人電話
     * @apiBody {String} address 收件人地址
     * @apiBody {String} [sort] 排序
     * 
     * @apiSuccess {String} sysCode 狀態碼
     * @apiSuccess {String} sysMsg 訊息
     * 
     */
    
    public function editMemberAddress()
    {
        $cols = ['id','account','province','city','area','address','target','phone','sort'];
        $required = ['id','account','province','city','area','address','target','phone'];
        $data = $this->api->chkJsonApi($cols, $required);
        
        if($this->MemberAddress->where('id',$data['id'])->where('account',$data['account'])->countAllResults() == 0){
            return $this->api->show('404','地址簿不存在');
        }
        $this->MemberAddress->where('id',$data['id'])->set($data)->update();
        return $this->api->show('200','修改成功');
    }
    
    /**
     * @api {get} /MemberAddress/delMemberAddress/:account/:id 刪除單一地址簿
     * @apiName delMemberAddress
     * @apiSampleRequest /MemberAddress/delMemberAddress/:account/:id
     * @apiGroup MemberAddress
     * @apiDescription 刪除單一地址簿
     * 
     * @apiParam {String} account 會員帳號
     * @apiParam {String} id 會員地址簿id
     * 
     * @apiSuccess {String} sysCode 狀態碼
     * @apiSuccess {String} sysMsg 訊息
     */
    public function delMemberAddress($account,$id){
        // 確認地址簿屬於該會員
        if($this->MemberAddress->where('id',$id)->where('account',$account)->countAllResults() == 0){
            return $this->api->show('404','地址簿不存在');
        }
        $this->MemberAddress->where('id',$id)->delete();
        return $this->api->show('200','刪除成功');
    }

    
    
}
