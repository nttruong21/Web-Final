<?php  
    session_start();

    // Kiểm tra nếu người dùng đã đang nhập mà vẫn muốn truy cập trang đăng nhập -> chuyển đến index.php
    if (isset($_SESSION['maNhanVien'])) {
        header("Location: index.php");
        die();
    }

    // Kiểm tra người dùng đã đổi mật khẩu chưa?
	if (isset($_SESSION['doiMatKhau'])) {
        if ($_SESSION['doiMatKhau'] == 0) {
            header("Location: change_pwd_first.php");
            die();
        } 
    } 
    
    require_once("connect_db.php");

    // Xử lý xác thực đăng nhập
    // Kiểm tra $username và $password có tương ứng với tài khoản trong db hay không?
    function validate_login($sql, $username, $password) {
        $conn = connect_db();

        // Prepare statement
        $stm = $conn -> prepare($sql);
        $stm -> bind_param("s", $username);
        if (!$stm -> execute()) {
            return array('code' => 1, 'error' => 'Có lỗi, vui lòng tải lại trang');
        }

        // Có tìm thấy nhân viên nào có maNhanVien = $username không?
        $result = $stm -> get_result();
        if ($result -> num_rows == 0) {
            return array('code' => 2, 'error' => 'Tài khoản không hợp lệ');
        } 

        // Lấy dữ liệu dòng đầu tiên đọc được 
        $data = $result -> fetch_assoc();

        // Kiểm tra mật khẩu có tương đồng không?
        if (!password_verify($password, $data['matKhau'])) {
            return array('code' => 3, 'error' => 'Mật khẩu không chính xác');
        } else {
            return array('code' => 0, 'error' => '', 'data' => $data);
        }
    }

    // Xử lý đăng nhập
    function handle_login($username, $password) {
        // Người dùng chia ra 2 loại: giám đốc & quản lý, nhân viên 
        if ($username == 'admin') {
            $sql = "select * from GiamDoc where maNhanVien = ?";
        } else {
            $sql = "select * from NhanVien where maNhanVien = ?";
        }
        return validate_login($sql, $username, $password);
    }

    // Kiểm tra người dùng đã đổi mật khẩu hay chưa 
    // function is_change_pass($username) {
    //     $sql = "select doiMatKhau from NhanVien where maNhanVien = ?";

    //     $conn = get_connect_db();

    //     $stm = $conn -> prepare($sql);
    //     $stm -> bind_param("s", $username);
    //     $stm -> execute();

    //     $result = $stm -> get_result();
    //     $data = $result -> fetch_assoc();
        
    //     if ($data['doiMatKhau'] == 0) {
    //         return false;
    //     } else {
    //         return true;
    //     }
    // }

    // Đặt session cho phiên đăng nhập 
    $error_msg = "";    // Hiển thị thông báo lỗi ra màn hình đăng nhập 
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Kiểm tra usename và password có rỗng?
        if ($username == "" || $password == "") {
            $error_msg = "Vui lòng nhập đầy đủ thông tin";
        }
        // Kiểm tra người dùng có trong database hay không?
        else {
            $result = handle_login($username, $password);

            $error_msg = $result['error'];

            if ($result['code'] == 0) {
                $data = $result['data'];
                $_SESSION['maNhanVien'] = $username;
                $_SESSION['hoTen'] = $data['hoTen'];
                $_SESSION['maChucVu'] = $data['maChucVu'];
                $_SESSION['anhDaiDien'] = $data['anhDaiDien'];
                $_SESSION['doiMatKhau'] = $data['doiMatKhau'];
                $_SESSION['maNhanVien'] = $data['maNhanVien'];
                $_SESSION['maPB'] = $data['maPhongBan'];
                
                if ($_SESSION['doiMatKhau'] == 0) {
                    header("Location: change_pwd_first.php");
                    die();
                } else {
                    header("Location: index.php");
                    die();
                }
            }
        }
    }
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Đăng nhập</title>
</head>
<body class="bg-image">
    <div class="card bg-light p-4 container mx-auto w-25 mt-5">
        <h3 class="text-center mb-4 text-primary font-weight-bold">Đăng nhập</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <p class="text-danger font-weight-bold"><?= $error_msg ?></p>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </div>
        </form>
    </div>
</body>
</html>
