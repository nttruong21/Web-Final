<?php
    require_once("account_db.php");
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    require_once("../../response_api.php");
    
    // Kiểm tra phương thức 
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        error_response(1, "API chỉ hỗ trợ phương thức GET");
    }

    $accounts = get_accounts();
    success_response($accounts, "Lấy danh sách nhân viên thành công");
?>