<?php
        require_once("task_and_dayOff_db.php");
        header("Access-Control-Allow-Origin: *");
        header("Content-type: application/json");
        require_once("../../response_api.php");

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
        if (!property_exists($input, 'inprogressTask')) {
            error_response(3, "Dữ liệu không đầy đủ");
        }

        // Lấy dữ liệu 
        $inprogressTask = $input -> inprogressTask;
        
        // Kiểm tra dữ liệu có hợp lệ?
        if($inprogressTask === "") {
            error_response(4, "Dữ liệu không hợp lệ");
        }

        $result = updateInProgressTask($inprogressTask);
        if ($result) {
            success_response(0, "Cập nhật trạng thái thành công");
        } else {
            error_response(5, "Cập nhật trạng thái thất bại");
        }
?>