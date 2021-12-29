<?php
    require_once("account_db.php");
    // session_start();
    // // Kiểm tra người dùng đã đăng nhập chưa 
    // if(!isset($_SESSION['maNhanVien'])) {
    //     header("Location: ../../login.php");
    //     die();
    // }
    
    header("Content-Type: application/json; charset = utf-8");
    header("Access-Control-Allow-Origin: *");
    
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
    if (!property_exists($input, 'user_id') || !property_exists($input, 'name') || !property_exists($input, 'birthday') || 
    !property_exists($input, 'sex') || !property_exists($input, 'phone_number') || !property_exists($input, 'address') || 
    !property_exists($input, 'email') || !property_exists($input, 'position') || !property_exists($input, 'departmental')) {
        error_response(3, "Dữ liệu không đầy đủ");
    }
    // if (($input -> user_id) === "" || ($input -> name) === "" || ($input -> birthday) === "" || ($input -> sex) === "" || ($input -> phone_number) === "" ||
    // ($input -> address) === "" || ($input -> email) === "" || ($input -> position) === "" || ($input -> departmental) === "") {
    //     error_response(4, "Dữ liệu không hợp lệ");
    // }

    // Lấy dữ liệu 
    $user_id = $input -> user_id;
    $name = $input -> name;
    $birthday = $input -> birthday;
    $sex = $input -> sex;
    $phone_number = $input -> phone_number;
    $address = $input -> address;
    $email = $input -> email;
    $position = $input -> position;
    $departmental = $input -> departmental;

        //
    // $user_id = isset($_POST['user-id']) ? $_POST['user-id'] : '';
    // $name = isset($_POST['name']) ? $_POST['name'] : '';
    // $birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
    // $sex = isset($_POST['sex']) ? $_POST['sex'] : '';   // string
    // $phone_number = isset($_POST['phone-number']) ? $_POST['phone-number'] : '';
    // $address = isset($_POST['address']) ? $_POST['address'] : '';
    // $email = isset($_POST['email']) ? $_POST['email'] : '';
    // $position = isset($_POST['position']) ? $_POST['position'] : '';
    // $departmental = isset($_POST['departmental']) ? $_POST['departmental'] : '';

    // Kiểm tra dữ liệu có hợp lệ?
    if($user_id === "" || $name === "" || ($birthday) === "" || !is_numeric($sex) || $sex === -1 || ($phone_number) === "" || 
    ($address) === "" || ($email) === "" || ($position) === "" || ($departmental) === "") {
        error_response(4, "Dữ liệu không hợp lệ");
    }

    $password = password_hash($user_id, PASSWORD_BCRYPT);

    // call api để lấy 
    // $position = explode(" - ", $position)[0];
    // $departmental = explode(" - ", $departmental)[0];

    $result = add_account($user_id, $name, $birthday, $sex, $phone_number, $address, $email, $position, $departmental, $password);

    if ($result == 1) {
        success_response($user_id, "Thêm tài khoản thành công");
    } else {
        error_response(5, "Thêm tài khoản thất bại");
    }
?>