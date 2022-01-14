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

<body>
	
	<?php
		require_once('sidebar_searchTask.php');
	?>
	<div>
		<div class="row m-0">
			
			<?php
				require_once('sidebar.php');
			?>

			<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-11 rounded border border-left-0 border-right-0 border-bottom-0">
				<div class="border border-left-0 border-right-0">
					<div class="scrollable-task">
						<div class="e__task__heading">
							<div class="d-flex">
								<div class='task-id__heading col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3 border border-top-0 border-left-0'>
									<p class="mb-0 p-1 e__check-font-style">Mã Nhiệm vụ</p>
								</div>
								<div class='task-name__heading col-xl-2 col-sm-5 col-5 border border-top-0 border-left-0'>
									<p class="mb-0 p-1 e__check-font-style">Tên nhiệm vụ</p>
								</div>
								<div class='task-description__heading col-xl-4 col-lg-6 col-md-6 border border-top-0 border-left-0'>
									<p class="mb-0 p-1 e__check-font-style">Thông tin nhiệm vụ</p>
								</div>
								<div class='task-time__heading col-xl-2 border border-top-0 border-left-0'>
									<p class="mb-0 p-1 e__check-font-style">Dealine</p>
								</div>
								<div class='task-rate__heading col-xl-2 col-lg-4 col-md-4 col-sm-4 col-4 border border-top-0 border-left-0 border-right-0'>
									<p class="mb-0 p-1 e__check-font-style">Trạng thái</p>
								</div>								
							</div>
						</div>	
						<div class="e__task__infomation">
						<?php
								require_once("../connect_db.php");
                                require_once("task_and_dayOff_db.php");
								$sql = "SELECT * FROM NHIEMVU WHERE trangThai != 'CANCELED' ORDER BY hanThucHien";
								$result = connect_db()->query($sql);

								while ($row = $result->fetch_assoc()) {
									$idNV = $row['maNhiemVu'];
									$name = $row['tenNhiemVu'];
									$desc = $row['moTa'];
									$time = $row['hanThucHien'];
									$condition = $row['trangThai'];

									if ($condition == 'NEW') {
										echo	"<div class='d-flex task-list'>
													<div class='task-id__heading col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3 border border-top-0 border-left-0'>
														<p class='task-id e__check-font-style mb-0 p-1'> <a class='text-dark' href='task_infomation.php?id=$idNV'> $idNV </a></p>
													</div>
													<div class='task-name__heading col-xl-2 col-sm-5 col-5 border border-top-0 border-left-0'>
														<p class='task-name e__check-font-style mb-0 p-1'> <a class='text-dark' href='task_infomation.php?id=$idNV'> $name </a></p>
													</div>
													<div class='task-description__heading col-xl-4 col-lg-6 col-md-6 border border-top-0 border-left-0'>
														<p class='task-description e__check-font-style mb-0 p-1'><a class='text-dark' href='task_infomation.php?id=$idNV'> $desc </a></p>
													</div>
													<div class='task-time__heading col-xl-2 border border-top-0 border-left-0'>
														<p class='mb-0 p-1 e__check-font-style'>$time</p>
													</div>
													<div class='task-rate__heading e__condition-style col-xl-2 col-lg-4 col-md-4 col-sm-4 col-4 border border-top-0 border-left-0'>
														<p class='badge badge-info mb-0 p-1 e__check-font-style'>$condition</p>
													</div>										
												</div>";
									}
									else if ($condition == 'COMPLETED') {
										echo	"<div class='d-flex task-list'>
													<div class='task-id__heading col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3 border border-top-0 border-left-0'>
														<p class='task-id e__check-font-style mb-0 p-1'> <a class='text-dark' href='task_infomation_completed.php?id=$idNV'> $idNV </a></p>
													</div>
													<div class='task-name__heading col-xl-2 col-sm-5 col-5 border border-top-0 border-left-0'>
														<p class='task-name e__check-font-style mb-0 p-1'> <a class='text-dark' href='task_infomation_completed.php?id=$idNV'> $name </a></p>
													</div>
													<div class='task-description__heading col-xl-4 col-lg-6 col-md-6 border border-top-0 border-left-0'>
														<p class='task-description e__check-font-style mb-0 p-1'><a class='text-dark' href='task_infomation_completed.php?id=$idNV'> $desc </a></p>
													</div>
													<div class='task-time__heading col-xl-2 border border-top-0 border-left-0'>
														<p class='mb-0 p-1 e__check-font-style'>$time</p>
													</div>
													<div class='task-rate__heading col-xl-2 col-lg-4 col-md-4 col-sm-4 col-4 border border-top-0 border-left-0'>
														<p class='badge badge-success mb-0 p-1 e__check-font-style'>$condition</p>
													</div>										
												</div>";
									}
									else if ($condition == 'REJECTED') {
										echo	"<div class='d-flex task-list'>
													<div class='task-id__heading col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3 border border-top-0 border-left-0'>
														<p class='task-id e__check-font-style mb-0 p-1'> <a class='text-dark' href='task_infomation_rejected.php?id=$idNV'> $idNV </a></p>
													</div>
													<div class='task-name__heading col-xl-2 col-lg-4 col-sm-5 col-5 border border-top-0 border-left-0'>
														<p class='task-name e__check-font-style mb-0 p-1'> <a class='text-dark' href='task_infomation_rejected.php?id=$idNV'> $name </a></p>
													</div>
													<div class='task-description__heading col-xl-4 col-lg-6 col-md-6 border border-top-0 border-left-0'>
														<p class='task-description e__check-font-style mb-0 p-1'><a class='text-dark' href='task_infomation_rejected.php?id=$idNV'> $desc </a></p>
													</div>
													<div class='task-time__heading col-xl-2 border border-top-0 border-left-0'>
														<p class='mb-0 p-1 e__check-font-style'>$time</p>
													</div>
													<div class='task-rate__heading col-xl-2 col-lg-4 col-md-4 col-sm-4 col-4 border border-top-0 border-left-0'>
														<p class='badge badge-danger mb-0 p-1 e__check-font-style'>$condition</p>
													</div>										
												</div>";
									}
									else if ($condition == 'IN PROGRESS') {
										echo	"<div class='d-flex task-list'>
													<div class='task-id__heading col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3 border border-top-0 border-left-0'>
														<p class='task-id e__check-font-style mb-0 p-1'> <a class='text-dark' href='task_infomation_inprogress.php?id=$idNV'> $idNV </a></p>
													</div>
													<div class='task-name__heading col-xl-2 col-lg-4 col-sm-5 col-5 border border-top-0 border-left-0'>
														<p class='task-name e__check-font-style mb-0 p-1'> <a class='text-dark' href='task_inprogress_infomation.php?id=$idNV'> $name </a></p>
													</div>
													<div class='task-description__heading col-xl-4 col-lg-6 col-md-6 border border-top-0 border-left-0'>
														<p class='task-description e__check-font-style mb-0 p-1'><a class='text-dark' href='task_infomation_completed.php?id=$idNV'> $desc </a></p>
													</div>
													<div class='task-time__heading col-xl-2 border border-top-0 border-left-0'>
														<p class='mb-0 p-1 e__check-font-style'>$time</p>
													</div>
													<div class='task-rate__heading col-xl-2 col-lg-4 col-md-4 col-sm-4 col-4 border border-top-0 border-left-0'>
														<p class='badge badge-secondary mb-0 p-1 e__check-font-style'>$condition</p>
													</div>										
												</div>";
									}
									else if ($condition == 'WAITING') {
										echo	"<div class='d-flex task-list'>
													<div class='task-id__heading col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3 border border-top-0 border-left-0'>
														<p class='task-id e__check-font-style mb-0 p-1'> <a class='text-dark' href='task_infomation_waiting.php?id=$idNV'> $idNV </a></p>
													</div>
													<div class='task-name__heading col-xl-2 col-lg-4 col-sm-5 col-5 border border-top-0 border-left-0'>
														<p class='task-name e__check-font-style mb-0 p-1'><a class='text-dark' href='task_infomation_waiting.php?id=$idNV'> $name </a></p>
													</div>
													<div class='task-description__heading col-xl-4 col-lg-6 col-md-6 border border-top-0 border-left-0'>
														<p class='task-description e__check-font-style mb-0 p-1'><a class='text-dark' href='task_infomation_completed.php?id=$idNV'> $desc </a></p>
													</div>
													<div class='task-time__heading col-xl-2 border border-top-0 border-left-0'>
														<p class='mb-0 p-1 e__check-font-style'>$time</p>
													</div>
													<div class='task-rate__heading col-xl-2 col-lg-4 col-md-4 col-sm-4 col-4 border border-top-0 border-left-0'>
														<p class='badge badge-warning mb-0 p-1 e__check-font-style'>$condition</p>
													</div>										
												</div>";
									// onclick='moveToTaskInfomationPage();
								}
							}
							?>		
							
							
						</div>
					</div>
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
	

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<script src="/main.js"></script> 
</body>

</html>