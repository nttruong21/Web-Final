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
	// Kiểm tra người dùng có phải nhân viên?
    if (!$_SESSION['maChucVu'] == 'NV') {
        header("Location: /no_access.html");
    }

	$message = '';
    if (!isset($_POST['maNVu']) || !isset($_POST['tenNVu']) || !isset($_POST['time'])
        || !isset($_POST['moTa'])){
          $message = 'vui lòng nhập đầy đủ thông tin!!';
          
        }else if (empty($_POST['maNVu']) || empty($_POST['tenNVu']) || empty($_POST['time'])
        || empty($_POST['moTa'])){
          $message = 'KHông để giá trị rỗng!!';
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
	<title>Trang chủ Nhân Viên</title>
</head>
<style>
	body {
		background-image: url(../images/background.jpg);
		background-repeat: no-repeat;
    	background-size: cover;
	}
	.task-search-input {
		width: inherit;
	}
	.scrollable-task {
		height: 500px;
		overflow-x: auto;
	}

	.e__task__heading {
		background-color: rgb(131,124,124);
		position: sticky;
		color: rgb(222,215,35);
	}
	.e__task__infomation {
		background-color: rgb(240,255,255);
	}
</style>
<body>
	<div>
		<div class="navbar navbar-expand-lg navbar-light bg-light d-flex justify-content-between mr-2 ml-2">
			<div class="">
				<div class="navbar-header">
					<div class=""><h4>Home page Employee</h4></div>
				</div>
			</div>
			<div class="navbar-info nav d-flex">
				<a class="font-weight-bold mr-4" href="../profile.php">Profile</a>
				<a class="font-weight-bold" href="../logout.php">Logout</a>
			</div>
			<div class="navbar-icon d-none">
				<i class="fas fa-bars"></i>
			</div>
		</div>

	</div>
	<div class="employee m-4">
		<div class="row">
			<div class="d-flex w-100 align-items-center employee-heading">
					
				<div class="col-xl-4 col-lg-6 col-md-5 employee-name">
					<h4 class="">Hello <?= $_SESSION['hoTen'] ?></h4>
				</div>
				<div class="col-xl-5 col-lg-4 col-md-6 col-sm-10 col-10">
					<div class="form-group border rounded-lg mb-0 bg-light">
						<form class="" methode="post">
							<div class="d-flex align-items-center justify-content-between w-100">
								<div class="task-search-input m-1">
									<input class="border border-0 border-none rounded p-1 w-100" type="search" placeholder="Search task" aria-label="Search">
								</div>
								<div class="task-search-icon m-1">
									<button class="btn btn-outline-info rounded-circle" type="submit"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="col-xl-3 col-lg-2 col-md-3 col-sm-2 col-2">
					<ul class="d-flex list-unstyled justify-content-end mb-0">
						<li>
							<button class="nav-item__day-off btn btn-light text-decoration-none d-flex align-items-center justify-content-center" data-toggle='modal' data-target='#day-off-dialog' href="">
								<i class="fas fa-calendar-day"></i>
								<p class="mb-0 ml-1 day-off">On leave</p> 
							</button>
						</li>
					</ul>
				</div>
		
				</div>
			</div>
	
		</div>
	</div>
	<div>
		<div class="row m-0">
			
			<?php
				require_once('sidebar.php');
			?>
			<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10 rounded border border-left-0 border-right-0 border-bottom-0">
				<div class="task-content bg-success">
					<h5 class="p-2 d-flex justify-content-center bg-dark text-white tex-center">
						<i class="fas fa-hand-point-left"></i>
						INFORMATION TASK
					</h5>
					<form action="" method="post" >
						<?php
							require_once("../connect_db.php");
							require_once("task_and_dayOff_db.php");

							$sql = "SELECT * FROM NHIEMVU WHERE maNhiemVu = '".$_GET['id']."'";
							$result = connect_db()->query($sql);

							while ($row = $result->fetch_assoc()) {

								$idNV = $row['maNhiemVu'];
								$name = $row['tenNhiemVu'];
								$desc = $row['moTa'];
								$time = $row['hanThucHien'];
								$condition = $row['trangThai'];
                                $file = $row['tapTin'];
							}
						?>
						<div class="row">
							<div class="col-xl-2">
								<div class="form-group">
									<label for="maNVu">Mã nhiệm vụ</label>
									<input type="text" value="<?= $idNV ?>" class="form-control" id="maNVu" name="maNVu" readonly />
								</div>
								<div class="form-group">
									<label for="timeNV">Hạn thực hiện</label>
									<input type="text" value="<?= $time ?>" class="form-control" id="timeNV" name="Deadline" readonly />
								</div>
							</div>
							<div class="col-xl-10">
                                <div class="form-group">
                                    <label for="tenNVu">Tên nhiệm vụ</label>
									<input type="text" value="<?= $name ?>" class="form-control" id="tenNVu" name="tenNVu" readonly />
								</div>
								<div class="form-group">
                                    <label for="moTa">Mô tả</label>
									<input type="text" value="<? echo $desc ?>" class="form-control" id="moTa" name="Mô tả" readonly>
								</div>
                                <div class="form-group">
                                    <label for="fileNV">Tập tin</label>
                                    <input type="file" value="<?= $file ?>" class="form-control" id="fileNV" name="fileNV" readonly />
                                </div>
								<div class="form-group">
									<button onclick="moveToGetInProgressTask();" disabled type="button" class="btn btn-primary">Start</button>
								</div>
							</div>
							
							
						</div>
					</form>
				</div>
			</div>
    	</div>	
	</div>


	<!-- Day off dialog -->
	<div class="modal fade" id="day-off-dialog">
         <div class="modal-dialog">
            <div class="modal-content">
        
               <div class="modal-header">
                  <h4 class="modal-title">Đơn xin nghỉ phép</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>

               <div class="modal-body">
				   <div class="row">
						<div class="col-xl-12">
							<div class="modal-off__form">
								
								<form action="" method="POST" onsubmit="return false;">
									<div class="row">
										<div class="col">
											<input type="text" class="form-control" id="maNVDayOff" placeholder="Nhập MSNV">
										</div>
										<div class="col">
											<input type="text" class="form-control" id="dayDayOff" placeholder="Số ngày xin nghỉ phép" >
										</div>
										
									</div>
									<div class="row mt-2">
										<div class="col">
											<input type="text" class="form-control" id="reasonDayOff" placeholder="Lý do">
										</div>										
									</div>
									<div class="form-group">
										<div class="custom-file">
											<label for="fileDayOff">Tệp đính kèm (nếu có)</label>
											<input type="file" class="custom-file-input" id="fileDayOff">
										</div>
									</div>
									<p class="mb-0 text-center text-danger d-none empty">Please fill out all of the infomation</p>
									<div class="modal-off__footer d-flex">
										<button onclick="addDayOffForm();" type="submit" class="btn btn-success ml-auto">Gửi</button>
									</div>
								</form>								
							</div>
						</div>
				   </div>
               </div>     
            </div>
         </div>
	</div>


	<!-- Day off list -->
	<div class="modal fade" id="day-off-list-dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
	
				<div class="modal-header">
					<h4 class="modal-title">Danh sách đơn xin nghỉ phép</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-xl-12">
							<!-- <div class="modal-list text-center">
								<p>Danh sách đơn xin nghỉ phép</p>
							</div> -->
							<div class='modal-list-items scrollable'>
							
								<div class="modal-list-item border">
									<!-- <div class='modal-list-name'>
										<h5 class='mb-0'>Danh sách đơn xin nghỉ phép</h5>
									</div> -->
									<div class="modal-list-info">
										<div class="modal-list__heading">
											<div class="row">
												<div class="col-xl-2">
													<p>Mã đơn</p>
												</div>
												<div class="col-xl-2">
													<p>Lý do</p>
												</div>
												<div class="col-xl-4">
													<p>Ngày viết đơn</p>
												</div>
												<div class="col-xl-4">
													<p>Kết quả phê duyệt</p>
												</div>
											</div>
										</div>
										<div class="modal-list__body">
											<div class="row">
												<?php
													// $idSql = "SELECT maNhanVien FROM NhanVien";
													$sql = "select * from DonXinNghiPhep	";
													$result = connect_db()->query($sql);
	
													while ($row = $result->fetch_assoc()) {
														$idForm = $row['maDon'];
														$reason = $row['lyDo'];
														$dayCreate = $row['ngayTao'];
														$conditionDayOff = $row['trangThai'];								
														echo "
															<div class='col-xl-2'>
																<p>$idForm</p>
															</div>
															<div class='col-xl-2'>
																<p>$reason</p>
															</div>
															<div class='col-xl-4'>
																<p>$dayCreate</p>
															</div>
															<div class='col-xl-4'>
																<p>$conditionDayOff</p>
															</div>";
													}
												?>
	
											</div>

										</div>
										
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
	
				<div class="modal-footer d-flex justify-content-between">
					<?php
						$sql = "select * from DonXinNghiPhep";
						$result = connect_db()->query($sql);

						while ($row = $result->fetch_assoc()) {
							$dayLeftDayOff = $row['soNgayNghi'];
						}
					?>
					<p>Số ngày đã nghỉ: <?= $dayLeftDayOff ?> </p>
					<p>Tổng số ngày có thể nghỉ : 15 </p>
				</div>            	
			</div>
		<div>
	</div>


	<!-- message response -->
	
	<div class="modal fade" id="message-respone">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Notification</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <p id="responseMess"></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Confirm</button>
                </div>
            </div>
        </div>
    </div>
});
	<script>
		// function handleChooseOne(e) {
		// 	var inputChooseOne = document.querySelector('.task-name .task-name__input');
		// 	var taskInfo = document.querySelector('.task-infomation');
		// 	inputChooseOne.onclick = function(e) {
		// 		taskInfo.classList.add('bg-primary');
		// 	}
		// }

		// $(document).ready(function() {
		// 	$('.btn-startTask').onclick = function(e) {
		// 		e.preventDefault();
		// 		$('.btn-submitTask').removeAtt('disabled');

		// 	}
		// })
		// $(".btn-start").click(function(e){
		// 	e.preventDefault();
		// 	$('btn-submit').prop('disabled', false);

		// });

		

		// Thêm thông tin form xin nghỉ phép
		// const readAPI = 'http://localhost:8080/manager/api/get_task.php';
  		
		
		
	
		// function getNewTask(e) {
		// 	e.preventDefault();

		// 	let 
		// }
	</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<script src="/main.js"></script> 
</body>

</html>