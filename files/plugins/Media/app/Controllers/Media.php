<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Api;

class Media extends BaseController
{
    function __construct()
    {
        $this->api = new Api();
        $this->request =\Config\Services::request();
        $this->media = new \App\Models\ModMedia();
    }


    function formTest(){
        return view('media/formTest');
    }

    // 上傳檔案 file
    /**
     * @api {post} /Media/uploadFromFile/    上傳檔案
     * @apiName uploadFromFile
     * @apiGroup Media
     * @apiVersion 0.1.0
     * @apiDescription 上傳檔案 
     * 
     * @apiBody {String} file 檔案
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * @apiSuccess {Object} data 回傳資料
     */
    function uploadFromFile(){
        if(!is_dir('media')){
            mkdir('media', 0777, true);
        }
        $path = 'media/'.$this->request->getPost('path');
        $newName = $this->request->getFile('file')->getRandomName();
        $file = $this->request->getFile('file');
        
        if(is_dir($path)){
            $file->move($path, $newName);
        }else{
            mkdir($path, 0777, true);
            $file->move($path, $newName);
        }
        $data = [
            'uri'=>$path.'/'.$newName,
            'path'=>$path,
            'type'=>$file->getClientMimeType(),
        ];
        $this->api->show(200, '上傳成功',$data);

    }

    // 上傳檔案 base64 轉 uri

    // 刪除檔案
    /**
     * @api {post} /Media/deleteFile Media 刪除檔案
     * @apiSampleRequest /Media/deleteFile/
     * @apiName deleteFile
     * @apiGroup Media
     * @apiDescription 刪除檔案
     * 
     * 
     * 
     * @apiBody {String} path 檔案路徑
     * 
     * @apiSuccess {String} status 狀態
     * @apiSuccess {String} message 訊息
     */
    function deleteFile(){
        $cols = ['path'];
        $required = ['path'];
        $data = $this->api->chkJsonApi($cols, $required);
        if(is_file($data['path'])){
            unlink($data['path']);
            $this->api->show(200, '刪除成功');
        }else{
            $this->api->show(400, '檔案不存在');
        }
    }

    // 刪除資料夾
    /**
     * @api {post} /Media/deleteFolder Media 刪除資料夾
     * @apiSampleRequest /Media/deleteFolder/
     * @apiName deleteFolder
     * @apiGroup Media
     * @apiDescription 刪除資料夾
     * 
     * 
     * 
     * @apiBody {String} path 資料夾路徑
     * 
     * @apiSuccess {String} status 狀態
     * @apiSuccess {String} message 訊息
     */
    function deleteFolder(){
        $cols = ['path'];
        $required = ['path'];
        $data = $this->api->chkJsonApi($cols, $required);
        if(is_dir($data['path'])){
            rmdir($data['path']);
            $this->api->show(200, '刪除成功');
        }else{
            $this->api->show(400, '資料夾不存在');
        }
    }

    


    // 取得資料夾樹狀
    /**
     * @api {get} /Media/getTree/    Media 取得資料夾樹狀
     * @apiName Media getTree
     * @apiSampleRequest /Media/getTree/
     * @apiGroup Media
     * @apiVersion 0.1.0
     * @apiDescription 取得資料夾樹狀
     * 
     * @apiSuccess {Number} sysCode Status Code
     * @apiSuccess {String} sysMsg System Message
     * @apiSuccess {Object} data 資料
     */
    function getTree(){
        $path = 'media';
        $tree = $this->media->getTreeRecursive($path);
        $this->api->show(200, '取得成功', $tree);
    }
    
}
