<?php
	session_start();
	
	require_once('../connect_db.php');
	
    if (isset($_POST['submit'])){
        $message = '';
        if (!isset($_POST['maNVu']) || !isset($_POST['noiDung'])) {
			$message = "Vui lòng nhập đầy đủ thông tin";
		} else if (empty($_POST['maNVu']) || empty($_POST['noiDung'])) {
			$message = "Không để giá trị rỗng";
		} else {
			$maNV = $_POST['maNVu'];
			$noiDung = $_POST['noiDung'];
			
			if (!isset($_FILES["tapTin"])) {
				$message = "Dữ liệu không đúng cấu trúc";
			}

			$name =  $_FILES["tapTin"]['name'];

			// $tapTin = $_FILES["tapTin"]["name"];
			// var_dump($name);
	
			// $tmp_name = $_FILES["tapTin"]['tmp_name'];
			// $tname = $_FILES["tapTin"]["tmp_name"];
			// $uploads_dir = '../files';
			// move_uploaded_file($tname,$uploads_dir.'/'.$name);
			// die($tname.$uploads_dir);

		
	

			if ($name == '') {
				
				$sql1 = "UPDATE NhiemVu SET trangThai = 'WAITING' WHERE maNhiemVu = ?";
				$conn1 = connect_db();
				$stm1 = $conn1->prepare($sql1);
				$stm1 -> bind_param("s", $maNV);
				$stm1 -> execute();


				$sql3 = "SELECT * FROM KetQuaGui where maNhiemVu='$maNV'";
				$conn3 = connect_db();
				$result3 = $conn3->query($sql3);
				$count = $result3->num_rows;
			// 	$rowKQTV = $result3->fetch_assoc();


					if( $count > 0){
						$sql2 = "UPDATE KetQuaGui SET noiDung = ?, tapTin = ? WHERE maNhiemVu = '$maNV'"; // chỗ này tập tin rỗng thì đưa vào làm gì?
						$conn2 = connect_db();
						$stm2 = $conn2->prepare($sql2);
						$stm2->bind_param('ss',$noiDung, $name);
						$stm2->execute();
							
					}else{
						$sql2 = "INSERT INTO KetQuaGui(maNhiemVu, noiDung, tapTin) VALUES(?, ?, ?)";
						$conn2 = connect_db();
						$stm2 = $conn2->prepare($sql2);
						$stm2->bind_param('sss', $maNV, $noiDung, $name);
						$stm2->execute();

               		}

			} else { // chỗ này có thì mưới thêm
				// $tname = $_FILES["tapTin"]["name"];
                // $uploads_dir = '../files';
				$tname = $_FILES["tapTin"]["tmp_name"];
				$uploads_dir = '../files';
				// move_uploaded_file($tname,$uploads_dir.'/'.$name);
			// 	move_uploaded_file($tname,$uploads_dir.'/'.$name);

				$sql1 = "UPDATE NhiemVu SET trangThai = 'WAITING' WHERE maNhiemVu = ?";
				$conn1 = connect_db();
				$stm1 = $conn1->prepare($sql1);
				$stm1 -> bind_param("s", $maNV);
				$stm1 -> execute();

				$sql3 = "SELECT * FROM KetQuaGui where maNhiemVu='$maNV'";
                $conn3 = connect_db();
                $result3 = $conn3->query($sql3);
                $count = $result3->num_rows;


				if( $count > 0){
                    $sql2 = "UPDATE KetQuaGui SET  noiDung = ?, tapTin = ? WHERE maNhiemVu = ?";
                    $conn2 = connect_db();
                    $stm2 = $conn2->prepare($sql2);
                    $stm2->bind_param('sss',$noiDung, $name, $maNV);
                    $stm2->execute();

                }else{
                    $sql2 = "INSERT INTO KetQuaGui(maNhiemVu, noiDung, tapTin) VALUES(?, ?, ?)";
                    $conn2 = connect_db();
                    $stm2 = $conn2->prepare($sql2);
                    $stm2->bind_param('sss', $maNV, $noiDung, $name);
                    $stm2->execute();
                }
				move_uploaded_file($tname,$uploads_dir.'/'.$name);

			}
			if( $stm2->affected_rows == 1 ){
				header("Location: get_waiting_task.php");
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
<<<<<<< HEAD
							// require_once("task_and_dayOff_db.php");
=======
							
>>>>>>> dad506238ff02d2514c9701e2c6262dc9e11917c

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
									<input type="text"  class="form-control" id="noiDung" name="noiDung" required />
								</div>
                                <div class="form-group ml-3 mr-3">
                                    <label for="tapTin">Tập tin đính kèm</label>
                                    <input type="file" class="form-control" id="tapTin" name="tapTin" required/>
                                </div>
								
								<div class="form-group ml-3 mr-3">
									<button type="submit" name="submit" class="btn btn-primary">Submit</button>
								</div>
							</div>														
						</div>
					</form>

					<!-- <form action="handle_change_admin_avatar.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="custom-file">
                            <input name="admin-avatar" type="file" class="custom-file-input" id="admin-avatar">
                            <label class="custom-file-label" for="admin-avatar">Choose file</label>
                        </div>
                        <div class="form-group mt-3">
                            <div id="change-admin-avatar-error-message" class="text-center alert-danger font-weight-bold"></div>
                        </div>
                    </div>
                    <div  class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Thoát</button>
                        <button onclick="handleChangeAdminAvatar(event);" type="submit" class="btn btn-primary">Thay đổi</button>
                    </div>   
                </form>       -->
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