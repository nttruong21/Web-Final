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
        if (!property_exists($input, 'id') || !property_exists($input, 'name') || !property_exists($input, 'birthday') || 
        !property_exists($input, 'sex') || !property_exists($input, 'phone_number') || !property_exists($input, 'address') || 
        !property_exists($input, 'email')) {
            error_response(3, "Dữ liệu không đầy đủ");
        }

        // Lấy dữ liệu 
        $id = $input -> id;
        $name = $input -> name;
        $birthday = $input -> birthday;
        $sex = $input -> sex;
        $phone_number = $input -> phone_number;
        $address = $input -> address;
        $email = $input -> email;

        // Kiểm tra dữ liệu có hợp lệ?
        if($id === "" || $name === "" || ($birthday) === "" || !is_numeric($sex) || $sex === -1 || ($phone_number) === "" || 
        ($address) === "" || ($email) === "") {
            error_response(4, "Dữ liệu không hợp lệ");
        }

        $result = update_account_admin($id, $name, $birthday, $sex, $phone_number, $address, $email);
        if ($result) {
            success_response(0, "Cập nhật thông tin giám đốc thành công");
        } else {
            error_response(5, "Cập nhật thông tin giám đốc thất bại");
        }
?>