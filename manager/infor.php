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

    $message = '';
    if (!isset($_POST['maNVu']) || !isset($_POST['tenNVu']) || !isset($_POST['time'])
        || !isset($_POST['moTa'])){
          $message = 'vui lòng nhập đầy đủ thông tin!!';
          
        }else if (empty($_POST['maNVu']) || empty($_POST['tenNVu']) || empty($_POST['time'])
        || empty($_POST['moTa'])){
          $message = 'KHông để giá trị rỗng!!';
          
        }else{
  
          if (!isset($_FILES["file"]))
            {
                $message =  "Dữ liệu không đúng cấu trúc";
                
            }
          $maNVu = $_POST['maNVu'];
          $tenNVu = $_POST['tenNVu'];
          $maNVien = $_POST['maNVien'];
          $maPB = $_POST['maPB'];
          $hanTH = $_POST['time'];
          $moTa = $_POST['moTa'];
          $tapTin = $_FILES["file"]['name'];
          // $tapTin = $_POST["file"];
  
          $trangThai = $_POST['trangThai'];
  
          $tname = $_FILES["file"]["tmp_name"];
          $uploads_dir = '../images';
          
  
         
          $sql = "INSERT INTO NhiemVu VALUES(?, ?, ?,?,?,?,?,?)";
          $conn = connect_db();
          $stm = $conn->prepare($sql);
          $stm->bind_param('ssssssss', $maNVu, $tenNVu, $maNVien, $maPB, $hanTH, $moTa, $tapTin, $trangThai);
          $stm->execute();
        
          if( $stm->affected_rows == 1){
            move_uploaded_file($tname,$uploads_dir.'/'.$tapTin);
            header("Location: index.php");
          }else{
            $message = "thêm thất bại";
          }
        }

        $sql = "SELECT * FROM NhiemVu where maNhiemVu = '".$_GET['maNVu']."'";
        $conn = connect_db();
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
		
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
					<form class="form-inline my-2 my-lg-0">
						<input class="box-search mr-sm-2" type="search" placeholder="Search" aria-label="Search">
						<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
					</form>
						<ul class="navbar-nav mr-auto">
							<li class="nav-item">
								<a class="nav-link" href="#"><i class="fas fa-cogs"></i></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#"><i class="fas fa-question-circle"></i></a>
							</li>
						</ul>
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
                        <i class="fas fa-book"></i>   Tất cả Task
                        </a>
                        <a href="progress.php" class="list-group-item list-group-item-action "><i class="fas fa-spinner"></i> Task in progress</a>
                        <a href="newTask.php" class="list-group-item list-group-item-action"><i class="fas fa-star"></i> Task Mới</a>
                        <a href="complete.php" class="list-group-item list-group-item-action"><i class="fas fa-check-double"></i> Task Đã hoàn Thành</a>
                        <a href="complete.php" class="list-group-item list-group-item-action"> <i class="fas fa-trash"></i> Task đã hủy</a>
                        
                       
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
                        <h3 class="p-2 d-flex justify-content-center bg-dark text-white">INFORMATION TASK</h3>
                        <form action="infor.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body mx-5">
                                <div class="form-group">
                                    <label for="maNVu">Mã nhiệm vụ</label>
                                    <input type="text" value="<?=$row['maNhiemVu']?>"class="form-control" id="maNVu" required />
                                </div>
                                <div class="form-group">
                                    <label for="tenNVu">Tên nhiệm vụ</label>
                                    <input type="text" value="<?=$row['tenNhiemVu']?>" class="form-control" id="tenNVu" required />
                                </div>
                                <div class="form-group">
                                    <label for="maNVien">mã nhân viên</label>
                                    <input type="text" value="<?=$row['maNhanVien']?>" class="form-control" id="maNVien" value=<?=$_SESSION['maNhanVien']?> />
                                </div>
                                <div class="form-group">
                                    <label for="maPB">mã phòng ban</label>
                                    <input type="text" value="<?=$row['maPhongBan']?>" class="form-control" id="maPB" value=<?=$_SESSION['maPB']?> />
                                </div>
                                <!-- <div class="form-group">
                                    <label for="time">hạn thực hiện</label>
                                    <input type="text" placeholder="Thời gian thực hiện" class="form-control" id="time" required />
                                </div> -->

                                <div class="form-group">
                                    <label for="time">Start date:</label>
                                    <input type="text" value="<?php echo date('Y/m/d',strtotime($row['hanThucHien']))?>" class="form-control" id="maPB" value=<?=$_SESSION['maPB']?> />

                                </div>
                                <div class="form-group">
                                    <label for="moTa">mô tả</label>
                                    <input r id="moTa" class="form-control" value="<?php echo $row['moTa'];?>" ></input>
                                
                                </div>
                                <div class="form-group">
                                    <label for="moTa">Tệp hiện tại</label>
                                    <input r id="moTa" class="form-control my-2" value="<?=$row['tapTin']?>" readonly  ></input>
                                    <input type="file" name="myFile" id="file" >
                                </div>
                                <!-- <div class="form-group">
                                    <label for="file">Tập tin</label>
                                    <input type="text" placeholder="Chọn tập tin" class="form-control" id="file" required />
                                </div> -->
                                <div class="form-group">
                                    <label for="trangThai">Trạng thái</label>
                                    <input type="text" readonly  class="form-control" id="trangThai" value="<?=$row['trangThai']?>" />
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Add</button>
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
	<script>
		
    //====================thêm task mới==========================
    
// chọn ngày
	$(function(){
   $('.datepicker').datepicker({
      format: 'dd-mm-yyyy'
    });
	});
// chọn file
  
    loadTasks()



	</script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>

