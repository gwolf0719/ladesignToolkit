<?php namespace App\Libraries;
class Page{
    // 取得items
  function items(){
    $request = service('request');
    
    if($request->getGetPost('Items') == ""){
        $items = 100;
    }else{
        $items = $request->getGetPost('Items');
    }
    return $items;
  }
  // 取得items
  function nowPage(){
    $request = service('request');
    if($request->getGetPost('nowPage') == ""){
        $nowPage = 1;
    }else{
        $nowPage = $request->getGetPost('nowPage');
    }
    return $nowPage;
  }


  // 完整輸出
  function pagesData($arr, $items="", $nowPage="")
  {
    if($items == ""){
      $items = $this->items();
    }
    
    if($nowPage == ""){
      $nowPage = $this->nowPage();
    }
    $data = $this->pagesConfig($arr, $items);
    $data['dataList'] = $this->dataList($arr, $items, $nowPage);
    $data['currentPage'] = $nowPage;
    return $data;
  }
  // 單純取得資料
  function dataList($arr, $items, $nowPage)
  {
    $start = ($nowPage - 1) * $items;
    $end = $start + $items;
    $res = array();
    while (
      $start < $end
    ) {
      if (isset($arr[$start])) {
        $res[] = $arr[$start];
      }
      $start = $start + 1;
      # code...
    }
    return $res;
  }
  // 取得分頁設定資料
  function pagesConfig($arr, $items)
  {
    $res['totalCount'] = count($arr);
    $res['totalPage'] = ceil(count($arr) / $items);
    return $res;
  }
}