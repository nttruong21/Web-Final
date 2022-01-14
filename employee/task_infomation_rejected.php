<?php
	session_start();
	
	require_once('../connect_db.php');

	$message = '';
    if (!isset($_POST['maNVu'])){
          $message = 'vui lòng nhập đầy đủ thông tin!!';
          
        }else if (empty($_POST['maNVu'])){
          $message = 'KHông để giá trị rỗng!!';
		} else {
			$maNV = $_POST['maNVu'];
			$sql = "UPDATE NhiemVu SET trangThai = 'IN PROGRESS' WHERE maNhiemVu = ?";
			$conn = connect_db();
			$stm = $conn->prepare($sql);
   			$stm -> bind_param("s", $maNV);
			$stm -> execute();
			if ($stm -> affected_rows == 1) {
				$message = 'Cập nhật trạng thái thành công';
				header('Location: get_inprogress_task.php');
			} else {
				$message = 'Cập nhật trạng thái thất bại';
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
	<title>Trang thông tin nhiệm vụ bị trả về</title>
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
			<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10 rounded border border-left-0 border-right-0 border-bottom-0">
				<div class="task-content">
					<h5 class="p-2 d-flex justify-content-center bg-dark text-white tex-center">
						<i class="fas fa-hand-point-left"></i>
						INFORMATION REJECTED TASK
					</h5>
					<form action="" method="post" enctype="multipart/form-data">
						<?php
							require_once("../connect_db.php");
							require_once("task_and_dayOff_db.php");

							$sql = "SELECT * FROM KetQuaTraVe WHERE maNhiemVu = '".$_GET['id']."'";
							$result = connect_db()->query($sql);

							while ($row = $result->fetch_assoc()) {

								$idNV = $row['maNhiemVu'];
                                $noiDung = $row['noiDung'];
                                $file = $row['tapTin'];
                                $time = $row['hanThucHien'];
							}
						?>
						<div class="row">
							<div class="col-xl-2 col-lg-4 ">
								<div class="form-group ml-3 mr-3">
									<label for="maNVu">Mã nhiệm vụ</label>
									<input type="text" value="<?= $idNV ?>" class="form-control" id="maNVu" name="maNVu" readonly />
								</div>
                                <div class="form-group ml-3 mr-3">
									<label for="hanThucHien">Hạn Thực hiện</label>
									<input type="text" value="<?= $time ?>" class="form-control" id="hanThucHien" name="hanThucHien" readonly />
								</div>
							</div>
							<div class="col-xl-10 col-lg-8 ">
                                <div class="form-group ml-3 mr-3">
									<label for="noiDung">Nội dung</label>
									<input type="text" value="<? echo $noiDung ?>" class="form-control" id="noiDung" name="noiDung" readonly />
								</div>
                                <div class="form-group ml-3 mr-3">
									<label for="file">Tập tin</label>
									<a class="text-primary" target="blank" href="/files/<?= $file ?>"><i class="text-primary font-italic fas fa-download"></i> <?= $file ?></a>
								</div>
								<div class="form-group ml-3 mr-3">
									<button type="submit" name="submit" class="btn btn-primary"><a href="task_infomation_inprogress.php?id=<?= $idNV ?>"> </a> Bắt đầu lại </button>
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
                    <p id="responseMess"></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Confirm</button>
                </div>
            </div>
        </div>
    </div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<script src="/main.js"></script> 
</body>

</html>