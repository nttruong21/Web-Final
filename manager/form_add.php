<?php
  session_start();
  require_once('../connect_db.php');
  $message = '';
  if (!isset($_POST['maNVu']) || !isset($_POST['tenNVu']) || !isset($_POST['time'])
      || !isset($_POST['moTa'])){
        $message = 'Bạn vui lòng nhập đầy đủ thông tin!!!';
        
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
          header("Location: newTask.php");
        }else{
          $message = "thêm thất bại";
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
				
                
				<div class="all-task">
					<div class="task-content">
            <h3 class="p-2 d-flex justify-content-center bg-dark text-white">THÊM NHIỆM VỤ MỚI</h3>
            <form action="form_add.php" method="post" enctype="multipart/form-data">

              <div class="modal-body">
                <?php
                  if(!empty($message)){
                    echo"<p class='alert alert-success'>". $message ."</p>";
                    
                  }
                ?>
                
                <div class="form-group">
                    <label for="maNVu">Mã nhiệm vụ</label>
                    <input type="text" placeholder="Nhập mã nhiệm vụ" class="form-control" id="maNVu" name="maNVu" required />
                </div>
                <div class="form-group">
                    <label for="tenNVu">Tên nhiệm vụ</label>
                    <input type="text" placeholder="Nhập tên nhiệm vụ" class="form-control" id="tenNVu" name="tenNVu" required />
                </div>

                <?php
                    $maNVi = $_SESSION['maNhanVien'];
                    $maPBa = $_SESSION['maPB'];
                  $sql = "SELECT * FROM NhanVien where maNhanVien != '$maNVi' and maPhongBan = '$maPBa' ";
                  $conn = connect_db();
                  $result = $conn->query($sql);
                  ?>
                  <div class="form-group">
                      <label for="maNVien">Tên nhân viên</label>
                      <select name="maNVien" class="form-control">
                      <?php
                      while ($row = $result->fetch_assoc()){
                        ?>
                          <option value="<?php echo $row['maNhanVien']?>"><?php echo $row['hoTen']?></option>
                        <?php
                      
                    }
                    ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="maPB">mã phòng ban</label>
                    <input type="text" readonly class="form-control" id="maPB" name="maPB" value=<?=$_SESSION['maPB']?> />
                </div>
                <!-- <div class="form-group">
                    <label for="time">hạn thực hiện</label>
                    <input type="text" placeholder="Thời gian thực hiện" class="form-control" name="time" id="time" required />
                </div> -->
                <div class="form-group">
                    <label for="time">Start date:</label>
                    <input type="date" id="time" name="time"
                        value="2022-01-01"
                        min="2022-01-01" max="3000-12-31">
                </div>
                <div class="form-group">
                    <label for="moTa">mô tả</label>
                    <textarea rows="2" id="moTa" class="form-control" name="moTa" placeholder="Nhập mô tả" required></textarea>

                </div>
                <div class="form-group">
                  <label for="file">Tệp đính kèm</label>
                  <input type="file" class="form-control" name="file">
                </div>

                <!-- <div class="form-group">
                    <label for="file">Tập tin</label>
                    <input type="text" placeholder="Chọn tập tin" name="file" class="form-control" id="file" required />
                </div> -->
                <div class="form-group">
                    <label for="trangThai">Trạng thái</label>
                    <input type="text" readonly class="form-control" id="trangThai" name="trangThai" value="NEW" />
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
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>