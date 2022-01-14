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
if (isset($_POST['submit'])){
    $message = '';
    if (!isset($_POST['maNVu'])  || !isset($_POST['time'])
        || !isset($_POST['moTa'])){
          $message = 'vui lòng nhập đầy đủ thông tin!!';
          
        }else if (empty($_POST['maNVu']) || empty($_POST['time'])
        || empty($_POST['moTa'])){
          $message = 'KHông để giá trị rỗng!!';
          
        }else{
            // cập nhật  lại task
          if (!isset($_FILES["file"]))
            {
                $message =  "Dữ liệu không đúng cấu trúc";
                
            }
          $maNVu = $_POST['maNVu'];
          $hanTH = $_POST['time'];
          $moTa = $_POST['moTa'].' ';
          $tapTin = $_FILES["file"]['name'];
        
          // $tapTin = $_POST["file"];
            if ($tapTin == ''){
                
                $tapTin = $_POST['fileCurrent'];
                $sql1 = "UPDATE NhiemVu SET  hanThucHien = ?, moTa = ?, trangThai = 'REJECTED' WHERE maNhiemVu = '$maNVu'";
                $conn1 = connect_db();
                $stm1 = $conn1->prepare($sql1);
                $stm1->bind_param('ss',$hanTH, $moTa);
                $stm1->execute();

                
                $sql3 = "SELECT * FROM KetQuaTraVe where maNhiemVu='$maNVu'";
                $conn3 = connect_db();
                $result3 = $conn3->query($sql3);
                $count = $result3->num_rows;
                $rowKQTV = $result3->fetch_assoc();
            //    echo $rowKQTV['maNhiemVu'];
            //    echo $rowKQTV['noiDung'];
            //    echo $rowKQTV['tapTin'];
            //    echo $rowKQTV['hanThucHien'];
            //     die;
                
                if( $count > 0){
                    // $maNVu = $row3['maNhiemVu'];
                    $sql2 = "UPDATE KetQuaTraVe SET  noiDung = ?, tapTin = ?, hanThucHien = ? WHERE maNhiemVu = '$maNVu'";
                    $conn2 = connect_db();
                    $stm2 = $conn2->prepare($sql2);
                    $stm2->bind_param('sss',$moTa, $tapTin, $hanTH);
                    $stm2->execute();
                    

                    // die;
                }else{
                    $sql2 = "INSERT INTO KetQuaTraVe VALUES(?, ?, ?,?)";
                    $conn2 = connect_db();
                    $stm2 = $conn2->prepare($sql2);
                    $stm2->bind_param('ssss', $maNVu, $moTa, $tapTin, $hanTH);
                    $stm2->execute();
                }

                
            }else{
                $tname = $_FILES["file"]["tmp_name"];
                $uploads_dir = '../files';
                // die($tname);
                $sql1 = "UPDATE NhiemVu SET hanThucHien = ?, moTa = ?, tapTin = ?, trangThai = 'REJECTED' WHERE maNhiemVu = '$maNVu'";
                $conn1 = connect_db();
                $stm1 = $conn1->prepare($sql1);
                $stm1->bind_param('sss',$hanTH, $moTa, $tapTin);
                $stm1->execute();

                $sql3 = "SELECT * FROM KetQuaTraVe where maNhiemVu='$maNVu'";
                $conn3 = connect_db();
                $result3 = $conn3->query($sql3);
                $count = $result3->num_rows;
                
                
                
                if( $count > 0){
                    // $maNVu = $row3['maNhiemVu'];
                    $sql2 = "UPDATE KetQuaTraVe SET  noiDung = ?, tapTin = ?, hanThucHien = ? WHERE maNhiemVu = '$maNVu'";
                    $conn2 = connect_db();
                    $stm2 = $conn2->prepare($sql2);
                    $stm2->bind_param('sss',$moTa, $tapTin, $hanTH);
                    $stm2->execute();

                    // die;
                }else{
                    $sql2 = "INSERT INTO KetQuaTraVe VALUES(?, ?, ?,?)";
                    $conn2 = connect_db();
                    $stm2 = $conn2->prepare($sql2);
                    $stm2->bind_param('ssss', $maNVu, $moTa, $tapTin, $hanTH);
                    $stm2->execute();
                }

                move_uploaded_file($tname,$uploads_dir.'/'.$tapTin);
            }

            if( $stm1->affected_rows == 1 ){
                header("Location: index.php");

            }
          
        }
    }

   if(isset($_GET['maNVuu']) && !empty($_GET['maNVuu'])){
        $sql = "SELECT * FROM NhiemVu where maNhiemVu = '".$_GET['maNVuu']."'";
        $conn = connect_db();
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
   }
        // lấy thông tin của 1 task
       
		
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
                    <a href="index.php" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tasks"></i>   Tất cả Task
                        </a>
                        <a href="newTask.php" class="list-group-item list-group-item-action"><i class="fas fa-star"></i> Task Mới</a>
                        <a href="progress.php" class="list-group-item list-group-item-action "><i class="fas fa-spinner"></i> Task in progress</a>
                        <a href="waiting.php" class="list-group-item list-group-item-action"> <i class="fas fa-stopwatch"></i> Task Waiting</a>
                        <a href="rejected.php" class="list-group-item list-group-item-action"> <i class="fas fa-history"></i> Task Phản hồi</a>
                        <a href="complete.php" class="list-group-item list-group-item-action"><i class="fas fa-check-double"></i> Task Đã hoàn Thành</a>
                        <a href="canceled.php" class="list-group-item list-group-item-action"> <i class="fas fa-trash"></i> Task đã hủy</a>
                        <a href="calendar.php" class="list-group-item list-group-item-action"> <i class="fas fa-calendar-week"></i>  Đơn Nghĩ Phép</a>
                       
                    </div>
				</ul>
              
			</div>
			<div class="col-xl-10  col-sm-12 ">
				<div class="d-flex">
					
				</div>
                
				<div class="all-task">
					<div class="task-content">
                        <h3 class="p-2 d-flex justify-content-center bg-dark text-white">THÔNG TIN PHẢN HỒI</h3>
                        <form action="formGuiLai.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body mx-5">
                                <div class="form-group">
                                    <label for="maNVu">Mã nhiệm vụ</label>
                                    <input type="text" value="<?=$row['maNhiemVu']?>"class="form-control" id="maNVu" name="maNVu" readonly />
                                </div>
                                <div class="form-group">
                                    <label for="time">Start date:</label>
                                    <input type="text" name="time" value="<?php echo date('Y/m/d',strtotime($row['hanThucHien']))?>" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="moTa">mô tả</label>
                                    <input  id="moTa" name="moTa" class="form-control" value="<?php echo $row['moTa'];?>" ></input>
                                
                                </div>
                                <div class="form-group">
                                    <label for="fileCurrent">Tệp hiện tại</label>
                                    <input  id="fileCurrent" class="form-control my-2" name="fileCurrent" value="<?=$row['tapTin']?>" readonly  ></input>
                                    <input type="file" name="file" id="file" >
                                </div>

                                
                            </div>

                            <div class="modal-footer">
                               
                                <button type="submit" id='sbGui' name="submit" class="btn btn-info">Gửi</button>
                                
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
	<script src="../main.js"> </script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>

