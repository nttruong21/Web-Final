<?php
	session_start();
	
	require_once('../connect_db.php');
	
    if (isset($_POST['submit'])){
        $message = 'vui lòng nhập đầy đủ thông tin!!';
        if (!isset($_POST['noiDung'])) {
			$message = "Vui lòng nhập đầy đủ thông tin";
		} else if (empty($_POST['noiDung'])) {
			$message = "Không để giá trị rỗng";
		} else {
			$maNV = $_POST['maNVu'];
			$noiDung = $_POST['noiDung'];
			
			if (!isset($_FILES["tapTin"])) {
				$message = "Dữ liệu không đúng cấu trúc";
			}

			$taptin = $_FILES["tapTin"]["name"];
			if ($taptin == '') {
				
				$sql1 = "UPDATE NhiemVu SET trangThai = 'WAITING' WHERE maNhiemVu = ?";
				$conn1 = connect_db();
				$stm1 = $conn->prepare($sql1);
				$stm1 -> bind_param("s", $maNV);
				$stm1 -> execute();

				$sql3 = "SELECT * FROM KetQuaTraVe where maNhiemVu='$maNV'";
                $conn3 = connect_db();
                $result3 = $conn3->query($sql3);
                $count = $result3->num_rows;
                $rowKQTV = $result3->fetch_assoc();


				if( $count > 0){
                    // $maNVu = $row3['maNhiemVu'];
                    $sql2 = "UPDATE KetQuaGui SET  noiDung = ?, tapTin = ? WHERE maNhiemVu = '$maNV'";
                    $conn2 = connect_db();
                    $stm2 = $conn2->prepare($sql2);
                    $stm2->bind_param('sss',$noiDung, $tapTin);
                    $stm2->execute();
                    
                }else{
                    $sql2 = "INSERT INTO KetQuaGui VALUES(?, ?, ?,?)";
                    $conn2 = connect_db();
                    $stm2 = $conn2->prepare($sql2);
                    $stm2->bind_param('sss', $maNVu, $noiDung, $tapTin);
                    $stm2->execute();
                }

			} else {
				$tname = $_FILES["tapTin"]["tmp_name"];
                $uploads_dir = '../files';
				
				$sql1 = "UPDATE NhiemVu SET trangThai = 'WAITING' WHERE maNhiemVu = ?";
				$conn1 = connect_db();
				$stm1 = $conn->prepare($sql1);
				$stm1 -> bind_param("s", $maNV);
				$stm1 -> execute();

				$sql3 = "SELECT * FROM KetQuaTraVe where maNhiemVu='$maNV'";
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

				// if ($stm->affected_rows == 1) {
				// 	header("Location: get_waiting_task.php");
				// } else {
				// 	$message = "Cập nhật thất bại";
				// }
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
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<title>Trang thông tin nhiệm vụ đang làm</title>
</head>
<style>
	body {
		background-image: url(../images/background.jpg);
		background-repeat: no-repeat;
    	background-size: cover;
	}
	.navbar-header__none {
		display: none;
	}
	.employee {
		margin: 10px 15px;
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
	.task-content {
		background-color: rgb(240,255,255);
	}
	.e__check-font-style{
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}
	.e__condition-style {
		padding: 5px 0px 0 15px;
	}
	.displayNone {
		display: none;
	}
	@media screen and (min-width: 992px) and (max-width: 1199px){
		.task-name__heading,
		.task-time__heading {
			display: none;
		}
	}
	@media screen and (min-width: 768px) and (max-width: 991px){
		.employee-name,
		.task-name__heading,
		.task-time__heading {
			display: none;
		}
		.employee-heading {
			justify-content: space-between;
		}
	}	

	/* @media screen and (min-width: 576px) and (max-width: 767px){
		.navbar {
			padding: 0;
    		position: absolute;
		}
		.navbar-header {
			display: none;
		}
		.navbar-header__none {
			display: block;
		}
		.employee-name {
			display: none;
		}
	} */
	@media screen and (max-width: 576px){
		/* .navbar {
			padding: 0;
    		position: absolute;
		} */
		.navbar-header {
			display: none;
		}
		.navbar-header__none {
			display: block;
			font-weight: bold;
		}
		.employee-name {
			display: none;
		}
		
		.task-description__heading,
		.task-time__heading {
			display: none;
		}
	}
</style>
<body>
	<?php
		require_once('sidebar_searchTask.php');
	?>
	</div>
	
	</div>
	<div>
		<div class="row m-0">
			
			<?php
				require_once('sidebar.php');
			?>
			<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10 rounded border border-left-0 border-right-0 border-bottom-0">
				<div class="task-content">
					<h5 class="p-2 d-flex justify-content-center bg-dark text-white tex-center">
						<i class="fas fa-hand-point-left"></i>
						INFORMATION IN PROGRESS TASK
					</h5>
					<form action="" method="post" enctype="multipart/form-data">
						<?php
							require_once("../connect_db.php");
							require_once("task_and_dayOff_db.php");

							$sql = "SELECT * FROM NHIEMVU WHERE maNhiemVu = '".$_GET['id']."'";
							$result = connect_db()->query($sql);

							while ($row = $result->fetch_assoc()) {

								$idNV = $row['maNhiemVu'];
							
							}
						?>
						<div class="row">
							<div class="col-xl-2">
								<div class="form-group ml-3 mr-3">
									<label for="maNVu">Mã nhiệm vụ</label>
									<input type="text" value="<?= $idNV ?>" class="form-control" id="maNVu" name="maNVu" readonly />
								</div>
					
							</div>
							<div class="col-xl-10">
                                <div class="form-group ml-3 mr-3">
									<label for="noiDung">Nội dung</label>
									<input type="text" value="" class="form-control" id="noiDung" name="noiDung"/>
								</div>
                                <div class="form-group ml-3 mr-3">
                                    <label for="tapTin">Tập tin đính kèm</label>
                                    <input type="file" class="form-control" id="tapTin" name="tapTin" class="p-0 border border-none" />
                                </div>
								
								<div class="form-group ml-3 mr-3">
									<button type="submit" name="submit" class="btn btn-primary">Submit</button>
								</div>
							</div>														
						</div>
					</form>
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
                    <p id="responseMess"><?= $messageSuccess ?> </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Confirm</button>
                </div>
            </div>
        </div>
    </div>

	<script>
	
	</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<!-- <script src="/main.js"></script>  -->
</body>

</html>