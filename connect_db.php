<?php
    // session_start(); 

	// Kiểm tra người dùng đã đăng nhập chưa 
	// if (!isset($_SESSION['maNhanVien'])) {
	// 	header("Location: login.php");
	// 	die();
	// }

	// Kiểm tra người dùng đã đổi mật khẩu chưa
	// if (isset($_SESSION['doiMatKhau'])) {
    //     if ($_SESSION['doiMatKhau'] == 0) {
    //         header("Location: change_pwd_first.php");
    //         die();
    //     } 
    // }

    // Tạo kết nối đến database
    function connect_db() {
        $host = 'mysql-server';
        $user = 'root';
        $pass = 'root';
        $db = 'company_management';

        $conn = new mysqli($host, $user, $pass, $db);
        $conn->set_charset("utf8");
        if ($conn -> connect_error) {
            die("Không thể kết nối đến database: " . $conn -> connect_error);
        }
        
        return $conn;
    }
?>