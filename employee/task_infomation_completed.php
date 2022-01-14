<?php
	session_start();

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
					<div class="e__heading-task-none">
						<p class="p-2 d-flex justify-content-center bg-dark text-white text-center">
							<i class="fas fa-hand-point-left"></i>
							INFORMATION COMPLETED TASK
						</p>
					</div>
					<div class="e__heading-task">
						<h5 class="p-2 d-flex justify-content-center bg-dark text-white text-center">
							<i class="fas fa-hand-point-left"></i>
							INFORMATION COMPLETED TASK
						</h5>
					</div>
					<form action="" method="post" >
						<?php
							require_once("../connect_db.php");
							

							$sql = "SELECT * FROM NhiemVuHoanThanh WHERE maNhiemVu = '".$_GET['id']."'";
							$result = connect_db()->query($sql);

							while ($row = $result->fetch_assoc()) {
								$idNV = $row['maNhiemVu'];
								$mucDo = $row['mucDo'];
								$dungHan = $row['dungHan'];

							}
	
						?>
						<div class="row">
							<div class="col-xl-4 col-lg-4 col-md-4">
								<div class="form-group ml-3 mr-3">
									<label for="maNVu">MÃ NHIỆM VỤ</label>
									<input type="text" value="<?= $idNV ?>" class="form-control" id="maNVu" name="maNVu" readonly />
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-5">
								<div class="form-group ml-3 mr-3">
                                    <label for="mucDo" class="text-center">MỨC ĐỘ HOÀN THÀNH</label>
									<input type="text" value="<? echo $mucDo ?>" class="form-control" id="mucDo" name="mucDo" readonly>
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-3">
								<div class="form-group ml-3 mr-3">
                                    <label for="dungHan">ĐÚNG HẠN</label>
									<?php
										if ($dungHan == 1) {
											echo "<input type='text' value='Đúng hạn' class='form-control' id='dungHan' name='dungHan' readonly>";
										} else {
											echo "<input type='text' value='Trễ hạn' class='form-control' id='dungHan' name='dungHan' readonly>";
										}
									?>
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