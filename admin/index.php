<?php
	session_start();

	// Kiểm tra người dùng đã đăng nhập chưa 
	if (!isset($_SESSION['maNhanVien'])) {
		header("Location: ../login.php");
		die();
	}

	// Kiểm tra người dùng đã đổi mật khẩu chưa
	if (isset($_SESSION['doiMatKhau'])) {
		if ($_SESSION['doiMatKhau'] == 0) {
			header("Location: ../change_pwd_first.php");
			die();
		}
	}

	// Kiểm tra người dùng có phải giám đốc?
    if (!$_SESSION['maChucVu'] == 'GD') {
        header("Location: /no_access.html");
    }
?>

<!DOCTYPE html>
<html lang="en">	
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
		<title>Quản lý nhân viên</title>
	</head>
	<body>
		<!-- Navigation -->
		<?php require_once("header.php"); ?>

		<!-- Content container -->
		<div class="container-fluid h-100-vh bg-image p-0">
			<div class="row py-4 m-0">
				<div class="d-flex w-100 align-items-center employee-heading">
					<div class="col-xl-4 col-lg-6 col-md-5 employee-name">
						<h4 class=""></h4>
					</div>
					<div class="col-xl-5 col-lg-4 col-md-6 col-sm-10 col-10">
						<div class="form-group border rounded-lg mb-0 bg-light">
							<form class="" method="post">
								<div class="d-flex justify-content-between align-items-center p-1">
									<div class="task-search-input flex-fill mr-2">
										<input class="search-input outline-none border border-none rounded p-1 w-100" type="search" placeholder="Search task" aria-label="Search">
									</div>
									<div class="task-search-icon ">
										<button class="btn btn-outline-info rounded-circle" type="submit"><i class="fas fa-search"></i></button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-xl-3 col-lg-2 col-md-3 col-sm-2 col-2">
						<div class="d-inline-block">
							<a class="add-account-link d-flex bg-primary text-white align-items-center" href="account/add_account_page.php">
								<i class="text-white fas fa-user-plus"></i>
								<p class="mb-0 ml-1 day-off">Thêm nhân viên</p>
							</a>
						</div>
					</div>

				</div>
			</div>
			<div class="row m-0">
				<!-- Sidebar -->
				<?php require_once("sidebar.php"); ?>
				<div class="task-form col-lg-10">
					<div class="scrollable">
						<div class="task-heading d-flex custom-border position-sticky">
							<div class='col-lg-3 custom-border-right'>
								<p class="mb-0 p-1">MÃ NHÂN VIÊN</p>
							</div>
							<div class='col-lg-3 custom-border-right'>
								<p class="mb-0 p-1">HỌ TÊN</p>
							</div>
							<div class='col-lg-3 custom-border-right'>
								<p class="mb-0 p-1">CHỨC VỤ</p>
							</div>
							<div class='col-lg-3'>
								<p class="mb-0 p-1">PHÒNG BAN</p>
							</div>
						</div>
						<div id="accounts-list" class="task-information  bg-azure">
							
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<script src="/main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	</body>
</html>