<?php
	session_start();
	require_once('../connect_db.php');
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

    
    if(isset($_POST['guiDon'])) {
        $message = '';
        if (!isset($_POST['maNVien'])  || !isset($_POST['time']) || !isset($_POST['lyDo'])){
          $message = 'vui lòng nhập đầy đủ thông tin!!';
          
        }else if (empty($_POST['maNVien']) || empty($_POST['time']) || empty($_POST['lyDo'])){
          $message = 'KHông để giá trị rỗng!!';
          
        }else{
            $maNVien = $_POST['maNVien'];
            $maPBan = $_SESSION['maPB'];
            $soNgayNghi = $_POST['time'];
            $lyDo = $_POST['lyDo'];
            $ngayTao = date("Y-m-d");
            $trangThai = $_POST['trangThai'];

            if (!isset($_FILES["file"]))
            {
                $message =  "Dữ liệu không đúng cấu trúc";
                
            }

            $tapTin = $_FILES["file"]['name'];
            if ($tapTin == ''){
                $sql2 = "INSERT INTO DonXinNghiPhep (maNhanVien, maPhongBan, soNgayNghi, trangThai, lyDo, ngayTao, tapTin) VALUES(?, ?, ?,?, ?, ?,?)";
                $conn2 = connect_db();
                $stm2 = $conn2->prepare($sql2);
                $stm2->bind_param('sssssss', $maNVien, $maPBan, $soNgayNghi, $trangThai, $lyDo, $ngayTao, $tapTin);
                $stm2->execute();
                if($stm2->affected_rows == 1){
            
                    header("Location: calendar.php");
                  }else{
                    $message = "cập nhật thất bại";
                  }
            
            }else {
                $tname = $_FILES["file"]["tmp_name"];
                $uploads_dir = '../files';

                $sql2 = "INSERT INTO DonXinNghiPhep (maNhanVien, maPhongBan, soNgayNghi, trangThai, lyDo, ngayTao, tapTin) VALUES(?, ?, ?,?, ?, ?,?)";
                $conn2 = connect_db();
                $stm2 = $conn2->prepare($sql2);
                $stm2->bind_param('sssssss', $maNVien, $maPBan, $soNgayNghi, $trangThai, $lyDo, $ngayTao, $tapTin);
                $stm2->execute();
                if($stm2->affected_rows == 1){
                    move_uploaded_file($tname,$uploads_dir.'/'.$tapTin);
                    header("Location: calendar.php");
                }else{
                    $message = "cập nhật thất bại";
                }
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
                        <a href="progress.php" class="list-group-item list-group-item-action "><i class="fas fa-spinner"></i> Task in progress</a>
                        <a href="waiting.php" class="list-group-item list-group-item-action"> <i class="fas fa-stopwatch"></i> Task Waiting</a>
                        <a href="rejected.php" class="list-group-item list-group-item-action"> <i class="fas fa-history"></i> Task Phản hồi</a>
                        <a href="complete.php" class="list-group-item list-group-item-action"><i class="fas fa-check-double"></i> Task Đã hoàn Thành</a>
                        <a href="canceled.php" class="list-group-item list-group-item-action"> <i class="fas fa-trash"></i> Task đã hủy</a>
                        <a href="calendar.php" class="list-group-item list-group-item-action activee"> <i class="fas fa-calendar-week"></i>  Đơn Nghĩ Phép</a>
                       
                    </div>
				</ul>
              
			</div>
			<div class="col-xl-10  col-sm-12 ">
				<div class="d-flex">
					<div class="p-2">
						<input type="checkbox" id="choose-all" name="choose-all">
						<label for="choose-all">Chọn tất cả</label>
					</div>
					<div class="p-2"><i class="fas fa-redo-alt"></i>Tải lại</div>
					<div class="ml-auto p-2 d-flex">
						<p>Tổng số Task:</p>
						<h5 class='countTask'></h5>
					</div>
				</div>
                
				<div class="all-task">
					<div class="task-content">
                        <h3 class="p-2 d-flex justify-content-center bg-dark text-white">ĐƠN XIN NGHĨ PHÉP</h3>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="modal-body mx-5">
                                <div class="form-group">
                                    <label for="maNVien">Mã nhân viên</label>
                                    <input type="text" value="<?=$_SESSION['maNhanVien']?>"class="form-control" id="maNVien" name="maNVien" readonly />
                                </div>
                                <div class="form-group">
                                    <label for="time">Chọn số ngày nghĩ</label>
                                    <select name="time" class="form-control">
                                        <?php
                                            for($i=1;$i<=15;$i++){
                                                echo "<option value='$i'>$i</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="lyDo">LÝ do</label>
                                    <textarea rows="2" id="lyDo" class="form-control" name="lyDo" placeholder="Nhập lý do" required></textarea>
                                
                                </div>
                                <div class="form-group">
                                    <label for="file">Tệp đính kèm</label>
                                    <input type="file" class="form-control" name="file">
                                </div>
                                <div class="form-group">
                                    <label for="trangThai">Trạng thái</label>
                                    <input type="text" readonly  class="form-control" id="m-trangThai"  name="trangThai" value="WAITING" />
                                </div>
                                
                            </div>

                            <div class="modal-footer">
                                <button type="submit" id='m-smguiDon' name="guiDon" class='btn btn-outline-success '>Gửi đơn</button>
                                
                            </div>
                        </form>
					</div>
				</div>
		</div>
		</div>
			

    <!-- <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="abc"> -->
     <!-- message respone -->
  
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
	<script src="../main.js">
		
  
    // if($('#m-trangThai').attr('value')!='WAITING'){
    //     $('#m-smDongY').attr('disabled', true);
    //     $('#m-smTuChoi').attr('disabled', true);
    // }

	</script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>

