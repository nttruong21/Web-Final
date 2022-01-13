<?php
	session_start();
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
	<title>Danh sách đơn xin nghỉ phép</title>
</head>
<style>
	body {
		background-image: url(../images/background.jpg);
		background-repeat: no-repeat;
    	background-size: cover;
	}
	.e__dayOff-heading-none {
		display: none;
	}
	.task-search-input {
		width: inherit;
	}
	.scrollable-dayOff {
		height: 450px;
		overflow-x: auto;
	}
	.e__dayOff__heading {
		background-color: rgb(131,124,124);
		position: sticky;
		color: rgb(222,215,35);
	}
	.e__dayOff-list-body {
		background-color: rgb(240,255,255);
	}

	@media screen and (min-width: 992px) and (max-width: 1199px){
		.dayOff-numDay__heading {
			display: none;
		}
	}
	@media screen and (min-width: 768px) and (max-width: 991px){
		.dayOff-numDay__heading {
			display: none;
		}
	}	

	@media screen and (min-width: 576px) and (max-width: 767px){
		.e__dayOff-heading-none {
			display: block;
			font-size: bold;
		}
		.e__dayOff-heading {
			display: none;
		}
		.e__sumDayOff {
			display: none;
		}
		.dayOff-numDay__heading {
			display: none;
		}
	}
	@media screen and (max-width: 576px){
		.e__dayOff-heading-none {
			display: block;
			font-size: bold;
		}
		.e__dayOff-heading {
			display: none;
		}
		.e__sumDayOff {
			display: none;
		}
		.dayOff-reason__heading,
		.dayOff-numDay__heading {
			display: none;
		}
	} 

</style>
<body>
	<?php
		require_once('sidebar_searchTask.php');
	?>
	<div>
		<div class="row m-0">
				
			<?php
				require_once('sidebar.php');
			?>
			<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10 rounded border border-left-0 border-right-0 border-bottom-0">
				<div class="e__dayOff-list-body">
					<p class="e__dayOff-heading-none p-2 justify-content-center bg-dark text-white text-center">
						<i class="fas fa-hand-point-left"></i>
						DANH SÁCH ĐƠN XIN NGHỈ PHÉP
					</p>
					<h5 class="e__dayOff-heading p-2 justify-content-center bg-dark text-white text-center">
						<i class="fas fa-hand-point-left"></i>
						DANH SÁCH ĐƠN XIN NGHỈ PHÉP
					</h5>
					<div class="scrollable-dayOff">
						<div class="e__dayOff__heading">
							<div class="d-flex">
								<div class='dayOff-id__heading col-xl-2 col-lg-2 col-md-2 col-sm-2 col-6 border border-top-0 border-left-0'>
									<p class="mb-0 p-1 e__check-font-style">Mã đơn</p>
								</div>
								<div class='dayOff-reason__heading col-xl-6 col-lg-6 col-md-6 col-sm-6 border border-top-0 border-left-0'>
									<p class="mb-0 p-1 e__check-font-style">Lý do nghỉ</p>
								</div>
								<div class='dayOff-numDay__heading col-xl-2 border border-top-0 border-left-0'>
									<p class="mb-0 p-1 e__check-font-style">Số ngày nghỉ</p>
								</div>
								<div class='dayOff-condition__heading col-xl-2 col-lg-4 col-md-4 col-sm-4 col-6 border border-top-0 border-left-0'>
									<p class="mb-0 p-1 e__check-font-style">Trạng thái</p>
								</div>							
							</div>
						</div>	
						<div class="e__task__infomation">
						<?php
								require_once("../connect_db.php");
								require_once("task_and_dayOff_db.php");

								$maNhanVien = $_SESSION['maNhanVien'];

								$sql = "SELECT * FROM DonXinNghiPhep WHERE maNhanVien = '$maNhanVien' ORDER BY ngayTao";
								$result = connect_db()->query($sql);

								while ($row = $result->fetch_assoc()) {
									
									$idNV = $row['maNhanVien'];
									$idForm = $row['maDon'];
									$lyDo = $row['lyDo'];
									$day = $row['soNgayNghi'];
									$trangThai = $row['trangThai'];

									if ($trangThai == 'WAITING') {
										echo	"<div class='d-flex task-list'>
													<div class='dayOff-id__heading col-xl-2 col-lg-2 col-md-2 col-sm-2 col-6 border border-top-0 border-left-0'>
														<p class='dayOff-id e__check-font-style mb-0 p-1'> <a class='text-dark' href='dayOff_infomation.php?id=$idNV'> $idForm </a></p>
													</div>
													<div class='dayOff-reason__heading col-xl-6 col-lg-6 col-md-6 col-sm-6 border border-top-0 border-left-0'>
														<p class='dayOff-reason e__check-font-style mb-0 p-1'> <a class='text-dark' href='dayOff_infomation.php?id=$idNV'> $lyDo </a></p>
													</div>
													<div class='dayOff-numDay__heading col-xl-2 border border-top-0 border-left-0'>
														<p class='dayOff-numDay e__check-font-style mb-0 p-1'><a class='text-dark' href='dayOff_infomation.php?id=$idNV'> $day </a></p>
													</div>
													<div class='dayOff-condition__heading col-xl-2 col-lg-4 col-md-4 col-sm-4 col-6 border border-top-0 border-left-0'>
														<p class='badge badge-warning mb-0 p-1 e__check-font-style'>$trangThai</p>
													</div>									
												</div>";

									} else if ($trangThai == 'APPROVED') {
										echo	"<div class='d-flex task-list'>
													<div class='dayOff-id__heading col-xl-2 col-lg-2 col-md-2 col-sm-2 col-6 border border-top-0 border-left-0'>
														<p class='dayOff-id e__check-font-style mb-0 p-1'> <a class='text-dark' href='dayOff_infomation.php?id=$idNV'> $idForm </a></p>
													</div>
													<div class='dayOff-reason__heading col-xl-6 col-lg-6 col-md-6 col-sm-6 border border-top-0 border-left-0'>
														<p class='dayOff-reason e__check-font-style mb-0 p-1'> <a class='text-dark' href='dayOff_infomation.php?id=$idNV'> $lyDo </a></p>
													</div>
													<div class='dayOff-numDay__heading col-xl-2 border border-top-0 border-left-0'>
														<p class='dayOff-numDay e__check-font-style mb-0 p-1'><a class='text-dark' href='dayOff_infomation.php?id=$idNV'> $day </a></p>
													</div>
													<div class='dayOff-condition__heading col-xl-2 col-lg-4 col-md-4 col-sm-4 col-6 border border-top-0 border-left-0'>
														<p class='badge badge-success mb-0 p-1 e__check-font-style'>$trangThai</p>
													</div>									
												</div>";
									} else if ($trangThai = 'REFUSED') {
										echo	"<div class='d-flex task-list'>
													<div class='dayOff-id__heading col-xl-2 col-lg-2 col-md-2 col-sm-2 col-6 border border-top-0 border-left-0'>
														<p class='dayOff-id e__check-font-style mb-0 p-1'> <a class='text-dark' href='dayOff_infomation.php?id=$idNV'> $idForm </a></p>
													</div>
													<div class='dayOff-reason__heading col-xl-6 col-lg-6 col-md-6 col-sm-6 border border-top-0 border-left-0'>
														<p class='dayOff-reason e__check-font-style mb-0 p-1'> <a class='text-dark' href='dayOff_infomation.php?id=$idNV'> $lyDo </a></p>
													</div>
													<div class='dayOff-numDay__heading col-xl-2 border border-top-0 border-left-0'>
														<p class='dayOff-numDay e__check-font-style mb-0 p-1'><a class='text-dark' href='dayOff_infomation.php?id=$idNV'> $day </a></p>
													</div>
													<div class='dayOff-condition__heading col-xl-2 col-lg-4 col-md-4 col-sm-4 col-6 border border-top-0 border-left-0'>
														<p class='badge badge-danger mb-0 p-1 e__check-font-style'>$trangThai</p>
													</div>									
												</div>";
									}

							}?>			
						</div>

					</div>
					<?php 
						$maNhanVien = $_SESSION['maNhanVien'];
						$sql = "SELECT * FROM `DonXinNghiPhep` where maNhanVien = '$maNhanVien' ORDER BY maDon DESC LIMIT 1";
						$conn = connect_db();
						$result = $conn->query($sql);
						if ($result->num_rows == 0){
							die('Kêt nối thành công, Nhưng không có dữ liệu');
						}else{
							$row = $result->fetch_assoc();
							$ngayMoiTao = strtotime($row['ngayTao']);
							$soNgayNghi = $row['soNgayNghi'];
							$dateNow = strtotime(date("y-m-d"));
							if($dateNow - $ngayMoiTao >= 60*60*24*7 && $soNgayNghi <= 12){
								echo 	"<div class='m-auto d-flex align-items-center justify-content-center'>
											<a href='dayOff_Form.php'>
											<button
											class='btn btn-light e__btn-task d-flex align-items-center'
											type='submit'>
											<i class='fas fa-calendar-da'></i>
											<p class='mb-0 ml-2 e__check-font-style e__dayOff-reason-btn'>Tạo đơn nghỉ phép</p>	
											</button>
											</a>
										</div>
							
								";
							} else {
								echo 	"<div class='m-auto d-flex align-items-center justify-content-center'>
											
											<button disabled 
											class='btn btn-light e__btn-task d-flex align-items-center'
											type='submit'>
											<i class='fas fa-calendar-da'></i>
											<p class='mb-0 ml-2 e__check-font-style e__dayOff-reason-btn'>Tạo đơn nghỉ phép</p>	
											</button>
											
										</div>
								
								";
						}
					}
					?>

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

	<script>
// 		function moveToDayOffFormPage() {
// 		let sumDayOff = $('#sumDayOff').val();
// 		let countDayOff = $('#countDayOff').val();

// 		if (countDayOff > sumDayOff) {
// 			window.location.href = "dayOff_Form_disabled.php";
// 		}else {
// 			window.location.href = "dayOff_Form.php";
// 		}
// }
	</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<script src="/main.js"></script> 
</body>

</html>