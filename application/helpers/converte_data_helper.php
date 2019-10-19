<?php

function mysqlToView($data){
    return date("d/m/Y", strtotime($data));   
}

function viewToMysql($data){
    $data_tmp = explode('/',$data);
     $d_data = $data_tmp[0];
     $m_data = $data_tmp[1];
     $y_data = $data_tmp[2];
     return $y_data.'-'.$m_data.'-'.$d_data;
}