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
        if (!property_exists($input, 'user_id') || !property_exists($input, 'name') || !property_exists($input, 'birthday') || 
        !property_exists($input, 'sex') || !property_exists($input, 'phone_number') || !property_exists($input, 'address') || 
        !property_exists($input, 'email') || !property_exists($input, 'day')) {
            error_response(3, "Dữ liệu không đầy đủ");
        }

        // Lấy dữ liệu 
        $user_id = $input -> user_id;
        $name = $input -> name;
        $birthday = $input -> birthday;
        $sex = $input -> sex;
        $phone_number = $input -> phone_number;
        $address = $input -> address;
        $email = $input -> email;
        $day = $input -> day;

        // Kiểm tra dữ liệu có hợp lệ?
        if($user_id === "" || $name === "" || ($birthday) === "" || !is_numeric($sex) || $sex === -1 || ($phone_number) === "" || 
        ($address) === "" || ($email) === "" || !is_numeric($day)) {
            error_response(4, "Dữ liệu không hợp lệ");
        }

        $result = update_account($user_id, $name, $birthday, $sex, $phone_number, $address, $email, $day);
        if ($result) {
            success_response(0, "Cập nhật thông tin nhân viên thành công");
        } else {
            error_response(5, "Cập nhật thông tin nhân viên thất bại");
        }
?>