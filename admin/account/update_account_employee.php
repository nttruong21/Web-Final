<?php
        require_once("account_db.php");
        header("Access-Control-Allow-Origin: *");
        header("Content-type: application/json");
        require_once("../../response_api.php");

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
        if (!property_exists($input, 'user_id')) {
            error_response(3, "Dữ liệu không đầy đủ");
        }

        // Lấy dữ liệu 
        $user_id = $input -> user_id;

        // Kiểm tra dữ liệu có hợp lệ?
        if($user_id === "") {
            error_response(4, "Dữ liệu không hợp lệ");
        }

        $result = update_account_employee($user_id);
        if ($result) {
            success_response(0, "Cập nhật chức vụ nhân viên thành công");
        } else {
            error_response(5, "Cập nhật chức vụ nhân viên thất bại");
        }
?>