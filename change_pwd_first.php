<?php
    session_start();

    // Kiểm tra người dùng đã đăng nhập chưa?
    if (!isset($_SESSION['maNhanVien'])) {
		header("Location: login.php");
		die();
	}

    require_once("connect_db.php");

    // Kiểm tra xem mật khẩu mới có trùng với mật khẩu cũ không?
    // Trả về bool 
    function check_pwd_exist($username, $new_pwd) {
        
        $sql = "select matKhau from NhanVien where maNhanVien = ?";

        $conn = connect_db();

        $stm = $conn -> prepare($sql);
        $stm -> bind_param("s", $username);
        $stm -> execute();

        $result = $stm -> get_result();
        $data = $result -> fetch_assoc();
        
        if (password_verify($new_pwd, $data['matKhau'])) {
            return true;
        } else {
            return false;
        }
    }

    // Cập nhật mật khẩu 
    function update_password($username, $new_pwd) {
        $pwd = password_hash($new_pwd, PASSWORD_BCRYPT);
        $reset_pwd = 1;

        $sql = "update NhanVien set matKhau = ?, doiMatKhau = ? where maNhanVien = ?";

        $conn = connect_db();

        $stm = $conn -> prepare($sql);
        $stm -> bind_param("sis", $pwd, $reset_pwd, $username);
        $stm -> execute();

        return $stm -> affected_rows == 1;
    }

    $error_msg = '';    // Hiển thị thông báo lỗi trên giao diện thay đổi mật khẩu 
    if (isset($_POST['new-pwd']) && isset($_POST['cfm-new-pwd'])) {
        $new_pwd = $_POST['new-pwd'];
        $cfm_new_pwd = $_POST['cfm-new-pwd'];
        $username = $_SESSION['maNhanVien'];

        // Kiểm tra xem có rỗng không?
        if ($new_pwd == '' || $cfm_new_pwd == '') {
            $error_msg = 'Vui lòng điền đầy đủ thông tin';
        } 
        // Kiểm tra xem có giống nhau không?
        else if ($new_pwd != $cfm_new_pwd) {
            $error_msg = 'Xác nhận mật khẩu không hợp lệ';
        } else if (strlen($new_pwd) < 6) {
            $error_msg = 'Mật khẩu phải chứa tối thiểu 6 ký tự';
        }
        // Kiểm tra xem có trùng với mật khẩu cũ không?
        else if (check_pwd_exist($username, $new_pwd)) {
            $error_msg = 'Mật khẩu không được trùng với mật khẩu cũ';
        } 
        // Thực hiện đổi mật khẩu: thành công -> chuyển đến index.php
        else {
            $result = update_password($username, $new_pwd);
            if ($result == 1) {
                $_SESSION['doiMatKhau'] = 1;
                header("Location: index.php");
                die();
            } else {
                $error_msg = 'Không thể cập nhật mật khẩu';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Đổi mật khẩu</title>
</head>
<body>
    <div class="container mx-auto w-50 mt-5 d-flex justify-content-between">
        <div class="form w-50 card p-4 bg-light ">
            <h3 class="text-center text-primary font-weight-bold">Change Password</h3>
            <form class="" action="" method="POST">
                <div class="form-group">
                    <label for="new-pwd">New Password</label>
                    <input type="password" class="form-control" id="new-pwd" name="new-pwd">
                </div>
                <div class="form-group">
                    <label for="cfm-new-pwd">Confirm New Password</label>
                    <input type="password" class="form-control" id="cfm-new-pwd" name="cfm-new-pwd">
                </div>
                <div class="form-group">
                    <p class="text-danger font-weight-bold"><?= $error_msg ?></p>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <div class="">
            <a class="btn btn-primary font-weight-bold" href="logout.php">Log Out</a>
        </div>
    </div>
</body>
</html>