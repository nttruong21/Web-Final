<?php
    session_start();

    // Kiểm tra người dùng đã đăng nhập chưa?
    if (!isset($_SESSION['maNhanVien'])) {
		header("Location: /login.php");
		die();
	}

    // Kiểm tra người dùng đã đổi mật khẩu chưa?
    if ($_SESSION['doiMatKhau'] == 0) {
        header("Location: /change_pwd_first.php");
        die();
    } 

    // Kiểm tra người dùng có phải giám đốc?
    if (!$_SESSION['maChucVu'] == 'GD') {
        header("Location: /no_access.html");
    }

    require_once("../connect_db.php");

    // Kiểm tra xem mật khẩu mới có trùng với mật khẩu cũ không?
    // Trả về bool 
    function check_pwd_exist($username, $new_pwd) {
        $sql = "select matKhau from GiamDoc where maNhanVien = ?";
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
    function update_admin_password($username, $new_pwd) {
        $pwd = password_hash($new_pwd, PASSWORD_BCRYPT);

        $sql = "update GiamDoc set matKhau = ? where maNhanVien = ?";
        $conn = connect_db();

        $stm = $conn -> prepare($sql);
        $stm -> bind_param("ss", $pwd, $username);
        $stm -> execute();

        return $stm -> affected_rows == 1;
    }

    $error_msg = '';
    $success_msg = '';    // Hiển thị thông báo lỗi trên giao diện thay đổi mật khẩu 
    if (isset($_POST['new-pass']) && isset($_POST['old-pass']) && isset($_POST['confirm-pass'])) {
        $new_pass = $_POST['new-pass'];
        $old_pass = $_POST['old-pass'];
        $confirm_pass = $_POST['confirm-pass'];
        $id = $_SESSION['maNhanVien'];

        // Kiểm tra xem có rỗng không?
        if ($old_pass == '' || $new_pass == '' || $confirm_pass == '') {
            $error_msg = 'Vui lòng điền đầy đủ thông tin';
        } 
        // Kiểm tra mật khẩu cũ có giống không
        else if (!check_pwd_exist($id, $old_pass)) {
            $error_msg = 'Mật khẩu cũ không hợp lệ';
        }
        // Kiểm tra xem có giống nhau không?
        else if ($new_pass != $confirm_pass) {
            $error_msg = 'Xác nhận mật khẩu không hợp lệ';
        } else if (strlen($new_pass) < 6) {
            $error_msg = 'Mật khẩu phải chứa tối thiểu 6 ký tự';
        }
        // Kiểm tra xem có trùng với mật khẩu cũ không?
        else if (check_pwd_exist($id, $new_pass)) {
            $error_msg = 'Mật khẩu mới không được trùng với mật khẩu cũ';
        } 
        // Thực hiện đổi mật khẩu: thành công -> chuyển đến index.php
        else {
            $result = update_admin_password($id, $new_pass);
            if ($result) {
                $success_msg = 'Đổi mật khẩu thành công';
            } else {
                $error_msg = 'Không thể đổi mật khẩu, vui lòng thử lại';
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
    <title>Thay đổi mật khẩu</title>
</head>
<body>
    <!-- Navigation -->
	<?php require_once("header.php"); ?>

    <div class="container mx-auto mt-5">
        <div class="text-center">
            <h2 class="my-4">Thay đổi mật khẩu</h2>
        </div>
        <div class="w-50 card p-4 bg-light mx-auto">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="change-pass-admin-account-old-pass">Mật khẩu cũ</label>
                    <input type="password" class="form-control" name="old-pass" id="change-pass-admin-account-old-pass"/>
                 </div>
                <div class="form-group">
                    <label for="change-pass-admin-account-new-pass">Mật khẩu mới</label>
                    <input type="password" name="new-pass" id="change-pass-admin-account-new-pass" class="form-control">
                </div>
                <div class="form-group">
                    <label for="change-pass-admin-account-new-pass-again">Nhập lại mật khẩu mới</label>
                    <input type="password" name="confirm-pass" id="change-pass-admin-account-new-pass-again" class="form-control">
                </div>
                <?php
                    if ($error_msg) {
                        ?>
                            <div id="update-admin-pass-error-message" class="form-group">
                                <div id="update-admin-pass-error" class="text-center card alert-danger font-weight-bold"><?= $error_msg ?></div>
                            </div>
                        <?php
                    } else {
                        ?>
                            <div class="form-group">
                                <div class="card text-center alert-success font-weight-bold"><?= $success_msg ?></div>
                            </div>
                        <?php
                    }
                ?>
                
                <div class="form-group text-center">
                    <button class="btn btn-primary" type="submit">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>