<?php

    require_once("./task_and_dayOff_db.php");
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    require_once("../response_api.php");

    // Kiểm tra phương thức 
    if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
        error_response(1, "API chỉ hỗ trợ phương thức PUT");
    }

    // Đọc JSON từ Client 
    $input = json_decode(file_get_contents('php://input'));

    // Kiểm tra dữ liệu 
    if (is_null($input)) {
        error_response(2, "Dữ liệu phải ở dạng JSON");
    }
    
    if (!property_exists($input, 'id') || !property_exists($input, 'numDayOff') || 
    !property_exists($input, 'reason') || !property_exists($input, 'dayCreate') || !property_exists($input, 'file')) 
    {
        error_response(3, "Dữ liệu không đầy đủ");
    }
    
    // Lấy dữ liệu
    
    $id = $input -> id;
    $numDayOff = $input -> numDayOff;
    $reason = $input -> reason;
    $dayCreate = $input -> dayCreate;
    $file = $input -> file;


    // Kiểm tra dữ liệu có hợp lệ?
    if(($id) === "" || ($numDayOff) === "" || ($reason) === "" || ($dayCreate) === "" || 
    ($file) === "" ) {
         error_response(4, "Dữ liệu không hợp lệ");
    }

    $result = insertFormDayOff($id, $numDayOff, $reason, $dayCreate, $file);
    if ($result) {
        success_response(0, "Tạo form xin nghỉ phép thành công");
    } else {
        error_response(5, "Tạo form xin nghỉ phép thất bại");
    }
?>