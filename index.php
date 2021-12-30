<?php 
	session_start();   

	// Kiểm tra người dùng đã đăng nhập chưa 
	if (!isset($_SESSION['maNhanVien'])) {
		header("Location: login.php");
		die();
	}

	// Kiểm tra người dùng đã đổi mật khẩu chưa
	if (isset($_SESSION['doiMatKhau'])) {
        if ($_SESSION['doiMatKhau'] == 0) {
            header("Location: change_pwd_first.php");
            die();
        } 
    }

	// Kiểm tra quyền hạn của người dùng rồi tiến hành chuyển trang 
	if (isset($_SESSION['maChucVu'])) {
		switch ($_SESSION['maChucVu']) {
			case 'GD':
				// require_once('admin/index.php');
				header("Location: /admin/index.php");
				die();
				break;
			case 'TP':
				// require_once('manager/index.php');
				header("Location: manager/index.php");
				die();
				break;
			case 'NV':
				// require_once('employee/index.php');
				header("Location: employee/index.php");
				die();
				break;
		}
	}
?>

<!-- <!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="/style.css">
		<title>Trang chủ</title>
	</head>

	<body>
		<div class="container d-flex mx-auto w-75 justify-content-between mt-4">
			
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<script src="/main.js"></script>
	</body>		
</html> -->