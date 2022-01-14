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
    if (!isset($_POST['maNVu']) || !isset($_POST['tenNVu']) || !isset($_POST['time'])
        || !isset($_POST['moTa'])){
          $message = 'vui lòng nhập đầy đủ thông tin!!';
          
        }else if (empty($_POST['maNVu']) || empty($_POST['tenNVu']) || empty($_POST['time'])
        || empty($_POST['moTa'])){
          $message = 'KHông để giá trị rỗng!!';
          
        }else{
            // cập nhật  lại task
          if (!isset($_FILES["file"]))
            {
                $message =  "Dữ liệu không đúng cấu trúc";
                
            }
          $maNVu = $_POST['maNVu'];
          $tenNVu = $_POST['tenNVu'];
          $maNVien = $_POST['maNVien'];

          if ($_POST['maNVienNew']==''){
            $maNVienNew = $maNVien;
          }else{
            $maNVienNew = $_POST['maNVienNew'];
          }
          
         
          $maPB = $_POST['maPB'];
          $hanTH = $_POST['time'];
          $moTa = $_POST['moTa'].' ';
          $tapTin = $_FILES["file"]['name'];
          $trangThai = $_POST['trangThai'];
          // $tapTin = $_POST["file"];
            if ($tapTin == ''){
                $sql = "UPDATE NhiemVu SET maNhiemVu = ?, tenNhiemVu = ?, maNhanVien = ? , maPhongBan = ? , hanThucHien = ?, moTa = ?, trangThai = ? WHERE maNhiemVu = '$maNVu'";
                  $conn = connect_db();
                  $stm = $conn->prepare($sql);
                  $stm->bind_param('sssssss', $maNVu, $tenNVu, $maNVienNew, $maPB, $hanTH, $moTa, $trangThai);
                  $stm->execute();
            }else{
                $tname = $_FILES["file"]["tmp_name"];
                $uploads_dir = '../files';

                $sql = "UPDATE NhiemVu SET maNhiemVu = ?, tenNhiemVu = ?, maNhanVien = ? , maPhongBan = ? , hanThucHien = ?, moTa = ?, tapTin = ?, trangThai = ? WHERE maNhiemVu = '$maNVu'";
                $conn = connect_db();
                $stm = $conn->prepare($sql);
                $stm->bind_param('ssssssss', $maNVu, $tenNVu, $maNVienNew, $maPB, $hanTH, $moTa, $tapTin, $trangThai);
                $stm->execute();
                move_uploaded_file($tname,$uploads_dir.'/'.$tapTin);
            }

        
          if( $stm->affected_rows == 1){
            
            header("Location: index.php");
          }else{
            $message = "cập nhật thất bại";
          }
        }
    }else if (isset($_POST['cancel'])){
        $message = '';
            $maNVu = $_POST['maNVu'];
            $trangThai = 'CANCELED';
        
            $sql = "UPDATE NhiemVu SET  trangThai = ? WHERE maNhiemVu = '$maNVu'";
            $conn = connect_db();
            $stm = $conn->prepare($sql);
            $stm->bind_param('s',$trangThai);
            $stm->execute();
            if( $stm->affected_rows == 1){
                
                header("Location: canceled.php");
            }else{
                $message = "cập nhật thất bại";
            }
            
    }else if (isset($_POST['sbGuiLai'])){

    }
   
        // lấy thông tin của 1 task
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
                    <a href="index.php" class="list-group-item list-group-item-action">
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
					<div class="ml-auto p-2 d-flex">
					</div>
				</div>
                
				<div class="all-task">
					<div class="task-content">
                        <h3 class="p-2 d-flex justify-content-center bg-dark text-white">THÔNG TIN NHIỆM VỤ</h3>
                        <form action="infor.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body mx-5">
                                <div class="d-flex justify-content-center lert alert-success" role="alert">
                                    Điền vào thông tin mới nếu muốn cập nhật!
                                </div>
                                <div class="form-group">
                                    <label for="maNVu">Mã nhiệm vụ</label>
                                    <input type="text" value="<?=$row['maNhiemVu']?>"class="form-control" id="maNVu" name="maNVu" readonly />
                                </div>
                                <div class="form-group">
                                    <label for="tenNVu">Tên nhiệm vụ</label>
                                    <input type="text" value="<?=$row['tenNhiemVu']?>" class="form-control" id="tenNVu" name="tenNVu"required />
                                </div>
                            <!--lấy thông tin về mã nhân viên và hiện tên nhân viên cho người dùng -->
                                <?php
                                    $maNVi = $_SESSION['maNhanVien'];
                                    $maPBa = $_SESSION['maPB'];
                                    $sql = "SELECT * FROM NhanVien where maNhanVien != '$maNVi' and maPhongBan = '$maPBa' ";
                                    $conn = connect_db();
                                    $result1 = $conn->query($sql);
                                ?>
                                <?php
                                        $mNV = $row['maNhanVien'];
                                        $sql4 = "SELECT * FROM NhanVien where maNhanVien = '$mNV'";
                                        $conn4 = connect_db();
                                        $result4 = $conn->query($sql4);
                                        $row4 = $result4->fetch_assoc();
                                     
                                    ?>
                                <div class="form-group">
                                    <label for="tennv">Nhân viên hiện tại</label>
                                    <input type="text" readonly value="<?=$row4['hoTen']?>" class="form-control" id="tennv" name="tennv"  />
                                </div>
                                 <div class="form-group">
                                    <label for="maNVien">Mã Nhân viên hiện tại</label>
                                    <input type="text" readonly value="<?=$row['maNhanVien']?>" class="form-control" id="maNVien" name="maNVien"  />
                                </div>
                                <div class="form-group">
                                    
                                    <label for="maNVienNew">Thay đổi mã nhân viên</label>
                                    <select name="maNVienNew" class="form-control">
                                        <option value="">không chọn</option>
                                        <?php
                                        while ($row1 = $result1->fetch_assoc()){
                                            ?>
                                            <option value="<?php echo $row1['maNhanVien']?>"><?php echo $row1['hoTen']?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                
                                <div class="form-group">
                                    <label for="maPB">mã phòng ban</label>
                                    <input type="text" value="<?=$row['maPhongBan']?>" class="form-control" id="maPB" name="maPB" />
                                </div>
                                <!-- <div class="form-group">
                                    <label for="time">hạn thực hiện</label>
                                    <input type="text" placeholder="Thời gian thực hiện" class="form-control" id="time" required />
                                </div> -->

                                <div class="form-group">
                                    <label for="time">Hạn chót thực hiện:</label>
                                    <input type="text" name="time" value="<?php echo date('Y/m/d',strtotime($row['hanThucHien']))?>" class="form-control"  />

                                </div>
                                <div class="form-group">
                                    <label for="moTa">mô tả</label>
                                    <input  id="moTa" name="moTa" class="form-control" value="<?php echo $row['moTa'];?>" ></input>
                                
                                </div>
                                <div class="form-group">
                                    <label for="moTa">Tệp hiện tại</label>
                                    <input  id="moTa" class="form-control my-2" name="fileCurrent" value="<?=$row['tapTin']?>" readonly  ></input>
                                    <input type="file" name="file" id="file" >
                                </div>
                                <!-- <div class="form-group">
                                    <label for="file">Tập tin</label>
                                    <input type="text" placeholder="Chọn tập tin" class="form-control" id="file" required />
                                </div> -->
                                <div class="form-group">
                                    <label for="trangThai">Trạng thái</label>
                                    <input type="text" readonly  class="form-control" id="trangThai"  name="trangThai" value="<?=$row['trangThai']?>" />
                                </div>

                                <?php
                                    if ($row['trangThai'] == 'WAITING'){
                                        $sql = "SELECT * FROM KetQuaGui where maNhiemVu = '".$_GET['maNVu']."'";
                                        $conn = connect_db();
                                        $result2 = $conn->query($sql);
                                        $row2 = $result2->fetch_assoc();
                                        $maNVuu = $row2['maNhiemVu'];
                                        $tapTin = $row2['tapTin'];
                                        $noiDung = $row2['noiDung'];
                                        echo "
                                            <h3>NỘI DUNG NỘP CỦA NHÂN VIÊN</h3>
                                            <div class='form-group'>
                                                <label for='noiDung'>Nội dung</label>
                                                <input type='text' readonly  class='form-control' id='noiDung'  name='noiDung' value='$noiDung' />
                                            </div>
                                            <div class='form-group'>
                                                <label for='tapTinGui'>Tập tin gửi</label>
                                               <div>Nhấn vào tên file để tải về: <a href='downloadFile.php?maNVuu=$maNVuu'>$tapTin</a></div>
                                            </div>
                                            <div class=''>
                                            <a href='formXacNhan.php?maNVuu=$maNVuu'<button class='btn btn-outline-success'>Đông ý</button></a>
                                            <a href='formGuiLai.php?maNVuu=$maNVuu'<button class='btn btn-outline-warning'>Gửi lại</button></a>
                                            
                                            
                                        </div>
                                        ";
                                        
                                    }
                                    if ($row['trangThai'] == 'COMPLETED'){
                                        $sql = "SELECT * FROM NhiemVuHoanThanh where maNhiemVu = '".$_GET['maNVu']."'";
                                        $conn = connect_db();
                                        $result2 = $conn->query($sql);
                                        $row2 = $result2->fetch_assoc();
                                        $mucDo = $row2['mucDo'];
                                        $dungHan = $row2['dungHan'];
                                     
                                        echo "
                                            <h3>ĐÁNH GIÁ NHIỆM VỤ</h3>
                                            <div class='form-group'>
                                                <label for='noiDung'>Mức độ</label>
                                                <input type='text' readonly  class='form-control' id='noiDung'  name='noiDung' value='$mucDo' />
                                            </div>
                                          
                                        ";
                                        if($dungHan == 1){
                                            echo "
                                               
                                                <div class='form-group'>
                                                    <label for='noiDung'>Đánh gia thời gian</label>
                                                    <input type='text' readonly  class='form-control' id='noiDung'  name='noiDung' value='Đúng hạn' />
                                                </div>
                                            
                                            ";
                                        }else{
                                            echo "
                                               
                                            <div class='form-group'>
                                                <label for='noiDung'>Đánh gia thời gian</label>
                                                <input type='text' readonly  class='form-control' id='noiDung'  name='noiDung' value='Trể hạn' />
                                            </div>
                                        
                                        ";
                                        }
                                        
                                    }
                                ?>
                            </div>

                            <div class="modal-footer">
                                
                                <button type="submit" id='sbCancel' name="submit" class="btn btn-info">Cập Nhật</button>
                                <button type="submit" id='sbUpdate' name="cancel" class="btn btn-danger">Hủy task</button>
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

        // if($('#trangThai').attr('value')=='NEW'){
        //     $('#sbUpdate').attr('disabled', false);
        //     $('#sbCancel').attr('disabled', false);
        // }else{
        //     $('#sbUpdate').attr('disabled', true);
        //     $('#sbCancel').attr('disabled', true);

        // }
	</script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>

