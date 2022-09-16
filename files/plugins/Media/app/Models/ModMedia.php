<?php

namespace App\Models;

use CodeIgniter\Model;

class ModMedia extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'media';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'uri', 'path', 'type', 'created_at', 'updated_at', 'deleted_at'];

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


    // 取得資料夾樹狀以及檔案詳細資料屬性
    function getTreeRecursive($path){
        $tree = [];
        $files = scandir($path);
        foreach($files as $file){
            if($file != '.' && $file != '..'){
                if(is_dir($path.'/'.$file)){
                    $tree[$file] = $this->getTreeRecursive($path.'/'.$file);
                }else{
                    $tree['files'][] = $this->getFileInfo($path.'/'.$file);
                }
            }
        }
        return $tree;
    }
    function getFileInfo($file){
        $info = [];
        $info['name'] = basename($file);
        $info['path'] = $file;
        $info['size'] = filesize($file);
        $info['type'] = filetype($file);
        $info['ctime'] = date('Y-m-d H:i:s',filectime($file));
        $info['atime'] = date("Y-m-d H:i:s",fileatime($file));
        $info['mtime'] = date("Y-m-d H:i:s",filemtime($file));
        return $info;
    }

}
