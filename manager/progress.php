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

	// Kiểm tra người dùng có phải trưởng phòng?
    if (!$_SESSION['maChucVu'] == 'TP') {
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
	<link rel="stylesheet" href="../style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<title>Trưởng Phòng</title>
</head>

<body>

	<div>
		<div>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<a class="navbar-brand" href="#">Task Manager</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse " id="navbarSupportedContent">
						<ul class="navbar-nav mr-auto"></ul>
					<?php
						?>
						<div>
							<a class="nav-link" href="../profile.php">Xin chào <?= $_SESSION['hoTen'] ?></a>
						</div>
						<div>
							<a class="font-weight-bold" href="../logout.php">Đăng xuất</a>
						</div>
					<?php
						?>
				</div>
			</nav>
		</div>
		
		<div class="row">
			<div class="col-xl-2  col-sm-12">
				<ul class="menu ">
					<li class="create-task add-task " ><a href="form_add.php" class="d-flex justify-content-between text-success"><i class="fas fa-plus-circle" ></i>   Tạo Task</a></li>
                    <div class="list-group">
                        <a href="index.php" class="list-group-item list-group-item-action ">
                            <i class="fas fa-tasks"></i>   Tất cả Task
                        </a>
                        <a href="newTask.php" class="list-group-item list-group-item-action"><i class="fas fa-star"></i> Task Mới</a>
                        <a href="progress.php" class="list-group-item list-group-item-action activee"><i class="fas fa-spinner"></i> Task in progress</a>
                        <a href="waiting.php" class="list-group-item list-group-item-action"> <i class="fas fa-stopwatch"></i> Task Waiting</a>
                        <a href="rejected.php" class="list-group-item list-group-item-action"> <i class="fas fa-history"></i> Task Phản hồi</a>
                        <a href="complete.php" class="list-group-item list-group-item-action"><i class="fas fa-check-double"></i> Task Đã hoàn Thành</a>
                        <a href="canceled.php" class="list-group-item list-group-item-action"> <i class="fas fa-trash"></i> Task đã hủy</a>
                        <a href="calendar.php" class="list-group-item list-group-item-action"> <i class="fas fa-calendar-week"></i>  Đơn Nghĩ Phép</a>
                        
                    </div>
				</ul>
              
			</div>
			<div class="col-xl-10  col-sm-12 ">
				

				<div class="all-task">
					<div class="task-content">
						<table class="table able-striped border ">
                <thead class="thead-dark">
                    <tr>
                        <th>TRẠNG THÁI</th>
                        <th>TÊM NHIỆM VỤ</th>
                        <th>THỜI GIAN</th>
                    </tr>
                </thead>
                <!-- manager list task -->

                <tbody id='list-task'>
                    <?php
                        require_once('../connect_db.php');
                        $maPB = $_SESSION['maPB'];
                        $sql = "SELECT * FROM NhiemVu where maPhongBan = '$maPB' and trangThai='IS PROGRESS' Order by maNhiemVu DESC";
                        $conn = connect_db();
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows == 0){
                            die('Kêt nối thành công, Nhưng không có dữ liệu');
                        }
                    
                        while ($row = $result->fetch_assoc()){
                            $trangThai = $row['trangThai'];
                            $tenNhiemVu = $row['tenNhiemVu'];
                            $time = $row['hanThucHien'];
                            $manv = $row['maNhiemVu'];
                            echo "<tr>";
                            echo  "<td><span class='badge badge-primary'>$trangThai</span></td>";
                            echo  " <td><a href='infor.php?maNVu=$manv'  class='tenNhiemVu'>$tenNhiemVu</a></td>";
                            echo  " <td>$time</td>";
                            echo  "</tr>";
                           
                        }
                       
                    ?>
                </tbody>
            </table>
					</div>
				</div>
		</div>
		</div>
			

		
 
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
	<script src="../main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>

