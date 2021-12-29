<?php
    require_once("departmental_db.php");
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    require_once("../../response_api.php");
    
    // Kiểm tra phương thức 
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        error_response(1, "API chỉ hỗ trợ phương thức GET");
    }

    $departmentals = get_departmentals();
    success_response($departmentals, "Lấy danh sách phòng ban thành công");
?>