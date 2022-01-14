<?php
	session_start();

	$message = '';
    if (!isset($_POST['maNVDayOff']) || !isset($_POST['dayDayOff']) || !isset($_POST['fileDayOff'])
        || !isset($_POST['reasonDayOff'])){
          $message = 'vui lòng nhập đầy đủ thông tin!!';
          
    }else if (empty($_POST['maNVDayOff']) || empty($_POST['dayDayOff']) || empty($_POST['fileDayOff'])
        || empty($_POST['reasonDayOff'])){
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
	<title>Trang thông tin nhiệm vụ mới</title>
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
	.task-content {
		background-color: rgb(240,255,255);
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
				<div class="task-content">
					<h5 class="p-2 d-flex justify-content-center bg-dark text-white tex-center">
						<i class="fas fa-hand-point-left"></i>
						ĐƠN XIN NGHỈ PHÉP
					</h5>
					<form action="" method="POST" validate="required" enctype="multipart/form">
						<?php
							require_once("../connect_db.php");
							require_once("task_and_dayOff_db.php");
							
							$maNhanVien = $_SESSION['maNhanVien'];
							$sql = "SELECT * FROM NhanVien WHERE maNhanVien = '$maNhanVien'";

							$result = connect_db()->query($sql);

							while ($row = $result->fetch_assoc()) {
								$maPhongBan = $row['maPhongBan'];
							}

						?>
						<div class="row">
							<div class="col-xl-3">
								<div class="form-group ml-3 mr-3">
									<label for="maNVDayOff">MSNV</label>
									<input type="text" value= '<?= $_SESSION['maNhanVien'] ?>' class="form-control" id="maNVDayOff" name="maNVDayOff" readonly/>
								</div>
								<div class="form-group ml-3 mr-3">
									<label for="maNVDayOff">MÃ PB</label>
									<input type="text" value= '<?= $maPhongBan ?>' class="form-control" id="maNVDayOff" name="maNVDayOff" readonly/>
								</div>
								<div class="form-group ml-3 mr-3">
									<label for="dayDayOff">NHẬP SỐ NGÀY</label>
									<input type="text" value="" class="form-control" id="dayDayOff" name="dayDayOff"/>
								</div>
								
							</div>
							<div class="col-xl-9">
								<div class="form-group ml-3 mr-3">
									<label for="fileDayOff">TẬP TIN ĐÍNH KÈM ( nếu có )</label>
									<input type="file" value="" class="form-control" id="fileDayOff" name="fileDayOff"/>
								</div>
                                <div class="form-group ml-3 mr-3">
									<label for="reasonDayOff">LÝ DO</label>
									<input type="text" value="" class="form-control" id="reasonDayOff" name="reasonDayOff"/>
								</div>
                                <div class="form-group ml-3 mr-3">
								    <div>
                                        <p class="text-danger text-center"> Bạn không thể tạo đơn nghỉ phép vì đã vượt quá số ngày nghỉ quy định </p>
                                    </div>
                                </div>
                                <div class="form-group ml-3 mr-3">
                                    <button onclick="addDayOffForm();" type="submit" disabled class="btn btn-success ml-auto">Gửi</button>
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

	<script>

	// const addAPIDayOff = 'http://localhost:8080/employee/send_dayOff_form.php';
	
	function addDayOffForm(e) {
	// e.preventDefault();
	// console.log("stopped")
	let maNVDayOff = $('#maNVDayOff').val()
	let dayDayOff = $('#dayDayOff').val()
	let reasonDayOff = $('#reasonDayOff').val()
	let fileDayOff = $('#fileDayOff').val()
  
	// Kiểm tra dữ liệu có rỗng hay không
	if (maNVDayOff == '' ||  dayDayOff == '' || reasonDayOff == '' || fileDayOff == '') {
		$('.empty').removeClass('d-none')
	} else {
		$('.empty').addClass('d-none')
	}

	let data = {
				"maNVDayOff":maNVDayOff,
				"dayDayOff":dayDayOff,
				"reasonDayOff":reasonDayOff,
				"fileDayOff":fileDayOff,
			}
	console.log(data);

	
  	fetch(addAPIDayOff, {
            'method': 'POST',
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data)
        })
	.then(res => res.json())
	.then(data => {
	  	console.log(data);
        //         if (data.code === 0) {
  		// 	console.log(0)
        //             $('#day-off-dialog').modal('toggle')
        //             $('#responseMess').html(data.message);
        //             $('#message-respone').modal('show');
                    
        //             $('tbody').children().remove()
        //             loadTasks()
        //         } else {
      	// console.log(1)
        //             $('#add-dialog').modal('toggle')
        //             $('#responseMess').html(data.message);
        //             $('#message-respone').modal('show');
        //         }
            })
  	}
	



	</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	
</body>

</html>