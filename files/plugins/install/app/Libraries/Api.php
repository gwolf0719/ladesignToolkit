<?php namespace App\Libraries;

/**
 * 2022-07-27 更新版 @James Chou
 * 更新版本內容：快速接收並整理 json 或 get post 資料
 * chkJsonApi 
 * chkGetPostApi
 * 
 */
class Api{
    // 接收 json 資料並驗證
    function chkJsonApi($cols = array(),$requred = array(),$default=array()){
        $json = file_get_contents('php://input');
        $json_arr = json_decode($json,true);
        $res = [];
        $requredErr = [];
        foreach($cols as $col){
            $res[$col] = $json_arr[$col];
            // 如果 $res[$col] 不存在且 $default[$col] 存在，則 $res[$col] = $default[$col];
            if(!isset($res[$col]) && isset($default[$col])){
                $res[$col] = $default[$col];
            }
            // 如果 $res[$col] 不存在且 $requred[$col] 存在，則 $requredErr[] = $col;
            if(!isset($res[$col]) && in_array($col,$requred)){
                $requredErr[] = $col;
            }
        }
        if(count($requredErr)>0){
            $data['requredErr'] = $requredErr;
            $data['cols'] = $cols;
            $data['required'] = $requred;
            $data['default'] = $default;
            $data['request'] = $_REQUEST;
            $this->show('000','Insufficient field data',$data);
        }else{
            return $res;
        }

    }
    // 接收 get post 資料並驗證
    function chkGetPostApi($cols = array(),$requred = array(),$default=array()){
        
        $request = service('request');
        $res = [];
        $requredErr = [];
        foreach($cols as $col){
            $res[$col] = $request->getGetPost($col);
            // 如果 $res[$col] 不存在且 $default[$col] 存在，則 $res[$col] = $default[$col];
            if(!isset($res[$col]) && isset($default[$col])){
                $res[$col] = $default[$col];
            }
            // 如果 $res[$col] 不存在且 $requred[$col] 存在，則 $requredErr[] = $col;
            if(!isset($res[$col]) && in_array($col,$requred)){
                $requredErr[] = $col;
            }
        }
        if(count($requredErr)>0){
            $data['requredErr'] = $requredErr;
            $data['cols'] = $cols;
            $data['required'] = $requred;
            $data['default'] = $default;
            $data['request'] = $_REQUEST;
            $this->show('000','Insufficient field data',$data);
        }else{
            return $res;
        }
    }
    function show($sysCode,$sysMsg='',$data=''){
        if($sysMsg == '' ){
            switch ($sysCode) {
                case '000':
                    # code...
                    $sysMsg = 'Data input error';
                    break;
                case '200':
                    # code...
                    $sysMsg = '成功！';
                    break;
                case '500':
                    $sysMsg = '喔喔！出現問題了！';
                    break;
                case '501':
                    $sysMsg = 'Duplicate Data';
                    break;
                case '404':
                    $sysMsg = 'Data Not Found';
                    break;
                default:
                    # code...
                    $sysMsg = "Other Msg";
                    break;
            }
        }
        $json_arr['sysMsg'] = $sysMsg;
        if($data != ""){
            $json_arr['data'] = $data;
        }
        $json_arr['sysCode'] = $sysCode;
        
        header("ALLOW-CONTROL-ALLOW-ORIGIN:*");
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Request-Headers: *');
        header('Access-Control-Request-Method: *');
        header('Access-Control-Allow-Credentials', true);
        header('Content-Type: application/json; charset=utf-8');
        header('HTTP/1.1 200 OK');
        echo json_encode($json_arr);
        
        exit();
    }
}