<?php
    require_once("departmental_db.php");
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    require_once("../../response_api.php");

    // Kiểm tra phương thức 
    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
        error_response(1, "API chỉ hỗ trợ phương thức DELETE");
    }

    // Đọc JSON từ Client 
    $input = json_decode(file_get_contents('php://input'));

    // Kiểm tra dữ liệu 
    if (is_null($input)) {
        error_response(2, "Dữ liệu phải ở dạng JSON");
    }
    if (!property_exists($input, 'id')) {
        error_response(3, "Dữ liệu không đầy đủ");
    }

    $id = $input -> id;
    if ($id === "") {
        error_response(4, "Dữ liệu không hợp lệ");
    }

    $result = delete_departmental($id);
    if ($result) {
        success_response(0, "Xóa thông tin phòng ban thành công");
    } else {
        error_response(5, "Xóa thông tin phòng ban thất bại");
    }
?>