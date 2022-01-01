<?php
    require_once("account_db.php");
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    require_once("../../response_api.php");

    // Kiểm tra phương thức 
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        error_response(1, "API chỉ hỗ trợ phương thức GET");
    }

    if (!isset($_GET['id'])) {
        error_response(2, "Chưa truyền id của nhân viên");
    }

    $id = $_GET['id'];
    if ($id === "") {
        error_response(3, "ID rỗng");
    }
    
    $result = get_account($id);
    if ($result) {
        success_response($result, "Đọc thông tin nhân viên thành công");
    } else {
        error_response(4, "Đọc thông tin nhân viên thất bại");
    }
?>