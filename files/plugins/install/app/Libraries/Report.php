<?php

namespace App\Libraries;

class Report
{

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    // 建立時間序列    
    /**
     * $start 開始時間
     * $end 結束時間
     * $unit 單位 
     * 
     */
    function getTimeSeries($start, $end, $unit = 'd')
    {
        switch ($unit) {
            case 'd':
                $timeLimit = 24 * 60 * 60;
                $format = "Y-m-d";
                break;
        }
        $res = [];
        foreach (range(strtotime($start), strtotime($end), $timeLimit) as $value) {
            $res[] = date($format, $value);
        }
        return $res;

    }

    function getTimeSeriesReport($series,$data){
        $res = [];
        foreach($series as $value){
            
            if(empty($data[$value])){
                $res[] = 0;
            }else{
                $res[] = $data[$value];
            }
        }
        return $res;
    }

    // 取得日期數量
    function getTimeReport($table,$where_arr, $start_time, $end_time, $time_col)
    {
        $output = array();
        $where = "";
        if(is_array($where_arr)){
            foreach($where_arr as $key => $value){
                $where = $where . " " . $key ." = '". $value ."' AND ";
            }   
        }
        $sql    = " SELECT DATE_FORMAT( $time_col , '%Y-%m-%d') AS days , COUNT(*) AS count from $table WHERE $where $time_col BETWEEN '$start_time' AND '$end_time' GROUP BY days ";
        // echo $sql;exit();
        $query  = $this->db->query($sql);

        $result = $query->getResult();

        foreach ($result as $row) {
            $output[$row->days] = (int)$row->count;
        }

        return $output;
    }
    // 取得日期小計
    function getTimeReportSum($table,$where_arr, $start_time, $end_time, $time_col,$sum_col)
    {
        $output = array();
        $where = "";
        if(is_array($where_arr)){
            foreach($where_arr as $key => $value){
                $where = $where . " " . $key ." = '". $value ."' AND ";
            }   
        }
        $sql    = " SELECT DATE_FORMAT( $time_col , '%Y-%m-%d') AS days , SUM($sum_col) AS sum from $table WHERE $where $time_col BETWEEN '$start_time' AND '$end_time' GROUP BY days ";
        
        $query  = $this->db->query($sql);

        $result = $query->getResult();

        foreach ($result as $row) {
            $output[$row->days] = (int)$row->sum;
        }

        return $output;
    }
}
