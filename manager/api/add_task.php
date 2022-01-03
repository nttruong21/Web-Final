<?php 
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset = utf-8");

require_once('../task_db.php');
require_once('function.php');



    // Kiểm tra phương thức 
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        err_messages(1, "API chỉ hỗ trợ phương thức POST");
    }

    // Đọc JSON từ Client 
    $input = json_decode(file_get_contents('php://input'));

    // Kiểm tra dữ liệu 
    if (is_null($input)) {
        err_messages(2, "Dữ liệu phải ở dạng JSON");
    }
    if (!property_exists($input, 'maNVu') || !property_exists($input, 'tenNVu') || !property_exists($input, 'maNVien') || 
    !property_exists($input, 'maPB') || !property_exists($input, 'hanTH') || !property_exists($input, 'moTa') || 
    !property_exists($input, 'tapTin') || !property_exists($input, 'trangThai') ) {
        err_messages(3, "Dữ liệu không đầy đủ");
    }
    // if (($input -> user_id) === "" || ($input -> name) === "" || ($input -> birthday) === "" || ($input -> sex) === "" || ($input -> phone_number) === "" ||
    // ($input -> address) === "" || ($input -> email) === "" || ($input -> position) === "" || ($input -> departmental) === "") {
    //     error_response(4, "Dữ liệu không hợp lệ");
    // }

    // Lấy dữ liệu 
    $maNVu = $input -> maNVu;
    $tenNVu = $input -> tenNVu;
    $maNVien = $input -> maNVien;
    $maPBan = $input -> maPB;
    $hanTH = $input -> hanTH;
    $moTa = $input -> moTa;
    $tapTin = $input -> tapTin;
    $trangThai = $input -> trangThai;
 

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
    if($maNVu === "" || $tenNVu === "" || ($maNVien) === "" ||  ($maPBan) === "" || 
    ($hanTH) === "" || ($moTa) === "" || ($tapTin) === "" || ($trangThai) === "") {
        err_messages(4, "Dữ liệu không hợp lệ");
    }

  

    // call api để lấy 
    // $position = explode(" - ", $position)[0];
    // $departmental = explode(" - ", $departmental)[0];

    $result = add_task($maNVu, $tenNVu, $maNVien, $maPBan, $hanTH, $moTa, $tapTin, $trangThai);

    if ($result == 1) {
        success_messages($maNVu, "Thêm task thành công");
    } else {
        err_messages(5, "Thêm task thất bại");
    }
?>
