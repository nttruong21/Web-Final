<?php
    require_once("departmental_db.php");
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    require_once("../../response_api.php");

    // Kiểm tra phương thức 
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        error_response(1, "API chỉ hỗ trợ phương thức GET");
    }

    if (!isset($_GET['id'])) {
        error_response(2, "Dữ liệu không đầy đủ");
    }

    $id = $_GET['id'];
    if ($id === "") {
        error_response(3, "Dữ liệu không hợp lệ");
    }
    
    $result = get_departmental($id);
    if ($result) {
        success_response($result, "Lấy dữ liệu phòng ban thành công");
    } else {
        error_response(4, "Lấy dữ liệu phòng ban thất bại");
    }
?>