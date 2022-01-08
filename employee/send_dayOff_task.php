<?php

    require_once("task_and_dayOff_db.php");
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    require_once("../response_api.php");

    // Kiểm tra phương thức 
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        err_messages(1, "API chỉ hỗ trợ phương thức POST");
    }

    // Đọc JSON từ Client 
    $input = json_decode(file_get_contents('php://input'));

    // Kiểm tra dữ liệu 
    if (is_null($input)) {
        err_messages(2, "Dữ liệu phải ở dạng JSON");
    }
    
    if (!property_exists($input, 'maNVDayOff') || !property_exists($input, 'dayDayOff') || 
    !property_exists($input, 'reasonDayOff')  || !property_exists($input, 'fileDayOff')) 
    {
        err_messages(3, "Dữ liệu không đầy đủ");
    }
    
    // Lấy dữ liệu
    
    $id = $input -> maNVDayOff;
    $numDayOff = $input -> dayDayOff;
    $reason = $input -> reasonDayOff;
    $file = $input -> fileDayOff;


    // Kiểm tra dữ liệu có hợp lệ?
    if(($id) === "" || ($numDayOff) === "" || ($reason) === "" || 
    ($file) === "" ) {
        err_messages(4, "Dữ liệu không hợp lệ");
    }

    require_once("../manager/api/function.php");
    $result = insertFormDayOff($id, $numDayOff, $reason, $file); 
    if ($result == 1) {
        success_messages(0, "Tạo form xin nghỉ phép thành công");
    } else {
        err_messages(5, "Tạo form xin nghỉ phép thất bại");
    }
?>