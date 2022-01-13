<?php

    require_once("task_and_dayOff_db.php");
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    require_once("../response_api.php");

    // Kiểm tra phương thức 
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        error_response(1, "API chỉ hỗ trợ phương thức POST");
    }

    // Đọc JSON từ Client 
    $input = json_decode(file_get_contents('php://input'));

    // Kiểm tra dữ liệu 
    if (is_null($input)) {
        error_response(2, "Dữ liệu phải ở dạng JSON");
    }
    
    if (!property_exists($input, 'maNVDayOff') || !property_exists($input, 'maPBDayOff') ||
    !property_exists($input, 'dayDayOff') || !property_exists($input, 'reasonDayOff')  || 
    !property_exists($input, 'dayCreateDayOff') || !property_exists($input, 'fileDayOff') || 
    !property_exists($input, 'conditionDayOff')) 

    {
        error_response(3, "Dữ liệu không đầy đủ");
    }
    
    // Lấy dữ liệu
    
    $maNVDayOff = $input -> maNVDayOff;
    $maPBDayOff = $input -> maPBDayOff;
    $dayDayOff = $input -> dayDayOff;
    $reasonDayOff = $input -> reasonDayOff;
    $dayCreateDayOff = $input -> dayCreateDay;
    $fileDayOff = $input -> fileDayOff;
    $conditionDayOff = $input -> conditionDayOff;


    // Kiểm tra dữ liệu có hợp lệ?
    if(($maNVDayOff) === "" || ($maPBDayOff === "") || ($dayDayOff) === "" || 
    ($reasonDayOff) === "" || ($dayCreateDayOff) === "" || ($fileDayOff) === "" || ($conditionDayOff) === "") {
        error_response(4, "Dữ liệu không hợp lệ");
    }

    // require_once("../manager/api/function.php");
    $result = insertFormDayOff($maNVDayOff, $maPBDayOff, $dayDayOff, $conditionDayOff, $reasonDayOff, $dayCreateDayOff, $fileDayOff); 
    if ($result == 1) {
        success_response(0, "Tạo form xin nghỉ phép thành công");
    } else {
        error_response(5, "Tạo form xin nghỉ phép thất bại");
    }
?>