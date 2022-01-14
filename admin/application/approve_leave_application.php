<?php
        require_once("application_db.php");
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
        if (!property_exists($input, 'id') || !property_exists($input, 'status')) {
            error_response(3, "Dữ liệu không đầy đủ");
        }

        // Lấy dữ liệu 
        $id = $input -> id;
        $status = $input -> status;

        // Kiểm tra dữ liệu có hợp lệ?
        if(!is_numeric($id) ||  $status == "") {
            error_response(4, "Dữ liệu không hợp lệ");
        }

        $result = approve_leave_application($id, $status);
        if ($result) {
            success_response(0, "Duyệt đơn thành công");
        } else {
            error_response(5, "Duyệt đơn thất bại");
        }
?>